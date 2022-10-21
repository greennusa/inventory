<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailPermintaanBarang extends Model
{
    
    protected $guarded = [];

    public function barang()
	{
		return $this->belongsTo(Barang::class);
	}
	public function permintaan()
	{
		return $this->belongsTo(PermintaanBarang::class,'permintaan_id');
	}

	public function satuan(){
    	return $this->belongsTo('App\Satuan','satuan_id');
    }
	
	public function pemasok(){
		return $this->belongsTo(Pemasok::class,'pemasok_id');
	}
}
