<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BuktiBarangKeluar;
use App\DetailBuktiBarangKeluar;
use App\SerialDetailBuktiBarangKeluar;
use App\Gudang;
use App\BuktiBarangMasuk;
use App\DetailBuktiBarangMasuk;
use App\SerialDetailBuktiBarangMasuk;
use App\SerialGudang;
use App\PemesananBarang;
use App\DetailPemesananBarang;
use App\User;
use App\Camp;
use App\Satuan;
use Auth;
use Mail;
use Session;
class BuktiBarangKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        if(Auth::user()->cek_akses('Bukti Barang Keluar','View',Auth::user()->id) != 1){
            return view('error.denied');
        }
        if(isset($request->q)){
            $q = $request->q;
        }
        else {
            $q = '';
        }
        $tables = BuktiBarangKeluar::WhereHas('detail',function ($query) use ($q){
            $qq = $q;
            $query->WhereHas('barang',function ($qr) use ($qq){
                $qr->where('kode', 'like', '%'.$qq.'%')->orWhere('nama', 'like', '%'.$qq.'%');
            });
        })->orWhere('nomor','like',"%$q%")->orderBy('created_at','DESC')->paginate(20); 
        return view('bbk.index',compact('tables'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        if(Auth::user()->cek_akses('Bukti Barang Keluar','Add',Auth::user()->id) != 1){
            return view('error.denied');
        }
        $user = User::all();
        $pemesanan = PemesananBarang::all();
        $bbm = BuktiBarangMasuk::all();
        return view('bbk.create',compact('pemesanan','user','bbm'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        if(Auth::user()->cek_akses('Bukti Barang Keluar','Add',Auth::user()->id) != 1){
            return view('error.denied');
        }
        // $cek = BuktiBarangKeluar::where('nomor',$request->nomor)->count();
        // if($cek > 0){
            
        //     Session::flash(
        //         "flash_notif",[
        //             "level"   => "dismissible alert-danger",
        //             "massage" => "Data Dengan Nomor <strong>$request->nomor</strong> Sudah Digunakan"
        //     ]);    
        //     return back();
        // }
        //dd($request->gudang_id);
        $input = $request->all();
        // $this->validate($request,[
        //     'nomor'=>'required|unique:bukti_barang_keluars|min:2',
        //     // 'tanggal'=>'required',
        //     // 'dikirim'=>'required',
        //     // 'kepada'=>'required',
        //     // 'mengetahui'=>'required',
        //     // 'pengantar'=>'required',
        //     // 'penerima'=>'required',
        //     // 'pengirim'=>'required',
            
        // ]);
        unset($input['_token']);
        unset($input['detail_bukti_barang_masuk_id']);
        $id = BuktiBarangKeluar::create([
                'nomor'=>$request->nomor,
                'status'=>2,
                // 'tanggal'=>$request->tanggal,
                // 'dikirim'=>$request->dikirim,
                // 'kepada'=>$request->kepada,
              
                // 'mengetahui'=>$request->mengetahui,
                // 'pengantar'=>$request->pengantar,
                // 'penerima'=>$request->penerima,
                // 'pengirim'=>$request->pengirim,
                // 'keterangan'=>$request->keterangan,

            ])->id;
        for ($i=0; $i < count($request->pilih); $i++) { 
            
            $detail = DetailBuktiBarangMasuk::where('id',$request->detail_bukti_barang_masuk_id[$request->pilih[$i]])->where('barang_id',$request->barang_id[$request->pilih[$i]])->first();
           
                $id_detail = DetailBuktiBarangKeluar::create([
                        'bukti_barang_keluar_id'=>$id,
                        'detail_bukti_barang_masuk_id'=>$request->detail_bukti_barang_masuk_id[$request->pilih[$i]],
                        'barang_id'=>$request->barang_id[$request->pilih[$i]],
                        'nama_barang'=>$request->nama_barang[$request->pilih[$i]],
                        'jumlah'=>$request->jumlah[$request->pilih[$i]],
                        'harga'=>$request->harga[$request->pilih[$i]],
                        'gabungan_id'=>$detail->gabungan_id,
                        'gabungan'=>$detail->gabungan
                        
                ])->id;
                $serial = SerialDetailBuktiBarangMasuk::where('detail_bukti_barang_masuk_id',$detail->id)->get();
                foreach ($serial as $item) {
                    SerialDetailBuktiBarangKeluar::create([
                        'detail_bukti_barang_keluar_id'=>$id_detail,
                        'sn'=>$item->sn
                    ]);
                }
                $g = Gudang::where('barang_id',$request->barang_id[$request->pilih[$i]])->where('detail_bukti_barang_masuk_id',$request->detail_bukti_barang_masuk_id[$request->pilih[$i]]);
                $stok = $g->first()->stok - $request->jumlah[$request->pilih[$i]];
                if ($g->first()->stok > 0) {
                    
                    $g->update(['stok'=>$stok]);

                    if ($g->first()->stok == 0) {
                        $g->delete();
                    }
                } 
            
                

        }
        $user = User::all();
        $bbk = BuktiBarangKeluar::findOrFail($id);
        \App\AktivitasUser::create(['user_id'=>Auth::user()->id,'aktivitas'=>'Menambah data bbk dengan nomor '.$bbk->nomor]);
        /*foreach ($user as $value) {
            if($value->email != null){
                try {
                    Mail::send('email.bbk', ['r' => $bbk], function ($m) use ($value) {
                        $m->from('postmaster@inventoryudit.green-nusa.net', 'Inventory Udit');

                        $m->to($value->email, $value->nama)->subject('Pemberitahuan');
                    });
                } catch (Exception $e) {
                    echo ("Email Notifikasi Tidak terkirim <br> <a href='".url('/')."'>Home</a>");
                    dd($e);
                }
            }
        }*/
        
        // for ($i=0; $i < count($request->detail_bukti_barang_masuk_id); $i++) { 
            
        //     $bbm = DetailBuktiBarangMasuk::where('detail_bukti_barang_masuk_id',$request->detail_bukti_barang_masuk_id[$i])->get();
        //     foreach ($bbm as $ddd) {
        //         $id_detail = DetailBuktiBarangKeluar::create([
        //                 'bukti_barang_keluar_id'=>$id,
        //                 'detail_bukti_barang_masuk_id'=>$request->detail_bukti_barang_masuk_id[$i],
        //                 'barang_id'=>$ddd->barang_id,
        //                 'gabungan_id'=>$ddd->gabungan_id,
        //                 'jumlah'=>$ddd->jumlah,
        //                 'harga'=>$ddd->harga,
        //                 'gabungan'=>$ddd->gabungan
                        
        //         ])->id;
        //         $serial = SerialDetailBuktiBarangMasuk::where('detail_bukti_barang_masuk_id',$ddd->id)->get();
        //         foreach ($serial as $item) {
        //             SerialDetailBuktiBarangKeluar::create([
        //                 'detail_bukti_barang_keluar_id'=>$id_detail,
        //                 'sn'=>$item->sn
        //             ]);
        //         }
        //     }     
           
        // }
        Session::flash(
            "flash_notif",[
                "level"   => "dismissible alert-success",
                "massage" => "Data <strong>$request->nomor</strong> Berhasil Di Tambahkan"
        ]);
        return redirect('item_out/'.$id.'/edit');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        if(Auth::user()->cek_akses('Bukti Barang Keluar','Edit',Auth::user()->id) != 1){
            return view('error.denied');
        }
        $user = User::all();
        $pemesanan = PemesananBarang::all();
        $bbm = BuktiBarangMasuk::all();
        $r = BuktiBarangKeluar::findOrFail($id);
        
        return view('bbk.edit',compact('r','user','pemesanan','bbm'));
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
        if(Auth::user()->cek_akses('Bukti Barang Keluar','Edit',Auth::user()->id) != 1){
            return view('error.denied');
        }
        $input = $request->all();
        $this->validate($request,[
            'nomor'=>'required|min:2',
            'tanggal'=>'required',
            'dikirim'=>'required',
            'kepada'=>'required',
            'mengetahui'=>'required',
            'pengantar'=>'required',
            'penerima'=>'required',
            'pengirim'=>'required',
            
        ]);
        unset($input['_token']);
        unset($input['page']);
        unset($input['pemesanan_barang_id']);

        $bbk = BuktiBarangKeluar::find($id);
        if($bbk->nomor != $request->nomor){
            $this->validate($request,[
                'nomor'=>'required|unique:bukti_barang_keluars|min:2',
                
            ]);
        }
        $bbk = BuktiBarangKeluar::findOrFail($id);
        $bbk->update($input);
        \App\AktivitasUser::create(['user_id'=>Auth::user()->id,'aktivitas'=>'Edit data bbk dengan nomor '.$bbk->nomor]);
        return redirect('item_out');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        if(Auth::user()->cek_akses('Bukti Barang Keluar','Delete',Auth::user()->id) != 1){
            return view('error.denied');
        }
        $data = BuktiBarangKeluar::findOrFail($id);

        try {
            
            $data->delete();
           
        } catch (\Illuminate\Database\QueryException $e) {
            if($e->errorInfo[1] == 1451){
                Session::flash(
                    "flash_notif",[
                        "level"   => "dismissible alert-danger",
                        "massage" => "Data Tidak Bisa Dihapus. Data Masih Digunakan"
                ]);   
                return redirect()->back();
            }
            
            
        }
        \App\AktivitasUser::create(['user_id'=>Auth::user()->id,'aktivitas'=>'Menghapus data bbk dengan nomor '.$data->nomor]);
        
        Session::flash(
            "flash_notif",[
                "level"   => "dismissible alert-success",
                "massage" => "Data <strong>$data->nomor</strong> Berhasil Di Hapus"
        ]);
        return back();
    }

    public function print_xls($id){
        $r = BuktiBarangKeluar::findOrFail($id);
        return view('bbk.xls',compact('r'));
    }

    public function print_doc($id){
        $r = BuktiBarangKeluar::findOrFail($id);
        return view('bbk.doc',compact('r'));
    }

    public function print_out($id){
        $r = BuktiBarangKeluar::findOrFail($id);
       
        return view('bbk.print',compact('r'));
    }


    public function get_detail_bbk($id){
        $detail = DetailBuktiBarangKeluar::where('bukti_barang_keluar_id',$id)->get();
        $bbk = BuktiBarangKeluar::find($id);
        ?>  

            <div style="min-width: 200px;min-height: 50px;padding: 10px;margin: 10px;border: 1px solid red;border-radius: 10px;">
                Keterangan : <?php echo $bbk->keterangan; ?>
            </div>
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
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        
                        <th>Pilih Barang</th>
                       
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                       
                        <th>Kode Unit</th>
                      
                        <th>Halaman</th>
                        <th>Indeks</th>
                        
                        <th>Keterangan</th>
                        <th>Jumlah</th>
                        
                        <th>Jumlah Yang Akan Diterima</th>
                        <th>Satuan</th>
                        <th width="100px">Harga</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1;
                    $jml_total = 0;
                      $total = 0;
                      $jumlahItem = 0;
                      $jumlahPengeluaran = 0; 
                      $no_b = 0;
                      $po = '';?>
                    <?php foreach ($detail as $d): ?>
                        <?php if($po != $d->detail_bbm->bbm->pemesanan->nomor): ?>
                            
                        <tr>
                            <input type="hidden" name="id[]" value="<?php echo $d->id ?>">
                            
                            <td><?php echo $no ?></td>
                            <td colspan="7">
                                No OPB : <?php echo $d->detail_bbm->bbm->pemesanan->nomor ?>
                                    Supplier : <?= $d->detail_bbm->bbm->pemesanan->pemasok->nama ?> 
                                </td>
                           
                          
                            <td></td>
                          
                            <td>
                               
                            </td>
                            <td>
                                
                            </td>
                            
                            <td></td>
                            
                        </tr>
                        <?php $po = $d->detail_bbm->bbm->pemesanan->nomor; ?>
                                        <?php endif; ?>
                        <?php 
                            

                                
                                    $jumlah_row = $d->jumlah*$d->harga;
                                    ?>
                                        <?php $db = DetailPemesananBarang::where('gabungan','like','%'.$d->gabungan_id.'%')->get();?>
                                        <tr>
                                            
                                            <td></td>
                                       

                                            <input type="hidden" name="detail_bukti_barang_keluar_id[<?php echo $no_b; ?>]" value="<?php echo $d->id ?>">
                                            <input type="hidden" name="detail_id[<?php echo $no_b; ?>]" value="<?php echo $d->id ?>">
                                            <input type="hidden" name="barang_id[<?php echo $no_b; ?>]" value="<?php echo $d->barang_id ?>">
                                            <td>
                                                <?php if(count(Camp::where('barang_id',$d->barang_id)->where('detail_bukti_barang_keluar_id',$d->id)->get()) > 0){ 
                                                    if($d->jumlah_di_camp < $d->jumlah){
                                                        echo '<input type="checkbox"  name="pilih[]" id="pilih-'.$no_b.'" value="'.$no_b.'">';
                                                        echo $d->jumlah_di_camp." sudah dicamp";
                                                    } else if($d->jumlah_di_camp == $d->jumlah) {
                                                        echo "barang sudah di camp";
                                                    }
                                                    


                                                } else { ?>
                                                
                                                <?php
                                                    if($d->jumlah_di_camp < $d->jumlah){
                                                        ?>
                                                        <input type="checkbox"  name="pilih[]" id="pilih-<?php echo $d->barang_id ?>" value="<?php echo $no_b; ?>">
                                                        <?php
                                                        echo $d->jumlah_di_camp." sudah dicamp";
                                                    } else if($d->jumlah_di_camp >= $d->jumlah) {
                                                        echo "barang sudah di camp";
                                                    }
                                                ?>

                                                
                                                
                                                
                                                <?php } ?>
                                               
                                            </td>
                                            
                                         
                                            <td><?php if($d->detail_bbm->detail_pemesanan->kode_barang != null){ echo $d->detail_bbm->detail_pemesanan->kode_barang; }else { echo $d->barang->kode; }?>
                                                <?php foreach($db as $dd): ?>
                                                 / <?php echo $dd->barang->kode ?>
                                                <?php endforeach; ?>
                                            </td>
                                            <td><?php if($d->detail_bbm->detail_pemesanan->nama_barang != null){ echo $d->detail_bbm->detail_pemesanan->nama_barang; }else { echo $d->barang->nama; }?>
                                                <?php foreach($db as $dd): ?>
                                                 / <?php echo $dd->barang->nama ?>
                                                <?php endforeach; ?>
                                            </td>
                                            <input type="hidden" name="nama_barang[<?php echo $no_b; ?>]" value="<?php echo $d->nama_barang ?>">
                                            
                                            <td><?php echo $d->barang->unit->kode ?></td>
                                           
                                            <td><?php echo $d->barang->halaman ?></td>
                                            <td><?php echo $d->barang->indeks ?></td>
                                            <?php if(count(Camp::where('barang_id',$d->barang_id)->where('detail_bukti_barang_keluar_id',$d->id)->get()) > 0){
                                                    $ket = Camp::where('barang_id',$d->barang_id)->where('detail_bukti_barang_keluar_id',$d->id)->first()->keterangan;
                                                } else {
                                                    $ket = $d->keterangan;
                                                } ?>
                                            <td><textarea name="keterangan[<?php echo $no_b; ?>]"><?=$ket;?></textarea></td>
                                            <td>
                                                <?php echo $d->jumlah; ?>
                                            </td>
                                            <td>
                                                <?php $jumlah = ($d->jumlah_di_camp == 0)?$d->jumlah:$d->jumlah-$d->jumlah_di_camp; ?>
                                                <input class="form-control" onchange="list_sn('<?php echo $d->barang->nama ?>','<?php echo $d->id ?>',this.value)" type="number" name="jumlah[<?php echo $no_b; ?>]" value="<?php echo max($jumlah,0) ?>" >
                                            </td>
                                            <?php $sat = Satuan::all(); ?>
                                            <td><?php echo $d->detail_bbm->detail_pemesanan->detail_permintaan->satuan->nama ?><select class="form-control" name="kategori" id="kategori"><?php foreach($sat as $s){ ?><option value="<?php echo $s->id?>" <?php if($d->detail_bbm->detail_pemesanan->detail_permintaan->satuan->id == $s->id){echo "selected";}?>><?php echo $s->nama;?></option><?php } ?></select></td>
                                            <td>
                                                Rp.<?php echo number_format($d->harga) ?>
                                            </td>
                                            
                                        </tr>
                                        <?php $no_b++; ?>
                    
                                    <?php

                                
                                
                           
                                        
                            
                           $no++ ?>

                        
                    <?php endforeach; ?>
                </tbody>
                
            </table>
            <div id="list_modal_sn">
            <?php foreach ($detail as $d): ?>
                       
                <?php 
                   
                        
                            
                            ?>
                            
                                <div id="myModal<?=$d->id?>" class="modal fade" role="dialog">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">Tambah Serial Number</h4>
                                            </div>
                                            <div class="modal-body" style="padding:0;">
                                                
                                                    
                                                    <table class="table table-bordered table-responsive" style="padding:0">
                                                        <thead>
                                                            <tr>
                                                                <th>Nomor</th>
                                                                <th>Serial Number Barang</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="isi_modal_<?=$d->id?>">
                                                            <?php $x = 1; ?>
                                                            <?php foreach ($d->serial as $zz) {
                                                               ?>
                                                                <tr class="inputan_sn<?=$d->id?>">
                                                                    <td valign="midlle"><?php echo $x ?></td>
                                                                    
                                                                    <td><input value="<?php echo $zz->sn ?>" type="text" name="sn_<?php echo $d->id ?>[]"  class=" form-control input-submit-query" placeholder="Serial number <?php echo $d->barang->nama ?>"></td>
                                                                    <?php $x++ ?>
                                                                </tr>

                                                               <?php
                                                            } ?>
                                                            
                                                        </tbody>
                                                    </table>
                                                
                                            </div>
                                            <div class="modal-footer">
                            
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            
                        <?php

                        

                  ?>
      
            <?php endforeach; ?>
            </div>
                
            
          
        <?php
    }

    public function scan_barang(Request $request){
        $d = SerialGudang::where('sn',$request->sn)->first();
        if($d){
            ?>  
                
                <tr id="list-barang-<?php echo $d->gudang->barang->id ?>">
                    <input type="hidden" name="detail_bukti_barang_masuk_id[]" value="<?php echo $d->gudang->detail_bbm->id ?>">
                    <input type="hidden" name="barang_id[]" value="<?php echo $d->gudang->barang->id ?>">
                    <input type="hidden" name="jumlah[]" value="<?php echo $d->gudang->stok ?>">
                    <input type="hidden" name="harga[]" value="<?php echo $d->gudang->detail_bbm->detail_pemesanan->harga ?>">

                    <td><?php echo $d->gudang->detail_bbm->detail_pemesanan->kode_barang; ?></td>
                    <td><?php echo $d->gudang->detail_bbm->detail_pemesanan->nama_barang; ?></td>
                    <td><?php echo $d->gudang->barang->unit->kode; ?></td>
                    <td><?php echo $d->gudang->detail_bbm->detail_pemesanan->keterangan; ?></td>
                    <td><?php echo $d->gudang->stok ?></td>
                    <td><?php echo $d->gudang->detail_bbm->detail_pemesanan->harga; ?></td>
                    <td><button type="button" class="hapus_list_barang" id_target="list-barang-<?php echo $d->gudang->barang->id ?>">X</button></td>
                </tr>

            <?php
        } else {
            ?>
                <script type="text/javascript">
                    alert('Barang Tidak Ada');
                </script>
            <?php
        }
            

    }

    public function scan()
    {   
        $user = User::all();
        $pemesanan = PemesananBarang::all();
        $bbm = BuktiBarangMasuk::all();
        return view('bbk.scan',compact('pemesanan','user','bbm'));
    }


    public function store_scan(Request $request)
    {   
        if(Auth::user()->cek_akses('Bukti Barang Keluar','Add',Auth::user()->id) != 1){
            return view('error.denied');
        }
        $cek = BuktiBarangKeluar::where('nomor',$request->nomor)->count();
        if($cek > 0){
            
            Session::flash(
                "flash_notif",[
                    "level"   => "dismissible alert-danger",
                    "massage" => "Data Dengan Nomor <strong>$request->nomor</strong> Sudah Digunakan"
            ]);    
            return back();
        }
        //dd($request->gudang_id);
        $input = $request->all();

        unset($input['_token']);
        unset($input['detail_bukti_barang_masuk_id']);
        $id = BuktiBarangKeluar::create([
                'nomor'=>$request->nomor,
                'tanggal'=>$request->tanggal,
                'dikirim'=>$request->dikirim,
                'kepada'=>$request->kepada,
              
                'mengetahui'=>$request->mengetahui,
                'pengantar'=>$request->pengantar,
                'penerima'=>$request->penerima,
                'pengirim'=>$request->pengirim,
                'keterangan'=>$request->keterangan,

            ])->id;
        for ($i=0; $i < count($request->barang_id); $i++) { 
            
            $detail = DetailBuktiBarangMasuk::where('id',$request->detail_bukti_barang_masuk_id[$i])->where('barang_id',$request->barang_id[$i])->first();
           
                $id_detail = DetailBuktiBarangKeluar::create([
                        'bukti_barang_keluar_id'=>$id,
                        'detail_bukti_barang_masuk_id'=>$request->detail_bukti_barang_masuk_id[$i],
                        'barang_id'=>$request->barang_id[$i],
                        'nama_barang'=>$request->nama_barang[$i],
                        'jumlah'=>$request->jumlah[$i],
                        'harga'=>$request->harga[$i],
                        'gabungan_id'=>$detail->gabungan_id,
                        'gabungan'=>$detail->gabungan
                        
                ])->id;
                $serial = SerialDetailBuktiBarangMasuk::where('detail_bukti_barang_masuk_id',$detail->id)->get();
                foreach ($serial as $item) {
                    SerialDetailBuktiBarangKeluar::create([
                        'detail_bukti_barang_keluar_id'=>$id_detail,
                        'sn'=>$item->sn
                    ]);
                }
                $g = Gudang::where('barang_id',$request->barang_id[$i])->where('detail_bukti_barang_masuk_id',$request->detail_bukti_barang_masuk_id[$i]);
                $g->delete();
            
                

        }
        $user = User::all();
        $bbk = BuktiBarangKeluar::findOrFail($id);
        \App\AktivitasUser::create(['user_id'=>Auth::user()->id,'aktivitas'=>'Menambah data bbk dengan nomor '.$bbk->nomor]);
        /*foreach ($user as $value) {
            if($value->email != null){
                try {
                    Mail::send('email.bbk', ['r' => $bbk], function ($m) use ($value) {
                        $m->from('postmaster@inventoryudit.green-nusa.net', 'Inventory Udit');

                        $m->to($value->email, $value->nama)->subject('Pemberitahuan');
                    });
                } catch (Exception $e) {
                    
                }
            }
        }*/
        
        // for ($i=0; $i < count($request->detail_bukti_barang_masuk_id); $i++) { 
            
        //     $bbm = DetailBuktiBarangMasuk::where('detail_bukti_barang_masuk_id',$request->detail_bukti_barang_masuk_id[$i])->get();
        //     foreach ($bbm as $ddd) {
        //         $id_detail = DetailBuktiBarangKeluar::create([
        //                 'bukti_barang_keluar_id'=>$id,
        //                 'detail_bukti_barang_masuk_id'=>$request->detail_bukti_barang_masuk_id[$i],
        //                 'barang_id'=>$ddd->barang_id,
        //                 'gabungan_id'=>$ddd->gabungan_id,
        //                 'jumlah'=>$ddd->jumlah,
        //                 'harga'=>$ddd->harga,
        //                 'gabungan'=>$ddd->gabungan
                        
        //         ])->id;
        //         $serial = SerialDetailBuktiBarangMasuk::where('detail_bukti_barang_masuk_id',$ddd->id)->get();
        //         foreach ($serial as $item) {
        //             SerialDetailBuktiBarangKeluar::create([
        //                 'detail_bukti_barang_keluar_id'=>$id_detail,
        //                 'sn'=>$item->sn
        //             ]);
        //         }
        //     }     
           
        // }
        Session::flash(
            "flash_notif",[
                "level"   => "dismissible alert-success",
                "massage" => "Data <strong>$request->nomor</strong> Berhasil Di Tambahkan"
        ]);
        return redirect('item_out');
    }

    public function new_item(Request $request,$id)
    {
        for ($i=0; $i < count($request->pilih); $i++) { 
            
            $detail = DetailBuktiBarangMasuk::where('id',$request->detail_bukti_barang_masuk_id[$request->pilih[$i]])->where('barang_id',$request->barang_id[$request->pilih[$i]])->first();
           
                $id_detail = DetailBuktiBarangKeluar::create([
                        'bukti_barang_keluar_id'=>$id,
                        'detail_bukti_barang_masuk_id'=>$request->detail_bukti_barang_masuk_id[$request->pilih[$i]],
                        'barang_id'=>$request->barang_id[$request->pilih[$i]],
                        'nama_barang'=>$request->nama_barang[$request->pilih[$i]],
                        'jumlah'=>$request->jumlah[$request->pilih[$i]],
                        'harga'=>$request->harga[$request->pilih[$i]],
                        'gabungan_id'=>$detail->gabungan_id,
                        'gabungan'=>$detail->gabungan
                        
                ])->id;
                $serial = SerialDetailBuktiBarangMasuk::where('detail_bukti_barang_masuk_id',$detail->id)->get();
                foreach ($serial as $item) {
                    SerialDetailBuktiBarangKeluar::create([
                        'detail_bukti_barang_keluar_id'=>$id_detail,
                        'sn'=>$item->sn
                    ]);
                }
                $g = Gudang::where('barang_id',$request->barang_id[$request->pilih[$i]])->where('detail_bukti_barang_masuk_id',$request->detail_bukti_barang_masuk_id[$request->pilih[$i]]);
                $g->delete();
            
        }

        $bbk = BuktiBarangKeluar::findOrFail($id);
        \App\AktivitasUser::create(['user_id'=>Auth::user()->id,'aktivitas'=>'Menambah data bbk dengan nomor '.$bbk->nomor]);

        $page = 1;
        if(isset($_GET['page'])){
            $page = $_GET['page'];
        }
        return redirect('item_out/'.$id.'/edit?page='.$page);
    }

    public function send(Request $request,$id)
    {
        BuktiBarangKeluar::find($id)->update(['status'=>0]);
        $page = 1;
        if(isset($_GET['page'])){
            $page = $_GET['page'];
        }
        return redirect('item_out/'.$id.'/edit?page='.$page);
    }

    public function cancel(Request $request,$id)
    {
        BuktiBarangKeluar::find($id)->update(['status'=>2]);
        $page = 1;
        if(isset($_GET['page'])){
            $page = $_GET['page'];
        }
        return redirect('item_out/'.$id.'/edit?page='.$page);
    }

    public function insert_scan(Request $request)
    {   
        if(Auth::user()->cek_akses('Bukti Barang Keluar','Add',Auth::user()->id) != 1){
            
        }
        $ff = SerialDetailBuktiBarangKeluar::where('sn',$request->sn)->count();
        if($ff > 0){
            echo '<span style="color: red;">Barang Sudah Ada</span>';
            
        }
        $sg = SerialGudang::where('sn',$request->sn)->first();
       
        if($request->nomor){
            $id = 0;
            $cek = BuktiBarangKeluar::where('nomor',$request->nomor)->first();
            if($cek == null){
                
                if($sg){
                    if($ff == 0 ){
                        $id = BuktiBarangKeluar::create([
                            'nomor'=>$request->nomor,
                            'tanggal'=>$request->tanggal,
                            'dikirim'=>$request->dikirim,
                            'kepada'=>$request->kepada,
                          
                            'mengetahui'=>$request->mengetahui,
                            'pengantar'=>$request->pengantar,
                            'penerima'=>$request->penerima,
                            'pengirim'=>$request->pengirim,
                            'keterangan'=>$request->keterangan,

                        ])->id;

                        $id_detail = DetailBuktiBarangKeluar::create([
                                'bukti_barang_keluar_id'=>$id,
                                'detail_bukti_barang_masuk_id'=>$sg->gudang->detail_bbm->id,
                                'barang_id'=>$sg->gudang->barang->id,
                                'nama_barang'=>$sg->gudang->detail_bbm->detail_pemesanan->nama,
                                'jumlah'=>1,
                                'harga'=>$sg->gudang->detail_bbm->detail_pemesanan->harga,
                                
                        ])->id;

                        SerialDetailBuktiBarangKeluar::create([
                            'detail_bukti_barang_keluar_id'=>$id_detail,
                            'sn'=>$sg->sn
                        ]);
                    }
                        

                }
                else {
                     echo '<span style="color: red;">Barang Tidak Ditemukan</span>';
                     
                }

            } else {
                 echo '<span style="color: red;">Nomor NPB Sudah Digunakan</span>';
                 
            }
            $bbk = BuktiBarangKeluar::findOrFail($id);
            ?>  
            
            
                <table style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Barang</th>
                                        <th>Nama Barang</th>
                                        
                                        <th>Kode Unit</th>
                                        
                                        <th>Keterangan</th>
                                        <th>Jumlah</th>
                                        
                                        <th>Harga</th>
                                       
                                    </tr>
                                </thead>
                                <tbody>
                                    <input type="hidden" name="bbk_id" value="<?php echo $id ?>">
                                    <?php $index = 0; ?>
                                    <?php foreach ($bbk->detail as $d): ?>
                                        
                                        <tr>
                                            <td><?php $index++ ?></td>
                                            <td><?php echo $d->detail_bbm->detail_pemesanan->kode_barang; ?></td>
                                            <td><?php echo $d->detail_bbm->detail_pemesanan->nama_barang; ?></td>
                                            <td><?php echo $d->barang->unit->kode; ?></td>
                                            <td><?php echo $d->detail_bbm->detail_pemesanan->keterangan; ?></td>
                                            <td><?php echo $d->jumlah; ?></td>
                                            <td><?php echo $d->detail_bbm->detail_pemesanan->harga; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                               
                            </table>
            <?php
        } else {

            if($sg){
                   
                    $cc = DetailBuktiBarangKeluar::where('bukti_barang_keluar_id',$request->bbk_id)->where('barang_id',$sg->gudang->barang_id);
                    


                    if($cc->count() == 0){
                        if($ff == 0){
                            $id_detail = DetailBuktiBarangKeluar::create([
                                    'bukti_barang_keluar_id'=>$request->bbk_id,
                                    'detail_bukti_barang_masuk_id'=>$sg->gudang->detail_bbm->id,
                                    'barang_id'=>$sg->gudang->barang->id,
                                    'nama_barang'=>$sg->gudang->detail_bbm->detail_pemesanan->nama_barang,
                                    'jumlah'=>1,
                                    'harga'=>$sg->gudang->detail_bbm->detail_pemesanan->harga,
                                    
                            ])->id;


                            SerialDetailBuktiBarangKeluar::create([
                                'detail_bukti_barang_keluar_id'=>$id_detail,
                                'sn'=>$sg->sn
                            ]);
                        }
                            
                        
                    }
                    else {
                        if($ff == 0){
                            $cc->update([
                                'jumlah'=>$cc->first()->jumlah+1,
                            ]);

                            SerialDetailBuktiBarangKeluar::create([
                                'detail_bukti_barang_keluar_id'=>$cc->first()->id,
                                'sn'=>$sg->sn
                            ]);
                        }
                            
                    }

                    $bbk = BuktiBarangKeluar::findOrFail($request->bbk_id);
            ?>  
    
                <table style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Barang</th>
                                        <th>Nama Barang</th>
                                        
                                        <th>Kode Unit</th>
                                        
                                        <th>Keterangan</th>
                                        <th>Jumlah</th>
                                        
                                        <th>Harga</th>
                                       
                                    </tr>
                                </thead>
                                <tbody>
                                    <input type="hidden" name="bbk_id" value="<?php echo $request->bbk_id ?>">
                                    <?php $index = 0; ?>
                                    <?php foreach ($bbk->detail as $d): ?>
                                        
                                        <tr>
                                            <td><?php $index++ ?></td>
                                            <td><?php echo $d->detail_bbm->detail_pemesanan->kode_barang; ?></td>
                                            <td><?php echo $d->detail_bbm->detail_pemesanan->nama_barang; ?></td>
                                            <td><?php echo $d->barang->unit->kode; ?></td>
                                            <td><?php echo $d->detail_bbm->detail_pemesanan->keterangan; ?></td>
                                            <td><?php echo $d->jumlah; ?></td>
                                            <td><?php echo $d->detail_bbm->detail_pemesanan->harga; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                               
                            </table>
            <?php


                }
                else {
                    echo '<span style="color: red;">Barang Tidak Ditemukan</span>';
                    
                }
                    
        }
    }
            
}
