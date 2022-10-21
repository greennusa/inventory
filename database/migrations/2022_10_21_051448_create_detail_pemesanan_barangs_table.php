<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailPemesananBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_pemesanan_barangs', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('pemesanan_barang_id');
            $table->integer('detail_permintaan_barang_id')->index('detail_permintaan_barang_id');
            $table->integer('detail_gabungan')->nullable();
            $table->integer('barang_id')->index('barang_id');
            $table->string('kode_barang', 200)->nullable();
            $table->string('nama_barang')->nullable();
            $table->integer('jumlah')->default(0);
            $table->integer('harga')->default(0);
            $table->string('keterangan', 100)->nullable();
            $table->string('keperluan', 225)->nullable();
            $table->boolean('status')->default(false);
            $table->boolean('masuk')->default(false);
            $table->string('gabungan', 100)->nullable();
            $table->timestamp('created_at')->useCurrentOnUpdate()->useCurrent();
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');

            $table->index(['pemesanan_barang_id', 'barang_id'], 'pemesanan_barang_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_pemesanan_barangs');
    }
}
