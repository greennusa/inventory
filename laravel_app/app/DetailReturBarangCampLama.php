<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailReturBarangCampLama extends Model
{
    protected $guarded = [];

    public function barang()
	{
		return $this->belongsTo(Barang::class,'barang_id','id');
	}

	public function camp_lama()
	{
		return $this->belongsTo(CampLama::class);
	}
}
