<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DetailPemesananBarang;
use App\PemesananBarang;
use App\PermintaanBarang;
use App\DetailPermintaanBarang;
use App\DetailBuktiBarangMasuk;
use App\SerialDetailBuktiBarangMasuk;
use Auth;
use Session;
class DetailBuktiBarangMasukController extends Controller
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

        for ($i=0; $i < count($request->barang_id); $i++) { 
            
            
            $cek = DetailBuktiBarangMasuk::findOrFail($request->id[$i])->update([
                  
                    
                    'jumlah'=>$request->jumlah[$i],
            
                    'kelengkapan'=>$request->kelengkapan[$i],
                    'keterangan'=>$request->detail_keterangan[$i]
            ]);

           	if($request->kelengkapan[$i] == 0){
                DetailPemesananBarang::where('pemesanan_barang_id',$request->pemesanan_barang_id)->where('barang_id',$request->barang_id[$i])->update(['masuk'=>0]);
            }

            if($request->kelengkapan[$i] == 1){
                DetailPemesananBarang::where('pemesanan_barang_id',$request->pemesanan_barang_id)->where('barang_id',$request->barang_id[$i])->update(['masuk'=>1]);
            }
          
            for ($x=0; $x < count($request->serial_id) ; $x++) { 
                $s = data_get($request,"sn_".$request->serial_id[$x]);
                $f = SerialDetailBuktiBarangMasuk::find($request->serial_id[$x]);
                if($f != null){
                    $f->update([
                    
                        'sn'=>$s[0]

                    ]);
                } else {
                    SerialDetailBuktiBarangMasuk::create([
                        'detail_bukti_barang_masuk_id'=>$request->id[$i],
                        'sn'=>$s[0]

                    ]);
                }
                
            }

            

            
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
        $dpm = DetailBuktiBarangMasuk::findOrFail($id);
        
        $dpm->delete();
        return back();
    }
}

