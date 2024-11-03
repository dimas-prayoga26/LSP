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
        Schema::create('t_user_test_wawancara', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->json('jawaban'); // Tanggapan, Rekomendasi, Umpan Balik
            $table->string('ttd_asesor');
            $table->string('ttd_asesi')->nullable();
            $table->timestamp('tgl_ttd_asesor');
            $table->timestamp('tgl_ttd_asesi')->nullable();
            $table->foreignId('kelompok_asesor_id')->constrained('t_kelompok_asesor')->cascadeOnDelete();
            $table->foreignId('asesi_id')->constrained('m_asesi')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_user_test_wawancara');
    }
};
