<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailBuktiBarangMasuksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_bukti_barang_masuks', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('bukti_barang_masuk_id')->index('bukti_barang_masuk_id');
            $table->integer('detail_pemesanan_barang_id')->index('detail_pemesanan_barang_id');
            $table->integer('barang_id')->index('barang_id');
            $table->string('nama_barang', 200)->nullable();
            $table->integer('jumlah')->default(0);
            $table->integer('harga')->default(0);
            $table->string('keterangan')->nullable();
            $table->boolean('kelengkapan')->default(false);
            $table->integer('status')->default(0);
            $table->integer('gabungan_id')->nullable();
            $table->string('gabungan', 100)->nullable();
            $table->timestamp('created_at')->useCurrentOnUpdate()->useCurrent();
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_bukti_barang_masuks');
    }
}
