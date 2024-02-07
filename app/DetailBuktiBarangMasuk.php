<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailBuktiBarangMasuk extends Model
{
    protected $guarded = [];
    

    public function barang()
	{
		return $this->belongsTo(Barang::class);
	}

	public function serial()
	{
		return $this->hasMany(SerialDetailBuktiBarangMasuk::class);
	}

	public function bbm(){
		return $this->belongsTo(BuktiBarangMasuk::class,'bukti_barang_masuk_id');
	}

	public function detail_pemesanan(){
		return $this->belongsTo(DetailPemesananBarang::class,'detail_pemesanan_barang_id');
	}
	

	public function delete(){
    	$this->serial()->delete();
    	parent::delete();
    }
}
