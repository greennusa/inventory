<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('username')->unique('username');
            $table->string('password');
            $table->string('nama');
            $table->string('email', 200)->nullable();
            $table->integer('lokasi_id');
            $table->integer('group_id')->index('grup_id');
            $table->integer('jabatan_id')->index('jabatan_id');
            $table->boolean('active')->default(true);
            $table->rememberToken();
            $table->string('ttd', 200)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');

            $table->index(['lokasi_id', 'group_id', 'jabatan_id'], 'lokasi_id');
            $table->index(['lokasi_id', 'group_id', 'jabatan_id'], 'lokasi_id_2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
