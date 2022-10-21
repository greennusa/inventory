<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermintaanBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permintaan_barangs', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('nomor');
            $table->date('tanggal');
            $table->string('destination', 10);
            $table->integer('lokasi_id');
            $table->integer('unit_id')->index('unit_id');
            $table->string('sifat', 10)->nullable();
            $table->boolean('setuju')->default(false);
            $table->string('keperluan')->nullable();
            $table->integer('diketahui_id')->nullable()->index('permintaan_barangs_ibfk_3');
            $table->integer('diperiksa_id')->index('diperiksa_id');
            $table->integer('disetujui_id')->nullable()->index('permintaan_barangs_ibfk_5');
            $table->integer('pembuat_id')->index('pembuat_id');
            $table->integer('diketahui_id_2')->nullable();
            $table->integer('disetujui_id_2')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');

            $table->index(['lokasi_id', 'unit_id', 'diketahui_id', 'diperiksa_id', 'disetujui_id', 'pembuat_id'], 'lokasi_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permintaan_barangs');
    }
}
