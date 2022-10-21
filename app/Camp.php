<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Camp extends Model
{
	use SoftDeletes;
	protected $guarded = [];

    public function barang()
	{
		return $this->belongsTo('App\Barang','barang_id','id');
	}

	public function detail_bbk()
	{
		return $this->belongsTo(DetailBuktiBarangKeluar::class,'detail_bukti_barang_keluar_id','id');
	}

	public function serial(){
		return $this->hasMany(SerialCamp::class);
	}

	public function delete(){
    	$this->serial()->delete();
    	parent::delete();
    }

    public function camp(){
    	return $this->belongsTo(Dapur::class,'dapur','id');
    }
}
