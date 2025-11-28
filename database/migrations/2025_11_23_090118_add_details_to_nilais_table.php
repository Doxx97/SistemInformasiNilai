<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
    Schema::table('nilais', function (Blueprint $table) {
        // Menyimpan nilai per pertemuan (misal: {"p1": 80, "p2": 90, ...})
        $table->json('detail_harian')->nullable(); 

        $table->integer('uts')->nullable(); // Nilai UTS
        $table->integer('uas')->nullable(); // Nilai UAS

        // Status: 'draft' (masih ngisi) atau 'terkirim' (sudah final)
        $table->string('status')->default('draft'); 
    });
    }

    public function down()
    {
    Schema::table('nilais', function (Blueprint $table) {
        $table->dropColumn(['detail_harian', 'uts', 'uas', 'status']);
    });
    }
};
