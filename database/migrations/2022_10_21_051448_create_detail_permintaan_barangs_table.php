<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailPermintaanBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_permintaan_barangs', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('permintaan_id');
            $table->integer('satuan_id')->index('satuan_Id');
            $table->integer('barang_id');
            $table->string('kode_barang')->nullable();
            $table->string('nama_barang')->nullable();
            $table->integer('jumlah')->default(0);
            $table->integer('jumlah_disetujui')->default(0);
            $table->integer('harga')->default(0);
            $table->string('keterangan')->nullable();
            $table->integer('pemasok_id')->default(-1)->index('pemasok_id');
            $table->boolean('status')->default(false);
            $table->boolean('dipesan')->default(false);
            $table->string('gabungan', 100)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');

            $table->index(['barang_id', 'pemasok_id'], 'barang_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_permintaan_barangs');
    }
}
