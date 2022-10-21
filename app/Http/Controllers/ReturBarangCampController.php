<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ReturBarangCamp;
use App\DetailReturBarangCamp;
use App\DetailReturBarangCampLama;
use App\Camp;
use App\CampLama;
use App\User;
use Auth;
use Session;
class ReturBarangCampController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
       
        if(isset($request->q)){
            $q = $request->q;
        }
        else {
            $q = '';
        }
        $tables = ReturBarangCamp::WhereHas('detail',function ($query) use ($q){
            $qq = $q;
            $query->WhereHas('barang',function ($qr) use ($qq){
                $qr->where('kode', 'like', '%'.$qq.'%')->orWhere('nama', 'like', '%'.$qq.'%');
            });
        })->orWhere('nomor','like',"%$q%")->orderBy('created_at','DESC')->paginate(20);
    
        return view('retur_camp.index',compact('tables'));
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
        if($request->lama == 'lama'){
            if($request->stok_lama  =='' || $request->stok_lama == null){
                $lama = ReturBarangCamp::findOrFail($request->nomor_lama);
                $dp = Camp::findOrFail($request->camp_id);
                DetailReturBarangCamp::create([
                    'retur_barang_camp_id'=>$lama->id,
                    'barang_id'=>$dp->barang_id,
                    'camp_id'=>$dp->id,
                    'detail_bukti_barang_keluar_id'=>$dp->detail_bukti_barang_keluar_id,
                    'jumlah'=>$request->jumlah,
                    'keterangan'=>$request->keterangan,
                ]);
            } else {
                $lama = ReturBarangCamp::findOrFail($request->nomor_lama);
                $dp = CampLama::findOrFail($request->camp_id);
                DetailReturBarangCampLama::create([
                    'retur_barang_camp_id'=>$lama->id,
                    'barang_id'=>$dp->barang_id,
                    'camp_lama_id'=>$dp->id,
                    'jumlah'=>$request->jumlah,
                    'keterangan'=>$request->keterangan,
                ]);
            }
                
        }
        else {
            if($request->stok_lama == '' || $request->stok_lama == null){
                $dp = Camp::findOrFail($request->camp_id);
                $data = ReturBarangCamp::create([
                    'nomor'=>$request->nomor_baru,
                    'tanggal'=>$request->tanggal,
                    'diterima_id'=>$request->diterima_id,
                    'dibawa_id'=>$request->dibawa_id,
                    'dikirim_id'=>$request->dikirim_id
                ]);
                $id = $data->id;
                \App\AktivitasUser::create(['user_id'=>Auth::user()->id,'aktivitas'=>'Menambah retur barang dengan nomor '.$data->nomor]);
                DetailReturBarangCamp::create([
                    'retur_barang_camp_id'=>$id,
                    'camp_id'=>$dp->id,
                    'barang_id'=>$dp->barang_id,
                    'detail_bukti_barang_keluar_id'=>$dp->detail_bukti_barang_keluar_id,
                    'jumlah'=>$request->jumlah,
                    'keterangan'=>$request->keterangan,

                ]);
            } else {
               
                $dp = CampLama::findOrFail($request->camp_id);
                $data = ReturBarangCamp::create([
                    'nomor'=>$request->nomor_baru,
                    'tanggal'=>$request->tanggal,
                    'diterima_id'=>$request->diterima_id,
                    'dibawa_id'=>$request->dibawa_id,
                    'dikirim_id'=>$request->dikirim_id
                ]);
                $id = $data->id;
                \App\AktivitasUser::create(['user_id'=>Auth::user()->id,'aktivitas'=>'Menambah retur barang dengan nomor '.$data->nomor]);
                DetailReturBarangCampLama::create([
                    'retur_barang_camp_id'=>$id,
                    'camp_lama_id'=>$dp->id,
                    'barang_id'=>$dp->barang_id,
                    'jumlah'=>$request->jumlah,
                    'keterangan'=>$request->keterangan,

                ]);
            }
                
        }

        \App\AktivitasUser::create(['user_id'=>Auth::user()->id,'aktivitas'=>'Retur barang dengan kode '.$dp->barang->kode]);
        $dp->update(['status'=>1,'stok_retur'=>$request->jumlah]);
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $r = ReturBarangCamp::findOrFail($id);
       
        $user = User::all();
        return view('retur_camp.view',compact('r','user'));
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
        $data = ReturBarangCamp::findOrFail($id);
        \App\AktivitasUser::create(['user_id'=>Auth::user()->id,'aktivitas'=>'Menghapus retur barang dengan nomor '.$data->nomor]);
        $data->delete();
        return back();
    }

    public function print_out($id){
        
        $r = ReturBarangCamp::findOrFail($id);
        return view('retur_camp.print',compact('r'));
    }

    public function print_xls($id){
        
        $r = ReturBarangCamp::findOrFail($id);
        return view('retur_camp.xls',compact('r'));
    }

    public function print_doc($id){
        
        $r = ReturBarangCamp::findOrFail($id);
        return view('retur_camp.doc',compact('r'));
    }
}
