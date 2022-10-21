<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PermintaanBarang extends Model
{
    protected $guarded = [];

    public function detail(){
		return $this->hasMany(DetailPermintaanBarang::class,'permintaan_id')->join('barangs', 'detail_permintaan_barangs.barang_id', '=', 'barangs.id')->select('detail_permintaan_barangs.*')->orderBy('barangs.nama','ASC');
	}



	public function diperiksa()
	{
		return $this->belongsTo(User::class,'diperiksa_id');
	}
	
    public function unit(){
    	return $this->belongsTo(Unit::class);
    }

    public function kategori(){
    	return $this->belongsTo('App\Kategori','kategori_id');
    }

    public function satuan(){
    	return $this->belongsTo('App\Satuan','satuan_id');
    }

    public function diketahui(){
		return $this->belongsTo(User::class,'diketahui_id');
	}
	public function diketahui2(){
		return $this->belongsTo(User::class,'diketahui_id_2');
	}
	public function disetujui(){
			return $this->belongsTo(User::class,'disetujui_id');
	}
	public function disetujui2(){
			return $this->belongsTo(User::class,'disetujui_id_2');
	}
	public function pembuat(){
			return $this->belongsTo(User::class,'pembuat_id');
	}
	public function lokasi(){
			return $this->belongsTo(Lokasi::class);
	}

	public function cek_barang(){
		$b = $this->detail()->where('dipesan',0)->count();
		if($b == 0){
			return false;
		}
		else {
			return true;
		}
	}

	public function delete(){
    	$this->detail()->delete();
    	parent::delete();
    }
}
