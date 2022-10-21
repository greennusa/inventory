<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gudang;
use App\BuktiBarangMasuk;
use App\DetailBuktiBarangMasuk;
use App\SerialDetailBuktiBarangMasuk;
use App\SerialGudang;
use App\PemesananBarang;
use App\User;
use Auth;
use Session;
class GudangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        if(Auth::user()->cek_akses('Gudang','View',Auth::user()->id) != 1){
            return view('error.denied');
        }
        if(isset($request->q)){
            $q = $request->q;
        }
        else {
            $q = '';
        }
        $tables = Gudang::with('barang')->whereHas('barang',function($qu) use ($q){
            $qu->where('kode','like',"%$q%")->orWhere('nama','like',"%$q%");
        })->orderBy('created_at','DESC')->paginate(20);
        return view('gudang.index',compact('tables'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        if(Auth::user()->cek_akses('Gudang','Add',Auth::user()->id) != 1){
            return view('error.denied');
        }
        $bbm = BuktiBarangMasuk::all();
        return view('gudang.create',compact('bbm'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        if(Auth::user()->cek_akses('Gudang','Add',Auth::user()->id) != 1){
            return view('error.denied');
        }
        
        for ($i=0; $i < count($request->pilih); $i++) { 
            
            $detail = DetailBuktiBarangMasuk::where('bukti_barang_masuk_id',$request->bbm_id)->where('barang_id',$request->barang_id[$request->pilih[$i]])->first();
            $gudang_id = Gudang::create([
                'barang_id'=>$request->barang_id[$request->pilih[$i]],
                'detail_bukti_barang_masuk_id'=>$detail->id,
                'nama_barang'=>$request->nama_barang[$request->pilih[$i]],
                'stok'=>$request->jumlah[$request->pilih[$i]],
                'harga'=>$request->harga[$request->pilih[$i]],
                'gabungan_id'=>$detail->gabungan_id,
                'gabungan'=>$detail->gabungan
            ])->id;
            

            $serial = SerialDetailBuktiBarangMasuk::where('detail_bukti_barang_masuk_id',$detail->id)->get();
            foreach ($serial as $item) {
                SerialGudang::create([
                    'gudang_id'=>$gudang_id,
                    'sn'=>$item->sn
                ]);
            }

            $data = DetailBuktiBarangMasuk::where('bukti_barang_masuk_id',$request->bbm_id)->where('barang_id',$request->barang_id[$request->pilih[$i]]);
            \App\AktivitasUser::create(['user_id'=>Auth::user()->id,'aktivitas'=>'Menambah data gudang dari bbm dengan nomor '.$data->first()->nomor]);
            $data->update(['status'=>1]);


        }

        return redirect('warehouse');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
        if(Auth::user()->cek_akses('Gudang','Detail',Auth::user()->id) != 1){
            return view('error.denied');
        }
        $r = Gudang::findOrFail($id);
        return view('gudang.view',compact('r'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        if(Auth::user()->cek_akses('Gudang','Delete',Auth::user()->id) != 1){
            return view('error.denied');
        }
        $data = Gudang::findOrFail($id);
        \App\AktivitasUser::create(['user_id'=>Auth::user()->id,'aktivitas'=>'Mengahpus data gudang dari bbm dengan nomor '.$data->nomor]);
        $data->delete();
        Gudang::where('gabungan','like','%'.$id.'%')->delete();
        Session::flash(
            "flash_notif",[
                "level"   => "dismissible alert-success",
                "massage" => "Data Berhasil Di Hapus"
        ]);
        return back();
    }

    public function print_all()
    {

      

         if(isset($request->q)){
            $q = $request->q;
        }
        else {
            $q = '';
        }

        $tables = Gudang::with('barang')->whereHas('barang',function($qu) use ($q){
            $qu->where('kode','like',"%$q%")->orWhere('nama','like',"%$q%");
        })->orderBy('created_at','DESC')->get();

        return view('gudang.cetak_semua', compact('tables'));

    }
}
