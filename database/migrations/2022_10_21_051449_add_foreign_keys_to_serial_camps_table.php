<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToSerialCampsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('serial_camps', function (Blueprint $table) {
            $table->foreign(['camp_id'], 'serial_camps_ibfk_1')->references(['id'])->on('camps')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('serial_camps', function (Blueprint $table) {
            $table->dropForeign('serial_camps_ibfk_1');
        });
    }
}
