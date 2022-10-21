<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Barang;
use App\Satuan;
use App\Camp;
use App\CampLama;
use App\CampLog;
use App\SerialCampLama;
use Auth;
use Session;

class CampLamaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $satuan = Satuan::all();
        $barang = Barang::all();
        return view('camp.stok_lama',compact('satuan','barang'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   

        $c = CampLama::where('barang_id',$request->barang_id)->where('harga',$request->harga);
        if($c->count() > 0){
            $stok = $c->first()->stok + $request->jumlah;
            if($c->first()->satuan->id == $request->satuan_id){
                    
                    if($request->sn != null){
                        $count_sn = count($request->sn);
                    } else {
                        $count_sn = 1;
                    }

                    for ($v=0; $v < $count_sn ; $v++) { 
                        SerialCampLama::create([
                            'camp_lama_id'=>$c->first()->id,
                            'sn'=>$request->sn[$v],
                            
                        ]);
                    } 
                    $c->update(['stok'=>$stok,'stok_awal'=> $c->first()->stok]);
				
				CampLog::create([
						'barang_id'=>$request->barang_id,
						'nama_barang'=>$request->nama,
						'tanggal'=>$request->tanggal,
						'aksi' => "penambahan",
						'jumlah'=>$request->jumlah
					]);
                } else {
                    $camp_id = CampLama::create([
                        'barang_id'=>$request->barang_id,
                        'nama_barang'=>$request->nama,
                        'kode_barang'=>$request->kode,
                        'harga'=>$request->harga,
                        'satuan_id'=>$request->satuan_id,

                        'stok'=>$request->jumlah,
                        'stok_awal'=>0,
                        
                        'tanggal'=>$request->tanggal,
                    ])->id;
					
					CampLog::create([
						'barang_id'=>$request->barang_id,
						'nama_barang'=>$request->nama,
						'tanggal'=>$request->tanggal,
						'aksi' => "penambahan",
						'jumlah'=>$request->jumlah
					]);
				
					if($request->sn != null){
						$count_sn = count($request->sn);
					} else {
						$count_sn = 1;
					}
				
                    for ($v=0; $v < $count_sn ; $v++) { 
                        SerialCampLama::create([
                            'camp_lama_id'=>$camp_id,
                            'sn'=>$request->sn[$v],
                            
                        ]);
                    } 
                    
                   
                    
                }
        } else {
            $camp_id = CampLama::create([
                'barang_id'=>$request->barang_id,
                'nama_barang'=>$request->nama,
                'kode_barang'=>$request->kode,
                'harga'=>$request->harga,
                'satuan_id'=>$request->satuan_id,

                'stok'=>$request->jumlah,
                'stok_awal'=>0,
                'keterangan'=>$request->keterangan,
                'tanggal'=>$request->tanggal,
            ])->id;
			
			CampLog::create([
						'barang_id'=>$request->barang_id,
						'nama_barang'=>$request->nama,
						'tanggal'=>$request->tanggal,
						'aksi' => "penambahan",
						'jumlah'=>$request->jumlah
					]);
			
			if($request->sn != null){
				$count_sn = count($request->sn);
			} else {
				$count_sn = 1;
			}
			
			
            for ($v=0; $v < $count_sn ; $v++) { 
                SerialCampLama::create([
                    'camp_lama_id'=>$camp_id,
                    'sn'=>$request->sn[$v],
                    
                ]);
            } 
        }

        \App\AktivitasUser::create(['user_id'=>Auth::user()->id,'aktivitas'=>'Menambah data camp dari stok lama']);
            

        return redirect('warehouse_udit'); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $r = CampLama::findOrFail($id);
        return view('camp.view',compact('r'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
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
        if(Auth::user()->cek_akses('Camp','Delete',Auth::user()->id) != 1){
            return view('error.denied');
        }
        $data = CampLama::findOrFail($id);
        \App\AktivitasUser::create(['user_id'=>Auth::user()->id,'aktivitas'=>'Mengahpus data camp dengan kode barang '.$data->barang->kode]);
        $data->delete();
        Session::flash(
            "flash_notif",[
                "level"   => "dismissible alert-success",
                "massage" => "Data Berhasil Di Hapus"
        ]);
        return back();
    }
}
