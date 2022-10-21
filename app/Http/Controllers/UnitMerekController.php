<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UnitMerek;
use App\Unit;
use App\Merek;
use Auth;
use Session;
class UnitMerekController extends Controller
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
        $mereks = UnitMerek::where('nama','like',"%$q%")->orderBy('created_at','DESC')->paginate(20);
        return view('unit_merek.index',compact('mereks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $unit = Unit::all();
        $merek = Merek::all();
        return view('unit_merek.create',compact('unit','merek'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Merek::create([
            'kode'=>$request->kode,
            'nama'=>$request->nama,
            'unit_id'=>$request->unit_id,
            'merek_id'=>$request->merek_id,
            'no_sn'=>$request->no_sn,
            'no_en'=>$request->no_en,
            
        ]);
        \App\AktivitasUser::create(['user_id'=>Auth::user()->id,'aktivitas'=>'Menambah data unit merek dengan kode '.$request->kode]);
        Session::flash(
            "flash_notif",[
                "level"   => "dismissible alert-success",
                "massage" => "Data <strong>$request->nama</strong> Berhasil Di Tambahkan"
        ]);
        return redirect('unit_brand');
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
        //
    }
}
