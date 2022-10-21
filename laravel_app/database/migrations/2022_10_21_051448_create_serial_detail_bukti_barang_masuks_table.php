<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSerialDetailBuktiBarangMasuksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('serial_detail_bukti_barang_masuks', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('detail_bukti_barang_masuk_id')->index('detail_bukti_barang_masuk_id');
            $table->string('sn', 200)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('serial_detail_bukti_barang_masuks');
    }
}
