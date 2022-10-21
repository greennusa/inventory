<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Satuan;
use Auth;
use Session;
class SatuanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(Auth::user()->cek_akses('Satuan','View',Auth::user()->id) != 1){
            return view('error.denied');
        }
        if(isset($request->q)){
            $q = $request->q;
        }
        else {
            $q = '';
        }
        $satuans = Satuan::where('nama','like',"%$q%")->orWhere('kode','like',"%$q%")->orderBy('created_at','DESC')->paginate(20);
        return view('satuan.index',compact('satuans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        if(Auth::user()->cek_akses('Satuan','Add',Auth::user()->id) != 1){
            return view('error.denied');
        }
        return view('satuan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        if(Auth::user()->cek_akses('Satuan','Add',Auth::user()->id) != 1){
            return view('error.denied');
        }
        Satuan::create([
            'kode'=>$request->kode,
            'nama'=>$request->nama,
            'jenis'=>$request->jenis,
            
        ]);
        Session::flash(
            "flash_notif",[
                "level"   => "dismissible alert-success",
                "massage" => "Data <strong>$request->nama</strong> Berhasil Di Tambahkan"
        ]);
        return redirect('satuan');
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
        if(Auth::user()->cek_akses('Satuan','Edit',Auth::user()->id) != 1){
            return view('error.denied');
        }
        $satuan = Satuan::findOrFail($id);
        return view('satuan.edit',compact('satuan'));
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
        if(Auth::user()->cek_akses('Satuan','Edit',Auth::user()->id) != 1){
            return view('error.denied');
        }
        $data = Satuan::findOrFail($id);
        $data->update([
            'kode'=>$request->kode,
            'nama'=>$request->nama,
            'jenis'=>$request->jenis,
  
        ]);
        Session::flash(
            "flash_notif",[
                "level"   => "dismissible alert-success",
                "massage" => "Data <strong>$data->nama</strong> Berhasil Di Update"
        ]);
        return redirect('satuan?page='.$request->page);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        if(Auth::user()->cek_akses('Satuan','Delete',Auth::user()->id) != 1){
            return view('error.denied');
        }
        $data = Satuan::findOrFail($id);
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
        $data->delete();

        return redirect('satuan');
    }
}
