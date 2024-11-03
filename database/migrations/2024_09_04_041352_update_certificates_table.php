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
        Schema::table('certificates', function (Blueprint $table) {
            // Menghapus kolom status_rekomendasi
            $table->dropColumn('status_rekomendasi');
            
            // Menambahkan kolom file_certificate
            $table->string('file_certificate')->nullable()->after('uuid'); // Anda bisa menambahkan 'nullable()' jika ingin membiarkan kolom ini kosong pada awalnya
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('certificates', function (Blueprint $table) {
            // Mengembalikan kolom status_rekomendasi
            $table->enum('status_rekomendasi', ['Kompeten', 'Belum Kompeten'])->default('Belum Kompeten');

            // Menghapus kolom file_certificate
            $table->dropColumn('file_certificate');
        });
    }
};
