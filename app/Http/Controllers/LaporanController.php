<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;

use App\User;

use App\Merek;

use App\Unit;

use App\JenisUnit;

use App\Barang;

use App\PemakaianBarang;

use App\DetailPemakaianBarang;

use App\DetailPemakaianBarangLama;

use App\DetailBuktiBarangKeluar;

use App\Pemasok;

use Auth;

use Session;

class LaporanController extends Controller

{

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index()

    {

        if(Auth::user()->cek_akses('Laporan','View',Auth::user()->id) != 1){

            return view('error.denied');

        }



        return view('laporan.index');

    }



    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {

        if(Auth::user()->cek_akses('Laporan','Add',Auth::user()->id) != 1){

            return view('error.denied');

        }

    }



    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request)

    {

        if(Auth::user()->cek_akses('Laporan','Add',Auth::user()->id) != 1){

            return view('error.denied');

        }

    }



    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function show($nama)

    {   

        $user = User::all();

        $unit = Unit::all();

        $jenisunit = JenisUnit::all();

        $supplier = Pemasok::all();

        

        if($nama == "pemakaian"){

            return view('laporan.pemakaian',compact('user'));

        }

        if($nama == "penerimaan"){

            return view('laporan.penerimaan',compact('user'));

        }



        if($nama == "opname"){

            return view('laporan.stok_opname',compact('user','jenisunit'));

        }



        if($nama == "pemakaian_per_unit"){

            return view('laporan.pemakaian_per_unit',compact('user','jenisunit'));

        }

   



        if($nama == "oil"){

            return view('laporan.oil',compact('user'));

        }



        if($nama == "supplier"){

            return view('laporan.pemasok', compact('user','supplier'));

        }



        if($nama == "piutang"){

            return view('laporan.piutang', compact('user'));

        }



        if($nama == "monitoring"){

            return view('laporan.monitoring', compact('user'));

        }



        if($nama == "pemakaian_gudang"){

            return view('laporan.pemakaian_gudang', compact('user'));

        }



        if ($nama == "dapur") {

            return view('laporan.dapur', compact('user'));

        }



        if ($nama == "bbm") {

            return view('laporan.bbm', compact('user'));

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

        if(Auth::user()->cek_akses('Laporan','Edit',Auth::user()->id) != 1){

            return view('error.denied');

        }

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

        if(Auth::user()->cek_akses('Laporan','Edit',Auth::user()->id) != 1){

            return view('error.denied');

        }

    }



    /**

     * Remove the specified resource from storage.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function destroy($id)

    {

        if(Auth::user()->cek_akses('Laporan','Delete',Auth::user()->id) != 1){

            return view('error.denied');

        }

    }





    public function pemakaian($nama,Request $request){



        if($nama == "print_laporan" && $_GET['format'] == 'print'){

            return view('laporan.pemakaian_print_1');

        } else if($nama == "print_laporan" && $_GET['format'] == 'doc'){

            return view('laporan.pemakaian_doc_1');

        }



        if($nama == "print_rekapitulasi" && $_GET['format'] == 'print'){

            return view('laporan.pemakaian_print_2');

        } else if($nama == "print_rekapitulasi" && $_GET['format'] == 'doc'){

            return view('laporan.pemakaian_doc_2');

        }



        if($nama == "print_grafik" && $_GET['format'] == 'print'){

            return view('laporan.pemakaian_print_3');

        } else if($nama == "print_grafik" && $_GET['format'] == 'doc'){

            return view('laporan.pemakaian_doc_3');

        }

    }





    public function penerimaan($nama,Request $request){



        if($nama == "print_laporan" && $_GET['format'] == 'print'){

            return view('laporan.penerimaan_print_1');

        } else if($nama == "print_laporan" && $_GET['format'] == 'doc'){

            return view('laporan.penerimaan_doc_1');

        }

    }



    public function opname($nama,Request $request){



        if($nama == "print_unit" && $_GET['format'] == 'print'){

            return view('laporan.opname_print_1');

        } else if($nama == "print_unit" && $_GET['format'] == 'doc'){

            return view('laporan.opname_doc_1');

        }



        if($nama == "print_kategori" && $_GET['format'] == 'print'){

            return view('laporan.opname_print_2');

        } else if($nama == "print_kategori" && $_GET['format'] == 'doc'){

            return view('laporan.opname_doc_2');

        }





    }



    public function pemakaian_per_unit($nama,Request $request){

        return view('laporan.pemakaian_per_unit_print_1');

    }



    public function oil($nama,Request $request){

        if($nama == "print_bbm" && $_GET['format'] == 'print'){

            return view('laporan.oil_print_1');

        } else if($nama == "print_bbm" && $_GET['format'] == 'doc'){

            return view('laporan.oil_doc_1');

        }





    }





    public function supplier($nama, Request $request){

        if($nama == "print_laporan" && $_GET['format'] == 'print'){

            return view('laporan.pemasok_print');

        } else if($nama == "print_laporan" && $_GET['format'] == 'doc'){

            return view('laporan.pemasok_doc');

        }



    }



    public function monitoring($nama, Request $request){

        if($nama == "print_laporan" && $_GET['format'] == 'print'){

            return view('laporan.monitoring_print');

        } else if($nama == "print_laporan" && $_GET['format'] == 'doc'){

            return view('laporan.monitoring_doc');

        }



    }



    public function pemakaian_gudang($nama, Request $request){

        if ($nama == "print_laporan" && $_GET['format'] == 'print') {

            return view('laporan.pemakaian_gudang_print');

        } else if($nama == "print_laporan" && $_GET['format'] == 'doc'){

            return view('laporan.pemakaian_gudang_doc');

        }

    }





    public function piutang($nama, Request $request){

        if ($nama == "print_laporan" && $_GET['format'] == 'print') {

            return view('laporan.piutang_print_1');

        } else if($nama == "print_laporan" && $_GET['format'] == 'doc'){

            return view('laporan.piutang_doc_1' );

        } else if($nama == "print_rekapitulasi" && $_GET['format'] == 'print'){

            return view('laporan.piutang_print_2');

        }else if($nama == "print_rekapitulasi" && $_GET['format'] == 'doc'){

            return view('laporan.piutang_doc_2');

        } else if($nama == "print_rekapitulasi_laporan" && $_GET['format'] == 'print'){

            return view('laporan.piutang_print_3');

        } else if($nama == "print_rekapitulasi_laporan" && $_GET['format'] == 'doc'){

            return view('laporan.piutang_doc_3');

        }

    }





    public function dapur($nama, Request $request){

        if ($nama == "print_laporan" && $_GET['format'] == 'print') {

            return view('laporan.dapur_print_1');

        } else if($nama == "print_laporan" && $_GET['format'] == 'doc'){

            return view('laporan.dapur_doc_1');

        }

    }





    public function bbm($nama, Request $request){

        if ($nama == "print_laporan" && $_GET['format'] == 'print') {

            return view('laporan.bbm_print');

        } else if($nama == "print_laporan" && $_GET['format'] == 'doc'){

            return view('laporan.bbm_doc');

        } else if($nama == "print_rekapitulasi" && $_GET['format'] == 'print'){

            return view('laporan.bbm_print_2');

        }else if($nama == "print_rekapitulasi" && $_GET['format'] == 'doc'){

            return view('laporan.bbm_doc_2');

        } else if($nama == "print_laporan_2" && $_GET['format'] == 'print'){

            return view('laporan.bbm_print_3');

        } else if($nama == "print_laporan_2" && $_GET['format'] == 'doc'){

            return view('laporan.bbm_doc_3');

        }

    }





    public function chart()

    {

        $result = DetailPemakaianBarang::with('barang','detail_bbk')->get();

        return $result;

    }



    public function get_total_per_bulan(Request $request){

        $total_col = [0,0,0,0,0,0,0,0,0,0,0,0];

        $tahun = $request->tahun;

        $result = DetailPemakaianBarang::whereHas('pemakaian',function ($q) use ($tahun) {

                                $q->whereYear('tanggal',$tahun);

                            })->get()->toBase()->merge(DetailPemakaianBarangLama::whereHas('pemakaian',function ($q) use ($tahun) {

                                $q->whereYear('tanggal',$tahun);

                            })->get());



        foreach ($result as $value) {

             $d = DetailPemakaianBarang::whereHas('pemakaian',function ($q) use ($tahun) {

                                $q->whereYear('tanggal',$tahun);

                            })->where('barang_id',$value->barang->id)->get()->toBase()->merge(DetailPemakaianBarangLama::whereHas('pemakaian',function ($q) use ($tahun) {

                                $q->whereYear('tanggal',$tahun);

                            })->where('barang_id',$value->barang->id)->get());$total = 0;   

                for ($i=0; $i < count($total_col) ; $i++) { 

                    $total = 0;



                    foreach($d as $dd){

                        if(date('m',strtotime($dd->pemakaian->tanggal)) == $i){

                            $total+=(int)(@$dd->detail_bbk->harga+@$dd->camp_lama->harga);

                            $total_col[$i-1] += $total;

                        }

                    }



                }

                            

        }



        return response()->json($total_col);

    }



    public function get_penerimaan_per_bulan(Request $request){



        $tahun = $request->tahun;

        $total_col = [0,0,0,0,0,0,0,0,0,0,0,0];



        $result = DetailBuktiBarangKeluar::whereHas('bbk',function ($q) use ($tahun) {

                                $q->whereYear('tanggal',$tahun);

                            })->where('barang_id',$value->barang->id)->get();



        foreach ($result as $value) {

             $d = DetailBuktiBarangKeluar::whereHas('bbk',function ($q) use ($tahun) {

                                $q->whereYear('tanggal',$tahun);

                            })->where('barang_id',$value->barang->id)->get();$total = 0;   

                for ($i=0; $i < count($total_col) ; $i++) { 

                    $total = 0;



                    foreach($d as $dd){

                        if( date('m',strtotime($dd->bbk->tanggal)) == $i){

                            $total+=(int)$dd->harga;

                            $total_col[$i-1] += $total;

                        }

                    }



                }  

                

                            

        }



        return response()->json($total_col);

    }



    public function pemakaian_doc($nama,Request $request){



        if($nama == "print_laporan"){

            return view('laporan.pemakaian_doc_1');

        }



        if($nama == "print_rekapitulasi"){

            return view('laporan.pemakaian_doc_2');

        }



        if($nama == "print_grafik"){

            return view('laporan.pemakaian_doc_3');

        }

    }





    public function penerimaan_doc($nama,Request $request){



        if($nama == "print_laporan"){

            return view('laporan.penerimaan_doc_1');

        }

    }



    public function opname_doc($nama,Request $request){



        if($nama == "print_unit"){

            return view('laporan.opname_doc_1');

        }



        if($nama == "print_kategori"){

            return view('laporan.opname_doc_2');

        }





    }



    public function pemakaian_per_unit_doc($nama,Request $request){

        if($nama == "print_unit"){

            return view('laporan.pemakaian_per_unit_doc_1');

        }

    }



    public function oil_doc($nama,Request $request){

        if($nama == "print_bbm"){

            return view('laporan.oil_doc_1');

        }

    }

}

