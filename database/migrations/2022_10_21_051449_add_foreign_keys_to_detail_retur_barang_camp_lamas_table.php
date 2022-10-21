<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToDetailReturBarangCampLamasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detail_retur_barang_camp_lamas', function (Blueprint $table) {
            $table->foreign(['barang_id'], 'detail_retur_barang_camp_lamas_ibfk_4')->references(['id'])->on('barangs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detail_retur_barang_camp_lamas', function (Blueprint $table) {
            $table->dropForeign('detail_retur_barang_camp_lamas_ibfk_4');
        });
    }
}
