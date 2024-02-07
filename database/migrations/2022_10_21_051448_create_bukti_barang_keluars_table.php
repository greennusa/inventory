<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuktiBarangKeluarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bukti_barang_keluars', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('nomor', 100);
            $table->date('tanggal')->nullable();
            $table->string('dikirim', 200)->nullable();
            $table->string('kepada', 200)->nullable();
            $table->integer('mengetahui')->nullable();
            $table->string('pengantar')->nullable();
            $table->integer('penerima')->nullable();
            $table->integer('pengirim')->nullable();
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
        Schema::dropIfExists('bukti_barang_keluars');
    }
}
