<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailPemakaianBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_pemakaian_barangs', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('pemakaian_barang_id')->index('pemakaian_barang_id');
            $table->integer('detail_bukti_barang_keluar_id')->index('detail_bukti_barang_keluar_id');
            $table->integer('barang_id')->index('barang_id');
            $table->string('nama_barang', 200)->nullable();
            $table->integer('harga');
            $table->integer('jumlah');
            $table->integer('jumlah_retur')->default(0);
            $table->integer('jumlah_awal')->nullable();
            $table->integer('gabungan_id')->nullable();
            $table->string('gabungan', 100)->nullable();
            $table->boolean('status')->default(false);
            $table->integer('dapur')->default(0);
            $table->text('keterangan')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');

            $table->index(['detail_bukti_barang_keluar_id'], 'bukti_barang_keluar_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_pemakaian_barangs');
    }
}
