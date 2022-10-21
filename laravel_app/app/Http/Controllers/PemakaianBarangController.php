<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;

use App\PemakaianBarang;

use App\DetailPemakaianBarang;

use App\DetailPemakaianBarangLama;

use App\Unit;

use App\User;

use App\Camp;

use App\CampLama;

use App\CampLog;

use App\SerialCamp;

use App\ReturBarang;

use App\Dapur;

use Auth;

use Session;

class PemakaianBarangController extends Controller

{

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index(Request $request)

    {   

        if(Auth::user()->cek_akses('Pemakaian Barang','View',Auth::user()->id) != 1){

            return view('error.denied');

        }





        $d = Dapur::all();

        if(isset($request->q)){

            $q = $request->q;

        }

        else {

            $q = '';

        }

        

        if(isset($request->p)){

            $p = $request->p;

        } else{

            $p = '0';

        }



        if(isset($request->r)){

            $r = $request->r;

        } else{

            $r = '0';

        }        



        $tables = PemakaianBarang::where('piutang', $p)->WhereHas('detail',function ($query) use ($q,$p,$r){

            $qq = $q;

            

            $query->WhereHas('barang',function ($qr) use ($qq){

                $qr->where('kode', 'like', '%'.$qq.'%')->orWhere('nama', 'like', '%'.$qq.'%');

            })->where('dapur','=', "$r");

        })->orWhereHas('detail_lama',function ($query) use ($q,$p,$r){

            $qq = $q;

            

            $query->WhereHas('barang',function ($qr) use ($qq){

                $qr->where('kode', 'like', '%'.$qq.'%')->orWhere('nama', 'like', '%'.$qq.'%');

            })->where('dapur','=', "$r");

        })->where('tanggal','like',"%$q%")->orderBy('created_at','DESC')->paginate(20);



        // $tables = PemakaianBarang::where('piutang', 0)->orderBy('created_at', 'DESC')->paginate(10);

        return view('pemakaian_barang.index',compact('tables','d'));

    }





    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {   

        if(Auth::user()->cek_akses('Pemakaian Barang','Add',Auth::user()->id) != 1){

            return view('error.denied');

        }

        $unit = Unit::all();

        $user = User::all();

        $penggunaan = ['Skidding','Road Counstruction','Produksi','Penimbunan','Penunjang','Alkon + Genset','PMDH/Umum','Mutasi'];

        return view('pemakaian_barang.create',compact('unit','user','penggunaan'));

    }



    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request)

    {   

        

        if(Auth::user()->cek_akses('Pemakaian Barang','Add',Auth::user()->id) != 1){

            return view('error.denied');

        }

       

       if(!isset($request->keterangan)){

        $request->keterangan = ' ';

       }

        $p = PemakaianBarang::create([

            

            'tanggal'=>$request->tanggal,
            'keterangan'=>$request->keterangan, 
            'unit_id'=>$request->unit_id,
            'diketahui_id'=>$request->diketahui_id,
            'diterima'=>$request->diterima,
            'dibuat_id'=>$request->dibuat_id,
            'lokasi'=>$request->lokasi,
            'piutang'=>$request->piutang,
            'penggunaan'=>$request->penggunaan

        ]);

        if($request->pilih == null){
            return redirect()->back()->withInput();
        }

        for ($i=0; $i < count($request->pilih); $i++) { 

            if( isset($request->detail_bukti_barang_keluar_id[$request->pilih[$i]]) ){

                $cc = Camp::findOrFail($request->camp_id[$request->pilih[$i]]);

                DetailPemakaianBarang::create([
                    'pemakaian_barang_id'=>$p->id,
                    'detail_bukti_barang_keluar_id'=>$request->detail_bukti_barang_keluar_id[$request->pilih[$i]],
                    'barang_id'=>$request->barang_id[$request->pilih[$i]],
					'nama_barang'=>$cc->nama_barang,
                    'gabungan'=>$cc->gabungan,
					'harga'=>$cc->harga,
                    'gabungan_id'=>$cc->gabungan_id,
                    'jumlah'=>$request->jumlah[$request->pilih[$i]],
					'jumlah_awal'=> $cc->stok,
                    'dapur'=>$cc->dapur,                
                ]);

                $c = Camp::where('barang_id',$request->barang_id[$request->pilih[$i]]);

                CampLog::create([
						'barang_id'=>$request->barang_id[$request->pilih[$i]],
						'nama_barang'=>$cc->nama_barang,
						'tanggal'=>$request->tanggal,
						'aksi' => "pemakaian",
						'jumlah'=>$request->jumlah[$request->pilih[$i]],
					]);

                if($cc->count() > 0){

                    $stok = $cc->stok - $request->jumlah[$request->pilih[$i]];
                    
                    if($stok > 0){

                        $cc->update(['stok'=>$stok,'stok_awal'=>$cc->stok]);

                    }

                    else if($stok <= 0) {
						$cc->update(['stok'=>$stok,'stok_awal'=>$cc->stok]);
                        //$cc->delete();

                    }

                }

                

            } else if( !isset($request->detail_bukti_barang_keluar_id[$request->pilih[$i]])) {

                $cc = CampLama::findOrFail($request->camp_id[$request->pilih[$i]]);

                DetailPemakaianBarangLama::create([

                    'pemakaian_barang_id'=>$p->id,

                    'barang_id'=>$request->barang_id[$request->pilih[$i]],
					
					'nama_barang'=>$cc->nama_barang,
					
					'harga'=>$cc->harga,

                    'jumlah'=>$request->jumlah[$request->pilih[$i]],
					
					'jumlah_awal'=> $cc->stok,
					
                    'camp_lama_id'=>$cc->id,

                    'dapur'=>$cc->dapur,

                    

                ]);

                $c = CampLama::where('barang_id',$request->barang_id[$request->pilih[$i]]);

                CampLog::create([
						'barang_id'=>$request->barang_id[$request->pilih[$i]],
						'nama_barang'=>$cc->nama_barang,
						'tanggal'=>$request->tanggal,
						'aksi' => "pemakaian",
						'jumlah'=>$request->jumlah[$request->pilih[$i]],
					]);

                if($cc->count() > 0){

                    $stok = $cc->stok - $request->jumlah[$request->pilih[$i]];

                    if($stok > 0){

                        $cc->update(['stok'=>$stok,'stok_awal'=>$cc->stok]);

                    }

                    else if($stok <= 0) {
                        $cc->update(['stok'=>$stok,'stok_awal'=> $cc->stok]);
                        //$cc->delete();

                    }

                }

            }   

        }



        \App\AktivitasUser::create(['user_id'=>Auth::user()->id,'aktivitas'=>'Menambah data pemakaian barang dengan tanggal '.$p->tanggal]);





        return redirect('item_use');

    }



    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function show($id)

    {   

        if(Auth::user()->cek_akses('Pemakaian Barang','Detail',Auth::user()->id) != 1){

            return view('error.denied');

        }

        $r = PemakaianBarang::with('detail','detail.barang')->findOrFail($id);

        $retur = ReturBarang::all();

        $unit = Unit::all();

        $user = User::all();

     

        return view('pemakaian_barang.view',compact('r','unit','user','retur'));

    }



    /**

     * Show the form for editing the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function edit($id)

    {

        $r = PemakaianBarang::with('detail','detail.barang')->findOrFail($id);

        $retur = ReturBarang::all();

        $unit = Unit::all();

        $user = User::all();
		
		$penggunaan = ['Skidding','Road Counstruction','Produksi','Penimbunan','Penunjang','Alkon + Genset','PMDH/Umum','Mutasi'];
		
        return view('pemakaian_barang.edit',compact('r','unit','user','retur','penggunaan'));

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

        PemakaianBarang::findOrFail($id)->update([

            

            'tanggal'=>$request->tanggal,

            'keterangan'=>$request->keterangan,
            

            'diketahui_id'=>$request->diketahui_id,

            'diterima'=>$request->diterima,

            'dibuat_id'=>$request->dibuat_id,

            'lokasi'=>$request->lokasi

        ]);



        if($request->pilih){

            for ($i=0; $i < count($request->pilih); $i++) { 

                $cek = DetailPemakaianBarang::where('pemakaian_barang_id',$id)->where('barang_id',$request->barang_id[$request->pilih[$i]])->first();

                if($cek == null){

                    $cc = Camp::findOrFail($request->camp_id[$request->pilih[$i]]);

                    DetailPemakaianBarang::create([

                        'pemakaian_barang_id'=>$p->id,

                        'detail_bukti_barang_keluar_id'=>$request->detail_bukti_barang_keluar_id[$request->pilih[$i]],

                        'barang_id'=>$request->barang_id[$request->pilih[$i]],

                        'gabungan'=>$cc->gabungan,

                        'gabungan_id'=>$cc->gabungan_id,

                        'jumlah'=>$request->jumlah[$request->pilih[$i]],

                        'jumlah_awal'=> $cc->stok

                    ]);
					CampLog::create([
						'barang_id'=>$request->barang_id[$request->pilih[$i]],
						'nama_barang'=>$cc->nama_barang,
						'tanggal'=>$request->tanggal,
						'aksi' => "pemakaian",
						'jumlah'=>$request->jumlah[$request->pilih[$i]],
					]);
					
                }

                else {

                    $cc = Camp::findOrFail($request->camp_id[$request->pilih[$i]]);

                    DetailPemakaianBarang::where('pemakaian_barang_id',$id)->where('barang_id',$request->barang_id[$request->pilih[$i]])->update([

                        

                        'jumlah'=>$cek->jumlah+$request->jumlah[$request->pilih[$i]],

                        

                    ]);

                }

                    

                $c = Camp::where('barang_id',$request->barang_id[$request->pilih[$i]]);

                CampLog::create([
						'barang_id'=>$request->barang_id[$request->pilih[$i]],
						'nama_barang'=>$cc->nama_barang,
						'tanggal'=>$request->tanggal,
						'aksi' => "pemakaian",
						'jumlah'=>$request->jumlah[$request->pilih[$i]],
					]);

                if($c->count() > 0){

                    $stok = $cc->stok - $request->jumlah[$request->pilih[$i]];

                    if($stok > 0){

                        $cc->update(['stok'=>$stok,'stok_awal'=>$cc->stok]);

                    }

                    else if($c->count() <= 0) {
						$cc->update(['stok'=>$stok,'stok_awal'=>$cc->stok]);
                        //$c->delete();

                    }

                }

                    

                

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

        if(Auth::user()->cek_akses('Pemakaian Barang','Delete',Auth::user()->id) != 1){

            return view('error.denied');

        }

        $p = PemakaianBarang::findOrFail($id);

        \App\AktivitasUser::create(['user_id'=>Auth::user()->id,'aktivitas'=>'Menghapus data pemakaian barang dengan tanggal '.$p->tanggal]);

        $p->delete();

        return redirect('item_use');

    }



    public function print_out($id){

        if(Auth::user()->cek_akses('Pemakaian Barang','Print',Auth::user()->id) != 1){

            return view('error.denied');

        }

        $r = PemakaianBarang::findOrFail($id);

        return view('pemakaian_barang.print',compact('r'));

    }



    public function print_xls($id){

        if(Auth::user()->cek_akses('Pemakaian Barang','Print',Auth::user()->id) != 1){

            return view('error.denied');

        }

        $r = PemakaianBarang::findOrFail($id);

        return view('pemakaian_barang.xls',compact('r'));

    }



    public function print_doc($id){

        if(Auth::user()->cek_akses('Pemakaian Barang','Print',Auth::user()->id) != 1){

            return view('error.denied');

        }

        $r = PemakaianBarang::findOrFail($id);

        return view('pemakaian_barang.doc',compact('r'));

    }





    public function scan(){

        $unit = Unit::all();

        $user = User::all();

        return view('pemakaian_barang.scan',compact('unit','user'));

    }





    public function insert_scan(Request $request){

        $sc = SerialCamp::where('sn',$request->sn)->first();

        if($sc){

            if($request->tanggal){

                $p = PemakaianBarang::create([

                    

                    'tanggal'=>$request->tanggal,

                    'keterangan'=>$request->keterangan,

                    

                    'unit_id'=>$request->unit_id,

                    'diketahui_id'=>$request->diketahui_id,

                    'diterima'=>$request->diterima,

                    'dibuat_id'=>$request->dibuat_id,

                    'lokasi'=>$request->lokasi

                ]);



                



                

                DetailPemakaianBarang::create([

                    'pemakaian_barang_id'=>$p->id,

                    'detail_bukti_barang_keluar_id'=>$sc->camp->detail_bukti_barang_keluar_id,

                    'barang_id'=>$sc->camp->barang_id,

                    'gabungan'=>$sc->camp->gabungan,

                    'gabungan_id'=>$sc->camp->gabungan_id,

                    'jumlah'=>1,

                    

                ]);

            } else {

                $bp = DetailPemakaianBarang::where('barang_id',$sc->camp->barang_id)->where('pemakaian_barang_id',$request->pemakaian_barang_id);

                if($bp->count() > 0){

                    $bp->update([

                        'jumlah'=>$bp->first()->jumlah + 1

                    ]);

                }

                else {

                    DetailPemakaianBarang::create([

                        'pemakaian_barang_id'=>$request->pemakaian_barang_id,

                        'detail_bukti_barang_keluar_id'=>$sc->camp->detail_bukti_barang_keluar_id,

                        'barang_id'=>$sc->camp->barang_id,

                        'gabungan'=>$sc->camp->gabungan,

                        'gabungan_id'=>$sc->camp->gabungan_id,

                        'jumlah'=>1,

                        

                    ]);

                }

            }

        } else {

            echo "Barang Tidak Ada";

            

        }

    }

}

