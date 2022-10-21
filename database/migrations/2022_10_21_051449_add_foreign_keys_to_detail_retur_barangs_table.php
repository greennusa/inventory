<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToDetailReturBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detail_retur_barangs', function (Blueprint $table) {
            $table->foreign(['barang_id'], 'detail_retur_barangs_ibfk_2')->references(['id'])->on('barangs');
            $table->foreign(['detail_bukti_barang_keluar_id'], 'detail_retur_barangs_ibfk_4')->references(['id'])->on('detail_bukti_barang_keluars');
            $table->foreign(['retur_barang_id'], 'detail_retur_barangs_ibfk_3')->references(['id'])->on('retur_barangs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detail_retur_barangs', function (Blueprint $table) {
            $table->dropForeign('detail_retur_barangs_ibfk_2');
            $table->dropForeign('detail_retur_barangs_ibfk_4');
            $table->dropForeign('detail_retur_barangs_ibfk_3');
        });
    }
}
