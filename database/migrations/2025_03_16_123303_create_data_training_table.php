<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('data_training', function (Blueprint $table) {
            $table->id();
            $table->foreignId('detail_peserta_id')->constrained()->onDelete('cascade');
            $table->string('upload_pas_foto_biru')->nullable();
            $table->string('upload_ktp')->nullable();
            $table->string('upload_npwp')->nullable();
            $table->string('upload_cv')->nullable();
            $table->string('upload_sk_kerja')->nullable();
            $table->string('upload_keterangan_sehat')->nullable();
            $table->string('upload_pakta_integritas')->nullable();
            $table->string('upload_ijazah')->nullable();
            $table->string('upload_sertifikat_k3')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('data_training');
    }
};
