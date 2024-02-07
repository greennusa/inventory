<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToDetailBuktiBarangKeluarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detail_bukti_barang_keluars', function (Blueprint $table) {
            $table->foreign(['barang_id'], 'detail_bukti_barang_keluars_ibfk_2')->references(['id'])->on('barangs');
            $table->foreign(['detail_bukti_barang_masuk_id'], 'detail_bukti_barang_keluars_ibfk_3')->references(['id'])->on('detail_bukti_barang_masuks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detail_bukti_barang_keluars', function (Blueprint $table) {
            $table->dropForeign('detail_bukti_barang_keluars_ibfk_2');
            $table->dropForeign('detail_bukti_barang_keluars_ibfk_3');
        });
    }
}
