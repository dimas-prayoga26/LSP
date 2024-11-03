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
        Schema::create('t_kelompok_asesor', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->foreignId('event_id')->constrained('m_event')->cascadeOnDelete();
            $table->foreignId('asesor_id')->constrained('m_asesor')->cascadeOnDelete();
            $table->foreignId('skema_id')->constrained('m_skema')->cascadeOnDelete();
            $table->foreignId('kelas_id')->constrained('m_kelas')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_kelompok_asesor');
    }
};
