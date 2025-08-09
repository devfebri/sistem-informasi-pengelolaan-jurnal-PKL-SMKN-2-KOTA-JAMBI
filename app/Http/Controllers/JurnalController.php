<?php

namespace App\Http\Controllers;

use App\Models\Jurnal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class JurnalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Jurnal::class);
        
        if (Auth::user()->role == 'siswa') {
            // Siswa hanya melihat jurnal mereka sendiri dengan status validasi
            $jurnals = DB::table('jurnals')
                ->select('jurnals.*', 'penilaians.status_validasi', 'penilaians.catatan_validasi')
                ->leftJoin('penilaians', 'jurnals.id', '=', 'penilaians.jurnal_id')
                ->where('jurnals.user_id', Auth::id())
                ->orderBy('jurnals.tanggal', 'desc')
                ->get();
        } elseif (Auth::user()->role == 'guru') {
            // Guru melihat jurnal siswa bimbingan mereka
            $jurnals = DB::table('jurnals')
                ->select('jurnals.*', 'penilaians.status_validasi', 'penilaians.catatan_validasi', 'users.name as nama_siswa')
                ->leftJoin('penilaians', 'jurnals.id', '=', 'penilaians.jurnal_id')
                ->leftJoin('users', 'jurnals.user_id', '=', 'users.id')
                ->where('users.guru_id', Auth::id())
                ->orderBy('jurnals.tanggal', 'desc')
                ->get();
        } else {
            // Admin melihat semua jurnal
            $jurnals = DB::table('jurnals')
                ->select('jurnals.*', 'penilaians.status_validasi', 'penilaians.catatan_validasi', 'users.name as nama_siswa')
                ->leftJoin('penilaians', 'jurnals.id', '=', 'penilaians.jurnal_id')
                ->leftJoin('users', 'jurnals.user_id', '=', 'users.id')
                ->orderBy('jurnals.tanggal', 'desc')
                ->get();
        }
        
        return view('jurnal.index', compact('jurnals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('siswa', Jurnal::class);

        // Cek apakah siswa sudah punya instansi
        if (Auth::user()->role == 'siswa' && empty(Auth::user()->instansi_id)) {
            return redirect()->route('jurnal.index')->with('error', 'Anda belum memilih instansi PKL. Silakan edit di profile.');
        }

        return view('jurnal.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Cek lagi untuk keamanan
        if (Auth::user()->role == 'siswa' && empty(Auth::user()->instansi_id)) {
            return redirect()->route('jurnal.index')->with('error', 'Anda belum memilih instansi PKL. Silakan edit di profile.');
        }

        $request->validate([
            'tanggal' => 'required|date',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'kegiatan' => 'required|string|max:500',
            'deskripsi' => 'nullable|string|max:1000',
        ]);

        Jurnal::create([
            'user_id' => Auth::id(),
            'tanggal' => $request->tanggal,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'kegiatan' => $request->kegiatan,
            'deskripsi' => $request->deskripsi,
            'status' => 'menunggu_validasi',
        ]);

        return redirect()->route('jurnal.index')->with('success', 'Jurnal berhasil ditambahkan dan menunggu validasi guru');
    }

    /**
     * Display the specified resource.
     */
    public function show(Jurnal $jurnal)
    {
        $this->authorize('view', $jurnal);

        // Ambil jurnal beserta penilaian (jika ada)
        $jurnal = Jurnal::with('penilaian')->findOrFail($jurnal->id);
        return view('jurnal.show', compact('jurnal'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jurnal $jurnal)
    {
        $this->authorize('siswa', $jurnal);
        return view('jurnal.edit', compact('jurnal'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Jurnal $jurnal)
    {
        $this->authorize('siswa', $jurnal);
        
        $request->validate([
            'tanggal' => 'required|date',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'kegiatan' => 'required|string|max:500',
            'deskripsi' => 'nullable|string|max:1000',
        ]);

        $jurnal->update([
            'tanggal' => $request->tanggal,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'kegiatan' => $request->kegiatan,
            'deskripsi' => $request->deskripsi,
            'status' => 'menunggu_validasi', // Reset status ketika diupdate
        ]);
        
        return redirect()->route('jurnal.index')->with('success', 'Jurnal berhasil diupdate dan menunggu validasi ulang');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jurnal $jurnal)
    {
        $this->authorize('siswa', $jurnal);
        $jurnal->delete();
        return redirect()->route('jurnal.index')->with('success', 'Jurnal berhasil dihapus');
    }

    /**
     * Validate jurnal by guru
     */
    public function validateJurnal(Request $request, Jurnal $jurnal)
    {
        try {
            // Pastikan hanya guru yang bisa validasi
            if (Auth::user()->role !== 'guru') {
                return response()->json(['error' => 'Unauthorized. Hanya guru yang dapat memvalidasi jurnal.'], 403);
            }

            // Pastikan jurnal adalah milik siswa bimbingan guru ini
            if ($jurnal->user->guru_id != Auth::id()) {
                return response()->json(['error' => 'Unauthorized. Jurnal ini bukan milik siswa bimbingan Anda.'], 403);
            }

            $request->validate([
                'status_validasi' => 'required|in:valid,tidak_valid,revisi',
                'catatan_validasi' => 'nullable|string|max:1000'
            ]);

            // Cek apakah sudah ada penilaian untuk jurnal ini
            $penilaian = \App\Models\Penilaian::where('jurnal_id', $jurnal->id)->first();

            if ($penilaian) {
                // Update existing penilaian
                $penilaian->update([
                    'status_validasi' => $request->status_validasi,
                    'catatan_validasi' => $request->catatan_validasi ?? 'Divalidasi melalui sistem',
                    'guru_id' => Auth::id(),
                    'tanggal_penilaian' => now()
                ]);
            } else {
                // Create new penilaian
                \App\Models\Penilaian::create([
                    'jurnal_id' => $jurnal->id,
                    'guru_id' => Auth::id(),
                    'status_validasi' => $request->status_validasi,
                    'catatan_validasi' => $request->catatan_validasi ?? 'Divalidasi melalui sistem',
                    'tanggal_penilaian' => now()
                ]);
            }

            // Log activity
            $statusText = [
                'valid' => 'diterima',
                'tidak_valid' => 'ditolak', 
                'revisi' => 'diminta untuk revisi'
            ];

            \Log::info("Jurnal ID {$jurnal->id} {$statusText[$request->status_validasi]} oleh guru " . Auth::user()->name);

            return response()->json([
                'success' => true,
                'message' => 'Jurnal berhasil divalidasi'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'error' => 'Data tidak valid', 
                'messages' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Error validating jurnal: ' . $e->getMessage());
            return response()->json([
                'error' => 'Terjadi kesalahan server. Silakan coba lagi.'
            ], 500);
        }
    }
}
