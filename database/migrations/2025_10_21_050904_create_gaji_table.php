<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('gaji', function (Blueprint $table) {
            $table->id('id_gaji');
            $table->unsignedBigInteger('id_karyawan');
            $table->unsignedBigInteger('id_lembur');
            $table->date('periode');
            $table->integer('lama_lembur');
            $table->integer('total_lembur');
            $table->integer('total_bonus');
            $table->integer('total_tunjangan');
            $table->integer('total_pendapatan');

            // Tambahkan kolom serahkan untuk status gaji sudah/belum diserahkan admin
            $table->enum('serahkan', ['belum', 'sudah'])->default('belum');

            $table->timestamps();

            // Relasi
            $table->foreign('id_karyawan')
                ->references('id_karyawan')
                ->on('karyawan')
                ->onDelete('cascade');

            $table->foreign('id_lembur')
                ->references('id_lembur')
                ->on('lembur')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gaji');
    }
};
