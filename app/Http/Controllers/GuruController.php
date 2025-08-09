<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gurus = User::where('role', 'guru')->get();
        return view('guru.index', compact('gurus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('guru.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:50|unique:users',
            'nip' => 'nullable|string|max:20|unique:users',
            'email' => 'required|email|unique:users',
            'phone' => 'nullable|string|max:15',
            'gender' => 'nullable|in:L,P',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'nip' => $request->nip,
            'email' => $request->email,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'role' => 'guru',
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $guru = User::where('role', 'guru')->with('siswa.instansi')->findOrFail($id);
        return view('guru.show', compact('guru'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $guru = User::where('role', 'guru')->findOrFail($id);
        return view('guru.edit', compact('guru'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $guru = User::where('role', 'guru')->findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:50|unique:users,username,'.$guru->id,
            'nip' => 'nullable|string|max:20|unique:users,nip,'.$guru->id,
            'email' => 'required|email|unique:users,email,'.$guru->id,
            'phone' => 'nullable|string|max:15',
            'gender' => 'nullable|in:L,P',
        ]);

        $guru->update($request->only('name', 'username', 'nip', 'email', 'phone', 'gender'));
        return redirect()->route('guru.index')->with('success', 'Data guru berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $guru = User::where('role', 'guru')->findOrFail($id);
        $guru->delete();
        return redirect()->route('guru.index')->with('success', 'Data guru berhasil dihapus');
    }
}
