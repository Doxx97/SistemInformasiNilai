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
    // 1. Tambah kolom kelas_id ke users (khusus untuk Siswa)
    Schema::table('users', function (Blueprint $table) {
        $table->foreignId('kelas_id')->nullable()->constrained('kelas')->onDelete('set null');
        // Tambahan: NIP/NUPTK untuk Guru (opsional, pakai username juga bisa)
        $table->string('nip')->nullable(); 
    });

    // 2. Tabel Pivot: Hubungan Guru <-> Mapel
    Schema::create('guru_mapel', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // ID Guru
        $table->foreignId('mapel_id')->constrained('mapels')->onDelete('cascade'); // ID Mapel
        $table->timestamps();
    });
    }

    public function down(): void
    {
    Schema::dropIfExists('guru_mapel');
    Schema::table('users', function (Blueprint $table) {
        $table->dropForeign(['kelas_id']);
        $table->dropColumn(['kelas_id', 'nip']);
    });
    }
};
