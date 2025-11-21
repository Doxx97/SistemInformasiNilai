<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\TahunPelajaran;

class TahunPelajaranSeeder extends Seeder
{
    public function run(): void
    {
        TahunPelajaran::create(['tahun' => '2024/2025', 'semester' => 'Ganjil', 'is_active' => true]);
        TahunPelajaran::create(['tahun' => '2024/2025', 'semester' => 'Genap', 'is_active' => false]);
        TahunPelajaran::create(['tahun' => '2025/2026', 'semester' => 'Ganjil', 'is_active' => false]);
    }
}