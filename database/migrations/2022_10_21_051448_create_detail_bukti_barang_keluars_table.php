<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailBuktiBarangKeluarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_bukti_barang_keluars', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('bukti_barang_keluar_id')->index('bukti_barang_keluar_id');
            $table->integer('detail_bukti_barang_masuk_id')->index('barang_id');
            $table->integer('barang_id')->index('barang_id_2');
            $table->string('nama_barang', 200)->nullable();
            $table->integer('jumlah')->default(0);
            $table->integer('harga')->nullable()->default(0);
            $table->integer('gabungan_id')->nullable();
            $table->string('gabungan', 100)->nullable();
            $table->integer('jumlah_di_camp')->default(0);
            $table->timestamp('created_at')->useCurrent();
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
        Schema::dropIfExists('detail_bukti_barang_keluars');
    }
}
