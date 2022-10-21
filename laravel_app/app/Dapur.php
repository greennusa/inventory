<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dapur extends Model
{
    protected $guarded = [];

    public function camp(){
    	return $this->hasMany(Camp::class,'dapur');
    }

    public function pemakaian(){
    	return $this->hasMany(DetailPemakaianBarang::class,'dapur');
    }
}
