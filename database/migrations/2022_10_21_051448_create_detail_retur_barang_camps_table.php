<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailReturBarangCampsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_retur_barang_camps', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('retur_barang_camp_id')->index('retur_barang_camp_id');
            $table->integer('camp_id')->index('camp_id');
            $table->integer('barang_id')->index('barang_id');
            $table->integer('detail_bukti_barang_keluar_id')->index('detail_bukti_barang_keluar_id');
            $table->integer('jumlah');
            $table->string('keterangan')->nullable();
            $table->boolean('status')->default(false);
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
        Schema::dropIfExists('detail_retur_barang_camps');
    }
}
