<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Lokasi;
use Auth;
use Session;
class LokasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        if(isset($request->q)){
            $q = $request->q;
        }
        else {
            $q = '';
        }
        $lokasis = Lokasi::where('nama','like',"%$q%")->orderBy('created_at','DESC')->paginate(20);
        return view('lokasi.index',compact('lokasis'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('lokasi.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $input = $request->all();
        unset($input['_token']);
        
        try {
            Lokasi::create($input);

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
        
            
        return redirect('lokasi');
        
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
        $r = Lokasi::findOrFail($id);
        return view('lokasi.edit',compact('r'));
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
        $input = $request->all();
        unset($input['_token']);
        unset($input['_method']);
        unset($input['page']);
        $data = Lokasi::find($id);
        try {
            $data->update($input);
            Session::flash(
                "flash_notif",[
                    "level"   => "dismissible alert-success",
                    "massage" => "Data <strong>$data->nama</strong> Berhasil Di Update"
            ]);
        } catch (Exception $e) {
            Session::flash(
                "flash_notif",[
                    "level"   => "dismissible alert-danger",
                    "massage" => "Data <strong>$data->nama</strong> Gagal Di Update"
            ]);
        }
        
       
        return redirect('lokasi?page='.$request->page);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   

        $data = Lokasi::find($id);
        $nama = $data->nama;
        try {

            $data->delete();
            
            Session::flash(
                "flash_notif",[
                    "level"   => "dismissible alert-success",
                    "massage" => "Data <strong>$nama</strong> Berhasil Di Hapus"
            ]);
        } catch (Exception $e) {
            Session::flash(
                "flash_notif",[
                    "level"   => "dismissible alert-danger",
                    "massage" => "Data <strong>$data->nama</strong> Gagal Di Hapus"
            ]);
        }
        

        return redirect('lokasi');
    }
}
