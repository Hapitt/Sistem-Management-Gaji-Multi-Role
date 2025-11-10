<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('karyawan', function (Blueprint $table) {
            $table->id('id_karyawan');

            // Foreign keys
            $table->foreignId('user_id')->nullable()
                ->constrained('users')
                ->onDelete('cascade');

            $table->foreignId('id_jabatan')
                ->constrained('jabatan', 'id_jabatan')
                ->onDelete('cascade');

            $table->foreignId('id_rating')
                ->constrained('rating', 'id_rating')
                ->onDelete('cascade');

            // Data pribadi
            $table->string('nama', 50);
            $table->string('divisi', 50);
            $table->text('alamat');
            $table->tinyInteger('umur'); // angka, bukan string
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('status', 20);
            $table->string('foto', 255)->nullable();

            // Timestamps otomatis
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('karyawan');
    }
};
