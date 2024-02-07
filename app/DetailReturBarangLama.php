<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailReturBarangLama extends Model
{
    protected $guarded = [];

    public function barang()
	{
		return $this->belongsTo(Barang::class,'barang_id','id');
	}

	public function pemakaian_lama()
	{
		return $this->belongsTo(DetailPemakaianBarangLama::class);
	}

	
}
