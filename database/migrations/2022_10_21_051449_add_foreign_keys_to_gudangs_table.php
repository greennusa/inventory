<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToGudangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gudangs', function (Blueprint $table) {
            $table->foreign(['barang_id'], 'gudangs_ibfk_1')->references(['id'])->on('barangs');
            $table->foreign(['detail_bukti_barang_masuk_id'], 'gudangs_ibfk_2')->references(['id'])->on('detail_bukti_barang_masuks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('gudangs', function (Blueprint $table) {
            $table->dropForeign('gudangs_ibfk_1');
            $table->dropForeign('gudangs_ibfk_2');
        });
    }
}
