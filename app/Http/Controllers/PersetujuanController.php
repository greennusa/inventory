<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DetailPermintaanBarang;
use App\PermintaanBarang;
use App\Pemasok;
use App\Barang;
use App\Merek;
use App\Lokasi;
use App\User;

use Auth;
use Session;
class PersetujuanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   

        // $pb = PermintaanBarang::all();
        // foreach ($pb as $value) {
        //     if($value->disetujui_id_2 == null && $value->disetujui_id){
        //         PermintaanBarang::find($value->id)->update(['disetujui_id_2'=>$value->disetujui_id]);
        //     }
        // }
        if(Auth::user()->cek_akses('Persetujuan','View',Auth::user()->id) != 1){
            return view('error.denied');
        }
        if(isset($request->q)){
            $q = $request->q;
            
        }
        else {
            $q = '';
            
        
        }
        
        if(isset($request->status)){
            if($request->status != 0){
                
                $tables = PermintaanBarang::where('setuju',$request->status)->WhereHas('detail',function ($query) use ($q){
                    $qq = $q;
                    $query->WhereHas('barang',function ($qr) use ($qq){
                        $qr->where('kode', 'like', '%'.$qq.'%')->orWhere('nama', 'like', '%'.$qq.'%');
                    });
                })->where('nomor','like',"%$q%")->orderBy('created_at','DESC')->paginate(20);
                
                 
            }
            else {
                 $tables = PermintaanBarang::WhereHas('detail',function ($query) use ($q){
                    $qq = $q;
                    $query->WhereHas('barang',function ($qr) use ($qq){
                        $qr->where('kode', 'like', '%'.$qq.'%')->orWhere('nama', 'like', '%'.$qq.'%');
                    });
                })->orWhere('nomor','like',"%$q%")->orderBy('created_at','DESC')->paginate(20);
            }
           
        }

        else {
            $tables = PermintaanBarang::WhereHas('detail',function ($query) use ($q){
                $qq = $q;
                $query->WhereHas('barang',function ($qr) use ($qq){
                    $qr->where('kode', 'like', '%'.$qq.'%')->orWhere('nama', 'like', '%'.$qq.'%');
                });
            })->orWhere('nomor','like',"%$q%")->orderBy('created_at','DESC')->paginate(20);
        }
       
        
        
        return view('persetujuan.index',compact('tables'));
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
        if(Auth::user()->cek_akses('Persetujuan','Detail',Auth::user()->id) != 1){
            return view('error.denied');
        }
        $r = PermintaanBarang::findOrFail($id);
        $barang = Barang::all();
        $user = User::all();
       
        $pemasok = Pemasok::all();
        $lokasi = Lokasi::all();
        return view('persetujuan.view',compact('r','barang','user','pemasok','lokasi'));
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
        
        $permintaan = PermintaanBarang::findOrFail($id);
        $permintaan->fill([
            'setuju'=> $request->setuju,
            'disetujui_id_2' => $request->disetujui_id_2
        ]);

        $permintaan->save();
        \App\AktivitasUser::create(['user_id'=>Auth::user()->id,'aktivitas'=>'Edit data persetujuan dengan nomor permintaan '.$permintaan->nomor]);
        return redirect('approval?page='.$request->page);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function update_detail(Request $request, $id)
    {   

        for ($i=0; $i < count($request->id_detail); $i++) { 
            $harganya = str_replace(',', '',$request->harga[$i]);
            $harganya = str_replace('.', '',$harganya);
            $permintaan = DetailPermintaanBarang::findOrFail($request->id_detail[$i]);
            $permintaan->fill([
                'jumlah_disetujui'=>$request->jumlah[$i],
                'status'=> $request->status[$i],
                'harga'=> $harganya,
                'keterangan'=>$request->keterangan[$i]
                
            ]);
            $permintaan->save();
            DetailPermintaanBarang::where('gabungan','like','%'.$request->id_detail[$i].'%')->update([
                    'jumlah_disetujui'=>$request->jumlah[$i],
                    'status'=> $request->status[$i],
                    'harga'=> $harganya,
                    'keterangan'=>$request->keterangan[$i]
            ]);
        }
            

        return back();
    }



}
