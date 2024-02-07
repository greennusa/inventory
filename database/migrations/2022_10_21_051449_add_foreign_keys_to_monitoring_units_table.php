<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToMonitoringUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('monitoring_units', function (Blueprint $table) {
            $table->foreign(['unit_id'], 'monitoring_units_ibfk_1')->references(['id'])->on('units');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('monitoring_units', function (Blueprint $table) {
            $table->dropForeign('monitoring_units_ibfk_1');
        });
    }
}
