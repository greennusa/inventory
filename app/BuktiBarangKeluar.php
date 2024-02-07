<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BuktiBarangKeluar extends Model
{
    protected $guarded = [];

    public function detail(){
		return $this->hasMany(DetailBuktiBarangKeluar::class)->join('barangs', 'detail_bukti_barang_keluars.barang_id', '=', 'barangs.id')->join('detail_bukti_barang_masuks', 'detail_bukti_barang_keluars.detail_bukti_barang_masuk_id', '=', 'detail_bukti_barang_masuks.id')->join('bukti_barang_masuks', 'detail_bukti_barang_masuks.bukti_barang_masuk_id', '=', 'bukti_barang_masuks.id')->join('pemesanan_barangs', 'bukti_barang_masuks.pemesanan_barang_id', '=', 'pemesanan_barangs.id')->select('detail_bukti_barang_keluars.*')->orderBy('pemesanan_barangs.nomor','ASC')->orderBy('barangs.nama','ASC');
	}

	public function detail_bbm()
	{
		return $this->belongsTo(DetailBuktiBarangMasuk::class,'detail_bukti_barang_masuk_id');
	}

	public function mengetahui_user(){
		return $this->belongsTo(User::class,'mengetahui','id');
	}

	public function pengantar_user(){
		return $this->belongsTo(User::class,'pengantar','id');
	}

	public function penerima_user(){
		return $this->belongsTo(User::class,'penerima','id');
	}

	public function pengirim_user(){
		return $this->belongsTo(User::class,'pengirim','id');
	}

	public function delete(){
    	$this->detail()->delete();
    	parent::delete();
    }

    public function getAdaDiCampAttribute()
    {
    	foreach ($this->detail as $d) {
    		if(count(Camp::where('barang_id',$d->barang_id)->where('detail_bukti_barang_keluar_id',$d->id)->get()) > 0){ 
	            if($d->jumlah_di_camp < $d->jumlah){
	                return false;
	            }
	    	}
	    }

    	return true;
    }
}
