<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\JenisUnit;
use Auth;
use Session;
class JenisUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        if(Auth::user()->cek_akses('Jenis Unit','View',Auth::user()->id) != 1){
            return view('error.denied');
        }
        if(isset($request->q)){
            $q = $request->q;
        }
        else {
            $q = '';
        }
        $mereks = JenisUnit::where('nama','like',"%$q%")->orWhere('kode','like',"%$q%")->orderBy('created_at','DESC')->paginate(20);
        return view('jenis_unit.index',compact('mereks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        if(Auth::user()->cek_akses('Jenis Unit','Add',Auth::user()->id) != 1){
            return view('error.denied');
        }
        return view('jenis_unit.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        if(Auth::user()->cek_akses('Jenis Unit','Add',Auth::user()->id) != 1){
            return view('error.denied');
        }
        JenisUnit::create(['kode'=>$request->kode,'nama'=>$request->nama]);
        return redirect('type_unit');
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
        if(Auth::user()->cek_akses('Jenis Unit','Edit',Auth::user()->id) != 1){
            return view('error.denied');
        }
        $r = JenisUnit::findOrFail($id);
        return view('jenis_unit.edit',compact('r'));
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
        if(Auth::user()->cek_akses('Jenis Unit','Edit',Auth::user()->id) != 1){
            return view('error.denied');
        }
        JenisUnit::findOrFail($id)->update(['kode'=>$request->kode,'nama'=>$request->nama]);
        return redirect('type_unit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        if(Auth::user()->cek_akses('Jenis Unit','Delete',Auth::user()->id) != 1){
            return view('error.denied');
        }
        $data = JenisUnit::findOrFail($id);
        Session::flash(
                "flash_notif",[
                    "level"   => "dismissible alert-success",
                    "massage" => "Data <strong>$data->nama</strong> Berhasil Di Hapus"
            ]);
        $data->delete();
        return redirect('type_unit');
    }
}
