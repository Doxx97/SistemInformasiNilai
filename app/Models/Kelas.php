<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    public function waliKelas()
    {
    return $this->belongsTo(User::class, 'wali_kelas_id');
    }
}
