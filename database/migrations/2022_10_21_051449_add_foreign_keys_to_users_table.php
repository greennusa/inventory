<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreign(['jabatan_id'], 'users_ibfk_1')->references(['id'])->on('jabatans');
            $table->foreign(['lokasi_id'], 'users_ibfk_3')->references(['id'])->on('lokasis');
            $table->foreign(['group_id'], 'users_ibfk_2')->references(['id'])->on('groups');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_ibfk_1');
            $table->dropForeign('users_ibfk_3');
            $table->dropForeign('users_ibfk_2');
        });
    }
}
