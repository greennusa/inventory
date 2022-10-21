<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DetailPermintaanBarang;
use App\Barang;
use Auth;
use Session;
class DetailPermintaanBarangController extends Controller
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
        
        $this->validate($request,[
            'barang_id'=>'required'
        ]);
        for ($i=0; $i < count($request->barang_id); $i++) { 
            $barang = Barang::findOrFail($request->barang_id[$i]);
            DetailPermintaanBarang::create([
                    'permintaan_id'=>$request->permintaan_id,
                    'barang_id'=>$request->barang_id[$i],
                    'satuan_id'=>$barang->satuan_id,
                    'jumlah'=>1,
                    'harga'=>$barang->harga,
                    'keterangan'=>$barang->keterangan,
            ]);
        }
            
        return redirect('purchase_request/'.$request->permintaan_id.'/edit');
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
        
        for ($i=0; $i < count($request->id_detail); $i++) { 
             DetailPermintaanBarang::findOrFail($request->id_detail[$i])->update([
                    'kode_barang'=>$request->kode_barang[$i],
                    'nama_barang'=>$request->nama_barang[$i],
                    'jumlah'=>$request->jumlah[$i],
                    'keterangan'=>$request->keterangan[$i],
                    'satuan_id'=>$request->satuan_id[$i]
                    
            ]);
        }
           
        return redirect('purchase_request/'.$id.'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   

        try {
            
            DetailPermintaanBarang::findOrFail($id)->delete();
            return back();
        } catch (\Illuminate\Database\QueryException $e) {
            if($e->errorInfo[1] == 1451){
                Session::flash(
                    "flash_notif",[
                        "level"   => "dismissible alert-danger",
                        "massage" => "Data Tidak Bisa Dihapus. Data Masih Digunakan"
                ]);   
                return redirect()->back();
            }
            
            
        }
        
    }

    public function get_supplier($id){
        $r = DetailPermintaanBarang::where('permintaan_id',$id)->groupBy('pemasok_id')->get();

        if(count($r) == 0){
            return json_encode(false);
        }
        $op = '<option ></option>';
        foreach ($r as $d) {

            $op .= 'hh<option value="'.$d->pemasok->id.'">'.$d->pemasok->nama.'</option>';
        }
        echo $op;
    }
}
