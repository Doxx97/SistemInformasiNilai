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
    Schema::table('users', function (Blueprint $table) {
        $table->string('tahun_masuk')->nullable()->default(date('Y'));
        $table->text('catatan_wali_kelas')->nullable(); // Catatan khusus individu
    });
    }

    public function down(): void
    {
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['tahun_masuk', 'catatan_wali_kelas']);
    });
    }
};
