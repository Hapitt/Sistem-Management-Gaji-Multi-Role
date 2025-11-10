<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('gaji', function (Blueprint $table) {
            $table->timestamp('tanggal_serah')->nullable()->after('serahkan');
        });
    }

    public function down()
    {
        Schema::table('gaji', function (Blueprint $table) {
            $table->dropColumn('tanggal_serah');
        });
    }
};
