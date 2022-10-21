<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barangs', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('qrcode', 100)->nullable();
            $table->string('kode', 100);
            $table->string('nama', 100);
            $table->integer('unit_id');
            $table->integer('kategori_id')->index('barangs_ibfk_3');
            $table->double('harga');
            $table->string('halaman', 50)->nullable();
            $table->string('indeks', 50)->nullable();
            $table->integer('satuan_id')->index('satuan_id');
            $table->string('keterangan', 200)->nullable();
            $table->string('gambar', 100);
            $table->boolean('pakai_sn')->default(true);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');

            $table->index(['unit_id', 'kategori_id', 'satuan_id'], 'merek_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barangs');
    }
}
