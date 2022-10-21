<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailPemakaianGudang extends Model
{
	protected $guarded = [];

    public function detail_bbm(){
    	return $this->belongsTo(DetailBuktiBarangMasuk::class,'detail_bukti_barang_masuk_id');
    }

    public function pemakaian(){
    	return $this->belongsTo(PemakaianGudang::class,'pemakaian_gudang_id');
    }
}
