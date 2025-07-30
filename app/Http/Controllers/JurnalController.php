<?php

namespace App\Http\Controllers;

use App\Models\Jurnal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class JurnalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Jurnal::class); // Ganti ini
        if (auth()->user()->role == 'siswa') {
            $jurnals = DB::table('jurnals')
                ->select('jurnals.*', 'penilaians.nilai')
                ->leftJoin('penilaians', 'jurnals.id', '=', 'penilaians.jurnal_id')
                ->where('user_id', Auth::id())
                ->get();
        } else {
            $jurnals = DB::table('jurnals')
                ->select('jurnals.*', 'penilaians.nilai')
                ->leftJoin('penilaians', 'jurnals.id', '=', 'penilaians.jurnal_id')
                ->get();
        }
        return view('jurnal.index', compact('jurnals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Jurnal::class);

        // Cek apakah siswa sudah punya instansi
        if (auth()->user()->role == 'siswa' && empty(auth()->user()->instansi_id)) {
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
        if (auth()->user()->role == 'siswa' && empty(auth()->user()->instansi_id)) {
            return redirect()->route('jurnal.index')->with('error', 'Anda belum memilih instansi PKL. Silakan edit di profile.');
        }

        $request->validate([
            'tanggal' => 'required|date',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'kegiatan' => 'required|string',
            'file_jurnal' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $filePath = null;
        if ($request->hasFile('file_jurnal')) {
            $filePath = $request->file('file_jurnal')->store('jurnal_files', 'public');
        }

        Jurnal::create([
            'user_id' => Auth::id(),
            'tanggal' => $request->tanggal,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'kegiatan' => $request->kegiatan,
            'file_jurnal' => $filePath,
            'status' => 'menunggu',
        ]);

        return redirect()->route('jurnal.index')->with('success', 'Jurnal berhasil ditambahkan');
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
        $this->authorize('update', $jurnal);
        return view('jurnal.edit', compact('jurnal'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Jurnal $jurnal)
    {
        $this->authorize('update', $jurnal);
        $request->validate([
            'tanggal' => 'required|date',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'kegiatan' => 'required|string',
            'file_jurnal' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $data = $request->only('tanggal', 'jam_mulai', 'jam_selesai', 'kegiatan');
        if ($request->hasFile('file_jurnal')) {
            // Hapus file lama jika ada
            if ($jurnal->file_jurnal) {
                \Storage::disk('public')->delete($jurnal->file_jurnal);
            }
            $data['file_jurnal'] = $request->file('file_jurnal')->store('jurnal_files', 'public');
        }

        $jurnal->update($data);
        return redirect()->route('jurnal.index')->with('success', 'Jurnal berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jurnal $jurnal)
    {
        $this->authorize('delete', $jurnal);
        $jurnal->delete();
        return redirect()->route('jurnal.index')->with('success', 'Jurnal berhasil dihapus');
    }
}
