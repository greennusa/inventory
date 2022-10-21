<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToDetailPemakaianBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detail_pemakaian_barangs', function (Blueprint $table) {
            $table->foreign(['pemakaian_barang_id'], 'detail_pemakaian_barangs_ibfk_1')->references(['id'])->on('pemakaian_barangs');
            $table->foreign(['detail_bukti_barang_keluar_id'], 'detail_pemakaian_barangs_ibfk_3')->references(['id'])->on('detail_bukti_barang_keluars');
            $table->foreign(['barang_id'], 'detail_pemakaian_barangs_ibfk_2')->references(['id'])->on('barangs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detail_pemakaian_barangs', function (Blueprint $table) {
            $table->dropForeign('detail_pemakaian_barangs_ibfk_1');
            $table->dropForeign('detail_pemakaian_barangs_ibfk_3');
            $table->dropForeign('detail_pemakaian_barangs_ibfk_2');
        });
    }
}
