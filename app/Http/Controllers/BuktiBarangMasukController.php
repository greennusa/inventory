<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BuktiBarangMasuk;
use App\DetailBuktiBarangMasuk;
use App\PemesananBarang;
use App\SerialDetailBuktiBarangMasuk;
use App\DetailPemesananBarang;
use App\Gudang;
use App\SerialGudang;
use Auth;
use Session;
class BuktiBarangMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        // if(Auth::user()->cek_akses('Bukti Barang Masuk','View',Auth::user()->id) != 1){
        //     return view('error.denied');
        // }
        // if(isset($request->q)){
        //     $q = $request->q;
        // }
        // else {
        //     $q = '';
        // }
        // $tables = BuktiBarangMasuk::WhereHas('detail',function ($query) use ($q){
        //     $qq = $q;
        //     $query->WhereHas('barang',function ($qr) use ($qq){
        //         $qr->where('kode', 'like', '%'.$qq.'%')->orWhere('nama', 'like', '%'.$qq.'%');
        //     });
        // })->orWhere('nomor','like',"%$q%")->orderBy('created_at','DESC')->paginate(10);

        if(Auth::user()->cek_akses('Pemesanan Barang','View',Auth::user()->id) != 1){
            return view('error.denied');
        }
        if(isset($request->q)){
            $q = $request->q;
        }
        else {
            $q = '';
        }
        $tables = PemesananBarang::WhereHas('detail',function ($query) use ($q){
            $qq = $q;
            $query->WhereHas('barang',function ($qr) use ($qq){
                $qr->where('kode', 'like', '%'.$qq.'%')->orWhere('nama', 'like', '%'.$qq.'%');
            });
        })->orWhere('nomor','like',"%$q%")->orderBy('created_at','DESC')->paginate(20);
        return view('bbm.index',compact('tables'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        if(Auth::user()->cek_akses('Bukti Barang Masuk','Add',Auth::user()->id) != 1){
            return view('error.denied');
        }
        $pemesanan = PemesananBarang::all();
        return view('bbm.create',compact('pemesanan'));
    }

    public function bbm_baru($id)
    {   
        if(Auth::user()->cek_akses('Bukti Barang Masuk','Add',Auth::user()->id) != 1){
            return view('error.denied');
        }
        $pemesanan = PemesananBarang::find($id);
        return view('bbm.bbm_baru',compact('pemesanan'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        if(Auth::user()->cek_akses('Bukti Barang Masuk','Add',Auth::user()->id) != 1){
            return view('error.denied');
        }
        $cek = BuktiBarangMasuk::where('nomor',$request->nomor)->count();
        if($cek > 0){
            
            Session::flash(
                "flash_notif",[
                    "level"   => "dismissible alert-danger",
                    "massage" => "Data Dengan Nomor <strong>$request->nomor</strong> Sudah Digunakan"
            ]);    
            return back();
        }
        $this->validate($request,[
            'barang_id'=>'required',
            
        ]);
        $this->validate($request,[
            'nomor'=>'required|unique:bukti_barang_masuks|min:2',
            'tanggal'=>'required',
            'pemesanan_barang_id'=>'required',
          
            
        ]);
        $id = BuktiBarangMasuk::create([
            'nomor'=>$request->nomor,
            'tanggal'=>$request->tanggal,
            'pemesanan_barang_id'=>$request->pemesanan_barang_id,
            'keterangan'=>$request->keterangan,
            'user_id'=>Auth::user()->id
        ])->id;

        for ($i=0; $i < count($request->barang_id); $i++) { 
            $xd = DetailPemesananBarang::findOrFail($request->detail_id[$i]);
            
            $id_detail = DetailBuktiBarangMasuk::create([
                    'bukti_barang_masuk_id'=>$id,
                    'detail_pemesanan_barang_id'=>$request->detail_id[$i],
                    'barang_id'=>$request->barang_id[$i],
                    'nama_barang'=>$request->nama_barang[$i],
                    'jumlah'=>$request->jumlah[$i],
                    'harga'=>$request->harga[$i],
                    'kelengkapan'=>$request->kelengkapan[$i],
                    'keterangan'=>$request->detail_keterangan[$i],
                    'gabungan_id'=>$xd->detail_gabungan,
                    'gabungan'=>$xd->gabungan
            ])->id;

            if($request->kelengkapan[$i] == 1){
                DetailPemesananBarang::where('id',$request->detail_id[$i])->update(['masuk'=>1]);
            }

            $s = data_get($request,"sn_".$request->barang_id[$i]);
            
            for ($x=0; $x < count($s) ; $x++) { 
                SerialDetailBuktiBarangMasuk::create([
                    'detail_bukti_barang_masuk_id'=>$id_detail,
                    'sn'=>$s[$x]

                ]);
            }
        }
        \App\AktivitasUser::create(['user_id'=>Auth::user()->id,'aktivitas'=>'Menambah data bbm dengan nomor '.$request->nomor]);
        Session::flash(
            "flash_notif",[
                "level"   => "dismissible alert-success",
                "massage" => "Data <strong>$request->nomor</strong> Berhasil Di Tambahkan"
        ]);
        return redirect('item_in');
    }

    public function numberRoman($number) {
        $map = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);
        $returnValue = '';
        while ($number > 0) {
            foreach ($map as $roman => $int) {
                if($number >= $int) {
                    $number -= $int;
                    $returnValue .= $roman;
                    break;
                }
            }
        }
        return $returnValue;
    }

    public function buat_bbm(Request $request,$id)
    {   
        if(Auth::user()->cek_akses('Bukti Barang Masuk','Add',Auth::user()->id) != 1){
            return view('error.denied');
        }
        $pb = PemesananBarang::find($id);
        $bl = BuktiBarangMasuk::orderBy('created_at','DESC')->first();
        $pieces = '001/UDIT/'.$this->numberRoman(date('m')).'/'.date('Y');
        $newNo = $pieces; 
        if($bl){
            $pieces = explode("/", $bl->nomor);
            $no = (isset($pieces[0]))?++$pieces[0]:++$bl->nomor;
            if($no == ''){
                $no = '001';
            }
            $no = str_pad($no + 1, 3, 0, STR_PAD_LEFT);
            
            $newNo = $no.'/UDIT/'.$this->numberRoman(date('m')).'/'.date('Y');
        }
        
        
        
        
        $id = BuktiBarangMasuk::create([
            'nomor'=>$newNo,
            'tanggal'=>$request->tanggal,
            'pemesanan_barang_id'=>$pb->id,
            'keterangan'=>$request->keterangan,
            'user_id'=>Auth::user()->id
        ])->id;

        for ($i=0; $i < count($request->barang_id); $i++) { 
            $xd = DetailPemesananBarang::findOrFail($request->detail_id[$i]);
            
            $id_detail = DetailBuktiBarangMasuk::create([
                    'bukti_barang_masuk_id'=>$id,
                    'detail_pemesanan_barang_id'=>$request->detail_id[$i],
                    'barang_id'=>$request->barang_id[$i],
                    'nama_barang'=>$request->nama_barang[$i],
                    'jumlah'=>$request->jumlah[$i],
                    'harga'=>$request->harga[$i],
                    'kelengkapan'=>$request->kelengkapan[$i],
                    'keterangan'=>$request->detail_keterangan[$i],
                    'gabungan_id'=>$xd->detail_gabungan,
                    'gabungan'=>$xd->gabungan
            ])->id;

            if($request->kelengkapan[$i] == 1){
                DetailPemesananBarang::where('id',$request->detail_id[$i])->update(['masuk'=>1]);
            }

            $s = data_get($request,"sn_".$request->barang_id[$i]);
            
            if($s != null && (is_array($s) || is_object($s))){
                for ($x=0; $x < count($s) ; $x++) { 
                    SerialDetailBuktiBarangMasuk::create([
                        'detail_bukti_barang_masuk_id'=>$id_detail,
                        'sn'=>$s[$x]

                    ]);
                }
            }
                
        }

        
        \App\AktivitasUser::create(['user_id'=>Auth::user()->id,'aktivitas'=>'Menambah data bbm dengan nomor '.$request->nomor]);
        Session::flash(
            "flash_notif",[
                "level"   => "dismissible alert-success",
                "massage" => "Data <strong>$request->nomor</strong> Berhasil Di Tambahkan"
        ]);
        return redirect('item_in');
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
        if(Auth::user()->cek_akses('Bukti Barang Masuk','Edit',Auth::user()->id) != 1){
            return view('error.denied');
        }
        $r = BuktiBarangMasuk::findOrFail($id);

        return view('bbm.edit',compact('r'));
        

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
        if(Auth::user()->cek_akses('Bukti Barang Masuk','Edit',Auth::user()->id) != 1){
            return view('error.denied');
        }
        $this->validate($request,[
            'nomor'=>'required|min:2',
            'tanggal'=>'required',
           
          
            
        ]);
        $data = BuktiBarangMasuk::findOrFail($id);
        if($data->nomor != $request->nomor){
            $this->validate($request,[
                'nomor'=>'required|unique:bukti_barang_masuks|min:2',
                'tanggal'=>'required',
               
              
                
            ]);
        }
        $data->update([
            'nomor'=>$request->nomor,
            'tanggal'=>$request->tanggal,
            
            'keterangan'=>$request->keterangan,
            
        ]);

        // for ($i=0; $i < count($request->id); $i++) { 

        //     $cek = DetailBuktiBarangMasuk::findOrFail($request->id[$i])->update([
                  
                    
        //             'jumlah'=>$request->jumlah[$i],
            
        //             'kelengkapan'=>$request->kelengkapan[$i],
        //             'keterangan'=>$request->detail_keterangan[$i]
        //     ]);

           
          
        //     for ($x=0; $x < count($request->serial_id) ; $x++) { 
        //         $s = data_get($request,"sn_".$request->serial_id[$x]);
        //         SerialDetailBuktiBarangMasuk::findOrFail($request->serial_id[$x])->update([
                    
        //             'sn'=>$s[0]

        //         ]);
        //     }
        
        // }
        \App\AktivitasUser::create(['user_id'=>Auth::user()->id,'aktivitas'=>'Edit data bbm dengan nomor '.$request->nomor]);
        Session::flash(
            "flash_notif",[
                "level"   => "dismissible alert-success",
                "massage" => "Data <strong>$request->nomor</strong> Berhasil Di Update"
        ]);
        return redirect('item_in?page='.$request->page);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        if(Auth::user()->cek_akses('Bukti Barang Masuk','Delete',Auth::user()->id) != 1){
            return view('error.denied');
        }
        $data = BuktiBarangMasuk::findOrFail($id);

        try {
            DetailPemesananBarang::where('pemesanan_barang_id',$data->pemesanan_barang_id)->update(['masuk'=>0]);
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
        \App\AktivitasUser::create(['user_id'=>Auth::user()->id,'aktivitas'=>'Mengahpus data bbm dengan nomor '.$data->nomor]);
        
        Session::flash(
            "flash_notif",[
                "level"   => "dismissible alert-success",
                "massage" => "Data <strong>$data->nomor</strong> Berhasil Di Hapus"
        ]);
        return back();
    }

    public function get_detail_bbm($id){
        $detail = DetailBuktiBarangMasuk::where('bukti_barang_masuk_id',$id)->get();
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
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Pilih Barang</th>
                        <th>#</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                       
                        <th>Kode Unit</th>
                        <th>Halaman</th>
                        <th>Indeks</th>
                        
                        <th>Jumlah </th>
                        <th>Harga</th>
                
                        <th>Status</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1;$index = 0; ?>
                    <?php foreach ($detail as $d): 
                        
                        ?>
                        <?php $db = DetailPemesananBarang::where('gabungan','like','%'.$d->gabungan_id.'%')->where('pemesanan_barang_id',$d->bbm->pemesanan->id)->get();?>
                        <tr>
                            <input type="hidden" name="detail_id[<?php echo $index; ?>]" value="<?php echo $d->id ?>">
                            <input type="hidden" name="barang_id[<?php echo $index; ?>]" value="<?php echo $d->barang_id ?>">
                            <td><?php if(count(Gudang::where('barang_id',$d->barang_id)->where('detail_bukti_barang_masuk_id',$d->id)->get()) > 0){ echo "barang sudah di gudang";} else { ?><input type="checkbox"  name="pilih[]" id="pilih-<?php echo $d->barang_id ?>" value="<?php echo $index; ?>"> <?php } ?>
                        </td>
                            <td><?php echo $no ?></td>

                            <td><?php echo $d->detail_pemesanan->kode_barang ?>
                                <?php foreach($db as $dd): ?>
                                 / <?php echo $dd->kode_barang ?>
                                <?php endforeach ?>
                            </td>
                            <td><?php echo $d->detail_pemesanan->nama_barang ?>
                                <?php foreach($db as $dd): ?>
                                 / <?php echo $dd->nama_barang ?>
                                <?php endforeach ?>
                            </td>
                            <input readonly class="form-control" type="hidden" name="nama_barang[]" value="<?php echo $d->nama_barang ?>">
                            
                            <td><?php echo $d->barang->unit->kode ?></td>
                            <td><?php echo $d->barang->halaman ?></td>
                            <td><?php echo $d->barang->indeks ?></td>
                           
                            <td>
                                <?php echo $d->jumlah ?> <?php echo $d->detail_pemesanan->detail_permintaan->satuan->nama ?>
                                <input readonly class="form-control" type="hidden" name="jumlah[<?php echo $index; ?>]" value="<?php echo $d->jumlah ?>">
                            </td>
                            <td>
                                Rp.<?php echo number_format($d->harga) ?>
                                <input readonly class="form-control" type="hidden" name="harga[<?php echo $index; ?>]" value="<?php echo $d->harga ?>"></td>
                            
                            <td>
                                <?php if($d->kelengkapan == 1): echo "Lengkap"; else: echo "Tidak Lengkap"; endif; ?>
                               
                                
                            </td>
                            <td>
                                <?php echo $d->keterangan ?>
                                <input readonly type="hidden" name="detail_keterangan[<?php echo $index; ?>]" class="form-control" value="<?php echo $d->keterangan ?>"></td>
                        </tr>
                        <?php $no++;$index++; ?>
                    <?php endforeach ?>
                </tbody>
            </table>
          
        <?php
    }

    public function get_bbm(Request $request){
        $index = 0;
        ?>
            <!-- <table>
                <tr>
                        <td colspan="11">
                            <input type="checkbox" id="pilih-semua">
                            <label for="pilih-semua">Pilih Semua</label>
                        </td>
                    </tr>
            </table> -->
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
        <?php
        for ($i=0; $i < count($request->bukti_barang_masuk_id); $i++) { 
            $bbmnya = BuktiBarangMasuk::findOrFail($request->bukti_barang_masuk_id[$i]);
            $detail = DetailBuktiBarangMasuk::where('bukti_barang_masuk_id',$request->bukti_barang_masuk_id[$i])->get();


            ?>
            
        
            <table class="table table-bordered table-hover">
                <thead>

                    <tr>
                        <td colspan="12">Nomor BBM : <?php echo $bbmnya->nomor; ?> / Nomor Pemesanan : <?php echo $bbmnya->pemesanan->nomor; ?></td>
                    </tr>
                    <tr>
                        <th>Pilih Barang</th>
                        <th>#</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                       
                        <th>Kode Unit</th>
                        <th>Halaman</th>
                        <th>Indeks</th>
                        
                        <th>Jumlah </th>
                        <th>Harga</th>
                
                        <th>Status</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <?php $no=1; ?>
                    <?php foreach ($detail as $d): 
                        
                        if(count(Gudang::where('barang_id',$d->barang_id)->where('detail_bukti_barang_masuk_id',$d->id)->get()) > 0){
                            $detail_gudang = Gudang::where('barang_id',$d->barang_id)->where('detail_bukti_barang_masuk_id',$d->id)->first();
                        ?>
                        <?php $db = DetailPemesananBarang::where('gabungan','like','%'.$d->gabungan_id.'%')->where('pemesanan_barang_id',$d->bbm->pemesanan->id)->get();?>
                        <?php if($detail_gudang->stok > 0){ ?>
                        <tr>
                            <input type="hidden" value="<?php echo $d->id ?>" name="detail_bukti_barang_masuk_id[<?php echo $index; ?>]">
                            <input type="hidden" name="barang_id[<?php echo $index; ?>]" value="<?php echo $d->barang_id ?>">
                            <td><input type="checkbox" name="pilih[]" id="pilih-<?php echo $d->barang_id ?>" value="<?php echo $index; ?>"></td>
                            <td><?php echo $no ?></td>
                            <td><?php echo $d->barang->kode ?>
                                <?php foreach($db as $dd): ?>
                                 / <?php echo $dd->barang->kode ?>
                                <?php endforeach ?>
                            </td>
                            <td><?php echo $d->barang->nama ?>
                                <?php foreach($db as $dd): ?>
                                 / <?php echo $dd->barang->nama ?>
                                <?php endforeach ?>
                            </td>
                            <input readonly class="form-control" type="hidden" name="nama_barang[<?php echo $index; ?>]" value="<?php echo $d->nama_barang ?>">
                            
                            <td><?php echo $d->barang->unit->kode ?></td>
                            <td><?php echo $d->barang->halaman ?></td>
                            <td><?php echo $d->barang->indeks ?></td>
                           
                            <td>
                                <input class="form-control" type="number" min="0" max="<?php echo $detail_gudang->stok ?>" name="jumlah[<?php echo $index; ?>]" value="<?php echo $detail_gudang->stok ?>"> <?php echo $d->detail_pemesanan->detail_permintaan->satuan->nama ?>
                                
                            </td>
                            <td>
                                Rp.<?php echo number_format($d->harga) ?>
                                <input readonly class="form-control" type="hidden" name="harga[<?php echo $index; ?>]" value="<?php echo $d->harga ?>"></td>
                            
                            <td>
                                <?php if($d->kelengkapan == 1): echo "Lengkap"; else: echo "Tidak Lengkap"; endif; ?>
                               
                                
                            </td>
                            <td>
                                <?php echo $d->keterangan ?>
                                <input readonly type="hidden" name="detail_keterangan[<?php echo $index; ?>]" class="form-control" value="<?php echo $d->keterangan ?>"></td>
                        </tr>
                        <?php $no++;$index++; } }?>
                        
                    <?php endforeach ?>
                </tbody>
            </table>
          
        <?php
           
           
        }
        
    }

    public function barcode($id){
        $bbm = BuktiBarangMasuk::findOrFail($id);

        return view('bbm.barcode',compact('bbm'));
    }

    public function qrcode($id){
        $bbm = BuktiBarangMasuk::findOrFail($id);

        return view('bbm.qrcode',compact('bbm'));
    }

    public function check_serial(Request $request){
        $sg = SerialGudang::where('sn',$request->sn)->first();
        if($sg){
            return $sg->gudang->barang_id;
        } 
    }
}

