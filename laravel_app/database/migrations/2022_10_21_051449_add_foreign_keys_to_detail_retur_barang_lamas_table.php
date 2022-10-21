<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToDetailReturBarangLamasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detail_retur_barang_lamas', function (Blueprint $table) {
            $table->foreign(['barang_id'], 'detail_retur_barang_lamas_ibfk_2')->references(['id'])->on('barangs');
            $table->foreign(['retur_barang_id'], 'detail_retur_barang_lamas_ibfk_3')->references(['id'])->on('retur_barangs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detail_retur_barang_lamas', function (Blueprint $table) {
            $table->dropForeign('detail_retur_barang_lamas_ibfk_2');
            $table->dropForeign('detail_retur_barang_lamas_ibfk_3');
        });
    }
}
