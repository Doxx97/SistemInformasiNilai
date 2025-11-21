<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
    {
    // 1. Setup Tabel Tahun Pelajaran
    Schema::create('tahun_pelajarans', function (Blueprint $table) {
        $table->id();
        $table->string('tahun'); // Contoh: "2024/2025"
        $table->enum('semester', ['Ganjil', 'Genap']); 
        $table->boolean('is_active')->default(false); // Penanda tahun aktif sistem
        $table->timestamps();
    });

    // 2. Update Tabel Nilai (Agar nilai terpisah per tahun)
    Schema::table('nilais', function (Blueprint $table) {
        $table->foreignId('tahun_pelajaran_id')->nullable()->constrained('tahun_pelajarans')->onDelete('cascade');
    });

    // 3. Update Tabel Pivot Guru_Mapel (Agar Admin bisa set Guru A mengajar Mapel X di Kelas Y)
    // Kita hapus tabel lama dan buat ulang agar strukturnya bersih
    Schema::dropIfExists('guru_mapel');
    
    Schema::create('guru_mapel', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Guru
        $table->foreignId('mapel_id')->constrained('mapels')->onDelete('cascade');
        $table->foreignId('kelas_id')->constrained('kelas')->onDelete('cascade'); // Tambahan: Spesifik Kelas
        $table->foreignId('tahun_pelajaran_id')->nullable()->constrained('tahun_pelajarans')->onDelete('cascade'); // Tambahan: Per Tahun
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
