<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusNilai extends Model
{
    protected $guarded = ['id'];

    // Relasi ke Mapel
    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'mapel_id');
    }

    // Relasi ke Guru (User)
    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }
}