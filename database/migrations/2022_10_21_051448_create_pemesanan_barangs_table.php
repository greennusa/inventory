<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePemesananBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pemesanan_barangs', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('nomor')->nullable()->default('');
            $table->date('tanggal');
            $table->integer('pemasok_id')->index('permintaan_id_2');
            $table->boolean('status');
            $table->string('dikirim', 200)->nullable();
            $table->string('keterangan', 200)->nullable();
            $table->string('keperluan')->nullable();
            $table->integer('menyetujui')->default(1)->index('menyetujui');
            $table->integer('mengetahui')->default(1)->index('mengetahui');
            $table->integer('memesan')->default(1)->index('memesan');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');

            $table->index(['pemasok_id'], 'pemasok_id');
            $table->index(['pemasok_id', 'menyetujui', 'mengetahui', 'memesan'], 'pemasok_id_2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pemesanan_barangs');
    }
}
