<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->increments('id');
            $table->string('no_tiket');
            $table->unsignedInteger('kecamatan_id');
            $table->unsignedInteger('kelurahan_id');
            $table->unsignedInteger('pelayanan_id');
            $table->unsignedInteger('seksi_id');
            $table->string('no_berkas')->nullable();
            $table->unsignedInteger('hak_id');
            $table->string('no_hak');
            $table->string('jenis_arsip');
            $table->string('keterangan')->nullable();
            $table->string('jenis_history');
            $table->unsignedBigInteger('urgent');
            $table->unsignedInteger('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('peminjaman');
    }
};
