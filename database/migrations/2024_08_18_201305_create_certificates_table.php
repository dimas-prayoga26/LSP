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
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->enum('status_rekomendasi',['Kompeten','Belum Kompeten'])->default('Belum Kompeten');
            $table->foreignId('asesi_id')->constrained('m_asesi')->cascadeOnDelete();
            $table->foreignId('kelompok_asesor_id')->constrained('t_kelompok_asesor')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
