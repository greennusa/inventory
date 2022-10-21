<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DetailPemesananBarang;
use App\PemesananBarang;
use App\PermintaanBarang;
use App\DetailPermintaanBarang;
use Auth;
use Session;
class DetailPemesananBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        for ($i=0; $i < count($request->detail_id) ; $i++) { 
            
            DetailPemesananBarang::findOrFail($request->detail_id[$i])->update([
                'nama_barang'=>strip_tags($request->nama_barang[$i]),
                'kode_barang'=>strip_tags($request->kode_barang[$i]),
                'harga'=>strip_tags($request->harga[$i])
            ]);

        }
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        $dpm = DetailPemesananBarang::findOrFail($id);
        //$psb = PemesananBarang::findOrFail($dpm->pemesanan_barang_id);
        $dpr = DetailPermintaanBarang::where('permintaan_id',$dpm->permintaan_id)->where('barang_id',$dpm->barang_id)->update(['dipesan'=>0]);
        $dpm->delete();
        return back();
    }
}
