<?php

namespace App\Http\Controllers;

use App\Models\HakAkses;
use Illuminate\Http\Request;

class HakAksesController extends Controller
{
    public function index()
    {
        // Daftar semua grup/bagian yang ada di sistem kamu (sesuai dropdown saat create user)
        $grupList = [
            'Pimpinan', 'Kepaniteraan', 'Kepaniteraan Pidana',
            'Kepaniteraan Perdata', 'Kepaniteraan Hukum', 'Kesekretariatan',
            'Umum dan Keuangan', 'Ortala', 'PTIP'
        ];

        // Ambil semua data hak akses yang sudah disetting sebelumnya di database
        $hakAksesData = HakAkses::all();
        
        // Kita ubah format datanya biar gampang dicek di tampilan Blade (HTML) nanti
        $hakAkses = [];
        foreach ($hakAksesData as $ha) {
            $hakAkses[$ha->grup_pemilik][$ha->grup_pengakses] = [
                'lihat' => $ha->bisa_lihat,
                'komentar' => $ha->bisa_komentar,
            ];
        }

        return view('hak_akses.index', compact('grupList', 'hakAkses'));
    }

    public function store(Request $request)
    {
        // Hapus semua settingan lama karena kita akan simpan ulang berdasarkan checkbox yang dicentang
        HakAkses::truncate();

        // Cek apakah ada checkbox yang dicentang dari form
        if ($request->has('akses')) {
            foreach ($request->akses as $pemilik => $pengaksesList) {
                foreach ($pengaksesList as $pengakses => $izin) {
                    HakAkses::create([
                        'grup_pemilik' => $pemilik,
                        'grup_pengakses' => $pengakses,
                        // Jika checkbox dicentang, nilainya 1. Jika tidak, nilainya 0.
                        'bisa_lihat' => isset($izin['lihat']) ? 1 : 0,
                        'bisa_komentar' => isset($izin['komentar']) ? 1 : 0,
                        // Admin dan pemilik dokumen secara otomatis punya hak edit/hapus
                        'bisa_edit_hapus' => 0, 
                    ]);
                }
            }
        }

        return redirect()->route('hak-akses.index')->with('success', 'Pengaturan Hak Akses berhasil diperbarui!');
    }
}