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
        Schema::create('m_kelas', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('nama_kelas');
            $table->string('keterangan');
            $table->foreignId('jurusan_id')->constrained('m_jurusan')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_kelas');
    }
};
