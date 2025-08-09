<?php

namespace App\Http\Controllers;

use App\Models\Penilaian;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PenilaianBerkalaController extends Controller
{
    public function __construct()
    {
        // Siswa hanya bisa akses index dan show
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $user = Auth::user();
            $allowedMethods = ['index', 'show'];
            $currentMethod = $request->route()->getActionMethod();
            
            if ($user->role === 'siswa' && !in_array($currentMethod, $allowedMethods)) {
                abort(403, 'Akses ditolak. Siswa hanya dapat melihat penilaian.');
            }
            
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Tampilkan penilaian nilai berkala untuk guru dan admin
        if(Auth::user()->role == 'guru') {
            $penilaians = Penilaian::with(['siswa', 'guru'])
                ->whereNotNull('nilai')
                ->whereNotNull('siswa_id')
                ->where('guru_id', Auth::id())
                ->orderBy('tanggal_penilaian', 'desc')
                ->get();
        } elseif(Auth::user()->role == 'siswa') {
            // Siswa melihat penilaian berkala mereka sendiri
            $penilaians = Penilaian::with(['siswa', 'guru'])
                ->whereNotNull('nilai')
                ->whereNotNull('siswa_id')
                ->where('siswa_id', Auth::id())
                ->orderBy('tanggal_penilaian', 'desc')
                ->get();
        } else {
            // Admin melihat semua penilaian berkala
            $penilaians = Penilaian::with(['siswa', 'guru'])
                ->whereNotNull('nilai')
                ->whereNotNull('siswa_id')
                ->orderBy('tanggal_penilaian', 'desc')
                ->get();
        }
        
        return view('penilaian-berkala.index', compact('penilaians'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Tampilkan siswa bimbingan yang perlu dinilai secara berkala
        $siswaList = User::where('role', 'siswa')
            ->where('guru_id', Auth::id())
            ->get();
            
        return view('penilaian-berkala.create', compact('siswaList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:users,id',
            'nilai' => 'required|integer|min:0|max:100',
            'periode_penilaian' => 'required|in:triwulan,semester',
            'tanggal_penilaian' => 'required|date',
            'catatan_nilai' => 'nullable|string',
        ]);

        // Cek apakah siswa adalah bimbingan guru ini
        $siswa = User::find($request->siswa_id);
        if ($siswa->guru_id != Auth::id()) {
            return redirect()->back()->withErrors(['siswa_id' => 'Anda hanya bisa memberi nilai pada siswa bimbingan Anda!']);
        }

        // Cek apakah sudah ada penilaian untuk periode yang sama
        $existing = Penilaian::where('guru_id', Auth::id())
            ->where('siswa_id', $request->siswa_id)
            ->where('periode_penilaian', $request->periode_penilaian)
            ->whereDate('tanggal_penilaian', $request->tanggal_penilaian)
            ->exists();

        if ($existing) {
            return redirect()->back()->withErrors(['periode_penilaian' => 'Penilaian untuk periode ini sudah ada!']);
        }

        Penilaian::create([
            'jurnal_id' => null, // Penilaian berkala tidak terkait jurnal spesifik
            'guru_id' => Auth::id(),
            'siswa_id' => $request->siswa_id,
            'nilai' => $request->nilai,
            'periode_penilaian' => $request->periode_penilaian,
            'tanggal_penilaian' => $request->tanggal_penilaian,
            'catatan_nilai' => $request->catatan_nilai,
        ]);

        return redirect()->route('penilaian-berkala.index')->with('success', 'Penilaian berkala berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $penilaian = Penilaian::with(['siswa', 'guru'])->findOrFail($id);
        return view('penilaian-berkala.show', compact('penilaian'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $penilaian = Penilaian::with(['siswa', 'guru'])->findOrFail($id);
        $siswaList = User::where('role', 'siswa')
            ->where('guru_id', Auth::id())
            ->get();
        return view('penilaian-berkala.edit', compact('penilaian', 'siswaList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $penilaian = Penilaian::findOrFail($id);
        
        $request->validate([
            'nilai' => 'required|integer|min:0|max:100',
            'periode_penilaian' => 'required|in:triwulan,semester',
            'tanggal_penilaian' => 'required|date',
            'catatan_nilai' => 'nullable|string',
        ]);

        $penilaian->update($request->only('nilai', 'periode_penilaian', 'tanggal_penilaian', 'catatan_nilai'));
        return redirect()->route('penilaian-berkala.index')->with('success', 'Penilaian berkala berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $penilaian = Penilaian::findOrFail($id);
        $penilaian->delete();
        return redirect()->route('penilaian-berkala.index')->with('success', 'Penilaian berkala berhasil dihapus');
    }
}
