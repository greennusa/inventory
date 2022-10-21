<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToDetailBuktiBarangMasuksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detail_bukti_barang_masuks', function (Blueprint $table) {
            $table->foreign(['bukti_barang_masuk_id'], 'detail_bukti_barang_masuks_ibfk_1')->references(['id'])->on('bukti_barang_masuks')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['detail_pemesanan_barang_id'], 'detail_bukti_barang_masuks_ibfk_3')->references(['id'])->on('detail_pemesanan_barangs');
            $table->foreign(['barang_id'], 'detail_bukti_barang_masuks_ibfk_2')->references(['id'])->on('barangs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detail_bukti_barang_masuks', function (Blueprint $table) {
            $table->dropForeign('detail_bukti_barang_masuks_ibfk_1');
            $table->dropForeign('detail_bukti_barang_masuks_ibfk_3');
            $table->dropForeign('detail_bukti_barang_masuks_ibfk_2');
        });
    }
}
