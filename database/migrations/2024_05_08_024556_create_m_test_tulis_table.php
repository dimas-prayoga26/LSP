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
        Schema::create('m_test_tulis', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->longText('pertanyaan');
            $table->string('kunci_jawaban');
            $table->json('jawaban');
            $table->foreignId('kriteria_unjuk_kerja_id')->constrained('m_kriteria_unjuk_kerja')->cascadeOnDelete();
            $table->foreignId('unit_kompetensi_id')->constrained('m_unit_kompetensi')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_test_tulis');
    }
};
