<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PemesananBarang extends Model
{
    
    protected $guarded = [];

    public function detail(){
		return $this->hasMany(DetailPemesananBarang::class,'pemesanan_barang_id')->join('detail_permintaan_barangs', 'detail_pemesanan_barangs.detail_permintaan_barang_id', '=', 'detail_permintaan_barangs.id')->join('permintaan_barangs', 'detail_permintaan_barangs.permintaan_id', '=', 'permintaan_barangs.id')->join('barangs', 'detail_pemesanan_barangs.barang_id', '=', 'barangs.id')->select('detail_pemesanan_barangs.*')->orderBy('permintaan_barangs.nomor','ASC');
	}

	

	// public function permintaan()
	// {
	// 	return $this->belongsTo(PermintaanBarang::class,'permintaan_id');
	// }

	public function bbm()
	{
		return $this->hasMany(BuktiBarangMasuk::class);
	}

	public function bbmnya()
	{
		return $this->hasOne(BuktiBarangMasuk::class);
	}

	public function pemasok(){
		return $this->belongsTo(Pemasok::class,'pemasok_id');
	}

	public function delete(){
    	$this->detail()->delete();
    	parent::delete();
    }

    public function menyetujui_user(){
		return $this->belongsTo(User::class,'menyetujui');
	}
	public function mengetahui_user(){
			return $this->belongsTo(User::class,'mengetahui');
	}
	public function memesan_user(){
			return $this->belongsTo(User::class,'memesan');
	}
}
