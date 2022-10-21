<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Barang;
use App\Kategori;

use App\Unit;
use App\Satuan;
use Auth;
use Session;
class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   

        
        
        // $db = Barang::all();
        // $kode = '';
        // $nama = '';
        // foreach ($db as $d) {
        // 	if(strlen($d->qrcode) != 7){
        // 		Barang::findOrFail($d->id)->update(['qrcode'=>$this->randomcode()]);
        // 	}
        // }
        // die();
        if(Auth::user()->cek_akses('Barang','View',Auth::user()->id) != 1){
            return view('error.denied');
        }
        if(isset($request->q)){
            $q = $request->q;
        }
        else {
            $q = '';
        }
        $tables = Barang::WhereHas('unit',function ($query) use ($q){
            
            $query->where('kode', 'like', '%'.$q.'%');
        })->orWhereHas('kategori',function ($query) use ($q){

            $query->where('nama', 'like', '%'.$q.'%');
        })->orWhere('nama','like',"%$q%")->orWhere('kode','like',"%$q%")->orWhere('qrcode','like',"%$q%")->orWhere('halaman','like',"%$q%")->orWhere('indeks','like',"%$q%")->orderBy('id','DESC')->paginate(20);
        
        return view('barang.index',compact('tables')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        if(Auth::user()->cek_akses('Barang','Add',Auth::user()->id) != 1){
            return view('error.denied');
        }
        $kategori = Kategori::all();
        $satuan = Satuan::all();
       
        $unit = Unit::all();
        return view('barang.create',compact('kategori','satuan','unit'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        if(Auth::user()->cek_akses('Barang','Add',Auth::user()->id) != 1){
            return view('error.denied');
        }
        $gambar  = '';
        if ($request->hasFile('userfile')) {
            $this->validate($request,[
                'userfile'=>'mimes:png,jpg,JPG,jpeg',
               
            ]);
            $gambar = 'gambar-barang-'.str_replace(" ", "-", $request->kode.'-'.$request->nama).'.png';
            $request->file('userfile')->storeAs('images/barang',$gambar,'public_img');
        }
        
        $this->validate($request,[
            'unit_id'=>'required',
            'kategori_id'=>'required',
            'satuan_id'=>'required',
            'nama'=>'required',
            
        ]);

       
        $harganya = str_replace(',', '',$request->harga);
        $harganya = str_replace('.', '',$harganya);
        $data = Barang::create([
            'qrcode'=>$this->randomcode(),
            'kode'=>$request->kode,
            'nama'=>$request->nama,
            'unit_id'=>$request->unit_id,
            
            'kategori_id'=>$request->kategori_id,
            'harga'=>$harganya,
            'halaman'=>$request->halaman,
            'indeks'=>$request->indeks,
            
            'satuan_id'=>$request->satuan_id,
            'keterangan'=>$request->keterangan,
            'gambar'=>$gambar,
            'pakai_sn'=>$request->pakai_sn,
         
        ]);
        \App\AktivitasUser::create(['user_id'=>Auth::user()->id,'aktivitas'=>'Menambah data barang dengan nama '.$data->nama]);
        return redirect('item');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        if(Auth::user()->cek_akses('Barang','Edit',Auth::user()->id) != 1){
            return view('error.denied');
        }
        $kategori = Kategori::all();
        $satuan = Satuan::all();
        
        $unit = Unit::all();
        $barang = Barang::findOrFail($id);
        return view('barang.edit',compact('kategori','satuan','unit','barang'));
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
        if(Auth::user()->cek_akses('Barang','Edit',Auth::user()->id) != 1){
            return view('error.denied');
        }
        $i = Barang::findOrFail($id);
        $gambar  = $i->gambar;
        if ($request->hasFile('userfile')) {
            $gambar = 'gambar-barang-'.str_replace(" ", "-", $request->kode.'-'.$request->nama).'.png';
            $request->file('userfile')->storeAs('images/barang',$gambar,'public_img');
        }
        
        $this->validate($request,[
            'unit_id'=>'required',
            'kategori_id'=>'required',
            'satuan_id'=>'required',
            'nama'=>'required',
            
        ]);
        $harganya = str_replace(',', '',$request->harga);
        $harganya = str_replace('.', '',$harganya);
        Barang::findOrFail($id)->update([
            'kode'=>$request->kode,
            'nama'=>$request->nama,
            'unit_id'=>$request->unit_id,
            
            'kategori_id'=>$request->kategori_id,
            'harga'=>$harganya,
            'halaman'=>$request->halaman,
            'indeks'=>$request->indeks,
            
            'satuan_id'=>$request->satuan_id,
            'keterangan'=>$request->keterangan,
            'gambar'=>$gambar,
            'pakai_sn'=>$request->pakai_sn,
            
        ]);
        \App\AktivitasUser::create(['user_id'=>Auth::user()->id,'aktivitas'=>'Edit data barang dengan nama '.$i->nama]);

        return redirect('item?page='.$request->page);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        if(Auth::user()->cek_akses('Barang','Delete',Auth::user()->id) != 1){
            return view('error.denied');
        }
        $data = Barang::findOrFail($id);
        try {
            
            $data->delete();
           
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
        \App\AktivitasUser::create(['user_id'=>Auth::user()->id,'aktivitas'=>'Mengahpus data barang dengan nama '.$data->nama]);
        
        
        return redirect('item');
    }
}
