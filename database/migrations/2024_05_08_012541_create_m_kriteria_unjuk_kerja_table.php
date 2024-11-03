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
        Schema::create('m_kriteria_unjuk_kerja', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('nama_kriteria_kerja');
            $table->foreignId('elemen_id')->constrained('m_elemen')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_kriteria_unjuk_kerja');
    }
};
