<?php

namespace App\Http\Controllers;

use App\Models\Penilaian;
use App\Models\Jurnal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PenilaianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
    public function index()
    {
        // Untuk siswa: tampilkan jurnal mereka dengan status validasi
        if(Auth::user()->role=='siswa'){
            $penilaians = DB::table('jurnals')
                ->select('jurnals.*', 'penilaians.status_validasi', 'penilaians.catatan_validasi', 'penilaians.created_at as tanggal_validasi', 'users.name as nama_guru')
                ->leftJoin('penilaians', 'jurnals.id', '=', 'penilaians.jurnal_id')
                ->leftJoin('users', 'penilaians.guru_id', '=', 'users.id')
                ->where('jurnals.user_id', Auth::id())
                ->orderBy('jurnals.tanggal', 'desc')
                ->get();
        } else {
            // Untuk guru: tampilkan jurnal siswa bimbingan mereka yang perlu divalidasi
            if(Auth::user()->role == 'guru') {
                $penilaians = DB::table('jurnals')
                    ->select('jurnals.*', 'penilaians.status_validasi', 'penilaians.catatan_validasi', 'penilaians.created_at as tanggal_validasi', 'siswa.name as nama_siswa')
                    ->leftJoin('penilaians', 'jurnals.id', '=', 'penilaians.jurnal_id')
                    ->leftJoin('users as siswa', 'jurnals.user_id', '=', 'siswa.id')
                    ->where('siswa.guru_id', Auth::id())
                    ->orderBy('jurnals.tanggal', 'desc')
                    ->get();
            } else {
                // Untuk admin: tampilkan semua jurnal
                $penilaians = DB::table('jurnals')
                    ->select('jurnals.*', 'penilaians.status_validasi', 'penilaians.catatan_validasi', 'penilaians.created_at as tanggal_validasi', 'siswa.name as nama_siswa', 'guru.name as nama_guru')
                    ->leftJoin('penilaians', 'jurnals.id', '=', 'penilaians.jurnal_id')
                    ->leftJoin('users as siswa', 'jurnals.user_id', '=', 'siswa.id')
                    ->leftJoin('users as guru', 'penilaians.guru_id', '=', 'guru.id')
                    ->orderBy('jurnals.tanggal', 'desc')
                    ->get();
            }
        }
        return view('penilaian.index', compact('penilaians'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil jurnal siswa bimbingan yang belum divalidasi oleh guru ini
        $jurnals = Jurnal::with('user')
            ->whereHas('user', function($q) {
                $q->where('guru_id', Auth::id());
            })
            ->whereDoesntHave('penilaian', function($q){
                $q->where('guru_id', Auth::id());
            })
            ->orderBy('tanggal', 'desc')
            ->get();
        
        return view('penilaian.create', compact('jurnals'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'jurnal_id' => 'required|exists:jurnals,id',
            'status_validasi' => 'required|in:valid,tidak_valid,revisi',
            'catatan_validasi' => 'nullable|string',
        ]);

        // Cek apakah jurnal sudah divalidasi oleh guru ini
        $sudahDivalidasi = Penilaian::where('jurnal_id', $request->jurnal_id)
            ->where('guru_id', Auth::id())
            ->exists();

        if ($sudahDivalidasi) {
            return redirect()->back()->withErrors(['jurnal_id' => 'Jurnal ini sudah divalidasi!']);
        }

        // Cek apakah jurnal milik siswa bimbingan guru ini
        $jurnal = Jurnal::with('user')->find($request->jurnal_id);
        if ($jurnal->user->guru_id != Auth::id()) {
            return redirect()->back()->withErrors(['jurnal_id' => 'Anda hanya bisa memvalidasi jurnal siswa bimbingan Anda!']);
        }

        Penilaian::create([
            'jurnal_id' => $request->jurnal_id,
            'guru_id' => Auth::id(),
            'status_validasi' => $request->status_validasi,
            'catatan_validasi' => $request->catatan_validasi,
        ]);

        return redirect()->route('penilaian.index')->with('success', 'Jurnal berhasil divalidasi');
    }

    /**
     * Display the specified resource.
     */
    public function show(Penilaian $penilaian)
    {
        return view('penilaian.show', compact('penilaian'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Penilaian $penilaian)
    {
        $jurnals = Jurnal::all();
        return view('penilaian.edit', compact('penilaian', 'jurnals'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Penilaian $penilaian)
    {
        $request->validate([
            'status_validasi' => 'required|in:valid,tidak_valid,revisi',
            'catatan_validasi' => 'nullable|string',
        ]);
        
        $penilaian->update($request->only('status_validasi', 'catatan_validasi'));
        return redirect()->route('penilaian.index')->with('success', 'Validasi jurnal berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Penilaian $penilaian)
    {
        $penilaian->delete();
        return redirect()->route('penilaian.index')->with('success', 'Validasi jurnal berhasil dihapus');
    }
}
