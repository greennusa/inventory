<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Kategori;
use Session;
class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        if(Auth::user()->cek_akses('Kategori','View',Auth::user()->id) != 1){
            return view('error.denied');
        }
        if(isset($request->q)){
            $q = $request->q;
        }
        else {
            $q = '';
        }
        $kategoris = Kategori::where('nama','like',"%$q%")->orderBy('created_at','DESC')->paginate(20);
        return view('kategori.index',compact('kategoris'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        if(Auth::user()->cek_akses('Kategori','Add',Auth::user()->id) != 1){
            return view('error.denied');
        }
        return view('kategori.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        if(Auth::user()->cek_akses('Kategori','Add',Auth::user()->id) != 1){
            return view('error.denied');
        }
        try {
            Kategori::create([
                'nama'=>$request->nama,
                
            ]);
            \App\AktivitasUser::create(['user_id'=>Auth::user()->id,'aktivitas'=>'Menambah data kategori dengan nama '.$request->nama]);
            Session::flash(
                "flash_notif",[
                    "level"   => "dismissible alert-success",
                    "massage" => "Data <strong>$request->nama</strong> Berhasil Di Tambahkan"
            ]);
        } catch (Exception $e) {
            Session::flash(
                "flash_notif",[
                    "level"   => "dismissible alert-danger",
                    "massage" => "Data <strong>$request->nama</strong> Gagal Di Tambahkan Error di ".$e
            ]);
        }
            
        return redirect('category');
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
        if(Auth::user()->cek_akses('Kategori','Edit',Auth::user()->id) != 1){
            return view('error.denied');
        }
        $kategori = Kategori::findOrFail($id);
        return view('kategori.edit',compact('kategori'));
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
        if(Auth::user()->cek_akses('Kategori','Edit',Auth::user()->id) != 1){
            return view('error.denied');
        }
        $data = Kategori::findOrFail($id);
        try {
            
            $data->update([
                'nama'=>$request->nama,
              
            ]);
            \App\AktivitasUser::create(['user_id'=>Auth::user()->id,'aktivitas'=>'Mengubah data kategori dengan nama '.$request->nama]);
            Session::flash(
                "flash_notif",[
                    "level"   => "dismissible alert-success",
                    "massage" => "Data <strong>$data->nama</strong> Berhasil Di Update"
            ]);
        } catch (Exception $e) {
            Session::flash(
                "flash_notif",[
                    "level"   => "dismissible alert-danger",
                    "massage" => "Data <strong>$data->nama</strong> Gagal Di Update Error di ".$e
            ]);
        }
            
        return redirect('category?page='.$request->page);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {      
        if(Auth::user()->cek_akses('Kategori','Delete',Auth::user()->id) != 1){
            return view('error.denied');
        }
        $data = Kategori::findOrFail($id);

        if(count($data->barang) > 0){
            Session::flash(
            "flash_notif",[
                "level"   => "dismissible alert-danger",
                "massage" => "Data <strong>$data->nama</strong> tidak bisa dihapus karena masih digunakan"
            ]);
        
            return back();
        }
        Session::flash(
                "flash_notif",[
                    "level"   => "dismissible alert-success",
                    "massage" => "Data <strong>$data->nama</strong> Berhasil Di Hapus"
            ]);
        \App\AktivitasUser::create(['user_id'=>Auth::user()->id,'aktivitas'=>'Menghapus data kategori dengan nama '.$data->nama]);
        $data->delete();

        return redirect('category');
    }

    public function excel()
    {
        
        $mereks = Kategori::orderBy('nama','ASC')->get();
        return view('kategori.excel',compact('mereks'));
    }
}
