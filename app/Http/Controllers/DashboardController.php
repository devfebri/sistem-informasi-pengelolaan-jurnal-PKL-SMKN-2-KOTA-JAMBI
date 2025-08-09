<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Jurnal;
use App\Models\Instansi;
use App\Models\Penilaian;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        switch ($user->role) {
            case 'admin':
                return $this->adminDashboard();
            case 'guru':
                return $this->guruDashboard();
            case 'siswa':
                return $this->siswaDashboard();
            default:
                return redirect()->route('login');
        }
    }

    private function adminDashboard()
    {
        // Statistik untuk Admin
        $totalSiswa = User::where('role', 'siswa')->count();
        $totalGuru = User::where('role', 'guru')->count();
        $totalInstansi = Instansi::count();
        $totalJurnal = Jurnal::count();

        // Jurnal berdasarkan status validasi
        $jurnalValid = Penilaian::where('status_validasi', 'valid')->count();
        $jurnalRevisi = Penilaian::where('status_validasi', 'revisi')->count();
        $jurnalTidakValid = Penilaian::where('status_validasi', 'tidak_valid')->count();
        $jurnalMenunggu = $totalJurnal - ($jurnalValid + $jurnalRevisi + $jurnalTidakValid);

        // Activity terbaru (10 jurnal terbaru)
        $recentJurnals = DB::table('jurnals')
            ->join('users', 'jurnals.user_id', '=', 'users.id')
            ->leftJoin('penilaians', 'jurnals.id', '=', 'penilaians.jurnal_id')
            ->select('jurnals.*', 'users.name as siswa_name', 'penilaians.status_validasi')
            ->orderBy('jurnals.created_at', 'desc')
            ->limit(10)
            ->get();

        // Jurnal per bulan (6 bulan terakhir)
        $monthlyJurnals = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $count = Jurnal::whereYear('created_at', $date->year)
                          ->whereMonth('created_at', $date->month)
                          ->count();
            $monthlyJurnals[] = [
                'month' => $date->format('M Y'),
                'count' => $count
            ];
        }

        return view('dashboard.admin', compact(
            'totalSiswa', 'totalGuru', 'totalInstansi', 'totalJurnal',
            'jurnalValid', 'jurnalRevisi', 'jurnalTidakValid', 'jurnalMenunggu',
            'recentJurnals', 'monthlyJurnals'
        ));
    }

    private function guruDashboard()
    {
        $guru = Auth::user();
        
        // Statistik untuk Guru
        $totalSiswaBimbingan = User::where('guru_id', $guru->id)->count();
        
        // Jurnal siswa bimbingan
        $totalJurnalBimbingan = DB::table('jurnals')
            ->join('users', 'jurnals.user_id', '=', 'users.id')
            ->where('users.guru_id', $guru->id)
            ->count();

        // Status validasi jurnal bimbingan
        $jurnalValid = DB::table('penilaians')
            ->join('jurnals', 'penilaians.jurnal_id', '=', 'jurnals.id')
            ->join('users', 'jurnals.user_id', '=', 'users.id')
            ->where('users.guru_id', $guru->id)
            ->where('penilaians.status_validasi', 'valid')
            ->count();

        $jurnalRevisi = DB::table('penilaians')
            ->join('jurnals', 'penilaians.jurnal_id', '=', 'jurnals.id')
            ->join('users', 'jurnals.user_id', '=', 'users.id')
            ->where('users.guru_id', $guru->id)
            ->where('penilaians.status_validasi', 'revisi')
            ->count();

        $jurnalTidakValid = DB::table('penilaians')
            ->join('jurnals', 'penilaians.jurnal_id', '=', 'jurnals.id')
            ->join('users', 'jurnals.user_id', '=', 'users.id')
            ->where('users.guru_id', $guru->id)
            ->where('penilaians.status_validasi', 'tidak_valid')
            ->count();

        $jurnalMenunggu = $totalJurnalBimbingan - ($jurnalValid + $jurnalRevisi + $jurnalTidakValid);

        // Siswa bimbingan
        $siswaBimbingan = User::where('guru_id', $guru->id)
            ->with('instansi')
            ->get();

        // Jurnal terbaru siswa bimbingan
        $recentJurnals = DB::table('jurnals')
            ->join('users', 'jurnals.user_id', '=', 'users.id')
            ->leftJoin('penilaians', 'jurnals.id', '=', 'penilaians.jurnal_id')
            ->where('users.guru_id', $guru->id)
            ->select('jurnals.*', 'users.name as siswa_name', 'penilaians.status_validasi')
            ->orderBy('jurnals.created_at', 'desc')
            ->limit(8)
            ->get();

        // Penilaian berkala yang dibuat
        $totalPenilaianBerkala = Penilaian::where('guru_id', $guru->id)
            ->whereNotNull('nilai')
            ->whereNotNull('siswa_id')
            ->count();

        return view('dashboard.guru', compact(
            'totalSiswaBimbingan', 'totalJurnalBimbingan', 'totalPenilaianBerkala',
            'jurnalValid', 'jurnalRevisi', 'jurnalTidakValid', 'jurnalMenunggu',
            'siswaBimbingan', 'recentJurnals'
        ));
    }

    private function siswaDashboard()
    {
        $siswa = Auth::user()->load(['instansi', 'guru']);
        
        // Statistik untuk Siswa
        $totalJurnal = Jurnal::where('user_id', $siswa->id)->count();
        
        // Status validasi jurnal siswa
        $jurnalValid = DB::table('penilaians')
            ->join('jurnals', 'penilaians.jurnal_id', '=', 'jurnals.id')
            ->where('jurnals.user_id', $siswa->id)
            ->where('penilaians.status_validasi', 'valid')
            ->count();

        $jurnalRevisi = DB::table('penilaians')
            ->join('jurnals', 'penilaians.jurnal_id', '=', 'jurnals.id')
            ->where('jurnals.user_id', $siswa->id)
            ->where('penilaians.status_validasi', 'revisi')
            ->count();

        $jurnalTidakValid = DB::table('penilaians')
            ->join('jurnals', 'penilaians.jurnal_id', '=', 'jurnals.id')
            ->where('jurnals.user_id', $siswa->id)
            ->where('penilaians.status_validasi', 'tidak_valid')
            ->count();

        $jurnalMenunggu = $totalJurnal - ($jurnalValid + $jurnalRevisi + $jurnalTidakValid);

        // Jurnal terbaru siswa
        $recentJurnals = DB::table('jurnals')
            ->leftJoin('penilaians', 'jurnals.id', '=', 'penilaians.jurnal_id')
            ->where('jurnals.user_id', $siswa->id)
            ->select('jurnals.*', 'penilaians.status_validasi', 'penilaians.catatan_validasi')
            ->orderBy('jurnals.created_at', 'desc')
            ->limit(5)
            ->get();

        // Penilaian berkala siswa
        $penilaianBerkala = Penilaian::where('siswa_id', $siswa->id)
            ->whereNotNull('nilai')
            ->orderBy('tanggal_penilaian', 'desc')
            ->limit(3)
            ->get();

        // Progress jurnal mingguan (4 minggu terakhir)
        $weeklyProgress = [];
        for ($i = 3; $i >= 0; $i--) {
            $startWeek = Carbon::now()->subWeeks($i)->startOfWeek();
            $endWeek = Carbon::now()->subWeeks($i)->endOfWeek();
            
            $count = Jurnal::where('user_id', $siswa->id)
                          ->whereBetween('tanggal', [$startWeek->format('Y-m-d'), $endWeek->format('Y-m-d')])
                          ->count();
            
            $weeklyProgress[] = [
                'week' => 'Week ' . ($i + 1),
                'count' => $count
            ];
        }

        return view('dashboard.siswa', compact(
            'totalJurnal', 'jurnalValid', 'jurnalRevisi', 'jurnalTidakValid', 'jurnalMenunggu',
            'recentJurnals', 'penilaianBerkala', 'weeklyProgress'
        ));
    }
}
