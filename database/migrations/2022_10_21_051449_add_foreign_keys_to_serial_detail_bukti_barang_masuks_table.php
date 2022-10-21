<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToSerialDetailBuktiBarangMasuksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('serial_detail_bukti_barang_masuks', function (Blueprint $table) {
            $table->foreign(['detail_bukti_barang_masuk_id'], 'serial_detail_bukti_barang_masuks_ibfk_1')->references(['id'])->on('detail_bukti_barang_masuks')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('serial_detail_bukti_barang_masuks', function (Blueprint $table) {
            $table->dropForeign('serial_detail_bukti_barang_masuks_ibfk_1');
        });
    }
}
