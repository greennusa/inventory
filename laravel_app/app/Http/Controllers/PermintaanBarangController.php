<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;

use App\PermintaanBarang;

use App\Barang;

use App\Merek;

use App\User;

use App\Lokasi;

use App\Unit;

use App\JenisUnit;

use App\Satuan;

use Auth;

use Session;

use Mail;



use App\Kategori;

use App\DetailPermintaanBarang;



class PermintaanBarangController extends Controller

{

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index(Request $request)

    {   

        if(Auth::user()->cek_akses('Permintaan Barang','View',Auth::user()->id) != 1){

            return view('error.denied');

        }

        if(isset($request->q)){

            $q = $request->q;

        }

        else {

            $q = '';

        }

        $tables = PermintaanBarang::WhereHas('detail',function ($query) use ($q){

            $qq = $q;

            $query->WhereHas('barang',function ($qr) use ($qq){

                $qr->where('kode', 'like', '%'.$qq.'%')->orWhere('nama', 'like', '%'.$qq.'%');

            });

        })->orWhere('nomor','like',"%$q%")->orderBy('created_at','DESC')->paginate(20);

        

        // foreach ($tables as $aa) {

        //     $dd = DetailPermintaanBarang::where('permintaan_id',$aa->id)->get();

        //     foreach ($dd as $ddd) {

        //        $cc = Barang::findOrFail($ddd->barang_id);

        //         $c = DetailPermintaanBarang::find($ddd->id)->update([

        //             'satuan_id'=>$cc->satuan_id,

        //         ]);

                

        //     }

        // }

        

        return view('permintaan_barang.index',compact('tables'));

    }



    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {   

        if(Auth::user()->cek_akses('Permintaan Barang','Add',Auth::user()->id) != 1){

            return view('error.denied');

        }

        $barang = Barang::all();

        $user = User::all();

        $jenisunit = JenisUnit::all();

        return view('permintaan_barang.create',compact('barang','user','jenisunit'));

    }



    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request)

    {

        if(Auth::user()->cek_akses('Permintaan Barang','Add',Auth::user()->id) != 1){

            return view('error.denied');

        }

        $orderBarang = PermintaanBarang::firstOrNew(['nomor'=>$request->nomor,'tanggal'=>$request->tanggal]);

        if($orderBarang->exists){

            

            Session::flash(

                "flash_notif",[

                    "level"   => "dismissible alert-danger",

                    "massage" => "Data Dengan Nomor <strong>$request->nomor</strong> Sudah Digunakan"

            ]);    

            return back();

        }



        $input = $request->all();

        

        $this->validate($request,[

            

            'nomor'=>'required',

            'pembuat_id'=>'required',

            'diperiksa_id'=>'required',

            'unit_id'=>'required'

            

        ]);

        $input['pembuat_id'] = $request->pembuat_id;

        $input['lokasi_id'] = Auth::user()->lokasi_id;

        //$input['jumlah_disetujui'] = $request->jumlah;

    

        unset($input['kota']);

        $orderBarang->fill($input)->save();

        $user = User::all();

        /*foreach ($user as $value) {

            if($value->email != null){

                try {

                    Mail::send('email.permintaan', ['r' => $orderBarang], function ($m) use ($value) {

                        $m->from('postmaster@inventoryudit.green-nusa.net', 'Inventory Udit');



                        $m->to($value->email, $value->nama)->subject('Pemberitahuan');

                    });

                  

                } catch (\Exception $e) {

                    dd("Email Notifikasi Tidak terkirim");

                }

                

            }

        }*/

        \App\AktivitasUser::create(['user_id'=>Auth::user()->id,'aktivitas'=>'Menambah data permintaan barang dengan nomor '.$orderBarang->nomor]);

        return redirect('purchase_request/'.$orderBarang->id.'/edit');

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

    public function edit($id,Request $request)

    {   

        if(Auth::user()->cek_akses('Permintaan Barang','Edit',Auth::user()->id) != 1){

            return view('error.denied');

        }

        $page = $request->p;

        $r = PermintaanBarang::findOrFail($id);

        $m = Unit::findOrFail($r->unit_id);

        $x = $m->jenis_unit->kode;

        $barang = Barang::whereHas('unit',function ($q) use ($x){

            $q->whereHas('jenis_unit',function($jn) use ($x){

                $jn->where('kode',$x);

            });

        })->get();

        $user = User::all();

        $jenisunit = JenisUnit::all();

        $kategori = Kategori::all();

        $satuan = Satuan::all();

       

        $unit = Unit::all();

        return view('permintaan_barang.edit',compact('r','barang','user','jenisunit','page','satuan','satuan','kategori','jenisunit','unit'));

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

        if(Auth::user()->cek_akses('Permintaan Barang','Edit',Auth::user()->id) != 1){

            return view('error.denied');

        }

        $data = PermintaanBarang::findOrFail($id);

        \App\AktivitasUser::create(['user_id'=>Auth::user()->id,'aktivitas'=>'Edit data permintaan barang dengan nomor '.$data->nomor]);

        $input = $request->all();

        $input['pembuat_id'] = $request->pembuat_id;

        unset($input['page']);

        $data->update($input);

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

        if(Auth::user()->cek_akses('Permintaan Barang','Delete',Auth::user()->id) != 1){

            return view('error.denied');

        }

        $data = PermintaanBarang::findOrFail($id);

        \App\AktivitasUser::create(['user_id'=>Auth::user()->id,'aktivitas'=>'Mengahpus data permintaan barang dengan nomor '.$data->nomor]);

        $data->delete();

        return redirect('purchase_request');

    }



    public function print_xls($id){

        if(Auth::user()->cek_akses('Permintaan Barang','Print',Auth::user()->id) != 1){

            return view('error.denied');

        }

        $r = PermintaanBarang::findOrFail($id);

        return view('permintaan_barang.xls',compact('r'));

    }



    public function print_doc($id){

        if(Auth::user()->cek_akses('Permintaan Barang','Print',Auth::user()->id) != 1){

            return view('error.denied');

        }

        $r = PermintaanBarang::findOrFail($id);

        return view('permintaan_barang.doc',compact('r'));

    }



    public function print_out($id){

        if(Auth::user()->cek_akses('Permintaan Barang','Print',Auth::user()->id) != 1){

            return view('error.denied');

        }

        $r = PermintaanBarang::findOrFail($id);

        return view('permintaan_barang.print',compact('r'));

    }





    public function get_list_barang_permintaan_barang($id,$permintaan_id){

        $detail = DetailPermintaanBarang::where('permintaan_id',$permintaan_id)->where('pemasok_id',$id)->get();

        $c = DetailPermintaanBarang::where('permintaan_id',$permintaan_id)->where('pemasok_id',$id)->where('dipesan',0)->count();

        if($c <= 0){

            return 'false';

        }

        ?>

            <table class="table table-bordered table-hover">

                <thead>

                    <tr>

                        <th>#</th>

                        <th>Kode Barang</th>

                        <th>Nama Barang</th>

                       

                        <th>Kode Unit</th>

                        <th>Halaman</th>

                        <th>Indeks</th>

                 

                       

                        <th>Harga</th>

                        <th>Jumlah</th>

                        

                        <th>Keterangan</th>

                        <th>Status</th>

                    </tr>

                </thead>

                <tbody>

                    <?php $no=1 ?>

                    <?php foreach ($detail as $d): if(($d->gabungan == '' || $d->gabungan == null) && $d->status == 2 && $d->dipesan == 0):?>



                        <tr>

                            <input type="hidden" name="detail_id" value="{{ $d->id }}">

                            <td><?php echo $no ?></td>

                            <?php $db = DetailPermintaanBarang::where('gabungan','like','%'.$d->id.'%')->get();?>

                            <td><?php echo $d->kode_barang ?>

                                <?php foreach($db as $dd): ?>

                                 / <?php echo $dd->kode_barang ?>

                                <?php endforeach ?>

                            </td>

                            <td><?php echo $d->nama_barang ?>

                                <?php foreach($db as $dd): ?>

                                 / <?php echo $dd->nama_barang ?>

                                <?php endforeach ?>

                            </td>

                           

                            <td><?php echo $d->barang->unit->kode ?></td>

                            <td><?php echo $d->barang->halaman ?></td>

                            <td><?php echo $d->barang->indeks ?></td>

                           

                            

                            <td>

                                Rp.<?php echo number_format($d->harga) ?>

                                

                            </td>

                            <td>

                                <?php echo $d->jumlah_disetujui ?> <?php echo $d->satuan->nama ?>

                            </td>

                      

                            <td><?php echo $d->keterangan ?></td>

                            <td>

                                <?php if (@$d->status == 1) {echo "Tidak Ada";} ?>

                                <?php if (@$d->status == 2) {echo "Ada";} ?>

                                <?php if (@$d->status == 3) {echo "Pending";} ?>

                            </td>

                                

                        </tr>

                        <?php $no++ ?>

                    <?php endif; endforeach ?>

                </tbody>

            </table>

 

        <?php

    }



    public function get_list_barang_permintaan_barang2($permintaan_id){

        $detail = DetailPermintaanBarang::where('permintaan_id',$permintaan_id)->get();

        $c = DetailPermintaanBarang::where('permintaan_id',$permintaan_id)->where('dipesan',0)->count();

        if($c <= 0){

            return 'false';

        }

        ?>

            <table class="table table-bordered table-hover">

                <thead>

                    <tr>

                        <th>#</th>

                        <th>Kode Barang</th>

                        <th>Nama Barang</th>

                       

                        <th>Kode Unit</th>

                        <th>Halaman</th>

                        <th>Indeks</th>

                 

                       

                        <th>Harga</th>

                        <th>Jumlah</th>

                        

                        <th>Keterangan</th>

                        <th>Status</th>

                    </tr>

                </thead>

                <tbody>

                    <?php $no=1 ?>

                    <?php foreach ($detail as $d): if(($d->gabungan == '' || $d->gabungan == null) && $d->status == 2 && $d->dipesan == 0):?>



                        <tr>

                            <input type="hidden" name="detail_id" value="{{ $d->id }}">

                            <td><?php echo $no ?></td>

                            <?php $db = DetailPermintaanBarang::where('gabungan','like','%'.$d->id.'%')->get();?>

                            <td><?php echo $d->kode_barang ?>

                                <?php foreach($db as $dd): ?>

                                 / <?php echo $dd->kode_barang ?>

                                <?php endforeach ?>

                            </td>

                            <td><?php echo $d->nama_barang ?>

                                <?php foreach($db as $dd): ?>

                                 / <?php echo $dd->nama_barang ?>

                                <?php endforeach ?>

                            </td>

                           

                            <td><?php echo $d->barang->unit->kode ?></td>

                            <td><?php echo $d->barang->halaman ?></td>

                            <td><?php echo $d->barang->indeks ?></td>

                           

                            

                            <td>

                                Rp.<?php echo number_format($d->harga) ?>

                                

                            </td>

                            <td>

                                <?php echo $d->jumlah_disetujui ?> <?php echo $d->barang->satuan->nama ?>

                            </td>

                      

                            <td><?php echo $d->keterangan ?></td>

                            <td>

                                <?php if (@$d->status == 1) {echo "Tidak Ada";} ?>

                                <?php if (@$d->status == 2) {echo "Ada";} ?>

                                <?php if (@$d->status == 3) {echo "Pending";} ?>

                            </td>

                                

                        </tr>

                        <?php $no++ ?>

                    <?php endif; endforeach ?>

                </tbody>

            </table>

 

        <?php

    }



    public function kirim_email(){

        $user = User::findOrFail(1);

            try {

                Mail::send('email.notif', ['user' => $user], function ($m) use ($user) {

                    $m->from('hello@app.com', 'Test Lagi');



                    $m->to($user->email, $user->nama)->subject('HELLO');

                });

            } catch (Exception $e) {

                die();

            }

            

        

    }



    public function get_permintaan($id){

        return PermintaanBarang::findOrFail($id);

    }



    public function barang_baru(Request $request)

    {

        if(Auth::user()->cek_akses('Barang','Add',Auth::user()->id) != 1){

            return view('error.denied');

        }

        $gambar  = '';

        if ($request->hasFile('userfile')) {

            $this->validate($request,[

                'userfile'=>'mimes:png,jpg,JPG,jpeg',

               

            ]);

            $gambar = 'gambar-barang-'.str_replace(" ", "-", $request->kode.'-'.$request->nama).'.png';

            $request->file('userfile')->storeAs('images/barang',$gambar,'public_img');

        }

        

        $this->validate($request,[

            'unit_id'=>'required',

            'kategori_id'=>'required',

            'satuan_id'=>'required',

            'nama'=>'required',

            

        ]);



       

        $harganya = str_replace(',', '',$request->harga);

        $harganya = str_replace('.', '',$harganya);

        $data = Barang::create([

            'qrcode'=>$this->randomcode(),

            'kode'=>$request->kode,

            'nama'=>$request->nama,

            'unit_id'=>$request->unit_id,

            

            'kategori_id'=>$request->kategori_id,

            'harga'=>$harganya,

            'halaman'=>$request->halaman,

            'indeks'=>$request->indeks,

            

            'satuan_id'=>$request->satuan_id,

            'keterangan'=>$request->keterangan,

            'gambar'=>$gambar,

            'pakai_sn'=>$request->pakai_sn,

         

        ]);

        \App\AktivitasUser::create(['user_id'=>Auth::user()->id,'aktivitas'=>'Menambah data barang dengan nama '.$data->nama]);



        $barang = Barang::findOrFail($data->id);

        DetailPermintaanBarang::create([

                'permintaan_id'=>$request->permintaan_id,

                'barang_id'=>$barang->id,

                'satuan_id'=>$barang->satuan_id,

                'jumlah'=>1,

                'harga'=>$barang->harga,

                'keterangan'=>$barang->keterangan,

        ]);

        return redirect()->back();

    }

}

