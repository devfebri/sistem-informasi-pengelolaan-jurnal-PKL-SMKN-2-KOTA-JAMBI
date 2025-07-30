<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Instansi;

class ProfileController extends Controller
{
    public function index()
    {
        $data = auth()->user();
        $instansis = Instansi::all();
        return view('profile', compact('data', 'instansis'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:50|unique:users,username,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
            'instansi_id' => 'nullable|exists:instansis,id',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->instansi_id = $request->instansi_id;
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        return redirect()->route('profile')->with('success', 'Profile berhasil diupdate');
    }
}
