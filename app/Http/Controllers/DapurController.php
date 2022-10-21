<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Dapur;
use Auth;
use Session;

class DapurController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(isset($request->q)){
            $q = $request->q;
        }
        else {
            $q = '';
        }

        $dapur = Dapur::where('nama','like',"%$q%")->paginate(20);
        return view('dapur.index',compact('dapur'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dapur.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            Dapur::create([
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
            
        return redirect('camp_list');
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
        $dapur = Dapur::findOrFail($id);
        return view('dapur.edit',compact('dapur'));
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
         $data = Dapur::findOrFail($id);
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
            
        return redirect('camp_list?page='.$request->page);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Dapur::findOrFail($id);

        if(count($data->pemakaian) > 0 || count($data->camp) > 0){
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

        return redirect('camp_list');
    }
}
