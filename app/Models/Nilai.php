<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    protected $guarded = ['id'];
    
    // Relasi ke Siswa (User)
    public function siswa() 
    { 
        return $this->belongsTo(User::class, 'siswa_id'); 
    }

    // --- TAMBAHKAN INI (PENTING) ---
    // Agar kita bisa mengambil nama mapel dari tabel nilai
    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'mapel_id');
    }

    // Relasi ke Kelas (Opsional, buat jaga-jaga)
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    // Relasi ke Guru (Opsional, buat jaga-jaga)
    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }
}