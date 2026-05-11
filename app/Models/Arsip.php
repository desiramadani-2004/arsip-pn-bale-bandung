<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Arsip extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_dokumen', 
        'judul_arsip', 
        'kategori_dokumen',
        'deskripsi_metadata', 
        'file_path', 
        'status_akses',
        'file_size', 
        'kategori_bagian_id', 
        'user_id'
        
    ];

    // INI TALI PENGHUBUNGNYA:
    public function kategori_bagian()
    {
        return $this->belongsTo(KategoriBagian::class, 'kategori_bagian_id');
    }
}