<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Unit;
use App\MonitoringUnit;

class MonitoringUnitController extends Controller
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

        if(isset($request->z)){
            $z = $request->z;
        }
        else {
            $z = '';
        }


        if(isset($request->r)){
            $r = $request->r;
        }
        else {
            $r = '';
        }
        $units = Unit::all();
        $monitoring = MonitoringUnit::where('unit_id','=', $z)->whereDate('tanggal',$r)->orderBy("tanggal","DESC")->paginate(20);
        
        if($r == ""){
           $monitoring = MonitoringUnit::where('unit_id','=', $z)->orderBy("tanggal","DESC")->paginate(20); 
        }
        if($z == ""){
            $monitoring = MonitoringUnit::whereDate('tanggal',$r)->orderBy("tanggal","DESC")->paginate(20);
        }
        if ($r == "" && $z == "") {
            $monitoring = MonitoringUnit::orderBy("tanggal","DESC")->paginate(20);
        }
        return view("monitoring.index", compact('monitoring','units'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $unit = Unit::all();
        return view("monitoring.create", compact('unit'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        for ($i=0; $i < count($request->unit) ; $i++) { 
            MonitoringUnit::create([
                'unit_id' => $request->unit[$i],
                'keterangan' => $request->keterangan,
                'status' => $request->status,
                'tanggal' => $request->tanggal,
                'libur'=>$request->libur,
            ]);
        }

          return redirect('monitoring');
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
        $unit = Unit::all();
        $r = MonitoringUnit::findOrFail($id);
        return view("monitoring.edit", compact('unit','r'));
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
        MonitoringUnit::findOrFail($id)->update(['tanggal'=>$request->tanggal,'keterangan'=>$request->keterangan,'status'=>$request->status,'libur'=>$request->libur,]);
        return redirect('monitoring');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = MonitoringUnit::findOrFail($id)->delete();
        return redirect('monitoring');
    }
}
