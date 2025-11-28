<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    // Pastikan nama tabel benar (jamak)
    protected $table = 'absensis';

    protected $fillable = [
        'siswa_id', 
        'kelas_id', 
        'mapel_id', 
        'guru_id', 
        'tahun_pelajaran_id', 
        'detail_absensi', // JSON data
        'sakit', 
        'izin', 
        'alpha', 
        'hadir',
        'status'
    ];

    // PENTING: Agar kolom JSON otomatis dibaca sebagai Array
    protected $casts = [
        'detail_absensi' => 'array',
    ];
    
    // Relasi (Opsional, tapi bagus untuk masa depan)
    public function siswa()
    {
        return $this->belongsTo(User::class, 'siswa_id');
    }
}