<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_mapel', 
        // 'kkm' // Uncomment jika nanti pakai KKM
    ];

    /**
     * Relasi ke Guru (Many-to-Many)
     * Satu Mapel bisa diajar oleh banyak Guru
     */
    public function gurus()
    {
        // Pastikan nama tabel pivot sesuai dengan database Anda ('guru_mapel')
        return $this->belongsToMany(User::class, 'guru_mapel', 'mapel_id', 'user_id')
                    ->where('role', 'guru');
    }
}