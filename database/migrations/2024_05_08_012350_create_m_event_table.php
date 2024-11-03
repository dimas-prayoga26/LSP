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
        Schema::create('m_event', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('nama_event');
            $table->enum('tuk', ['Sewaktu','Tempat Kerja','Mandiri']);
            $table->timestamp('event_mulai');
            $table->timestamp('event_selesai');
            $table->string('keterangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_event');
    }
};
