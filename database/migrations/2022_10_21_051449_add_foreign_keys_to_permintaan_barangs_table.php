<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToPermintaanBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('permintaan_barangs', function (Blueprint $table) {
            $table->foreign(['disetujui_id'], 'permintaan_barangs_ibfk_5')->references(['id'])->on('users');
            $table->foreign(['unit_id'], 'permintaan_barangs_ibfk_7')->references(['id'])->on('units');
            $table->foreign(['lokasi_id'], 'permintaan_barangs_ibfk_2')->references(['id'])->on('lokasis');
            $table->foreign(['diperiksa_id'], 'permintaan_barangs_ibfk_4')->references(['id'])->on('users');
            $table->foreign(['pembuat_id'], 'permintaan_barangs_ibfk_6')->references(['id'])->on('users');
            $table->foreign(['diketahui_id'], 'permintaan_barangs_ibfk_3')->references(['id'])->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('permintaan_barangs', function (Blueprint $table) {
            $table->dropForeign('permintaan_barangs_ibfk_5');
            $table->dropForeign('permintaan_barangs_ibfk_7');
            $table->dropForeign('permintaan_barangs_ibfk_2');
            $table->dropForeign('permintaan_barangs_ibfk_4');
            $table->dropForeign('permintaan_barangs_ibfk_6');
            $table->dropForeign('permintaan_barangs_ibfk_3');
        });
    }
}
