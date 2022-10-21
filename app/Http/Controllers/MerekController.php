<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Merek;
use App\Unit;
use Auth;
use Session;
class MerekController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        
        // $db =  \DB::table('mereks')->get();
        
        // foreach ($db as $value) {
        //     $ss = $value->nama;
                
        //     if(strpos($value->nama, '- 01') !== false){
        //         $ss = str_replace('- 01', '', $value->nama);
                
        //     }

        //     if(strpos($value->nama, '- 02') !== false){
        //         $ss = str_replace('- 02', '', $value->nama);
                
        //     }

        //     if(strpos($value->nama, '- 03') !== false){
        //         $ss = str_replace('- 03', '', $value->nama);
                
        //     }
        //     if(strpos($value->nama, '- 04') !== false){
        //         $ss = str_replace('- 04', '', $value->nama);
                
        //     }
        //     if(strpos($value->nama, '- 05') !== false){
        //         $ss = str_replace('- 05', '', $value->nama);
                
        //     }
        //     if(strpos($value->nama, '- 06') !== false){
        //         $ss = str_replace('- 06', '', $value->nama);
                
        //     }
        //     if(strpos($value->nama, '- 07') !== false){
        //         $ss = str_replace('- 07', '', $value->nama);
                
        //     }
        //     if(strpos($value->nama, '- 08') !== false){
        //         $ss = str_replace('- 08', '', $value->nama);
                
        //     }
        //     if(strpos($value->nama, '- 09') !== false){
        //         $ss = str_replace('- 09', '', $value->nama);
                
        //     }
        //     if(strpos($value->nama, '- 10') !== false){
        //         $ss = str_replace('- 10', '', $value->nama);
                
        //     }
        //     if(strpos($value->nama, '- 010') !== false){
        //         $ss = str_replace('- 010', '', $value->nama);
                
        //     }
        //     $m = \DB::table('merek')->where('nama',$ss)->first();
        //     Merek::where('nama','like',"%$ss%")->update(['merek_id'=>$m->id]);
            
                
        // }


        if(Auth::user()->cek_akses('Merek','View',Auth::user()->id) != 1){
            return view('error.denied');
        }
        if(isset($request->q)){
            $q = $request->q;
        }
        else {
            $q = '';
        }
        $mereks = Merek::where('nama','like',"%$q%")->orderBy('created_at','DESC')->paginate(20);
        return view('merek.index',compact('mereks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   

        if(Auth::user()->cek_akses('Merek','Add',Auth::user()->id) != 1){
            return view('error.denied');
        }
        $unit = Unit::all();
        return view('merek.create',compact('unit'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        if(Auth::user()->cek_akses('Merek','Add',Auth::user()->id) != 1){
            return view('error.denied');
        }
        Merek::create([
            
            'nama'=>$request->nama,
                        
        ]);
        \App\AktivitasUser::create(['user_id'=>Auth::user()->id,'aktivitas'=>'Menambah data merek dengan nama '.$request->nama]);
        Session::flash(
            "flash_notif",[
                "level"   => "dismissible alert-success",
                "massage" => "Data <strong>$request->nama</strong> Berhasil Di Tambahkan"
        ]);
        return redirect('brand');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(Auth::user()->cek_akses('Merek','Detail',Auth::user()->id) != 1){
            return view('error.denied');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        if(Auth::user()->cek_akses('Merek','Edit',Auth::user()->id) != 1){
            return view('error.denied');
        }
        $merek = Merek::findOrFail($id);
        $unit = Unit::all();
        return view('merek.edit',compact('merek','unit'));
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
        if(Auth::user()->cek_akses('Merek','Edit',Auth::user()->id) != 1){
            return view('error.denied');
        }
        $data = Merek::findOrFail($id);
        $data->update([
            
            'nama'=>$request->nama,
            
            
        ]);
        \App\AktivitasUser::create(['user_id'=>Auth::user()->id,'aktivitas'=>'Edit data merek dengan nama '.$data->nama]);
        Session::flash(
            "flash_notif",[
                "level"   => "dismissible alert-success",
                "massage" => "Data <strong>$data->nama</strong> Berhasil Di Update"
        ]);
        return redirect('brand?page='.$request->page);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        if(Auth::user()->cek_akses('Merek','Delete',Auth::user()->id) != 1){
            return view('error.denied');
        }
        
        $data = Merek::findOrFail($id);
        if(count($data->barang) > 0){
            Session::flash(
            "flash_notif",[
                "level"   => "dismissible alert-danger",
                "massage" => "Data <strong>$data->nama</strong> tidak bisa dihapus karena masih digunakan"
            ]);
        
            return back();
        }
        $nama = $data->nama;
        try {
            
            $data->delete();
            
            Session::flash(
                "flash_notif",[
                    "level"   => "dismissible alert-success",
                    "massage" => "Data <strong>$nama</strong> Berhasil Di Hapus"
            ]);

            \App\AktivitasUser::create(['user_id'=>Auth::user()->id,'aktivitas'=>'Mengahpus data merek dengan nama '.$data->nama]);
        } catch (Exception $e) {
            Session::flash(
                "flash_notif",[
                    "level"   => "dismissible alert-danger",
                    "massage" => "Data <strong>$data->nama</strong> Gagal Di Hapus"
            ]);
        }
        
        
        
        return redirect('brand');
    }
}
