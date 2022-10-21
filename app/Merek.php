<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Merek extends Model
{
    protected $guarded = [];

    public function barang(){
    	return $this->hasMany(Barang::class);
    }

    
}
