<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PermintaanBarang;
class ApiPermintaanBarangController extends Controller
{
    public function get_data(){
    	return PermintaanBarang::Join("mereks", "mereks.id", "=", "permintaan_barangs.merek_id")->orderBy('permintaan_barangs.created_at','DESC')->get(['permintaan_barangs.nomor as 1','permintaan_barangs.tanggal as 2','permintaan_barangs.destination as 3','mereks.nama as 4','mereks.unit as 5','mereks.no_en as 6','mereks.no_sn as 7']);
    }
}
