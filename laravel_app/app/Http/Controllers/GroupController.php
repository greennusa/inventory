<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;
use App\Modul;
use Auth;
use Session;
class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        if(Auth::user()->cek_akses('Group','View',Auth::user()->id) != 1){
            return view('error.denied');
        }
        if(isset($request->q)){
            $q = $request->q;
        }
        else {
            $q = '';
        }
        $tables = Group::where('nama','like',"%$q%")->orderBy('created_at','DESC')->paginate(20);
        return view('group.index',compact('tables'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        if(Auth::user()->cek_akses('Group','Add',Auth::user()->id) != 1){
            return view('error.denied');
        }
        $modul = Modul::orderBy('nama','ASC')->get();
        return view('group.create',compact('modul'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        if(Auth::user()->cek_akses('Group','Add',Auth::user()->id) != 1){
            return view('error.denied');
        }
        
        try {
            $data = Group::create(['nama'=>$request->nama]);
            $data->modul()->attach($request->modul);
            Session::flash(
                "flash_notif",[
                    "level"   => "dismissible alert-success",
                    "massage" => "Data <strong>$request->nama</strong> Berhasil Di Tambah"
            ]);
        } catch (Exception $e) {
            Session::flash(
                "flash_notif",[
                    "level"   => "dismissible alert-danger",
                    "massage" => "Data <strong>$request->nama</strong> Gagal Di Tambah"
            ]);
        }
        \App\AktivitasUser::create(['user_id'=>Auth::user()->id,'aktivitas'=>'Menambah data group dengan nama '.$request->nama]);
        
        return redirect('group');
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
        if(Auth::user()->cek_akses('Group','Edit',Auth::user()->id) != 1){
            return view('error.denied');
        }
        $modul = Modul::orderBy('nama','ASC')->get();
        $r = Group::findOrFail($id);
        return view('group.edit',compact('r','modul'));

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
        if(Auth::user()->cek_akses('Group','Edit',Auth::user()->id) != 1){
            return view('error.denied');
        }
        $data = Group::findOrFail($id);
        try {
            $data->update(['nama'=>$request->nama]);
            $data->modul()->sync($request->akses);
            Session::flash(
                "flash_notif",[
                    "level"   => "dismissible alert-success",
                    "massage" => "Data <strong>$request->nama</strong> Berhasil Di Update"
            ]);
            \App\AktivitasUser::create(['user_id'=>Auth::user()->id,'aktivitas'=>'Edit data group dengan nama '.$data->nama]);
        } catch (Exception $e) {
            Session::flash(
                "flash_notif",[
                    "level"   => "dismissible alert-danger",
                    "massage" => "Data <strong>$request->nama</strong> Gagal Di Update"
            ]);
        }
        
        
       
        return redirect('group?page='.$request->page);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        if(Auth::user()->cek_akses('Group','Delete',Auth::user()->id) != 1){
            return view('error.denied');
        }
        $data = Group::findOrFail($id);
        try {
            $data->delete();
            Session::flash(
                "flash_notif",[
                    "level"   => "dismissible alert-success",
                    "massage" => "Data <strong>$data->nama</strong> Berhasil Di Hapus"
            ]);
            \App\AktivitasUser::create(['user_id'=>Auth::user()->id,'aktivitas'=>'Menghapus data group dengan nama '.$data->nama]);
        } catch (Exception $e) {
            Session::flash(
                "flash_notif",[
                    "level"   => "dismissible alert-danger",
                    "massage" => "Data <strong>$data->nama</strong> Gagal Di Hapus"
            ]);
        }
        
        
        return redirect('group');
    }
}