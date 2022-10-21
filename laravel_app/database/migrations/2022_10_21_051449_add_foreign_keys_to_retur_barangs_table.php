<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToReturBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('retur_barangs', function (Blueprint $table) {
            $table->foreign(['diterima_id'], 'retur_barangs_ibfk_1')->references(['id'])->on('users');
            $table->foreign(['dikirim_id'], 'retur_barangs_ibfk_3')->references(['id'])->on('users');
            $table->foreign(['dibawa_id'], 'retur_barangs_ibfk_2')->references(['id'])->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('retur_barangs', function (Blueprint $table) {
            $table->dropForeign('retur_barangs_ibfk_1');
            $table->dropForeign('retur_barangs_ibfk_3');
            $table->dropForeign('retur_barangs_ibfk_2');
        });
    }
}
