<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pemasok extends Model
{
    protected $guarded = [];

    public function detail_permintaan(){
    	return $this->hasMany('App\DetailPermintaanBarang','pemasok_id');
    }
}
