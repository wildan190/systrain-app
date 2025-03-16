<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('detail_perusahaan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('detail_peserta_id')->nullable()->constrained('detail_pesertas')->nullOnDelete();
            $table->string('kode_perusahaan')->nullable();
            $table->string('nama_perusahaan')->nullable();
            $table->text('alamat')->nullable();
            $table->string('telepon')->nullable();
            $table->string('jabatan')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('detail_perusahaan');
    }
};
