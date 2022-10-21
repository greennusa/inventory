<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ReturBarang;
use App\DetailReturBarang;
use App\DetailReturBarangLama;
use App\DetailPemakaianBarang;
use App\DetailPemakaianBarangLama;
use App\User;
use Auth;
use Session;
class ReturBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        if(Auth::user()->cek_akses('Retur Barang','View',Auth::user()->id) != 1){
            return view('error.denied');
        }
        if(isset($request->q)){
            $q = $request->q;
        }
        else {
            $q = '';
        }
        $tables = ReturBarang::WhereHas('detail',function ($query) use ($q){
            $qq = $q;
            $query->WhereHas('barang',function ($qr) use ($qq){
                $qr->where('kode', 'like', '%'.$qq.'%')->orWhere('nama', 'like', '%'.$qq.'%');
            });
        })->orWhere('nomor','like',"%$q%")->orderBy('created_at','DESC')->paginate(20);
    
        return view('retur_barang.index',compact('tables'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        if(Auth::user()->cek_akses('Retur Barang','Add',Auth::user()->id) != 1){
            return view('error.denied');
        }
        if($request->lama == 'lama'){
            if($request->stok_lama  =='' || $request->stok_lama == null){
                $lama = ReturBarang::findOrFail($request->nomor_lama);
                $dp = DetailPemakaianBarang::findOrFail($request->detail_pemakaian_id);
                DetailReturBarang::create([
                    'retur_barang_id'=>$lama->id,
                    'barang_id'=>$dp->barang_id,
                    'pemakaian_barang_id'=>$dp->pemakaian_barang_id,
                    'detail_bukti_barang_keluar_id'=>$dp->detail_bukti_barang_keluar_id,
                    'jumlah'=>$request->jumlah,
                    'keterangan'=>$request->keterangan,
                ]);
            } else {
                $lama = ReturBarang::findOrFail($request->nomor_lama);
                $dp = DetailPemakaianBarangLama::findOrFail($request->detail_pemakaian_id);
                DetailReturBarangLama::create([
                    'retur_barang_id'=>$lama->id,
                    'barang_id'=>$dp->barang_id,
                    'detail_pemakaian_barang_lama_id'=>$dp->id,
                    
                    'jumlah'=>$request->jumlah,
                    'keterangan'=>$request->keterangan,
                ]);
            }
        }
        else {
            if($request->stok_lama  =='' || $request->stok_lama == null){
                $dp = DetailPemakaianBarang::findOrFail($request->detail_pemakaian_id);
                $data = ReturBarang::create([
                    'nomor'=>$request->nomor_baru,
                    'tanggal'=>$request->tanggal,
                    'diterima_id'=>$request->diterima_id,
                    'dibawa_id'=>$request->dibawa_id,
                    'dikirim_id'=>$request->dikirim_id
                ]);
                $id = $data->id;
                \App\AktivitasUser::create(['user_id'=>Auth::user()->id,'aktivitas'=>'Menambah retur barang dengan nomor '.$data->nomor]);
                DetailReturBarang::create([
                    'retur_barang_id'=>$id,
                    'pemakaian_barang_id'=>$dp->pemakaian_barang_id,
                    'barang_id'=>$dp->barang_id,
                    'detail_bukti_barang_keluar_id'=>$dp->detail_bukti_barang_keluar_id,
                    'jumlah'=>$request->jumlah,
                    'keterangan'=>$request->keterangan,
                ]);
            } else {
                $dp = DetailPemakaianBarangLama::findOrFail($request->detail_pemakaian_id);
                $data = ReturBarang::create([
                    'nomor'=>$request->nomor_baru,
                    'tanggal'=>$request->tanggal,
                    'diterima_id'=>$request->diterima_id,
                    'dibawa_id'=>$request->dibawa_id,
                    'dikirim_id'=>$request->dikirim_id
                ]);
                $id = $data->id;
                \App\AktivitasUser::create(['user_id'=>Auth::user()->id,'aktivitas'=>'Menambah retur barang dengan nomor '.$data->nomor]);
                DetailReturBarangLama::create([
                    'retur_barang_id'=>$id,
                    'detail_pemakaian_barang_lama_id'=>$dp->id,
                    'barang_id'=>$dp->barang_id,
                    
                    'jumlah'=>$request->jumlah,
                    'keterangan'=>$request->keterangan,
                ]);
            }
                
        }
        \App\AktivitasUser::create(['user_id'=>Auth::user()->id,'aktivitas'=>'Retur barang dengan kode '.$dp->barang->kode]);
        $dp->update(['status'=>1,'jumlah_retur'=>$request->jumlah]);
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
        if(Auth::user()->cek_akses('Retur Barang','Detail',Auth::user()->id) != 1){
            return view('error.denied');
        }
        $r = ReturBarang::findOrFail($id);
        
        $user = User::all();
        return view('retur_barang.view',compact('r','user'));
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
        if(Auth::user()->cek_akses('Retur Barang','Delete',Auth::user()->id) != 1){
            return view('error.denied');
        }
        $data = ReturBarang::findOrFail($id);
        \App\AktivitasUser::create(['user_id'=>Auth::user()->id,'aktivitas'=>'Menghapus retur barang dengan nomor '.$data->nomor]);
        $data->delete();
        return back();
    }

    public function print_out($id){
        if(Auth::user()->cek_akses('Retur Barang','Print',Auth::user()->id) != 1){
            return view('error.denied');
        }
        $r = ReturBarang::findOrFail($id);
        return view('retur_barang.print',compact('r'));
    }

    public function print_xls($id){
        
        $r = ReturBarang::findOrFail($id);
        return view('retur_barang.xls',compact('r'));
    }

    public function print_doc($id){
        
        $r = ReturBarang::findOrFail($id);
        return view('retur_barang.doc',compact('r'));
    }
}
