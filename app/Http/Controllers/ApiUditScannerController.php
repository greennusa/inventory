<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UditScannerSession;
use App\DetailUditScannerSession;
use App\Barang;
class ApiUditScannerController extends Controller
{
    

    public function tambah_sesi($kode)
    {
    	$c = UditScannerSession::where('kode',$kode)->orderBy('created_at','DESC')->first();
    	if($c == null){
    		UditScannerSession::create(['kode'=>$kode]);
    		return $kode;
    	}
    }


    public function cek_sesi($kode)
    {
    	$c = UditScannerSession::where('kode',$kode)->orderBy('created_at','DESC')->first();
    	if($c){
    		return $c->kode;
    	}
    }

    public function tambah_detail($sesi,$detail)
    {	
    	$x = UditScannerSession::where('kode',$sesi)->orderBy('created_at','DESC')->first();
    	$c = DetailUditScannerSession::where('udit_scanner_session_id',$x->id)->where('detail',$detail)->orderBy('created_at','DESC')->first();
    	DetailUditScannerSession::create(['detail'=>$detail,'udit_scanner_session_id'=>$x->id]);
        return $detail;
    }

    public function cek_detail($sesi)
    {	
    	$x = UditScannerSession::where('kode',$sesi)->orderBy('created_at','DESC')->first();
    	$c = DetailUditScannerSession::where('udit_scanner_session_id',$x->id)->orderBy('created_at','DESC')->first();
    	if($c){

    		$b = Barang::where('qrcode',$c->detail)->first();
    		return $b->id;
    	}

    }

    public function cek_barang($qrcode){
        $b = Barang::where('qrcode',$qrcode)->first();
        
    }
}
