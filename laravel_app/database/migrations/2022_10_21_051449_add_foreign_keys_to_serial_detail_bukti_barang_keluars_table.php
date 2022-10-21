<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToSerialDetailBuktiBarangKeluarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('serial_detail_bukti_barang_keluars', function (Blueprint $table) {
            $table->foreign(['detail_bukti_barang_keluar_id'], 'serial_detail_bukti_barang_keluars_ibfk_1')->references(['id'])->on('detail_bukti_barang_keluars')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('serial_detail_bukti_barang_keluars', function (Blueprint $table) {
            $table->dropForeign('serial_detail_bukti_barang_keluars_ibfk_1');
        });
    }
}
