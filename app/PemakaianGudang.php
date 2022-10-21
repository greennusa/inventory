<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PemakaianGudang extends Model
{
    protected $guarded = [];

    
    public function detail(){
    	return $this->hasMany(DetailPemakaianGudang::class,'pemakaian_gudang_id');
    }
}
