<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PemesananBarang;
class ApiPemesananBarangController extends Controller
{
    public function get_data(){
    	return PemesananBarang::Join("pemasoks", "pemasoks.id", "=", "pemesanan_barangs.pemasok_id")->orderBy('pemesanan_barangs.created_at','DESC')->get(['pemesanan_barangs.nomor as 1','pemesanan_barangs.tanggal as 2','pemasoks.nama as 3']);
    }
}
