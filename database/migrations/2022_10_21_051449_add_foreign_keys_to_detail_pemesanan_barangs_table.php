<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToDetailPemesananBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detail_pemesanan_barangs', function (Blueprint $table) {
            $table->foreign(['barang_id'], 'detail_pemesanan_barangs_ibfk_1')->references(['id'])->on('barangs');
            $table->foreign(['detail_permintaan_barang_id'], 'detail_pemesanan_barangs_ibfk_3')->references(['id'])->on('detail_permintaan_barangs');
            $table->foreign(['pemesanan_barang_id'], 'detail_pemesanan_barangs_ibfk_2')->references(['id'])->on('pemesanan_barangs')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detail_pemesanan_barangs', function (Blueprint $table) {
            $table->dropForeign('detail_pemesanan_barangs_ibfk_1');
            $table->dropForeign('detail_pemesanan_barangs_ibfk_3');
            $table->dropForeign('detail_pemesanan_barangs_ibfk_2');
        });
    }
}
