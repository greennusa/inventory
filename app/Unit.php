<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $guarded = [];


    public function jenis_unit(){
    	return $this->belongsTo(JenisUnit::class);
    }

    public function barang(){
    	return $this->hasMany(Barang::class);
    }

    public function monitoring(){
    	return $this->hasMany(Barang::class);
    }

    public function pemakaian(){
        return $this->hasMany(PemakaianBarang::class);
    }

}
