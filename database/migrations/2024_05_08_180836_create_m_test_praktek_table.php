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
        Schema::create('m_test_praktek', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->longText('isi_prosedur_kerja');
            $table->foreignId('skema_id')->constrained('m_skema')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_test_praktek');
    }
};
