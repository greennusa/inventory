<?php   
$jenisunit = \App\JenisUnit::find($_GET['jenis_unit_id']);
        $from = (int)date('m',strtotime($_GET['tanggal']));
        $tahun = date('Y',strtotime($_GET['tanggal']));
        $bulannya = ['array_bulan','JANUARI','FEBRUARI','MARET','APRIL','MEI','JUNI','JULI','AGUSTUS','SEPTEMBER','NOVEMBER','OKTOBER','DESEMBER']; 
        ?>
<!DOCTYPE html>
<html>
<head>
    <title>PERIODE BULAN <?php echo $bulannya[$from]; ?> <?php echo $tahun; ?></title>
    <link rel="stylesheet" type="text/css" href="{{ asset('bootstrap/theme/16/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('selectbox/css/bootstrap-select.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('jquery-ui/jquery-ui.min.css') }}">




    <script src="{{ asset('jquery/jquery-1.11.3.min.js') }}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('selectbox/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-notify.min.js') }}" ></script>
</head>
<style type="text/css" media="print">
    @page {
        size: auto;   /* auto is the initial value */
        margin-bottom: 0;  /* this affects the margin in the printer settings */
    }
</style>
<body onload="window.print()">
    
    <div class="container">
        <br>
        <br>
        <center>
            <h5>LAPORAN STOK SPARE PART {{ $jenisunit->kode }} - {{ $jenisunit->nama }}</h5>

            <u>PERIODE BULAN <?php echo $bulannya[$from]; ?> <?php echo $tahun; ?></u>
        </center>
        <br>
        <?php 
            use App\Barang;
            use App\DetailPemakaianBarang;
            use App\DetailPemakaianBarangLama;
            use App\Camp;
            use App\CampLama;
            use App\DetailBuktiBarangKeluar;
            use App\User;
            use App\DetailPemesananBarang;
            $diketahui = User::findOrFail($_GET['diketahui']);
            $dibuat = User::findOrFail($_GET['dibuat']);
            $tables = Camp::whereMonth('tanggal',$from)->get()->toBase()->merge(CampLama::whereMonth('tanggal',$from)->get());

            $kategori = '';
            $no = 1;
            
            // $to = date('m',strtotime($_GET['tanggal2']));
            
            
            $total_semua = 0;
        ?>
        <table class="table table-bordered table-hover">
                        <tr>
                            <th rowspan="2">No</th>

                            <th rowspan="2">Kode Barang</th>
                            <th rowspan="2">Nama Barang</th>
                            
                            <th rowspan="2">Unit</th>
                            <th rowspan="2">Harga Satuan</th>
                            <th colspan="4" style="text-align: center;">Jumlah</th>
                            <th rowspan="2">Nilai Akhir</th>
                            <th rowspan="2">Keterangan Dokumen SPB</th>
                        </tr>
                        <tr>
                            <th>Stok Awal</th>
                            <th>Penambahan</th>
                            <th>Pemakaian</th>
                            <th>Stok Akhir</th>
                        </tr>
                        <?php 
                        $page = 0;
                        if(isset($_GET['page']) && $_GET['page'] > 1){
                            $page = $_GET['page']*10;
                        }
                        $no = 1*$page+1; 
                        $grand_total = 0;
                        ?>
                        @foreach($tables as $data)
                            @if(@$data->barang->unit->jenis_unit_id == $_GET['jenis_unit_id'])
                            <tr>
                                <td><?php echo $no ?></td>
                                <?php $db = DetailPemesananBarang::where('gabungan','like','%'.@$data->gabungan_id.'%')->get();?>
                                <td><?php if(@$data->detail_bbk->detail_bbm->detail_pemesanan->kode_barang != null){ echo @$data->detail_bbk->detail_bbm->detail_pemesanan->kode_barang; }else if(@$data->detail_bbk == null){ echo @$data->kode_barang;} else { echo @$data->barang->kode; }?>
                                                    <?php if($data->detail_bbk != null):foreach($db as $dd): ?>
                                                     / <?php echo @$dd->barang->kode ?>
                                                    <?php endforeach;endif; ?>
                                </td>
                                <td><?php if(@$data->detail_bbk->detail_bbm->detail_pemesanan->nama_barang != null){ echo @$data->detail_bbk->detail_bbm->detail_pemesanan->nama_barang; }else if(@$data->detail_bbk == null){ echo @$data->nama_barang;} else { echo @$data->barang->nama; }?>
                                                    <?php if($data->detail_bbk != null):foreach($db as $dd): ?>
                                                     / <?php echo @$dd->barang->nama ?>
                                                    <?php endforeach;endif; ?>
                                </td>
                                
                                <td><?php echo @$data->barang->unit->nama ?></td>
                                <td>Rp.<?php echo number_format((!isset($data->harga) ? $data->detail_bbk->harga : $data->harga)) ?></td>
                                <td>{{ @$data->stok_awal }}</td>
                                <?php $dbbk = DetailBuktiBarangKeluar::whereNotIn('id',[@$data->detail_bukti_barang_keluar])->where('barang_id',@$data->detail_bbk->barang_id)->get(); $penambahan = 0;?>
                                @foreach($dbbk as $ddbbk)
                                    <?php $penambahan += $ddbbk->jumlah; ?>
                                @endforeach
                                <td>{{ $penambahan }}</td>
                                <?php $dp= DetailPemakaianBarang::where('barang_id',@$data->detail_bbk->barang_id)->get()->toBase()->merge(DetailPemakaianBarangLama::where('barang_id',@$data->detail_bbk->barang_id)->get()); $pemakaian = 0;?>
                                @foreach($dp as $ddp)
                                    <?php $pemakaian += $ddp->jumlah; ?>
                                @endforeach
                                <td>{{ $pemakaian }}</td>
                                <td>{{ @$data->stok }}</td>
                                <td>Rp.<?php  echo number_format($data->stok* (!isset($data->harga) ? $data->detail_bbk->harga : $data->harga)) ?></td>
                                <td>{{ @$data->detail_bbk->keterangan }}</td>
                            </tr>
                            <?php $no++;$grand_total += @$data->stok*(!isset($data->harga) ? $data->detail_bbk->harga : $data->harga); ?>
                            @endif
                            
                        @endforeach
                        <tr>
                            <td colspan="8"></td>
                            <td colspan="2">Total:</td>
                            <td colspan="2">Rp.{{ number_format($grand_total) }}</td>
                        </tr>
                    </table>
        <br>
        <br>

        <table style="width: 100%;text-align: center;">
            <tr>
                        <td colspan="2" style="text-align: right;">{{ date('d F Y') }}</td>
                      </tr>
            <tr>
                <td>Diketahui Oleh</td>

                <td>Dibuat Oleh</td>
            </tr>
            <tr>
                <td colspan="2"><br><br><br><br></td>
            </tr>
            <tr>
                <td>{{ $diketahui->nama }}<br>{{ $diketahui->jabatan->nama }}</td>
                
                <td>{{ $dibuat->nama }}<br>{{ $dibuat->jabatan->nama }}</td>
            </tr>
        </table>
    </div>
</div>
</body>
</html>
