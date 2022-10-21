<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('camps', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('barang_id')->index('barang_id');
            $table->integer('detail_bukti_barang_keluar_id')->index('bukti_barang_keluar_id');
            $table->string('nama_barang', 200)->nullable();
            $table->integer('harga')->default(0);
            $table->integer('gabungan_id')->nullable();
            $table->string('gabungan', 100)->nullable();
            $table->integer('stok_awal')->default(0);
            $table->integer('stok');
            $table->integer('stok_retur')->default(0);
            $table->boolean('status')->default(false);
            $table->string('keterangan')->nullable();
            $table->integer('dapur')->default(0);
            $table->date('tanggal');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
            $table->dateTime('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('camps');
    }
}
