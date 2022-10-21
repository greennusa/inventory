<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToDetailReturBarangCampsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detail_retur_barang_camps', function (Blueprint $table) {
            $table->foreign(['retur_barang_camp_id'], 'detail_retur_barang_camps_ibfk_1')->references(['id'])->on('retur_barang_camps');
            $table->foreign(['barang_id'], 'detail_retur_barang_camps_ibfk_4')->references(['id'])->on('barangs');
            $table->foreign(['detail_bukti_barang_keluar_id'], 'detail_retur_barang_camps_ibfk_3')->references(['id'])->on('detail_bukti_barang_keluars');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detail_retur_barang_camps', function (Blueprint $table) {
            $table->dropForeign('detail_retur_barang_camps_ibfk_1');
            $table->dropForeign('detail_retur_barang_camps_ibfk_4');
            $table->dropForeign('detail_retur_barang_camps_ibfk_3');
        });
    }
}
