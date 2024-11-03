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
            // Menambahkan kolom valid_date dengan tipe date
            $table->date('valid_date')->nullable(); // Ganti 'column_name' dengan nama kolom sebelumnya
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('m_asesi', function (Blueprint $table) {
            // Menghapus kolom valid_date
            $table->dropColumn('valid_date');
        });
    }
};
