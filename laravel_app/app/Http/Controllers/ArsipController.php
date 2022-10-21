<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Arsip;
use Session;
use Auth;
class ArsipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $arsips = Arsip::paginate(20);
        return view('arsip.index',compact('arsips'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('arsip.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $file  = '';
        
        $this->validate($request,[
                'userfile'=>'required|mimes:xls,docx,png,jpeg,jpg,doc,pdf|max:10240',
               
            ]);
        if ($request->hasFile('userfile')) {
            $tmp    = $request->file('userfile');            
            $ext    = $tmp->getClientOriginalExtension();
            $nm     = $tmp->getClientOriginalName();
            $file   = date('d-m-Y-h-i-s').'-'.$nm;
            $request->file('userfile')->storeAs('arsip',$file,'public_file');
        }
        try {
            Arsip::create([
                'tanggal'=>$request->tanggal,
                'keterangan'=>$request->keterangan,
                'file'=>$file,

            ]);
            Session::flash(
                "flash_notif",[
                    "level"   => "dismissible alert-success",
                    "massage" => "Arsip tanggal <strong>$request->tanggal</strong> Berhasil Di Tambah"
            ]);
        } catch (Exception $e) {
            Session::flash(
                "flash_notif",[
                    "level"   => "dismissible alert-danger",
                    "massage" => "Arsip tanggal <strong>$request->tanggal</strong> Gagal Di Tambah"
            ]);
        }
        
        return redirect('arsip');
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
        $data = Arsip::findOrFail($id);
        try {
            $data->delete();
            Session::flash(
                "flash_notif",[
                    "level"   => "dismissible alert-success",
                    "massage" => "Arsip tanggal <strong>$data->tanggal</strong> Berhasil Di Hapus"
            ]);
        } catch (Exception $e) {
            Session::flash(
                "flash_notif",[
                    "level"   => "dismissible alert-danger",
                    "massage" => "Arsip tanggal <strong>$data->tanggal</strong> Gagal Di Hapus"
            ]);
        }
        
        return back();
    }
}
