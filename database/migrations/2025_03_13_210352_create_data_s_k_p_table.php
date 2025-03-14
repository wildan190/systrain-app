<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('data_s_k_p', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('detail_peserta_id');
            $table->string('upload_surat_permohonan')->nullable();
            $table->string('upload_sertifikat_pembinaan')->nullable();
            $table->string('upload_sk_kerja')->nullable();
            $table->string('upload_surat_pernyataan_kerja')->nullable();
            $table->string('upload_rekapitulasi')->nullable();
            $table->string('upload_pas_foto')->nullable();
            $table->string('upload_ijazah_terakhir')->nullable();
            $table->string('upload_paklaring')->nullable();
            $table->string('upload_surat_pengantar')->nullable();
            $table->string('upload_pernyataan_personel')->nullable();
            $table->string('upload_ktp')->nullable();
            $table->string('upload_keahlian_teknis')->nullable();
            $table->string('upload_cv')->nullable();
            $table->string('upload_laporan_kegiatan')->nullable();
            $table->string('upload_sk_pensiun')->nullable();
            $table->timestamps();

            $table->foreign('detail_peserta_id')->references('id')->on('detail_pesertas')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_s_k_p');
    }
};
