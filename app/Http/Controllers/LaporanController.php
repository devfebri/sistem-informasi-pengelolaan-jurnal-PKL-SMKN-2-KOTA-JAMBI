<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jurnal;
use App\Models\Penilaian;
use App\Models\User;
use App\Models\Instansi;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // Hanya pimpinan dan admin yang bisa akses laporan
        $this->middleware(function ($request, $next) {
            if (!in_array(Auth::user()->role ?? '', ['pimpinan', 'admin'])) {
                abort(403, 'Akses ditolak. Hanya pimpinan dan admin yang dapat mengakses laporan.');
            }
            return $next($request);
        });
    }

    public function index()
    {
        return view('laporan.index');
    }

    public function laporanLengkap(Request $request)
    {
        $tanggalMulai = $request->get('tanggal_mulai', Carbon::now()->subMonths(3)->format('Y-m-d'));
        $tanggalSelesai = $request->get('tanggal_selesai', Carbon::now()->format('Y-m-d'));
        
        // Data statistik
        $totalJurnal = Jurnal::whereBetween('tanggal', [$tanggalMulai, $tanggalSelesai])->count();
        $totalPenilaian = Penilaian::whereNotNull('periode_penilaian')
            ->whereBetween('tanggal_penilaian', [$tanggalMulai, $tanggalSelesai])
            ->count();
        $totalSiswa = User::where('role', 'siswa')->count();
        $totalGuru = User::where('role', 'guru')->count();
        $totalInstansi = Instansi::count();
        
        // Jurnal berdasarkan status
        $jurnalValid = Penilaian::where('status_validasi', 'valid')
            ->whereHas('jurnal', function($q) use ($tanggalMulai, $tanggalSelesai) {
                $q->whereBetween('tanggal', [$tanggalMulai, $tanggalSelesai]);
            })->count();
        $jurnalRevisi = Penilaian::where('status_validasi', 'revisi')
            ->whereHas('jurnal', function($q) use ($tanggalMulai, $tanggalSelesai) {
                $q->whereBetween('tanggal', [$tanggalMulai, $tanggalSelesai]);
            })->count();
        $jurnalTidakValid = Penilaian::where('status_validasi', 'tidak_valid')
            ->whereHas('jurnal', function($q) use ($tanggalMulai, $tanggalSelesai) {
                $q->whereBetween('tanggal', [$tanggalMulai, $tanggalSelesai]);
            })->count();
        $jurnalBelumValidasi = $totalJurnal - ($jurnalValid + $jurnalRevisi + $jurnalTidakValid);
        
        // Data jurnal per instansi
        $jurnalPerInstansi = Jurnal::with(['siswa.instansi'])
            ->whereBetween('tanggal', [$tanggalMulai, $tanggalSelesai])
            ->get()
            ->groupBy(function($jurnal) {
                return $jurnal->siswa->instansi->nama ?? 'Tidak Ada Instansi';
            })
            ->map(function($jurnals) {
                return $jurnals->count();
            });
            
        // Data jurnal per guru
        $jurnalPerGuru = Jurnal::with(['siswa.guru'])
            ->whereBetween('tanggal', [$tanggalMulai, $tanggalSelesai])
            ->get()
            ->groupBy(function($jurnal) {
                return $jurnal->siswa->guru->name ?? 'Tidak Ada Guru';
            })
            ->map(function($jurnals) {
                return $jurnals->count();
            });
            
        // Penilaian berkala
        $penilaianBerkala = Penilaian::with(['siswa', 'guru'])
            ->whereNotNull('periode_penilaian')
            ->whereBetween('tanggal_penilaian', [$tanggalMulai, $tanggalSelesai])
            ->orderBy('tanggal_penilaian', 'desc')
            ->get();
            
        // Jurnal terbaru
        $jurnalTerbaru = Jurnal::with(['siswa.instansi', 'penilaian'])
            ->whereBetween('tanggal', [$tanggalMulai, $tanggalSelesai])
            ->orderBy('tanggal', 'desc')
            ->limit(50)
            ->get();

        $data = compact(
            'tanggalMulai', 'tanggalSelesai', 'totalJurnal', 'totalPenilaian', 
            'totalSiswa', 'totalGuru', 'totalInstansi', 'jurnalValid', 
            'jurnalRevisi', 'jurnalTidakValid', 'jurnalBelumValidasi',
            'jurnalPerInstansi', 'jurnalPerGuru', 'penilaianBerkala', 'jurnalTerbaru'
        );

        if ($request->get('download') == 'pdf') {
            $pdf = Pdf::loadView('laporan.pdf.lengkap', $data);
            $pdf->setPaper('A4', 'portrait');
            return $pdf->download('Laporan_PKL_Lengkap_' . date('Y-m-d') . '.pdf');
        }

        return view('laporan.lengkap', $data);
    }

    public function laporanSiswa(Request $request)
    {
        $siswaId = $request->get('siswa_id');
        $tanggalMulai = $request->get('tanggal_mulai', Carbon::now()->subMonths(3)->format('Y-m-d'));
        $tanggalSelesai = $request->get('tanggal_selesai', Carbon::now()->format('Y-m-d'));
        
        $siswa = null;
        $jurnals = collect();
        $penilaians = collect();
        $statistik = [
            'total_jurnal' => 0,
            'jurnal_valid' => 0,
            'jurnal_revisi' => 0,
            'jurnal_tidak_valid' => 0,
            'belum_validasi' => 0,
            'nilai_rata_rata' => 0
        ];
        
        if ($siswaId) {
            $siswa = User::with(['instansi', 'guru'])->find($siswaId);
            
            if ($siswa) {
                $jurnals = Jurnal::with(['penilaian'])
                    ->where('user_id', $siswa->id)
                    ->whereBetween('tanggal', [$tanggalMulai, $tanggalSelesai])
                    ->orderBy('tanggal', 'desc')
                    ->get();
                    
                $penilaians = Penilaian::with(['guru'])
                    ->where('siswa_id', $siswa->id)
                    ->whereNotNull('periode_penilaian')
                    ->whereBetween('tanggal_penilaian', [$tanggalMulai, $tanggalSelesai])
                    ->orderBy('tanggal_penilaian', 'desc')
                    ->get();
                    
                $statistik = [
                    'total_jurnal' => $jurnals->count(),
                    'jurnal_valid' => $jurnals->filter(function($j) { return $j->penilaian->first()?->status_validasi == 'valid'; })->count(),
                    'jurnal_revisi' => $jurnals->filter(function($j) { return $j->penilaian->first()?->status_validasi == 'revisi'; })->count(),
                    'jurnal_tidak_valid' => $jurnals->filter(function($j) { return $j->penilaian->first()?->status_validasi == 'tidak_valid'; })->count(),
                    'belum_validasi' => $jurnals->filter(function($j) { return !$j->penilaian->first(); })->count(),
                    'nilai_rata_rata' => $penilaians->avg('nilai') ?? 0
                ];
            }
        }
        
        $siswaList = User::where('role', 'siswa')->orderBy('name')->get();
        
        $data = compact('siswa', 'jurnals', 'penilaians', 'statistik', 'siswaList', 'tanggalMulai', 'tanggalSelesai');
        
        if ($request->get('download') == 'pdf' && $siswa) {
            $pdf = Pdf::loadView('laporan.pdf.siswa', $data);
            $pdf->setPaper('A4', 'portrait');
            return $pdf->download('Laporan_PKL_' . str_replace(' ', '_', $siswa->name) . '_' . date('Y-m-d') . '.pdf');
        }
        
        return view('laporan.siswa', $data);
    }

    public function laporanInstansi(Request $request)
    {
        $instansiId = $request->get('instansi_id');
        $tanggalMulai = $request->get('tanggal_mulai', Carbon::now()->subMonths(3)->format('Y-m-d'));
        $tanggalSelesai = $request->get('tanggal_selesai', Carbon::now()->format('Y-m-d'));
        
        $instansi = null;
        $siswaList = collect();
        $jurnals = collect();
        $statistik = [
            'total_siswa' => 0,
            'total_jurnal' => 0,
            'jurnal_valid' => 0,
            'jurnal_revisi' => 0,
            'jurnal_tidak_valid' => 0
        ];
        
        if ($instansiId) {
            $instansi = Instansi::find($instansiId);
            
            if ($instansi) {
                $siswaList = User::where('role', 'siswa')
                    ->where('instansi_id', $instansi->id)
                    ->with(['guru'])
                    ->get();
                    
                $jurnals = Jurnal::with(['siswa', 'penilaian'])
                    ->whereHas('siswa', function($q) use ($instansi) {
                        $q->where('instansi_id', $instansi->id);
                    })
                    ->whereBetween('tanggal', [$tanggalMulai, $tanggalSelesai])
                    ->orderBy('tanggal', 'desc')
                    ->get();
                    
                $statistik = [
                    'total_siswa' => $siswaList->count(),
                    'total_jurnal' => $jurnals->count(),
                    'jurnal_valid' => $jurnals->filter(function($j) { return $j->penilaian->first()?->status_validasi == 'valid'; })->count(),
                    'jurnal_revisi' => $jurnals->filter(function($j) { return $j->penilaian->first()?->status_validasi == 'revisi'; })->count(),
                    'jurnal_tidak_valid' => $jurnals->filter(function($j) { return $j->penilaian->first()?->status_validasi == 'tidak_valid'; })->count(),
                ];
            }
        }
        
        $instansiList = Instansi::orderBy('nama')->get();
        
        $data = compact('instansi', 'siswaList', 'jurnals', 'statistik', 'instansiList', 'tanggalMulai', 'tanggalSelesai');
        
        if ($request->get('download') == 'pdf' && $instansi) {
            $pdf = Pdf::loadView('laporan.pdf.instansi', $data);
            $pdf->setPaper('A4', 'portrait');
            return $pdf->download('Laporan_PKL_' . str_replace(' ', '_', $instansi->nama) . '_' . date('Y-m-d') . '.pdf');
        }
        
        return view('laporan.instansi', $data);
    }

    public function laporanGuru(Request $request)
    {
        $tanggalMulai = $request->get('tanggal_mulai');
        $tanggalSelesai = $request->get('tanggal_selesai');
        $guruId = $request->get('guru_id');
        
        // Daftar semua guru
        $guruList = User::where('role', 'guru')->orderBy('name')->get();
        
        $data = [
            'guruList' => $guruList,
            'tanggalMulai' => $tanggalMulai,
            'tanggalSelesai' => $tanggalSelesai,
        ];
        
        if ($guruId) {
            $guru = User::where('role', 'guru')->find($guruId);
            
            if ($guru) {
                // Siswa yang dibimbing guru ini
                $siswaBimbingan = User::where('role', 'siswa')
                    ->where('guru_id', $guru->id)
                    ->with(['instansi', 'jurnal', 'penilaian'])
                    ->get();
                
                // Query jurnal siswa bimbingan
                $jurnalQuery = Jurnal::whereHas('siswa', function($q) use ($guru) {
                    $q->where('guru_id', $guru->id);
                });
                
                // Filter tanggal jika ada
                if ($tanggalMulai && $tanggalSelesai) {
                    $jurnalQuery->whereBetween('tanggal', [$tanggalMulai, $tanggalSelesai]);
                }
                
                $jurnalSiswaBimbingan = $jurnalQuery->with(['siswa', 'penilaian'])
                    ->orderBy('tanggal', 'desc')
                    ->take(20)
                    ->get();
                
                // Query penilaian siswa bimbingan
                $penilaianQuery = Penilaian::whereHas('siswa', function($q) use ($guru) {
                    $q->where('guru_id', $guru->id);
                })->whereNotNull('periode_penilaian');
                
                // Filter tanggal jika ada
                if ($tanggalMulai && $tanggalSelesai) {
                    $penilaianQuery->whereBetween('tanggal_penilaian', [$tanggalMulai, $tanggalSelesai]);
                }
                
                $penilaianSiswaBimbingan = $penilaianQuery->with(['siswa', 'guru'])
                    ->orderBy('tanggal_penilaian', 'desc')
                    ->take(20)
                    ->get();
                
                // Statistik
                $totalSiswaBimbingan = $siswaBimbingan->count();
                $totalJurnalBimbingan = $jurnalQuery->count();
                $jurnalValidBimbingan = Penilaian::where('status_validasi', 'valid')
                    ->whereHas('siswa', function($q) use ($guru) {
                        $q->where('guru_id', $guru->id);
                    })
                    ->when($tanggalMulai && $tanggalSelesai, function($q) use ($tanggalMulai, $tanggalSelesai) {
                        $q->whereHas('jurnal', function($q2) use ($tanggalMulai, $tanggalSelesai) {
                            $q2->whereBetween('tanggal', [$tanggalMulai, $tanggalSelesai]);
                        });
                    })
                    ->count();
                
                $totalPenilaianBimbingan = $penilaianQuery->count();
                $averageNilaiBimbingan = $penilaianQuery->avg('nilai') ?? 0;
                
                // Hitung data per siswa untuk widget
                foreach ($siswaBimbingan as $siswa) {
                    $siswaJurnalQuery = Jurnal::where('user_id', $siswa->id);
                    $siswaPenilaianQuery = Penilaian::where('siswa_id', $siswa->id)->whereNotNull('periode_penilaian');
                    
                    if ($tanggalMulai && $tanggalSelesai) {
                        $siswaJurnalQuery->whereBetween('tanggal', [$tanggalMulai, $tanggalSelesai]);
                        $siswaPenilaianQuery->whereBetween('tanggal_penilaian', [$tanggalMulai, $tanggalSelesai]);
                    }
                    
                    $siswa->jurnal_count = $siswaJurnalQuery->count();
                    $siswa->jurnal_valid_count = Penilaian::where('status_validasi', 'valid')
                        ->whereHas('jurnal', function($q) use ($siswa, $tanggalMulai, $tanggalSelesai) {
                            $q->where('user_id', $siswa->id);
                            if ($tanggalMulai && $tanggalSelesai) {
                                $q->whereBetween('tanggal', [$tanggalMulai, $tanggalSelesai]);
                            }
                        })
                        ->count();
                    $siswa->avg_nilai = $siswaPenilaianQuery->avg('nilai') ?? 0;
                }
                
                $data = array_merge($data, [
                    'guru' => $guru,
                    'siswaBimbingan' => $siswaBimbingan,
                    'jurnalSiswaBimbingan' => $jurnalSiswaBimbingan,
                    'penilaianSiswaBimbingan' => $penilaianSiswaBimbingan,
                    'totalSiswaBimbingan' => $totalSiswaBimbingan,
                    'totalJurnalBimbingan' => $totalJurnalBimbingan,
                    'jurnalValidBimbingan' => $jurnalValidBimbingan,
                    'totalPenilaianBimbingan' => $totalPenilaianBimbingan,
                    'averageNilaiBimbingan' => $averageNilaiBimbingan,
                ]);
            }
        }
        
        if ($request->get('download') == 'pdf' && isset($guru) && $guru) {
            $pdf = Pdf::loadView('laporan.pdf.guru', $data);
            $pdf->setPaper('A4', 'portrait');
            return $pdf->download('Laporan_PKL_Guru_' . str_replace(' ', '_', $guru->name) . '_' . date('Y-m-d') . '.pdf');
        }
        
        return view('laporan.guru', $data);
    }
}
