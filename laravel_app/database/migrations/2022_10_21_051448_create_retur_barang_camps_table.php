<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReturBarangCampsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retur_barang_camps', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('nomor', 100);
            $table->date('tanggal');
            $table->integer('diterima_id')->index('diterima_id');
            $table->integer('dibawa_id')->index('dibawa_id');
            $table->integer('dikirim_id')->index('dikirim_Id');
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
        Schema::dropIfExists('retur_barang_camps');
    }
}
