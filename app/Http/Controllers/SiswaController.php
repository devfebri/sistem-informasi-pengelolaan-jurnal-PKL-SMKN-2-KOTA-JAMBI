<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $siswas = User::where('role', 'siswa')->get();
        return view('siswa.index', compact('siswas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $gurus = User::where('role', 'guru')->get();
        $instansis = \App\Models\Instansi::all();
        return view('siswa.create', compact('gurus', 'instansis'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:50|unique:users',
            'nisn' => 'required|string|max:20|unique:users',
            'email' => 'required|email|unique:users',
            'phone' => 'nullable|string|max:15',
            'gender' => 'nullable|in:L,P',
            'guru_id' => 'nullable|exists:users,id',
            'instansi_id' => 'nullable|exists:instansis,id',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'nisn' => $request->nisn,
            'email' => $request->email,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'guru_id' => $request->guru_id,
            'instansi_id' => $request->instansi_id,
            'role' => 'siswa',
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $siswa = User::where('role', 'siswa')->findOrFail($id);
        return view('siswa.show', compact('siswa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $siswa = User::where('role', 'siswa')->findOrFail($id);
        $gurus = User::where('role', 'guru')->get();
        $instansis = \App\Models\Instansi::all();
        return view('siswa.edit', compact('siswa', 'gurus', 'instansis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $siswa = User::where('role', 'siswa')->findOrFail($id);
        
        $rules = [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:50|unique:users,username,'.$siswa->id,
            'nisn' => 'required|string|max:20|unique:users,nisn,'.$siswa->id,
            'email' => 'required|email|unique:users,email,'.$siswa->id,
            'phone' => 'nullable|string|max:15',
            'gender' => 'nullable|in:L,P',
            'guru_id' => 'nullable|exists:users,id',
            'instansi_id' => 'nullable|exists:instansis,id',
        ];

        // Jika password diisi, tambahkan validasi password
        if ($request->filled('password')) {
            $rules['password'] = 'required|string|min:8|confirmed';
        }

        $request->validate($rules);

        $updateData = $request->only('name', 'username', 'nisn', 'email', 'phone', 'gender', 'guru_id', 'instansi_id');
        
        // Jika password diisi, tambahkan ke data update
        if ($request->filled('password')) {
            $updateData['password'] = bcrypt($request->password);
        }

        $siswa->update($updateData);
        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $siswa = User::where('role', 'siswa')->findOrFail($id);
        $siswa->delete();
        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil dihapus');
    }
}
