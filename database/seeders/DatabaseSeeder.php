<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\KategoriBagian;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Kategori Bagian (Sesuai aslinya)
        $kategori = [
            ['nama_bagian' => 'Pidana', 'kelompok' => 'kepaniteraan'],
            ['nama_bagian' => 'Perdata', 'kelompok' => 'kepaniteraan'],
            ['nama_bagian' => 'Hukum', 'kelompok' => 'kepaniteraan'],
            ['nama_bagian' => 'Umum dan Keuangan', 'kelompok' => 'kesekretariatan'],
            ['nama_bagian' => 'Ortala', 'kelompok' => 'kesekretariatan'],
            ['nama_bagian' => 'PTIP', 'kelompok' => 'kesekretariatan'],
        ];
        
        foreach ($kategori as $kat) { 
            \App\Models\KategoriBagian::create($kat); 
        }

        // 10 Akun (9 Akun asli dari kamu + 1 Super Admin biar bisa login)
        $users = [
            // --- Akun Super Admin ---
            ['name' => 'Super Admin PNBB', 'email' => 'admin@pnbb.com', 'grup' => 'ADMIN'],
            
            // --- 9 Akun Sesuai Codingan Kamu ---
            ['name' => 'Ketua/Wakil', 'email' => 'pimpinan@pn.go.id', 'grup' => 'pimpinan'],
            ['name' => 'Panitera', 'email' => 'panitera@pn.go.id', 'grup' => 'kepaniteraan'],
            ['name' => 'Staf Pidana', 'email' => 'pidana@pn.go.id', 'grup' => 'kepaniteraan'],
            ['name' => 'Staf Perdata', 'email' => 'perdata@pn.go.id', 'grup' => 'kepaniteraan'],
            ['name' => 'Staf Hukum', 'email' => 'hukum@pn.go.id', 'grup' => 'kepaniteraan'],
            ['name' => 'Sekretaris', 'email' => 'sekretaris@pn.go.id', 'grup' => 'kesekretariatan'],
            ['name' => 'Staf Umum', 'email' => 'umum@pn.go.id', 'grup' => 'kesekretariatan'],
            ['name' => 'Staf Ortala', 'email' => 'ortala@pn.go.id', 'grup' => 'kesekretariatan'],
            ['name' => 'Staf PTIP', 'email' => 'ptip@pn.go.id', 'grup' => 'kesekretariatan'],
        ];

        foreach ($users as $u) {
            // Khusus admin pakai admin123, sisanya password123 sesuai aslinya
            $passwordUser = ($u['email'] === 'admin@pnbb.com') ? 'admin123' : 'password123';

            \App\Models\User::create([
                'name' => $u['name'],
                'email' => $u['email'],
                'password' => bcrypt($passwordUser),
                'grup' => $u['grup'],
            ]);
        }
    } 
}