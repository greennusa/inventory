<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jabatan;
use Auth;
use Session;
class JabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(Auth::user()->cek_akses('Jabatan','View',Auth::user()->id) != 1){
            return view('error.denied');
        }
        if(isset($request->q)){
            $q = $request->q;
        }
        else {
            $q = '';
        }
        $jabatans = Jabatan::where('nama','like',"%$q%")->orderBy('created_at','DESC')->paginate(20);
        return view('jabatan.index',compact('jabatans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        if(Auth::user()->cek_akses('Jabatan','Add',Auth::user()->id) != 1){
            return view('error.denied');
        }
        return view('jabatan.create');
    }

    /**
     * Store a newly created resource in storage.
     * @return \Illuminate\Http\Response
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {   
        if(Auth::user()->cek_akses('Jabatan','Add',Auth::user()->id) != 1){
            return view('error.denied');
        }
        $data = Jabatan::create(['nama'=>$request->nama]);
        \App\AktivitasUser::create(['user_id'=>Auth::user()->id,'aktivitas'=>'Menambah data jabatan dengan nama '.$data->nama]);
        return redirect('job');
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
        if(Auth::user()->cek_akses('Jabatan','Edit',Auth::user()->id) != 1){
            return view('error.denied');
        }
        $r = Jabatan::findOrFail($id);
        return view('jabatan.edit',compact('r'));

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
        if(Auth::user()->cek_akses('Jabatan','Edit',Auth::user()->id) != 1){
            return view('error.denied');
        }
        $data = Jabatan::findOrFail($id)->update(['nama'=>$request->nama]);
        \App\AktivitasUser::create(['user_id'=>Auth::user()->id,'aktivitas'=>'Edit data jabatan dengan nama '.$data->nama]);
        return redirect('job');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        if(Auth::user()->cek_akses('Jabatan','Delete',Auth::user()->id) != 1){
            return view('error.denied');
        }
        $data = Jabatan::findOrFail($id);
        \App\AktivitasUser::create(['user_id'=>Auth::user()->id,'aktivitas'=>'Menghapus data jabatan dengan nama '.$data->nama]);
        $data->delete();
        return redirect('job');
    }
}
