<?php

namespace App\Http\Controllers;

use App\Models\Instansi;
use Illuminate\Http\Request;

class InstansiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $instansis = Instansi::all();
        return view('instansi.index', compact('instansis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('instansi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'telepon' => 'nullable|string|max:20',
        ]);

        Instansi::create($request->only('nama', 'alamat', 'telepon'));
        return redirect()->route('instansi.index')->with('success', 'Instansi berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Instansi $instansi)
    {
        return view('instansi.show', compact('instansi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Instansi $instansi)
    {
        return view('instansi.edit', compact('instansi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Instansi $instansi)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'telepon' => 'nullable|string|max:20',
        ]);
        $instansi->update($request->only('nama', 'alamat', 'telepon'));
        return redirect()->route('instansi.index')->with('success', 'Instansi berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Instansi $instansi)
    {
        $instansi->delete();
        return redirect()->route('instansi.index')->with('success', 'Instansi berhasil dihapus');
    }
}
