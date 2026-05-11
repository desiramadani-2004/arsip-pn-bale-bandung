<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    // 1. Tampilkan halaman daftar user
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    // 2. Tampilkan form tambah user baru
    public function create()
    {
        return view('users.create'); // Nanti kita buat file create.blade.php
    }

    // 3. Proses simpan data user baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'username' => ['nullable', 'string', 'max:255', 'unique:users'],
            'no_hp' => ['required', 'string', 'max:20'], // <-- Validasi No HP
            'grup' => ['required', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'no_hp' => $request->no_hp, // <-- Simpan No HP
            'grup' => $request->grup,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan!');
    }

    // 4. Tampilkan form edit user
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user')); // Nanti kita buat file edit.blade.php
    }

    // 5. Proses update data user ke database
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            // Email dan username unique, tapi kecualikan ID user yang sedang diedit
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'username' => ['nullable', 'string', 'max:255', 'unique:users,username,'.$user->id],
            'no_hp' => ['required', 'string', 'max:20'], // <-- Validasi No HP
            'grup' => ['required', 'string', 'max:255'],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()], // Password boleh kosong kalau gak mau diubah
        ]);

        // Siapkan data yang mau diupdate
        $dataToUpdate = [
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'no_hp' => $request->no_hp, // <-- Update No HP
            'grup' => $request->grup,
        ];

        // Kalau password diisi (artinya mau ganti password), tambahkan ke array
        if ($request->filled('password')) {
            $dataToUpdate['password'] = Hash::make($request->password);
        }

        $user->update($dataToUpdate);

        return redirect()->route('users.index')->with('success', 'Data user berhasil diperbarui!');
    }

    // 6. Proses hapus user
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        
        return back()->with('success', 'User berhasil dihapus dari sistem!');
    }
}