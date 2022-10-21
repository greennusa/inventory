<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailPemakaianGudangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_pemakaian_gudangs', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('pemakaian_gudang_id');
            $table->integer('detail_bukti_barang_masuk_id')->index('detail_bukti_barang_masuk_id');
            $table->text('keterangan');
            $table->integer('stok');
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
        Schema::dropIfExists('detail_pemakaian_gudangs');
    }
}
