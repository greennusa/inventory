<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToSerialGudangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('serial_gudangs', function (Blueprint $table) {
            $table->foreign(['gudang_id'], 'serial_gudangs_ibfk_1')->references(['id'])->on('gudangs')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('serial_gudangs', function (Blueprint $table) {
            $table->dropForeign('serial_gudangs_ibfk_1');
        });
    }
}
