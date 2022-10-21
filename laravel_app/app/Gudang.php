<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gudang extends Model
{	

    protected $guarded = [];

    public function barang()
	{
		return $this->belongsTo('App\Barang','barang_id','id');
	}

	public function detail_bbm()
	{
		return $this->belongsTo('App\DetailBuktiBarangMasuk','detail_bukti_barang_masuk_id','id');
	}

	public function serial(){
		return $this->hasMany(SerialGudang::class);
	}

	public function delete(){
    	$this->serial()->delete();
    	parent::delete();
    }
}
