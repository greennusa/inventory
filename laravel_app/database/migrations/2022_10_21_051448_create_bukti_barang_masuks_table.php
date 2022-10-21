<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuktiBarangMasuksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bukti_barang_masuks', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('nomor')->unique('nomor');
            $table->date('tanggal');
            $table->integer('pemesanan_barang_id')->index('permintaan_id');
            $table->string('keterangan');
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
            $table->integer('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bukti_barang_masuks');
    }
}
