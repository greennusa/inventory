<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DetailPemakaianGudang;
use App\PemakaianGudang;
use App\User;
use App\PemesananBarang;
use App\DetailPemesanan;
use App\BuktiBarangMasuk;
use App\DetailBuktiBarangMasuk;
use App\BuktiBarangKeluar;
use App\DetailBuktiBarangKeluar;

use App\Gudang;
use Auth;
use Mail;
use Session;

class PemakaianGudangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tables = PemakaianGudang::orderBy('tanggal','DESC')->paginate(20);
        return view('pemakaian_gudang.index', compact('tables'));


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = User::all();
        $pemesanan = PemesananBarang::all();
        $bbm = BuktiBarangMasuk::all();
        return view('pemakaian_gudang.create',compact('pemesanan','user','bbm'));
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
        unset($input['detail_bukti_barang_masuk_id']);
        $id = PemakaianGudang::create([
                'keterangan'=>$request->keterangan,
                'tanggal'=>$request->tanggal

            ])->id;

        for ($i=0; $i < count($request->pilih); $i++) { 
            
            $detail = DetailBuktiBarangMasuk::where('id',$request->detail_bukti_barang_masuk_id[$request->pilih[$i]])->where('barang_id',$request->barang_id[$request->pilih[$i]])->first();
           
                $id_detail = DetailPemakaianGudang::create([
                        'pemakaian_gudang_id'=>$id,
                        'detail_bukti_barang_masuk_id'=>$request->detail_bukti_barang_masuk_id[$request->pilih[$i]],
                        'stok'=>$request->jumlah[$request->pilih[$i]]
                        
                ])->id;
                $g = Gudang::where('barang_id',$request->barang_id[$request->pilih[$i]])->where('detail_bukti_barang_masuk_id',$request->detail_bukti_barang_masuk_id[$request->pilih[$i]])->first();
                $stok = $g->stok - $request->jumlah[$request->pilih[$i]];
                if ($g->stok > 0) {
                    // echo "there's still others left";
                    $g->update(['stok'=>$stok]);
                } else if($g->stok <= 0) {
                    // "there's nothing left";
                    $g->delete();
                }else{
                    // echo "ayy lmao";
                }
                // dd($g->first()->stok);
                return redirect('warehouse_use');
     }           
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
        $t = PemakaianGudang::findOrFail($id);
        return view('pemakaian_gudang.edit', compact('t'));
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
        PemakaianGudang::find($request->id)->update([
            'keterangan'=>$request->keterangan,
            'tanggal'=>$request->tanggal,
        ]);
        // echo "ok";
        return redirect('warehouse_use/'.$id.'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = DetailPemakaianGudang::where('pemakaian_gudang_id', $id)->delete();

        if ($delete) {
            PemakaianGudang::findOrFail($id)->delete();
        }

        return redirect('warehouse_use/');
    }
}
