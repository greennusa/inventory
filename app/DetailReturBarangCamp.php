<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailReturBarangCamp extends Model
{
    protected $guarded = [];

    public function barang()
	{
		return $this->belongsTo(Barang::class,'barang_id','id');
	}

	public function detail_bbk()
	{
		return $this->belongsTo(DetailBuktiBarangKeluar::class,'detail_bukti_barang_keluar_id','id');
	}
}
