<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailPemesananBarang extends Model
{
    protected $guarded = [];

    public function barang()
	{
		return $this->belongsTo(Barang::class);
	}

	public function detail_permintaan()
	{
		return $this->belongsTo(DetailPermintaanBarang::class,'detail_permintaan_barang_id');
	}

	public function pemesanan(){
		return $this->belongsTo(PemesananBarang::class,'pemesanan_barang_id');
	}
}
