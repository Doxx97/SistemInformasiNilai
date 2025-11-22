<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // --- UPDATE BAGIAN INI ---
    protected $fillable = [
        'name',
        'username', // <--- Tambahkan ini (Pengganti Email)
        'password',
        'role',     // <--- Tambahkan ini
        'kelas_id', // <--- Tambahkan ini (Untuk Siswa)
        'nip',      // <--- Tambahkan ini (Untuk Guru)

        'foto',
        'tahun_masuk',
        'catatan_wali_kelas',
        'status_kenaikan',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ... (Kode relasi mapels dan kelas yang sudah Anda buat sebelumnya biarkan saja di bawah sini) ...
    
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function mapels()
    {
        return $this->belongsToMany(Mapel::class, 'guru_mapel', 'user_id', 'mapel_id');
    }

    //dashboard guru
    public function nilais()
    {
    return $this->hasMany(Nilai::class, 'siswa_id');
    }

    //Agar guru bisa menjadi wali kelas
    public function kelasPerwalian()
    {
    return $this->hasOne(Kelas::class, 'wali_kelas_id');
    }
}