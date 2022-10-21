<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailBuktiBarangKeluar extends Model
{
    protected $guarded = [];

    public function barang()
	{
		return $this->belongsTo(Barang::class);
	}

	// public function pemesanan()
	// {
	// 	return $this->belongsTo(PemesananBarang::class,'pemesanan_barang_id');
	// }

	public function detail_bbm()
	{
		return $this->belongsTo(DetailBuktiBarangMasuk::class,'detail_bukti_barang_masuk_id');
	}

	public function bbk()
	{
		return $this->belongsTo(BuktiBarangKeluar::class,'bukti_barang_keluar_id');
	}

	public function serial()
	{
		return $this->hasMany(SerialDetailBuktiBarangKeluar::class);
	}

	
	

	public function delete(){
    	$this->serial()->delete();
    	parent::delete();
    }
}
