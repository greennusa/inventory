<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PemesananBarang;
use App\DetailPemesananBarang;
use App\PermintaanBarang;
use App\DetailPermintaanBarang;
use App\User;
use App\Pemasok;
use App\Kategori;
use App\Satuan;
use App\Unit;
use App\JenisUnit;
use App\Barang;
use Session;
use Auth;
use Mail;
class PemesananBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(Auth::user()->cek_akses('Pemesanan Barang','View',Auth::user()->id) != 1){
            return view('error.denied');
        }
        if(isset($request->q)){
            $q = $request->q;
        }
        else {
            $q = '';
        }
        
        if(isset($request->r)){
            $r = $request->r;
        }
        else {
            $r = '';
        }
        
        $pemasok = Pemasok::all();
        if($r > -1 && $r != ''){
            // $tables = PemesananBarang::where('pemasok_id', $r)->Where('nomor','like',"%$q%")->orderBy('created_at','DESC')->paginate(20);

            $tables = PemesananBarang::where('pemasok_id', $r)->Where('nomor','like',"%$q%")->
            // orWhereHas('detail',function ($query) use ($q){
            //     $qq = $q;
            //     $query->orwhere('kode_barang', 'like', '%'.$q.'%')->orWhere('nama_barang', 'like', '%'.$q.'%');
            // })
            //->
            orderBy('created_at','DESC')->paginate(20);
        
        }else if($r == -1 || $r == ''){
            $tables = PemesananBarang::Where('nomor','like',"%$q%")->orderBy('created_at','DESC')->paginate(20);
            
        }

        
        // foreach ($tables as $aa) {
        //     $dd = DetailPemesananBarang::where('pemesanan_barang_id',$aa->id)->get();
        //     foreach ($dd as $ddd) {
        //        $cc = DetailPermintaanBarang::where('permintaan_id',$ddd->permintaan_id)->where('barang_id',$ddd->barang_id)->first();
        //         DetailPemesananBarang::where('pemesanan_barang_id',$aa->id)->where('permintaan_id',$ddd->permintaan_id)->where('barang_id',$ddd->barang_id)->update([
        //             'detail_permintaan_barang_id'=>$cc->id,
        //         ]);
        //     }
        // }
        return view('pemesanan_barang.index',compact('tables','pemasok'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        if(Auth::user()->cek_akses('Pemesanan Barang','Add',Auth::user()->id) != 1){
            return view('error.denied');
        }
        $permintaan = PermintaanBarang::where('setuju',2)->whereHas('detail',function ($q)
        {
            $q->where('dipesan',0);
        })->get();
        $user = User::all();
        $pemasok = Pemasok::all();
        $satuan = Satuan::all();
        $kategori = Kategori::all();
        $unit = Unit::all();
        $user = User::all();
        $jenisunit = JenisUnit::all();
       
        return view('pemesanan_barang.create',compact('permintaan','pemasok','satuan','kategori','unit','jenisunit','user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {       
        if(Auth::user()->cek_akses('Pemesanan Barang','Add',Auth::user()->id) != 1){
            return view('error.denied');
        }
       
       

        $input = $request->all();
        $input['status'] = 0;
        unset($input['_token']);
        unset($input['pemesanan_lama']);
        unset($input['detail_id']);
        $cek_sup = DetailPermintaanBarang::where('permintaan_id',$input['permintaan_id'])->where('pemasok_id','-1')->count();

        if($cek_sup > 0){
            Session::flash(
                "flash_notif",[
                    "level"   => "dismissible alert-danger",
                    "massage" => "Ada Data Di Permintaan Barang Yang Belum Di Atur Suplliernya"
            ]);    
            return back();
        }
        $p = PermintaanBarang::findOrFail($input['permintaan_id']);
        
        $dp = DetailPermintaanBarang::where('permintaan_id',$input['permintaan_id'])->where('pemasok_id',$input['pemasok_id'])->where('dipesan',0)->where('status',2)->get();
        if(count($dp) == 0){
            Session::flash(
                "flash_notif",[
                    "level"   => "dismissible alert-danger",
                    "massage" => "Data <strong>Barang</strong> Belum Siap Di Pesan"
            ]);
            return back();
        }
        if($request->data_baru){
            $cek = PemesananBarang::firstOrNew(['nomor'=>$request->nomor,'tanggal'=>$request->tanggal]);
            if($cek->exists){
                
                Session::flash(
                    "flash_notif",[
                        "level"   => "dismissible alert-danger",
                        "massage" => "Data Dengan Nomor <strong>$request->nomor</strong> Sudah Digunakan"
                ]);    
                return back();
            }
           
            unset($input['permintaan_id']);
            unset($input['pemesanan_baru']);
            unset($input['data_baru']);
            unset($input['detail_id']);
            $data = PemesananBarang::create($input);
            \App\AktivitasUser::create(['user_id'=>Auth::user()->id,'aktivitas'=>'Menambah data pemesanan barang dengan nomor '.$data->nomor]);
            $id = $data->id;
            
            
            foreach ($p->detail as $d) {
                if($d->status == 2 && $d->pemasok_id == $input['pemasok_id']){
                    
                    $dp = DetailPermintaanBarang::findOrFail($d->id);
                    if($dp->jumlah_disetujui == $dp->jumlah){
                        //$dp->update(['dipesan'=>1]);
                    }
                    
                    DetailPemesananBarang::create([
                        'pemesanan_barang_id'=>$id,
                        'detail_permintaan_barang_id'=>$d->id,
                        'detail_gabungan'=>$d->id,
                        'barang_id'=>$d->barang_id,
                        'jumlah'=>$d->jumlah_disetujui, 
                        'harga'=>$d->harga,
                        'keterangan'=>$d->keterangan,
                        'gabungan'=>$d->gabungan,
                        'nama_barang'=>$dp->nama_barang,
                        'kode_barang'=>$dp->kode_barang,
                        'keperluan'=>$request->keperluan
                    ]);
                }
            }
        }
        
        else {
            $pemesanan_barang = PemesananBarang::where('nomor',$input['nomor'])->first();
            // $ck = explode('</>', $pemesanan_barang->keperluan);
            // $cek_ck = count($ck);
            // $new_sep = ' . </>';
            // if($cek_ck < count($pemesanan_barang->detail)){
            //     $new_sep = '';
            //     for ($i=0; $i < (count($pemesanan_barang->detail) - $cek_ck); $i++) { 
            //         $new_sep .= ' . </> ';
            //     }
            //}
            // $keperluan = $pemesanan_barang->keperluan.' </> '.$request->keperluan;
            // PemesananBarang::where('nomor',$input['nomor'])->update([
            //     'keperluan'=>$keperluan,
            // ]);
            $id = $pemesanan_barang->id;
            foreach ($p->detail as $d) {
                $dp = DetailPermintaanBarang::findOrFail($d->id);
                $cek = DetailPemesananBarang::where('pemesanan_barang_id',$pemesanan_barang->id)->where('detail_permintaan_barang_id',$d->id)->where('barang_id',$d->barang_id)->get();
                
                if($d->status == 2 && $d->pemasok_id == (int)$input['pemasok_id'] && count($cek) == 0 && $d->dipesan == 0){

                    
                    if($dp->jumlah_disetujui == $dp->jumlah){
                        //$dp->update(['dipesan'=>1]);
                    }
                    DetailPemesananBarang::create([
                        'pemesanan_barang_id'=>$pemesanan_barang->id,
                        'detail_permintaan_barang_id'=>$d->id,
                        'barang_id'=>$d->barang_id,
                        'jumlah'=>$d->jumlah_disetujui,
                        'harga'=>$d->harga,
                        'keterangan'=>$d->keterangan,
                        'nama_barang'=>$dp->nama_barang,
                        'kode_barang'=>$dp->kode_barang,
                        'keperluan'=>$request->keperluan
                    ]);
                }
            }
        }
            
        Session::flash(
            "flash_notif",[
                "level"   => "dismissible alert-success",
                "massage" => "Data <strong>Pemesanan Barang</strong> Berhasil Di Tambahkan"
        ]);
        return redirect('order/'.$id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
        if(Auth::user()->cek_akses('Pemesanan Barang','Detail',Auth::user()->id) != 1){
            return view('error.denied');
        }
        $r = PemesananBarang::findOrFail($id);
        $pemasok = Pemasok::all();
        $satuan = Satuan::all();
        $kategori = Kategori::all();
        $unit = Unit::all();
        $user = User::all();
        $jenisunit = JenisUnit::all();
  
        return view('pemesanan_barang.view',compact('r','pemasok','satuan','kategori','unit','jenisunit','user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        if(Auth::user()->cek_akses('Pemesanan Barang','Edit',Auth::user()->id) != 1){
            return view('error.denied');
        }
        $r = PemesananBarang::findOrFail($id);

        $permintaan = PermintaanBarang::where('setuju',2)->get();

        return view('pemesanan_barang.edit',compact('permintaan','r'));
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
        if(Auth::user()->cek_akses('Pemesanan Barang','Edit',Auth::user()->id) != 1){
            return view('error.denied');
        }
        $input = $request->all();
        $input['status'] = 0;
        unset($input['_token']);
        unset($input['page']);
        $data = PemesananBarang::findOrFail($id);

        $data->update([
            'tanggal'=>$request->tanggal,
            'pemasok_id'=>$request->pemasok_id,
            'dikirim'=>$request->dikirim,
        ]);

        \App\AktivitasUser::create(['user_id'=>Auth::user()->id,'aktivitas'=>'Edit data pemesanan barang dengan nomor '.$data->nomor]);
        $data->update($input);
        // DetailPemesananBarang::where('pemesanan_barang_id',$id)->delete();      
        // $p = PermintaanBarang::findOrFail($input['permintaan_id']);

        // foreach ($p->detail as $d) {
        //     if($d->status == 2 && $d->pemasok_id == $input['pemasok_id']){
        //         DetailPemesananBarang::create([
        //             'pemesanan_barang_id'=>$id,
        //             'barang_id'=>$d->barang_id,
        //             'jumlah'=>$d->jumlah,
        //             'harga'=>$d->harga,
        //             'keterangan'=>$d->keterangan
        //         ]);
        //     }
                
        // }

        return redirect('order');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        if(Auth::user()->cek_akses('Pemesanan Barang','Delete',Auth::user()->id) != 1){
            return view('error.denied');
        }
        $data = PemesananBarang::findOrFail($id);
        foreach ($data->detail as $d) {
 
        
            $dpr = DetailPermintaanBarang::where('permintaan_id',$d->permintaan_id)->where('barang_id',$d->barang_id)->update(['dipesan'=>0]);
        }
        \App\AktivitasUser::create(['user_id'=>Auth::user()->id,'aktivitas'=>'Mengahpus data pemesanan barang dengan nomor '.$data->nomor]);
        $data->delete();
        Session::flash(
            "flash_notif",[
                "level"   => "dismissible alert-success",
                "massage" => "Data <strong>$data->nama</strong> Berhasil Di Hapus"
        ]);
        return redirect('order');
    }


    public function print_doc($id){
        if(Auth::user()->cek_akses('Pemesanan Barang','Print',Auth::user()->id) != 1){
            return view('error.denied');
        }
        $r = PemesananBarang::findOrFail($id);
        return view('pemesanan_barang.doc',compact('r'));
    }

    public function print_xls($id){
        if(Auth::user()->cek_akses('Pemesanan Barang','Print',Auth::user()->id) != 1){
            return view('error.denied');
        }
        $r = PemesananBarang::findOrFail($id);
        return view('pemesanan_barang.xls',compact('r'));
    }

    public function print_pdf($id){
        if(Auth::user()->cek_akses('Pemesanan Barang','Print',Auth::user()->id) != 1){
            return view('error.denied');
        }
        $r = PemesananBarang::findOrFail($id);
        return view('pemesanan_barang.pdf',compact('r'));
    }

    public function print_out($id){
        if(Auth::user()->cek_akses('Pemesanan Barang','Print',Auth::user()->id) != 1){
            return view('error.denied');
        }
        $r = PemesananBarang::findOrFail($id);
        
        return view('pemesanan_barang.print',compact('r'));
    }


    public function get_detail_pemesanan($id){
        $detail = DetailPemesananBarang::where('pemesanan_barang_id',$id)->where('masuk',0)->get();
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
                        <th>SN</th>
                        <th>Jumlah</th>
                        <th>Harga Satuan</th>
                        
                        <th width="150px">Kelengkapan</th>
                        
                        <th>Keterangan</th>
                        <th>No OPB</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1 ?>
                    <?php foreach ($detail as $d): if($d->gabungan == '' || $d->gabungan == null):
                            ?>
                        <tr>
                            <input type="hidden" name="detail_id[]" value="<?php echo $d->id ?>">
                            <input type="hidden" name="barang_id[]" value="<?php echo $d->barang_id ?>">
                            <td><?php echo $no ?></td>
                            <?php $db = DetailPemesananBarang::where('gabungan','like','%'.$d->detail_gabungan.'%')->where('pemesanan_barang_id',$id)->get();?>
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
                            <input readonly class="form-control" type="hidden" name="nama_barang[]" value="<?php echo $d->nama_barang ?>">
                          
                            <td><?php echo $d->barang->unit->kode ?></td>
                            <td><?php echo $d->barang->halaman ?></td>
                            <td><?php echo $d->barang->indeks ?></td>
                            <td><?php if($d->barang->pakai_sn == 1): ?><button type="button" class="btn btn-primary " id="id_<?=$no?>" data-toggle="modal" data-target="#myModal<?=$d->id?>"><i class="glyphicon glyphicon-plus"></i></button><?php endif; ?></td>
                            <td>
                                <?php echo $d->jumlah ?> <?php echo $d->detail_permintaan->satuan->nama ?>
                                <input readonly class="form-control" type="hidden" name="jumlah[]" value="<?php echo $d->jumlah ?>">
                            </td>
                            <td>
                                Rp.<?php echo number_format($d->harga) ?>
                                <input readonly class="form-control" type="hidden" name="harga[]" value="<?php echo $d->harga ?>">
                            </td>
                           
                            <td>
                                <select name="kelengkapan[]" class="form-control "   required>
                                    <option value="1">Lengkap</option>
                                    <option value="0">Tidak Lengkap</option>
                                </select>
                            </td>
                        
                            <td><input type="text" name="detail_keterangan[]" class="form-control" value="<?php echo $d->keterangan ?>"></td>
                            <td>
                                <?php echo $d->detail_permintaan->permintaan->nomor ?>
                            </td>
                        </tr>
                        <?php $no++ ?>
                    <?php endif; endforeach; ?>
                </tbody>
            </table>

            <?php foreach ($detail as $detail_barang): 
                    if($detail_barang->barang->pakai_sn == 1):?>
                <div id="myModal<?=$detail_barang->id?>" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Tambah Serial Number</h4>
                            </div>
                            <div class="modal-body" style="padding:0;overflow-y: scroll;max-height: 70vh;">
                                    
                                    
                                    <table class="table table-bordered table-responsive" style="padding:0">
                                        <thead>
                                            <tr>
                                                <th>Nomor</th>
                                                <th>Serial Number Barang</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $x = 1; ?>
                                            <?php for ($i=0; $i < $detail_barang->jumlah; $i++):?>
                                                <tr>
                                                    <td valign="midlle"><?php echo $x ?></td>
                                                    
                                                    <td><input type="text" name="sn_<?php echo $detail_barang->barang_id ?>[]" class="form-control input-submit-query input_sn" placeholder="Serial number <?php echo $detail_barang->barang->nama ?>"></td>
                                                    <?php $x++ ?>
                                                </tr>
                                            <?php endfor ?>
                                        </tbody>
                                    </table>
                                
                            </div>
                            <div class="modal-footer">
            
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>

                    </div>
                </div>
            <?php endif; endforeach ?>
        <?php
    }

    public function cek_pemesanan($supplier_id){
        $c = PemesananBarang::where('pemasok_id',$supplier_id)->get();
        if(count($c) > 0){
            
            return $c;
        }
        else {
            return json_encode(false);
        }
    }


    public function get_pemesanan_lama ($supplier_id){
        $pemesanan = PemesananBarang::where('pemasok_id',$supplier_id)->get();
        if(count($pemesanan) > 0){
            ?>
                <option></option>
                <?php foreach ($pemesanan as $p): ?>
                    <option value="<?php echo $p->id ?>" ><?php echo $p->nomor ?> - <?php echo $p->tanggal ?></option>
                <?php endforeach ?>

            <?php
        }
        else {
            echo "false";
        }
            
    }

    public function get_pemesanan ($id){
        $pemesanan = PemesananBarang::findOrFail($id);
        return $pemesanan;
            
    }


    public function detail_baru(Request $request,$id)
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
        


        if(Auth::user()->cek_akses('Permintaan Barang','Add',Auth::user()->id) != 1){
            return view('error.denied');
        }
        $dp = PermintaanBarang::firstOrNew(['nomor'=>$request->nomor,'tanggal'=>$request->tanggal]);
        if($dp->exists){
            
            Session::flash(
                "flash_notif",[
                    "level"   => "dismissible alert-danger",
                    "massage" => "Data Dengan Nomor <strong>$request->nomor</strong> Sudah Digunakan"
            ]);    
            return redirect()->back();
        }

        $input = $request->all();
        
        $this->validate($request,[
            
            'nomor'=>'required',
            'pembuat_id'=>'required',
            'diperiksa_id'=>'required',
            
        ]);
        $input['pembuat_id'] = $request->pembuat_id;
        $input['unit_id'] = $barang->unit_id;
        $input['lokasi_id'] = Auth::user()->lokasi_id;
        //$input['jumlah_disetujui'] = $request->jumlah;
        $pem = PemesananBarang::find($id);

        unset($input['kota']);
        $dp = PermintaanBarang::create([
            'nomor'=>$request->nomor,
            'tanggal'=>$request->tanggal,
            'destination'=>$request->destination,
            'lokasi_id'=> Auth::user()->lokasi_id,
            'unit_id'=>$barang->unit_id,
            'sifat'=>$request->sifat,
            'setuju'=>2,
            'diketahui_id'=>$request->diketahui_id,
            'diperiksa_id'=>$request->diperiksa_id,
            'disetujui_id'=>$request->disetujui_id,
            'pembuat_id'=>$request->pembuat_id
        ]);


        $d = DetailPermintaanBarang::create([
            'permintaan_id'=>$dp->id,
            'barang_id'=>$barang->id,
            'satuan_id'=>$barang->satuan_id,
            'jumlah'=>$request->jumlah,
            'jumlah_disetujui'=>$request->jumlah,
            'harga'=>$barang->harga,
            'keterangan'=>$barang->keterangan,
            'pemasok_id'=>$pem->pemasok_id
        ]);
        

        $dd = DetailPemesananBarang::create([
            'pemesanan_barang_id'=>$id,
            'detail_permintaan_barang_id'=>$d->id,
            'detail_gabungan'=>$d->id,
            'barang_id'=>$d->barang_id,
            'jumlah'=>$d->jumlah_disetujui, 
            'harga'=>$d->harga,
            'keterangan'=>$d->keterangan,
            'gabungan'=>$d->gabungan,
            'nama_barang'=>$dp->nama_barang,
            'kode_barang'=>$dp->kode_barang,
        ]);

        $user = User::all();

        \App\AktivitasUser::create(['user_id'=>Auth::user()->id,'aktivitas'=>'Menambah data permintaan barang dengan nomor '.$dp->nomor]);
        /*foreach ($user as $value) {
            if($value->email != null){
                try {
                    Mail::send('email.permintaan', ['r' => $dp], function ($m) use ($value) {
                        $m->from('postmaster@inventoryudit.green-nusa.net', 'Inventory Udit');

                        $m->to($value->email, $value->nama)->subject('Pemberitahuan');
                    });
                  
                } catch (\Exception $e) {
                    echo ("Email Notifikasi Tidak terkirim <br> <a href='".url('/')."'>Home</a>");
                    dd($e);
                }
                
            }
        }*/
        
        return redirect('order/'.$id);
    

    }


    public function detail_baru2(Request $request)
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
        


        if(Auth::user()->cek_akses('Permintaan Barang','Add',Auth::user()->id) != 1){
            return view('error.denied');
        }
        $dp = PermintaanBarang::firstOrNew(['nomor'=>$request->nomor]);
        if($dp->exists){
            
            Session::flash(
                "flash_notif",[
                    "level"   => "dismissible alert-danger",
                    "massage" => "Data Dengan Nomor <strong>$request->nomor</strong> Sudah Digunakan"
            ]);    
            return redirect()->back();
        }

        $input = $request->all();
        
        $this->validate($request,[
            
            'nomor'=>'required',
            'pembuat_id'=>'required',
            'diperiksa_id'=>'required',
            
        ]);
        $input['pembuat_id'] = $request->pembuat_id;
        $input['unit_id'] = $barang->unit_id;
        $input['lokasi_id'] = Auth::user()->lokasi_id;
        //$input['jumlah_disetujui'] = $request->jumlah;
  

        unset($input['kota']);
        $dp = PermintaanBarang::create([
            'nomor'=>$request->nomor,
            'tanggal'=>$request->tanggal,
            'destination'=>$request->destination,
            'lokasi_id'=> Auth::user()->lokasi_id,
            'unit_id'=>$barang->unit_id,
            'sifat'=>$request->sifat,
            'setuju'=>2,
            'diketahui_id'=>$request->diketahui_id,
            'diperiksa_id'=>$request->diperiksa_id,
            'disetujui_id'=>$request->disetujui_id,
            'pembuat_id'=>$request->pembuat_id
        ]);


        $d = DetailPermintaanBarang::create([
            'permintaan_id'=>$dp->id,
            'barang_id'=>$barang->id,
            'satuan_id'=>$barang->satuan_id,
            'jumlah'=>$request->jumlah,
            'jumlah_disetujui'=>$request->jumlah,
            'harga'=>$barang->harga,
            'keterangan'=>$barang->keterangan,
            'pemasok_id'=>$pem->pemasok_id
        ]);
        

      

        $user = User::all();

        \App\AktivitasUser::create(['user_id'=>Auth::user()->id,'aktivitas'=>'Menambah data permintaan barang dengan nomor '.$dp->nomor]);
        /*foreach ($user as $value) {
            if($value->email != null){
                try {
                    Mail::send('email.permintaan', ['r' => $dp], function ($m) use ($value) {
                        $m->from('postmaster@inventoryudit.green-nusa.net', 'Inventory Udit');

                        $m->to($value->email, $value->nama)->subject('Pemberitahuan');
                    });
                  
                } catch (\Exception $e) {
                    echo ("Email Notifikasi Tidak terkirim <br> <a href='".url('/')."'>Home</a>");
                    dd($e);
                }
                
            }
        }*/
        
        return redirect('order/create');
    

    }

    

}
