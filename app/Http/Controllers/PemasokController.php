<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pemasok;
use Auth;
use Session;
class PemasokController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        
        if(Auth::user()->cek_akses('Pemasok','View',Auth::user()->id) != 1){
            return view('error.denied');
        }
        if(isset($request->q)){
            $q = $request->q;
        }
        else {
            $q = '';
        }
        $tables = Pemasok::where('nama','like',"%$q%")->where('id','>','-1')->orderBy('created_at','DESC')->paginate(20);
        return view('pemasok.index',compact('tables'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        if(Auth::user()->cek_akses('Pemasok','Add',Auth::user()->id) != 1){
            return view('error.denied');
        }
        return view('pemasok.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {      
        if(Auth::user()->cek_akses('Pemasok','Add',Auth::user()->id) != 1){
            return view('error.denied');
        }
        $input = $request->all();
        unset($input['_token']);
        
        $data = Pemasok::create($input);
        \App\AktivitasUser::create(['user_id'=>Auth::user()->id,'aktivitas'=>'Menambah data pemasok dengan nama '.$data->nama]);
        Session::flash(
            "flash_notif",[
                "level"   => "dismissible alert-success",
                "massage" => "Data <strong>$request->nama</strong> Berhasil Di Tambahkan"
        ]);
        return redirect('supplier');
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
        if(Auth::user()->cek_akses('Pemasok','Edit',Auth::user()->id) != 1){
            return view('error.denied');
        }
        $r = Pemasok::findOrFail($id);
        return view('pemasok.edit',compact('r'));
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
        if(Auth::user()->cek_akses('Pemasok','Edit',Auth::user()->id) != 1){
            return view('error.denied');
        }
        $input = $request->all();
        unset($input['_token']);
        unset($input['page']);
        $data = Pemasok::findOrFail($id);
        \App\AktivitasUser::create(['user_id'=>Auth::user()->id,'aktivitas'=>'Edit data pemasok dengan nama '.$data->nama]);
        $data->update($input);
        return redirect('supplier');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        if(Auth::user()->cek_akses('Pemasok','Delete',Auth::user()->id) != 1){
            return view('error.denied');
        }
        $data = Pemasok::findOrFail($id);
        if(count($data->detail_permintaan) > 0){
            Session::flash(
            "flash_notif",[
                "level"   => "dismissible alert-danger",
                "massage" => "Data <strong>$data->nama</strong> tidak bisa dihapus karena masih digunakan"
            ]);
        
            return back();
        }
        \App\AktivitasUser::create(['user_id'=>Auth::user()->id,'aktivitas'=>'Mengahpus data pemasok dengan nama '.$data->nama]);
        $data->delete();
        return redirect('supplier');
    }


    
}
