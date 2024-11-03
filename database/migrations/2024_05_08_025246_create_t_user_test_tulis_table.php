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
        Schema::create('t_user_test_tulis', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->json('jawaban');
            $table->string('ttd_asesor')->nullable();
            $table->string('ttd_asesi');
            $table->timestamp('tgl_ttd_asesor')->nullable();
            $table->timestamp('tgl_ttd_asesi');
            $table->foreignId('asesi_id')->constrained('m_asesi')->cascadeOnDelete();
            $table->foreignId('unit_kompetensi_id')->constrained('m_unit_kompetensi')->cascadeOnDelete();
            $table->foreignId('kelompok_asesor_id')->constrained('t_kelompok_asesor')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_user_test_tulis');
    }
};
