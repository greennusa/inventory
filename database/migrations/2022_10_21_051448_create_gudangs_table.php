<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGudangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gudangs', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('detail_bukti_barang_masuk_id')->index('bukti_barang_masuk_id');
            $table->integer('barang_id')->index('barang_id');
            $table->string('nama_barang', 200)->nullable();
            $table->integer('stok');
            $table->integer('harga')->default(0);
            $table->integer('status')->default(0);
            $table->integer('gabungan_id')->nullable();
            $table->string('gabungan', 100)->nullable();
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
        Schema::dropIfExists('gudangs');
    }
}
