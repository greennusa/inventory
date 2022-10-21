<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailReturBarangLamasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_retur_barang_lamas', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('retur_barang_id')->index('retur_barang_id');
            $table->integer('detail_pemakaian_barang_lama_id')->index('detail_pemakaian_barang_lama_id');
            $table->integer('barang_id')->index('barang_id');
            $table->integer('jumlah');
            $table->string('keterangan')->nullable();
            $table->boolean('status')->default(false);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');

            $table->index(['detail_pemakaian_barang_lama_id'], 'pemakaian_barang_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_retur_barang_lamas');
    }
}
