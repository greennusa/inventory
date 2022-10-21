<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToBuktiBarangMasuksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bukti_barang_masuks', function (Blueprint $table) {
            $table->foreign(['pemesanan_barang_id'], 'bukti_barang_masuks_ibfk_1')->references(['id'])->on('pemesanan_barangs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bukti_barang_masuks', function (Blueprint $table) {
            $table->dropForeign('bukti_barang_masuks_ibfk_1');
        });
    }
}
