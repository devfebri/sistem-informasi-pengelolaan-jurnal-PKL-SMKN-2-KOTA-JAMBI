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
        // $penilaians = Penilaian::where('guru_id', Auth::id())->get();
        if(auth()->user()->role=='siswa'){
            $penilaians = DB::table('jurnals')
                ->select('jurnals.*', 'penilaians.nilai')
                ->leftJoin('penilaians', 'jurnals.id', '=', 'penilaians.jurnal_id')
                ->where('user_id', Auth::id())
                ->get();
        }else{
             $penilaians = DB::table('jurnals')
                ->select('jurnals.*', 'penilaians.nilai')
                ->leftJoin('penilaians', 'jurnals.id', '=', 'penilaians.jurnal_id')
                ->get();
        }
        return view('penilaian.index', compact('penilaians'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil jurnal yang belum dinilai oleh guru ini
        $jurnals = Jurnal::whereDoesntHave('penilaian', function($q){
            $q->where('guru_id', Auth::id());
        })->get();
        // dd($jurnals);
        return view('penilaian.create', compact('jurnals'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'jurnal_id' => 'required|exists:jurnals,id',
            'nilai' => 'required|integer|min:0|max:100',
            'catatan' => 'nullable|string',
        ]);

        // Cek apakah jurnal sudah dinilai oleh guru ini
        $sudahDinilai = Penilaian::where('jurnal_id', $request->jurnal_id)
            ->where('guru_id', Auth::id())
            ->exists();

        if ($sudahDinilai) {
            return redirect()->back()->withErrors(['jurnal_id' => 'Jurnal ini sudah dinilai!']);
        }

        Penilaian::create([
            'jurnal_id' => $request->jurnal_id,
            'guru_id' => Auth::id(),
            'nilai' => $request->nilai,
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('jurnal.index')->with('success', 'Penilaian berhasil ditambahkan');
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
            'nilai' => 'required|integer|min:0|max:100',
            'catatan' => 'nullable|string',
        ]);
        $penilaian->update($request->only('nilai', 'catatan'));
        return redirect()->route('penilaian.index')->with('success', 'Penilaian berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Penilaian $penilaian)
    {
        $penilaian->delete();
        return redirect()->route('penilaian.index')->with('success', 'Penilaian berhasil dihapus');
    }
}
