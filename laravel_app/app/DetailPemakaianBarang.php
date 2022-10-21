<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailPemakaianBarang extends Model
{
    protected $guarded = [];
    protected $appends = ['tanggal'];
    public function barang()
	{
		return $this->belongsTo(Barang::class,'barang_id','id');
	}

	public function detail_bbk()
	{
		return $this->belongsTo(DetailBuktiBarangKeluar::class,'detail_bukti_barang_keluar_id','id');
	}

	public function pemakaian()
	{
		return $this->belongsTo(PemakaianBarang::class,'pemakaian_barang_id','id')->orderBy('unit_id');
	}

	public function getTanggalAttribute(){
		return $this->created_at->format('F');
	}
	
}
