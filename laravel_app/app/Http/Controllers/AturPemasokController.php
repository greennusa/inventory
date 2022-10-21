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
use Session;
use Auth;
class AturPemasokController extends Controller
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
        //     if($value->diketahui_id_2 == null && $value->diketahui_id){
        //         PermintaanBarang::find($value->id)->update(['diketahui_id_2'=>$value->diketahui_id]);
        //     }
        // }

        if(Auth::user()->cek_akses('Atur Pemasok','View',Auth::user()->id) != 1){
            return view('error.denied');
        }
        if(isset($request->q)){
            $q = $request->q;
        }
        else {
            $q = '';
        }
        $tables = PermintaanBarang::WhereHas('detail',function ($query) use ($q){
            $qq = $q;
            $query->WhereHas('barang',function ($qr) use ($qq){
                $qr->where('kode', 'like', '%'.$qq.'%')->orWhere('nama', 'like', '%'.$qq.'%');
            });
        })->orWhere('nomor','like',"%$q%")->orderBy('created_at','DESC')->paginate(20);
        
        return view('atur_pemasok.index',compact('tables'));
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
    public function show($id,Request $request)
    {   

        if(Auth::user()->cek_akses('Atur Pemasok','Detail',Auth::user()->id) != 1){
            return view('error.denied');
        }
        $page = $request->p;
        $r = PermintaanBarang::findOrFail($id);
        $barang = Barang::where('unit_id',$r->unit_id)->get();
        $user = User::all();
      
        $pemasok = Pemasok::all();
        $lokasi = Lokasi::all();
        return view('atur_pemasok.view',compact('r','barang','user','pemasok','lokasi','page'));
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

        if(Auth::user()->cek_akses('Atur Pemasok','Edit',Auth::user()->id) != 1){
            return view('error.denied');
        }

        // dd($request->id_detail);

        

        $data = PermintaanBarang::findOrFail($id);
        $data->update([
            'diketahui_id_2'=>$request->diketahui_id_2
        ]);
        \App\AktivitasUser::create(['user_id'=>Auth::user()->id,'aktivitas'=>'Edit data atur supplier dengan nomor permintaan '.$data->nomor]);
        for ($i=0; $i < count($request->id_detail); $i++) {
           
            $harganya = str_replace(',', '',$request->harga[$i]);
            $harganya = str_replace('.', '',$harganya);
            
            $dd = DetailPermintaanBarang::findOrFail($request->id_detail[$i]);
            
            $dd->barang->update([
                'harga'=>$harganya,
            ]);
            
            $dd->update([
                    'keterangan'=>$request->keterangan[$i],
                    'jumlah'=>$request->jumlah[$i],
                    'harga'=>$harganya,
                    'pemasok_id'=>$request->pemasok_id[$i],
                    'satuan_id'=>$request->satuan_id[$i],
                    'nama_barang'=>$request->nama_barang[$i],
                    'kode_barang'=>$request->kode_barang[$i],
                    
            ]);
            DetailPermintaanBarang::where('gabungan','like','%'.$request->id_detail[$i].'%')->update([
                    'keterangan'=>$request->keterangan[$i],
                    'nama_barang'=>$request->nama_barang[$i],
                    'kode_barang'=>$request->kode_barang[$i],
                    'harga'=>$harganya,
                    'pemasok_id'=>$request->pemasok_id[$i]
            ]);
        }
        
        Session::flash(
            "flash_notif",[
                "level"   => "dismissible alert-success",
                "massage" => "Data <strong>$data->nomor</strong> Detail Pemasok Berhasil Di Update"
        ]);
        return redirect('set_supplier/'.$data->id);
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

    public function print_xls($id){
        $r = PermintaanBarang::findOrFail($id);
        return view('atur_pemasok.xls',compact('r'));
    }
    public function print_doc($id){
        $r = PermintaanBarang::findOrFail($id);
        return view('atur_pemasok.doc',compact('r'));
    }

    public function gabung(Request $request)
    {   
        if(count($request->gabung) > 0){
            $gabungan = $request->id_parent.',';
            for ($i=0; $i < count($request->gabung); $i++) { 
               $gabungan .= $request->gabung[$i]." ";
            }

            for ($i=0; $i < count($request->gabung); $i++) { 
               DetailPermintaanBarang::findOrFail($request->gabung[$i])->update(['gabungan'=>$gabungan]);
            }
            
            
        }
            
        return back();
    }
}
