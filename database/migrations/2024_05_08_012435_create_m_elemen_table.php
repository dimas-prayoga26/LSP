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
        Schema::create('m_elemen', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('nama_elemen');
            $table->foreignId('unit_kompetensi_id')->constrained('m_unit_kompetensi')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_elemen');
    }
};
