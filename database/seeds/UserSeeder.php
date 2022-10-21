<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash; 

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    $this->call([
      GroupSeeder::class,
      JabatanSeeder::class,
      LokasiSeeder::class
    ]);

    DB::table('users')->insert([
      'username' => 'admin',
      'nama' => 'admin',
      'email' => 'admin@gmail.com',
      'password' => Hash::make('password'),
      'lokasi_id' => 1,
      'group_id' => 1,
      'jabatan_Id' => 1,
      'active' => 1
    ]);
    }
}
