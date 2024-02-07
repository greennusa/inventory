<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BuktiBarangMasuk extends Model
{
    protected $guarded = [];
    

    public function pemesanan()
	{
		return $this->belongsTo(PemesananBarang::class,'pemesanan_barang_id');
	}

	public function detail(){
		return $this->hasMany(DetailBuktiBarangMasuk::class,'bukti_barang_masuk_id');
	}

	public function delete(){
    	$this->detail()->delete();
    	parent::delete();
    }

    public function getKelengkapanAttribute()
	{
		return $this->detail()->where('kelengkapan',0)->count();
	}
	

  //   public function kelengkapan(){
  //   	$this->detail->each(function ($item)
		// {
		// 	if($item->kelengkapan == 0){
		// 		return true;
		// 	}
		// });
  //   }
}
