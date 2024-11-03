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
        Schema::create('m_asesi', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('nim',20);
            $table->enum('status',['active','nonactive'])->default('nonactive');
            $table->foreignId('kelas_id')->constrained('m_kelas')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_asesi');
    }
};
