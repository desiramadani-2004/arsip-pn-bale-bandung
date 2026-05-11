<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HakAkses extends Model
{
    use HasFactory;
    protected $fillable = ['grup_pemilik', 'grup_pengakses', 'bisa_lihat', 'bisa_komentar', 'bisa_edit_hapus'];
}
