<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunPelajaran extends Model
{
    use HasFactory;

    // --- BAGIAN PENTING: DAFTARKAN KOLOM DISINI ---
    protected $fillable = [
        'tahun',      // <-- Ini yang bikin error tadi
        'semester',   // <-- Ini juga wajib
        'is_active'
    ];
}
