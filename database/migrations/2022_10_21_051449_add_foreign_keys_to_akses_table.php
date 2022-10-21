<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToAksesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('akses', function (Blueprint $table) {
            $table->foreign(['group_id'], 'akses_ibfk_1')->references(['id'])->on('groups');
            $table->foreign(['modul_id'], 'akses_ibfk_2')->references(['id'])->on('moduls');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('akses', function (Blueprint $table) {
            $table->dropForeign('akses_ibfk_1');
            $table->dropForeign('akses_ibfk_2');
        });
    }
}
