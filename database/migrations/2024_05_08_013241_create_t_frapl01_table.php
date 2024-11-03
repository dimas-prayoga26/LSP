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
        Schema::create('t_frapl01', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('no_ktp',20)->unique();
            $table->string('tempat_lahir');
            $table->json('berkas_pemohon_asesi');
            $table->date('tgl_lahir');
            $table->string('kebangsaan',30);
            $table->string('kode_pos',5);
            $table->string('tlp_rumah',20)->nullable()->unique();
            $table->string('tlp_kantor',20)->nullable()->unique();
            $table->text('alamat_kantor')->nullable();
            $table->string('pendidikan',100);
            $table->string('nama_institusi')->nullable();
            $table->string('no_tlp_institusi',20)->nullable()->unique();
            $table->string('kode_pos_institusi',5)->nullable();
            $table->string('email_institusi', 50)->nullable()->unique();
            $table->string('fax',50)->nullable();
            $table->string('tujuan_assesmen');
            $table->string('jabatan')->nullable();
            $table->string('no_reg')->nullable();
            $table->enum('status_rekomendasi',['Pending','Diterima','Tidak Diterima'])->default('Pending');
            $table->string('ttd_admin_lsp')->nullable();
            $table->string('ttd_asesi');
            $table->timestamp('tgl_ttd_admin_lsp')->nullable();
            $table->timestamp('tgl_ttd_asesi');
            $table->string('catatan')->nullable();
            $table->foreignId('asesi_id')->constrained('m_asesi')->cascadeOnDelete();
            $table->foreignId('kelompok_asesor_id')->constrained('t_kelompok_asesor')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_frapl01');
    }
};
