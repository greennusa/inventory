<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('camp_logs', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('nama_barang', 85);
            $table->integer('barang_id');
            $table->enum('aksi', ['pemakaian', 'penambahan'])->nullable();
            $table->integer('jumlah');
            $table->date('tanggal');
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('camp_logs');
    }
}
