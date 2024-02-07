<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToSerialCampLamasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('serial_camp_lamas', function (Blueprint $table) {
            $table->foreign(['camp_lama_id'], 'serial_camp_lamas_ibfk_1')->references(['id'])->on('camp_lamas')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('serial_camp_lamas', function (Blueprint $table) {
            $table->dropForeign('serial_camp_lamas_ibfk_1');
        });
    }
}
