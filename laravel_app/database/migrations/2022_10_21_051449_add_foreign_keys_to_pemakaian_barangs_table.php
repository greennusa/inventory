<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToPemakaianBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pemakaian_barangs', function (Blueprint $table) {
            $table->foreign(['diketahui_id'], 'pemakaian_barangs_ibfk_1')->references(['id'])->on('users');
            $table->foreign(['unit_id'], 'pemakaian_barangs_ibfk_4')->references(['id'])->on('units');
            $table->foreign(['dibuat_id'], 'pemakaian_barangs_ibfk_3')->references(['id'])->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pemakaian_barangs', function (Blueprint $table) {
            $table->dropForeign('pemakaian_barangs_ibfk_1');
            $table->dropForeign('pemakaian_barangs_ibfk_4');
            $table->dropForeign('pemakaian_barangs_ibfk_3');
        });
    }
}
