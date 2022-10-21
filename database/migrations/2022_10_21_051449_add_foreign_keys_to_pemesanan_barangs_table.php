<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToPemesananBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pemesanan_barangs', function (Blueprint $table) {
            $table->foreign(['menyetujui'], 'pemesanan_barangs_ibfk_1')->references(['id'])->on('users');
            $table->foreign(['memesan'], 'pemesanan_barangs_ibfk_3')->references(['id'])->on('users');
            $table->foreign(['mengetahui'], 'pemesanan_barangs_ibfk_2')->references(['id'])->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pemesanan_barangs', function (Blueprint $table) {
            $table->dropForeign('pemesanan_barangs_ibfk_1');
            $table->dropForeign('pemesanan_barangs_ibfk_3');
            $table->dropForeign('pemesanan_barangs_ibfk_2');
        });
    }
}
