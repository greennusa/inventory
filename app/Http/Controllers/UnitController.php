<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Unit;
use App\JenisUnit;
use Auth;
use Session;
class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function index(Request $request)
    {
        if(Auth::user()->cek_akses('Unit','View',Auth::user()->id) != 1){
            return view('error.denied');
        }
        if(isset($request->q)){
            $q = $request->q;
        }
        else {
            $q = '';
        }
        $mereks = Unit::where('kode','like',"%$q%")->orderBy('created_at','DESC')->paginate(20);
        return view('unit.index',compact('mereks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        if(Auth::user()->cek_akses('Unit','Add',Auth::user()->id) != 1){
            return view('error.denied');
        }
        $jenisunit = JenisUnit::all();
        
        return view('unit.create',compact('jenisunit'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        if(Auth::user()->cek_akses('Unit','Add',Auth::user()->id) != 1){
            return view('error.denied');
        }
        Unit::create([
            'kode'=>$request->kode,
            
            'jenis_unit_id'=>$request->jenis_unit_id,
            'no_sn'=>$request->no_sn,
            'no_en'=>$request->no_en,
            'operator'=>$request->operator,
            
        ]);
        \App\AktivitasUser::create(['user_id'=>Auth::user()->id,'aktivitas'=>'Menambah data unit dengan kode '.$request->kode]);
        Session::flash(
            "flash_notif",[
                "level"   => "dismissible alert-success",
                "massage" => "Data <strong>$request->nama</strong> Berhasil Di Tambahkan"
        ]);
        return redirect('unit');
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
        if(Auth::user()->cek_akses('Unit','Edit',Auth::user()->id) != 1){
            return view('error.denied');
        }
        $jenisunit = JenisUnit::all();
        $r = Unit::findOrFail($id);
        return view('unit.edit',compact('jenisunit','r'));
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
        if(Auth::user()->cek_akses('Unit','Edit',Auth::user()->id) != 1){
            return view('error.denied');
        }
        Unit::findOrFail($id)->update([
            'kode'=>$request->kode,
            
            'jenis_unit_id'=>$request->jenis_unit_id,
            'no_sn'=>$request->no_sn,
            'no_en'=>$request->no_en,
            'operator'=>$request->operator,
            
        ]);
        \App\AktivitasUser::create(['user_id'=>Auth::user()->id,'aktivitas'=>'Mengubah data unit dengan kode '.$request->kode]);
        Session::flash(
            "flash_notif",[
                "level"   => "dismissible alert-success",
                "massage" => "Data <strong>$request->nama</strong> Berhasil Di Ubah"
        ]);
        return redirect('unit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        if(Auth::user()->cek_akses('Unit','Delete',Auth::user()->id) != 1){
            return view('error.denied');
        }
        $data = Unit::findOrFail($id);
        if(count($data->barang) > 0){
            Session::flash(
            "flash_notif",[
                "level"   => "dismissible alert-danger",
                "massage" => "Data <strong>$data->kode</strong> tidak bisa dihapus karena masih digunakan"
            ]);
        
            return back();
        }
        $kode = $data->kode;
        try {
            
            $data->delete();
            \App\AktivitasUser::create(['user_id'=>Auth::user()->id,'aktivitas'=>'Menghapus data unit dengan kode '.$kode]);
            Session::flash(
                "flash_notif",[
                    "level"   => "dismissible alert-success",
                    "massage" => "Data <strong>$kode</strong> Berhasil Di Hapus"
            ]);

            
        } catch (Exception $e) {
            Session::flash(
                "flash_notif",[
                    "level"   => "dismissible alert-danger",
                    "massage" => "Data <strong>$data->kode</strong> Gagal Di Hapus"
            ]);
        }
        
        
        
        return redirect('unit');
    }


    public function get_kode_unit($id){
        $db = Unit::where('jenis_unit_id',$id)->get();
        foreach ($db as $v) {
            ?>
                <option value="<?php echo $v->id ?>"><?php echo $v->kode; ?></option>
            <?php
        }
    }

    public function excel()
    {
        
        $mereks = Unit::orderBy('kode','ASC')->get();
        return view('unit.excel',compact('mereks'));
    }
}
