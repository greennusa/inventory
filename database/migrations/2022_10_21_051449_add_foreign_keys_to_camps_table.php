<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToCampsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('camps', function (Blueprint $table) {
            $table->foreign(['barang_id'], 'camps_ibfk_1')->references(['id'])->on('barangs');
            $table->foreign(['detail_bukti_barang_keluar_id'], 'camps_ibfk_2')->references(['id'])->on('detail_bukti_barang_keluars');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('camps', function (Blueprint $table) {
            $table->dropForeign('camps_ibfk_1');
            $table->dropForeign('camps_ibfk_2');
        });
    }
}
