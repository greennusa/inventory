<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailPemakaianBarangLama extends Model
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

	public function pemakaian()
	{
		return $this->belongsTo(PemakaianBarang::class,'pemakaian_barang_id','id')->orderBy('unit_id');
	}
}
