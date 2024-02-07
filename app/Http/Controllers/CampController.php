<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;

use App\User;

use App\Camp;

use App\SerialCamp;

use App\BuktiBarangKeluar;

use App\DetailBuktiBarangKeluar;

use App\SerialDetailBuktiBarangKeluar;

use App\DetailPemesananBarang;

use App\ReturBarangCamp;

use App\Gudang;

use App\Satuan;

use App\Barang;

use Illuminate\Support\Collection;

use App\CampLama;

use App\CampLog;

use App\Dapur;

use Auth;

use Session;

class CampController extends Controller

{

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index(Request $request)

    {   

        

        // $c = Camp::all();

        // foreach ($c as $d) {

        //     foreach ($d->serial as $s) {

        //         SerialCamp::find($s->id)->update(['detail_bukti_barang_keluar_id'=>$d->detail_bukti_barang_keluar_id]);

        //     }

        // }

       

        if(Auth::user()->cek_akses('Camp','View',Auth::user()->id) != 1){

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





        $c = collect(Camp::with('barang')->whereHas('barang',function($qu) use ($q){

            $qu->where('kode','like',"%$q%")->orWhere('qrcode','like',"%$q%")->orWhere('nama_barang','like',"%$q%");

        })->get());

        $user = User::all();

        $retur = ReturBarangCamp::all();



        // $g =  collect(CampLama::with('barang')->whereHas('barang',function($qu) use ($q){

        //     $qu->where('kode','like',"%$q%")->orWhere('qrcode','like',"%$q%");

        // })->where('dapur','=', "$p")->get());

        $g =  collect(CampLama::with('barang')->where('kode_barang','like',"%$q%")->orWhere('nama_barang','like',"%$q%")->get());

        $cg = $c->toBase()->merge($g);

        $tables = (new Collection($cg))->where('stok','>',0)->where('dapur','=', "$p")->sortByDesc('updated_at')->paginate(20);

        

        return view('camp.index',compact('tables','user','retur','d'));

    }



    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {   



        $d = Dapur::all();

        if(Auth::user()->cek_akses('Camp','Add',Auth::user()->id) != 1){

            return view('error.denied');

        }

        $bbk = BuktiBarangKeluar::all();

        return view('camp.create',compact('bbk','d'));

    }



    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request)

    {   



        if(Auth::user()->cek_akses('Camp','Add',Auth::user()->id) != 1){

            return view('error.denied');

        }



        for ($i=0; $i < count($request->pilih); $i++) { 

            $cc = DetailBuktiBarangKeluar::findOrFail($request->detail_bukti_barang_keluar_id[$request->pilih[$i]]);

            $c = Camp::where('barang_id',$request->barang_id[$request->pilih[$i]])->where('nama_barang',$cc->nama_barang)->where('dapur', $request->camp);

            $cc->update(['jumlah_di_camp'=>$request->jumlah[$request->pilih[$i]] + $cc->jumlah_di_camp]);

			

            //Cek Apakah ada barang yang sama di Camp, Jika ada maka di update jumlahnya

            if($c->count() > 0){

                $stok = $c->first()->stok + $request->jumlah[$request->pilih[$i]];

                if($c->first()->detail_bbk->detail_bbm->detail_pemesanan->detail_permintaan->satuan->id == $cc->detail_bbm->detail_pemesanan->detail_permintaan->satuan->id ){

                    $c->update(['keterangan'=>$request->keterangan[$request->pilih[$i]],'stok'=>$stok,'stok_awal'=>$c->first()->stok]);
					
					CampLog::create([
						'barang_id' => $request->barang_id[$request->pilih[$i]],
						'nama_barang' => $request->nama_barang[$request->pilih[$i]],
						'tanggal'=>$request->tanggal,
						'aksi' => "penambahan",
						'jumlah'=>$request->jumlah[$request->pilih[$i]]
					]);

                    $v = 0;

                    foreach ($cc->serial as $dbs) {

                        if($v < $request->jumlah[$request->pilih[$i]]){

                            $v++;

                            SerialCamp::create([

                                'camp_id'=>Camp::where('barang_id',$request->barang_id[$request->pilih[$i]])->where('nama_barang',$cc->nama_barang)->first()->id,

                                'sn'=>$dbs->sn,

                                'permintaan_barang_id'=>$cc->detail_bbm->detail_pemesanan->detail_permintaan->permintaan->id,

                                'detail_bukti_barang_keluar_id'=>$request->detail_bukti_barang_keluar_id[$request->pilih[$i]],

                            ]);

                        }

                            

                    }

                } else {

                    $camp_id = Camp::create([

                        'barang_id'=>$request->barang_id[$request->pilih[$i]],

                        'detail_bukti_barang_keluar_id'=>$request->detail_bukti_barang_keluar_id[$request->pilih[$i]],

                        'nama_barang'=>$request->nama_barang[$request->pilih[$i]],

                        'stok'=>$request->jumlah[$request->pilih[$i]],

                        'stok_awal'=>0,

                        'gabungan'=>$cc->gabungan,

                        'gabungan_id'=>$cc->gabungan_id,

                        'tanggal'=>$request->tanggal,

                        'harga'=>$cc->harga,

                        'keterangan'=>$request->keterangan[$request->pilih[$i]],

                        'dapur'=>$request->camp,

                    ])->id;

                    CampLog::create([
						'barang_id' => $request->barang_id[$request->pilih[$i]],
						'nama_barang' => $request->nama_barang[$request->pilih[$i]],
						'tanggal'=>$request->tanggal,
						'aksi' => "penambahan",
						'jumlah'=>$request->jumlah[$request->pilih[$i]]
					]);

                    

                    // $s = data_get($request,"sn_".$request->detail_id[$i]);

                    // for ($v=0; $v < count($s) ; $v++) { 

                    //     SerialCamp::create([

                    //         'camp_id'=>$camp_id,

                    //         'sn'=>$s[$v],

                    //         'permintaan_barang_id'=>$cc->detail_bbm->detail_pemesanan->detail_permintaan->permintaan->id

                    //     ]);

                    // } 

                    $v = 0;

                    foreach ($cc->serial as $dbs) {

                        if($v < $request->jumlah[$request->pilih[$i]]){

                            $v++;

                            SerialCamp::create([

                                'camp_id'=>$camp_id,

                                'sn'=>$dbs->sn,

                                'permintaan_barang_id'=>$cc->detail_bbm->detail_pemesanan->detail_permintaan->permintaan->id,

                                'detail_bukti_barang_keluar_id'=>$request->detail_bukti_barang_keluar_id[$request->pilih[$i]],

                            ]);

                        }

                            

                    }

                    $data = BuktiBarangKeluar::findOrFail($request->bbk_id);

                    \App\AktivitasUser::create(['user_id'=>Auth::user()->id,'aktivitas'=>'Menambah data camp dari bkk dengan nomor '.$data->nomor]);

                    if(count($request->pilih) == count($data->detail)){

               

                        $cek = DetailBuktiBarangKeluar::findOrFail($request->detail_bukti_barang_keluar_id[$request->pilih[$i]]);



                        if($cek->jumlah == $cek->jumlah_di_camp){

                            $data->update(['status'=>1]);

                        }

                            

                    }

                    

                }

            //Jika tidak ada yang sama, maka buat data Camp baru    

            } else {

                

                $camp_id = Camp::create([

                    'barang_id'=>$request->barang_id[$request->pilih[$i]],

                    'detail_bukti_barang_keluar_id'=>$request->detail_bukti_barang_keluar_id[$request->pilih[$i]],

                    'nama_barang'=>$request->nama_barang[$request->pilih[$i]],

                    'stok'=>$request->jumlah[$request->pilih[$i]],

                    'stok_awal'=> 0,

                    'gabungan'=>$cc->gabungan,

                    'gabungan_id'=>$cc->gabungan_id,

                    'tanggal'=>$request->tanggal,

                    'harga'=>$cc->harga,

                    'keterangan'=>$request->keterangan[$request->pilih[$i]],

                    'dapur'=>$request->camp,

                ])->id;

					CampLog::create([
						'barang_id' => $request->barang_id[$request->pilih[$i]],
						'nama_barang' => $request->nama_barang[$request->pilih[$i]],
						'tanggal'=>$request->tanggal,
						'aksi' => "penambahan",
						'jumlah'=>$request->jumlah[$request->pilih[$i]]
					]);
                

                

                // $s = data_get($request,"sn_".$request->detail_id[$i]);

                // for ($v=0; $v < count($s) ; $v++) { 

                //     SerialCamp::create([

                //         'camp_id'=>$camp_id,

                //         'sn'=>$s[$v],

                //         'permintaan_barang_id'=>$cc->detail_bbm->detail_pemesanan->detail_permintaan->permintaan->id

                //     ]);

                // } 



                $v = 0;

                    foreach ($cc->serial as $dbs) {

                        if($v < $request->jumlah[$request->pilih[$i]]){

                            $v++;

                            SerialCamp::create([

                                'camp_id'=>$camp_id,

                                'sn'=>$dbs->sn,

                                'permintaan_barang_id'=>$cc->detail_bbm->detail_pemesanan->detail_permintaan->permintaan->id,

                                'detail_bukti_barang_keluar_id'=>$request->detail_bukti_barang_keluar_id[$request->pilih[$i]],

                            ]);

                        }

                            

                    }

                $data = BuktiBarangKeluar::findOrFail($request->bbk_id);

                \App\AktivitasUser::create(['user_id'=>Auth::user()->id,'aktivitas'=>'Menambah data camp dari bkk dengan nomor '.$data->nomor]);

                if(count($request->pilih) == count($data->detail)){

               

                    $cek = DetailBuktiBarangKeluar::findOrFail($request->detail_bukti_barang_keluar_id[$request->pilih[$i]]);



                        if($cek->jumlah == $cek->jumlah_di_camp){

                            $data->update(['status'=>1]);

                        }

                }

                

            }

            

                  

                

            



        }



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

        $r = Camp::findOrFail($id);

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

        if(Auth::user()->cek_akses('Camp','Delete',Auth::user()->id) != 1){

            return view('error.denied');

        }

        $data = Camp::findOrFail($id);

        \App\AktivitasUser::create(['user_id'=>Auth::user()->id,'aktivitas'=>'Mengahpus data camp dengan kode barang '.$data->barang->kode]);

        $data->delete();

        Session::flash(

            "flash_notif",[

                "level"   => "dismissible alert-success",

                "massage" => "Data Berhasil Di Hapus"

        ]);

        return back();

    }





    public function get_barang_camp(Request $request){

        

        ?>

             <script type="text/javascript">

            function toggle(source) {

            checkboxes = document.getElementsByName('pilih[]');

            console.log(checkboxes);

            for(var i=0, n=checkboxes.length;i<n;i++) {

                checkboxes[i].checked = source.checked;

  }

}

        </script>

        <input type="checkbox" onClick="toggle(this)"> Centang Semua

            <table class="table">

                <tr>

                    <th>Pilih</th>

                    <th>Kode Barang</th>

                    <th>Nama Barang</th>
					
					<th></th>
					
                    <th>Stok</th>
					
					<th>Harga</th>

                    <th>Jumlah Pemakaian</th>

                    

                </tr>

        <?php

        $index = 0;

        for ($i=0; $i < count($request->unit); $i++) { 

            $unit_id = $request->unit[$i];

            $barang_nama = $request->barang_nama;

            $user = User::all();

            $retur = ReturBarangCamp::all();

            $c = collect(Camp::where('dapur', 0)->with('barang')->whereHas('barang',function($qu) use ($unit_id,$barang_nama){

                $qu->where('barangs.unit_id',$unit_id)->where('barangs.nama','like',"%".$barang_nama."%");

            })->get());

            $g =  collect(CampLama::where('dapur', 0)->with('barang')->whereHas('barang',function($qu) use ($unit_id,$barang_nama){

                    $qu->where('barangs.unit_id',$unit_id)->where('barangs.nama','like',"%".$barang_nama."%");

                })->get());

            $cg = $c->toBase()->merge($g);

            $tables = (new Collection($cg))->where('stok','>',0)->sortByDesc("created_at");

            $barang_camp = Camp::with('barang')->whereHas('barang',function($qu) use ($unit_id){

                $qu->where('barangs.unit_id',$unit_id);

            })->get();

            

            if(count($tables) > 0){

                

            ?>

                    <?php foreach ($tables as $u): ?>

                        <?php $db = DetailPemesananBarang::where('gabungan','like','%'.@$u->gabungan_id.'%')->get();?>

                        <tr>

                            <td>

                                <input type="checkbox" name="pilih[]" value="<?php echo $index ?>" id="pilih-<?php echo @$u->barang_id?>">

                                <input type="hidden" name="camp_id[<?php echo $index; ?>]" value="<?php echo @$u->id ?>">

                                <input type="hidden" name="barang_id[<?php echo $index; ?>]" value="<?php echo @$u->barang_id ?>">

                                <input type="hidden" name="nama_barang[<?php echo $index; ?>]" value="<?php echo @$u->nama_barang ?>">

                                <?php if($u->detail_bukti_barang_keluar_id != null): ?>

                                <input type="hidden" name="detail_bukti_barang_keluar_id[<?php echo $index; ?>]" value="<?php echo @$u->detail_bukti_barang_keluar_id ?>">

                                <?php endif; ?>

                                <input type="hidden" name="harga[<?php echo $index; ?>]" value="<?php echo @$u->detail_bbk->harga ?>">

                            </td>



                            <td>

                                <?php if(@$u->detail_bbk->detail_bbm->detail_pemesanan->kode_barang != null){ echo @$u->detail_bbk->detail_bbm->detail_pemesanan->kode_barang; }else { echo @$u->barang->kode; }?>

                                <?php if($u->detail_bbk != null): ?>

                                <?php foreach($db as $dd): ?>

                                 / <?php echo $dd->barang->kode ?>

                                <?php endforeach;endif; ?>

                            </td>

                            <td>

                                <?php if(@$u->detail_bbk->detail_bbm->detail_pemesanan->nama_barang != null){ echo @$u->barang->nama; }else { echo @$u->barang->nama; }?> 

                                <?php if($u->detail_bbk != null): ?>

                                <?php foreach($db as $dd): ?>

                                 / <?php echo $dd->barang->nama ?>

                                <?php endforeach;endif; ?>

                            </td>
							
							<td>
								<?php echo @$u->camp->nama ?>
							</td>
							
                            <td>

                                <?php echo @$u->stok ?> <?php echo @$u->detail_bbk->detail_bbm->detail_pemesanan->detail_permintaan->satuan->nama ?>

                            </td>
							
							<td>
								<?php echo number_format(@$u->harga) ?>
							</td>
							
                            <td>

                                <input type="number" max="<?php echo @$u->stok ?>" name="jumlah[<?php echo $index; ?>]" value="<?php echo @$u->stok ?>" >

                            </td>

                           

                        </tr>

                                                    

                            <?php $index += 1; ?>

                           

                        

                    <?php ;endforeach; ?>

                

            <?php



            }

        }

        ?>

            </table>

        <?php

        

    }



    public function stok_lama(){

        $satuan = Satuan::all();

        $barang = Barang::all();

        return view('camp.stok_lama',compact('satuan','barang'));

    }



    public function tambah_stok_lama(Request $request){

        $camp_id = CampLama::create([

            'barang_id'=>$request->barang_id,

            'nama_barang'=>$request->nama,

            'harga'=>$request->harga,

            'satuan_id'=>$request->satuan_id,



            'stok'=>$request->jumlah,

            'stok_awal'=>0,

            

            'tanggal'=>$request->tanggal,

        ])->id;

        

        return redirect('warehouse_udit');     

                

    }



    public function check_serial(Request $request){

        $sg = SerialCamp::where('sn',$request->sn)->first();

        if($sg){

            return $sg->camp->barang_id;

        } 

    }

}

