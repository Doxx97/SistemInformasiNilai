<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mapel;
use App\Models\Kelas;
use App\Models\StatusNilai;
use App\Models\User;

class DataMasterSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Data Kelas (1 sampai 6)
        for ($i = 1; $i <= 6; $i++) {
            Kelas::create(['nama_kelas' => 'Kelas ' . $i]);
        }

        // 2. Buat Data Mapel
        $mapels = ['Matematika', 'Bahasa Indonesia', 'IPA', 'IPS', 'PJOK', 'Agama', 'Seni Budaya'];
        foreach ($mapels as $m) {
            Mapel::create(['nama_mapel' => $m]);
        }

        // 3. Ambil Guru Pertama (Pastikan UserSeeder sudah dijalankan sebelumnya)
        $guru = User::where('role', 'guru')->first();

        if ($guru) {
            // 4. Buat Dummy Status Nilai untuk Kelas 1
            // Mapel 1 & 2 status Terkirim, sisanya Belum
            StatusNilai::create([
                'kelas_id' => 1, 'mapel_id' => 1, 'guru_id' => $guru->id, 'status' => 'terkirim'
            ]);
            StatusNilai::create([
                'kelas_id' => 1, 'mapel_id' => 2, 'guru_id' => $guru->id, 'status' => 'terkirim'
            ]);
            StatusNilai::create([
                'kelas_id' => 1, 'mapel_id' => 3, 'guru_id' => $guru->id, 'status' => 'belum'
            ]);
            
             // Dummy untuk Kelas 2 (Agar filter terlihat beda)
            StatusNilai::create([
                'kelas_id' => 2, 'mapel_id' => 1, 'guru_id' => $guru->id, 'status' => 'belum'
            ]);
        }
    }
}