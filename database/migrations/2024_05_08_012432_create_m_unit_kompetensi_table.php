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
        Schema::create('m_unit_kompetensi', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('kode_unit');
            $table->string('judul_unit');
            $table->enum('jenis_standar',['KKNI','Okupasi','Klaster']);
            $table->foreignId('skema_id')->constrained('m_skema')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_unit_kompetensi');
    }
};
