<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('barangs', function (Blueprint $table) {
            $table->foreign(['satuan_id'], 'barangs_ibfk_2')->references(['id'])->on('satuans');
            $table->foreign(['unit_id'], 'barangs_ibfk_4')->references(['id'])->on('units');
            $table->foreign(['kategori_id'], 'barangs_ibfk_3')->references(['id'])->on('kategoris');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('barangs', function (Blueprint $table) {
            $table->dropForeign('barangs_ibfk_2');
            $table->dropForeign('barangs_ibfk_4');
            $table->dropForeign('barangs_ibfk_3');
        });
    }
}
