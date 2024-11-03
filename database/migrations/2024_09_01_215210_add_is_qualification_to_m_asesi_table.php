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
        Schema::table('m_asesi', function (Blueprint $table) {
            $table->enum('is_qualification', ['Kompeten', 'Belum Kompeten'])->default('Belum Kompeten'); // Menambahkan kolom is_qualification dengan enum
        });
    }

    public function down(): void
    {
        Schema::table('m_asesi', function (Blueprint $table) {
            $table->dropColumn('is_qualification'); // Menghapus kolom is_qualification jika migrasi di-rollback
        });
    }

};
