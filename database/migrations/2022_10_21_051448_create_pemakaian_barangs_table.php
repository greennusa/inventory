<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePemakaianBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pemakaian_barangs', function (Blueprint $table) {
            $table->integer('id', true);
            $table->date('tanggal');
            $table->string('keterangan', 200);
            $table->integer('unit_id')->index('merek_id');
            $table->integer('diketahui_id')->index('diketahui_id');
            $table->string('diterima');
            $table->integer('dibuat_id')->index('dibuat_id');
            $table->string('lokasi', 100);
            $table->integer('piutang');
            $table->string('penggunaan', 20)->nullable();
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
        Schema::dropIfExists('pemakaian_barangs');
    }
}
