<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gudang;
class ApiGudangController extends Controller
{
    public function get_data(){
    	return Gudang::Join("detail_pememsanan_barangs", "detail_pememsanan_barangs.id", "=", "bukti_barang_masuks.detail_pememsanan_barang_id")->Join('pemesanan_barangs',"pemesanan_barangs.id","=","detail_pememsanan_barangs.pemesanan_barang_id")->orderBy('barangs.created_at','DESC')->get(['bukti_barang_masuks.nomor as 1','bukti_barang_masuks.tanggal as 2','pemesanan_barangs.nomor as 3','bukti_barang_masuks.keterangan as 4']);
    }
}
