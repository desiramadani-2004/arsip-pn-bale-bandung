<?php

namespace App\Http\Controllers;

use App\Models\Arsip;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Tambahan untuk fungsi DB::raw

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $role = strtolower($user->grup);

        // --- LOGIKA KHUSUS SUPER ADMIN ---
        if ($role == 'admin') {
            $totalUsers = User::count();
            $totalArsipGlobal = Arsip::count();
            $userTerbaru = User::latest()->take(5)->get();
            $arsipTerbaru = Arsip::with('kategori_bagian')->latest()->take(5)->get();

            // HITUNG STATISTIK PER BAGIAN UNTUK ADMIN
            $statsBagian = [
                'pidana' => Arsip::whereHas('kategori_bagian', fn($q) => $q->where('nama_bagian', 'like', '%Pidana%'))->count(),
                'perdata' => Arsip::whereHas('kategori_bagian', fn($q) => $q->where('nama_bagian', 'like', '%Perdata%'))->count(),
                'hukum' => Arsip::whereHas('kategori_bagian', fn($q) => $q->where('nama_bagian', 'like', '%Hukum%'))->count(),
                'umum' => Arsip::whereHas('kategori_bagian', fn($q) => $q->where('nama_bagian', 'like', '%Umum%'))->count(),
                'ptip' => Arsip::whereHas('kategori_bagian', fn($q) => $q->where('nama_bagian', 'like', '%PTIP%'))->count(),
                'ortala' => Arsip::whereHas('kategori_bagian', fn($q) => $q->where('nama_bagian', 'like', '%Ortala%'))->count(),
            ];

            // --- TAMBAHAN LOGIKA GRAFIK KATEGORI (ADMIN) ---
            $dataGrafik = Arsip::select('kategori_dokumen', DB::raw('count(*) as total'))
                ->groupBy('kategori_dokumen')
                ->get();

            return view('dashboard_admin', compact(
                'totalUsers', 'totalArsipGlobal', 'userTerbaru', 'arsipTerbaru', 
                'user', 'statsBagian', 'dataGrafik'
            ));
        }
        
        // --- LOGIKA USER BIASA (STAF/PIMPINAN) ---
        $namaUser = strtolower($user->name ?? '');
        $searchTerm = trim(str_replace('staf', '', $namaUser)); 

        $query = Arsip::with('kategori_bagian');
        $nama_grup = strtoupper($role);

        if (in_array($role, ['pimpinan', 'ketua', 'wakil'])) {
            $nama_grup = 'SELURUH BAGIAN (PIMPINAN)';
        } elseif (in_array($role, ['panitera'])) {
            $query->whereHas('kategori_bagian', function($q) {
                $q->where('kelompok', 'kepaniteraan');
            });
            $nama_grup = 'KEPANITERAAN (SEMUA)';
        } elseif (in_array($role, ['sekretaris'])) {
            $query->whereHas('kategori_bagian', function($q) {
                $q->where('kelompok', 'kesekretariatan');
            });
            $nama_grup = 'KESEKRETARIATAN (SEMUA)';
        } else {
            $query->whereHas('kategori_bagian', function($q) use ($searchTerm) {
                $q->where('nama_bagian', 'like', "%{$searchTerm}%");
            });
            $nama_grup = strtoupper($searchTerm); 
        }

        $totalArsip = (clone $query)->count();
        $arsipPublik = (clone $query)->where('status_akses', 'public')->count();
        $arsipInternal = (clone $query)->where('status_akses', 'private')->count(); 
        $totalBytes = (clone $query)->sum('file_size');
        $totalStorageMB = round($totalBytes / 1048576, 2); 
        $arsipTerbaru = (clone $query)->latest()->take(5)->get();

        // --- TAMBAHAN LOGIKA GRAFIK KATEGORI (USER BIASA) ---
        // Kita clone query-nya supaya filternya tetap sama dengan dashboard user tsb
        $dataGrafik = (clone $query)
            ->select('kategori_dokumen', DB::raw('count(*) as total'))
            ->groupBy('kategori_dokumen')
            ->get();

        return view('dashboard', compact(
            'totalArsip', 'arsipPublik', 'arsipInternal', 'totalStorageMB', 
            'arsipTerbaru', 'user', 'nama_grup', 'dataGrafik'
        ));
    }
}