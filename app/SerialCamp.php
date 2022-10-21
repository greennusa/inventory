<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SerialCamp extends Model
{
    protected $guarded = [];


    public function camp(){
    	return $this->belongsTo(Camp::class);
    }

    public function permintaan()
	{
		return $this->belongsTo(PermintaanBarang::class,'permintaan_barang_id');
	}

	public function detail_bbk()
	{
		return $this->belongsTo(DetailBuktiBarangKeluar::class,'detail_bukti_barang_keluar_id','id');
	}
}
