<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSerialCampsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('serial_camps', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('camp_id')->index('camp_id');
            $table->string('sn', 100)->nullable();
            $table->integer('permintaan_barang_id')->index('permintaan_barang_id');
            $table->integer('detail_bukti_barang_keluar_id')->nullable();
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
        Schema::dropIfExists('serial_camps');
    }
}
