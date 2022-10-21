<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DetailPemakaianBarang;
use App\DetailPemakaianBarangLama;
use App\ReturBarang;
use Auth;
use Session;
class DetailPemakaianBarangController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
          for ($i=0; $i < count($request->detail_id) ; $i++) { 
            
            if($request->nomor[$i] != "stok_lama")
            {
                
                DetailPemakaianBarang::findOrFail($request->detail_id[$i])->update([
                        'keterangan'=>strip_tags($request->detail_keterangan[$i])
                    ]);
            }
            else if($request->nomor[$i] == 'stok_lama')
            {
                
                DetailPemakaianBarangLama::findOrFail($request->detail_id[$i])->update([
                        'keterangan'=>strip_tags($request->detail_keterangan[$i])
                    ]);   
            }
            
        }
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        $dd = DetailPemakaianBarang::findOrFail($id);
        
    }
}
