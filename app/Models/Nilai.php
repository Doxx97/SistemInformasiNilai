<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    use HasFactory;

    // 1. Pastikan semua kolom ini ada (termasuk guru_id)
    protected $fillable = [
        'siswa_id', 
        'kelas_id', 
        'mapel_id', 
        'tahun_pelajaran_id', 
        'guru_id',       // <--- PENTING: Agar error guru_id hilang
        'nilai',         // Nilai Akhir
        'detail_harian', // Data JSON
        'uts', 
        'uas', 
        'status'
    ];

    // 2. BAGIAN INI YANG MENGATASI ERROR "Array to string conversion"
    protected $casts = [
        'detail_harian' => 'array', // Laravel otomatis ubah Array <-> JSON
    ];

    // --- Relasi (Biarkan jika sudah ada) ---
    public function siswa()
    {
        return $this->belongsTo(User::class, 'siswa_id');
    }

    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }
    
    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'mapel_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function tahunPelajaran()
    {
        return $this->belongsTo(TahunPelajaran::class, 'tahun_pelajaran_id');
    }
}