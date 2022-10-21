<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Satuan extends Model
{
    
    protected $guarded = [];


    public function getJenisLabelAttribute()
	{
		return $this->jenis  == 0 ? "Cair" : "Padat";
	}

	public function barang(){
    	return $this->hasMany('App\Barang','satuan_id');
    }
}
