<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LokasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
  	DB::table('lokasis')->insert([
	    'nama' => 'Lokasi 1',
	    'kode' => 'L-1',
	    'alamat' => 'alamat 1'
	]);
    }
}
