<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $guarded = [];

    public function unit(){
    	return $this->belongsTo(Unit::class);
    }

    public function merek(){
        return $this->belongsTo(Merek::class);
    }

    public function kategori(){
    	return $this->belongsTo('App\Kategori','kategori_id');
    }

    public function satuan(){
    	return $this->belongsTo('App\Satuan','satuan_id');
    }

    public function gudang()
    {
        return $this->hasMany('App\Gudang','barang_id','id');
    }

    public function detail_pemakaian(){
        return $this->hasMany(DetailPemakaianBarang::class,'barang_id');
    }

    public function detail_pemakaian_lama(){
        return $this->hasMany(DetailPemakaianBarangLama::class,'barang_id');
    }
}
