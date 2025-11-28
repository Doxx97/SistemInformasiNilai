<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\TahunPelajaran;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. BUAT TAHUN PELAJARAN
        $tahun = TahunPelajaran::create([
            'tahun' => '2024/2025',
            'semester' => 'Ganjil',
            'is_active' => true
        ]);

        // 2. BUAT KELAS (1 sampai 6)
        for ($i = 1; $i <= 6; $i++) {
            Kelas::create(['nama_kelas' => (string)$i]);
        }

        // 3. BUAT MAPEL
        $mapels = ['Matematika', 'Bahasa Indonesia', 'IPA', 'IPS', 'PJOK', 'Agama'];
        foreach ($mapels as $nama) {
            Mapel::create(['nama_mapel' => $nama]);
        }

        // 4. BUAT ADMIN
        User::create([
            'name' => 'Admin Utama',
            'username' => 'admin',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // 5. BUAT GURU (CONTOH: PAK BUDI)
        $guru = User::create([
            'name' => 'Pak Budi (Guru MTK)',
            'username' => '123456', // NIP
            'password' => Hash::make('password'),
            'role' => 'guru',
            'nip' => '123456'
        ]);

        // 6. BUAT SISWA (CONTOH: ANDI DI KELAS 1)
        User::create([
            'name' => 'Andi Siswa',
            'username' => '112233', // NISN
            'password' => Hash::make('112233'), // Pass = NISN
            'role' => 'walimurid',
            'kelas_id' => 1 // Masuk Kelas 1
        ]);

        // ---------------------------------------------------------
        // 7. ASSIGN GURU MENGAJAR (PENTING!)
        // Kita set Pak Budi mengajar MATEMATIKA di KELAS 1 pada TAHUN INI
        // ---------------------------------------------------------
        
        $mapelMtk = Mapel::where('nama_mapel', 'Matematika')->first();
        
        DB::table('guru_mapel')->insert([
            'user_id' => $guru->id,
            'mapel_id' => $mapelMtk->id,
            'kelas_id' => 1, // Mengajar Kelas 1
            'tahun_pelajaran_id' => $tahun->id, // Di Tahun Ini
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Tambahkan juga Pak Budi mengajar Kelas 2 (Biar terlihat bedanya)
        DB::table('guru_mapel')->insert([
            'user_id' => $guru->id,
            'mapel_id' => $mapelMtk->id,
            'kelas_id' => 2, // Mengajar Kelas 2
            'tahun_pelajaran_id' => $tahun->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->command->info('Data Dummy Berhasil Dibuat!');
    }
}