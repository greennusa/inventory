<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailPemakaianBarangLamasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_pemakaian_barang_lamas', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('pemakaian_barang_id')->index('pemakaian_barang_id');
            $table->integer('camp_lama_id')->index('camp_lama_id');
            $table->integer('barang_id')->index('barang_id');
            $table->string('nama_barang', 200)->nullable();
            $table->integer('jumlah');
            $table->integer('harga');
            $table->integer('jumlah_retur')->default(0);
            $table->integer('jumlah_awal')->nullable();
            $table->boolean('status')->default(false);
            $table->integer('dapur')->default(0);
            $table->text('keterangan')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->dateTime('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_pemakaian_barang_lamas');
    }
}
