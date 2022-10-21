<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampLamasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('camp_lamas', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('barang_id')->index('barang_id');
            $table->string('kode_barang')->nullable();
            $table->string('nama_barang', 200);
            $table->integer('harga');
            $table->integer('satuan_id')->index('satuan_id');
            $table->integer('stok_awal');
            $table->integer('stok');
            $table->integer('stok_retur')->default(0);
            $table->integer('status')->default(0);
            $table->date('tanggal');
            $table->integer('dapur')->default(0);
            $table->text('keterangan')->nullable();
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
        Schema::dropIfExists('camp_lamas');
    }
}
