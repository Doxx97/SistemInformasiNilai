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
    Schema::create('status_rapors', function (Blueprint $table) {
        $table->id();
        $table->foreignId('kelas_id')->constrained('kelas')->onDelete('cascade');
        $table->foreignId('tahun_pelajaran_id')->constrained('tahun_pelajarans')->onDelete('cascade');
        $table->boolean('is_published')->default(false); // 0 = Draft, 1 = Terkirim ke Wali Murid
        $table->timestamps();
    });
    }

    public function down(): void
    {
        Schema::dropIfExists('status_rapors');
    }
};
