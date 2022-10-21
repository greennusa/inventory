<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToDetailPermintaanBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detail_permintaan_barangs', function (Blueprint $table) {
            $table->foreign(['pemasok_id'], 'detail_permintaan_barangs_ibfk_1')->references(['id'])->on('pemasoks');
            $table->foreign(['satuan_id'], 'detail_permintaan_barangs_ibfk_4')->references(['id'])->on('satuans');
            $table->foreign(['barang_id'], 'detail_permintaan_barangs_ibfk_2')->references(['id'])->on('barangs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detail_permintaan_barangs', function (Blueprint $table) {
            $table->dropForeign('detail_permintaan_barangs_ibfk_1');
            $table->dropForeign('detail_permintaan_barangs_ibfk_4');
            $table->dropForeign('detail_permintaan_barangs_ibfk_2');
        });
    }
}
