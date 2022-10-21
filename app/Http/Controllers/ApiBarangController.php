<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Barang;
class ApiBarangController extends Controller
{
    public function get_data(){
    	return Barang::Join("mereks", "mereks.id", "=", "barangs.merek_id")->Join("kategoris", "kategoris.id", "=", "barangs.kategori_id")->Join("satuans", "satuans.id", "=", "barangs.satuan_id")->orderBy('barangs.created_at','DESC')->get(['barangs.kode AS 1','barangs.nama AS 2','kategoris.nama as 3','mereks.kode AS 4','mereks.nama AS 5','barangs.harga AS 6','satuans.nama AS 7','barangs.keterangan AS 8']);
    }

    public function get_data_by_id($id){
    	return Barang::find($id);
    }
}
