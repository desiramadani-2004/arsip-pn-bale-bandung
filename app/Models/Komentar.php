<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Komentar extends Model
{
    use HasFactory;

    protected $fillable = ['arsip_id', 'user_id', 'isi_komentar'];

    // Relasi ke tabel User (siapa yang komen)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke tabel Arsip (komen di dokumen mana)
    public function arsip()
    {
        return $this->belongsTo(Arsip::class);
    }
}