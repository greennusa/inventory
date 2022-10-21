<?php 
        $from = (int)date('m',strtotime($_GET['tanggal']));
        $to = (int)date('m',strtotime($_GET['tanggal2']));
        $tahun = date('Y',strtotime($_GET['tanggal']));
        $bulannya = ['array_bulan','JANUARI','FEBRUARI','MARET','APRIL','MEI','JUNI','JULI','AGUSTUS','SEPTEMBER','NOVEMBER','OKTOBER','DESEMBER']; 
   
        ?>

         <?php 
    $date = date('d/m/Y');
    $unit = \App\JenisUnit::find($_GET['jenis_unit_id']);
    header("Content-type: application/vhd.ms-word");
    header("Content-Disposition: attachment; filename=Pemakaian-Unit-".$unit->kode."-".$bulannya[$from]."-".$tahun.".doc");
    header("Pragma: no-cache");
    header("Expires: 0");
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
            <h5>LAPORAN PEMAKAIAN BARANG MATERIAL DAN SPARE PART</h5>

            <u>PERIODE BULAN <?php echo date('d',strtotime($_GET['tanggal'])); ?> <?php echo $bulannya[$from]; ?> <?php echo date('Y',strtotime($_GET['tanggal'])); ?> - <?php echo date('d',strtotime($_GET['tanggal2'])); ?> <?php echo $bulannya[$to]; ?> <?php echo date('Y',strtotime($_GET['tanggal2'])); ?></u>
        </center>
        <br>
        <?php 
            use App\Barang;
            use App\DetailPemakaianBarang;
            use App\DetailPemakaianBarangLama;
            use App\Camp;
            use App\User;
            $diketahui = User::findOrFail($_GET['diketahui']);
            $disetujui_1 = User::findOrFail($_GET['disetujui_1']);
            // $disetujui_2_1 = User::findOrFail($_GET['disetujui_2'][0]);
            // $disetujui_2_2 = User::findOrFail($_GET['disetujui_2'][1]);
            $dibuat = User::findOrFail($_GET['dibuat']);
            $camps = Camp::all();
            $kategori = '';
            $no = 1;
            
            // $to = date('m',strtotime($_GET['tanggal2']));
            $details = DetailPemakaianBarang::groupBy('barang_id')->get()->toBase()->merge(DetailPemakaianBarangLama::groupBy('barang_id')->get());
            
            $total_semua = 0;
        ?>
        <table class="table table-bordered table-hover" border="1">
            <tr>
                <td colspan="8"><u><?php echo \App\JenisUnit::find($_GET['jenis_unit_id'])->kode; ?> - <?php echo \App\JenisUnit::find($_GET['jenis_unit_id'])->nama; ?></u></td>
            </tr>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nama Barang</th>
                <th>Part Number</th>
                <th>Qty</th>
                <th>Harga Satuan</th>
                <th>Jumlah</th>
                <th>Keterangan</th>
            </tr>

            @foreach($details as $detail)
                @if(date('Y-m-d',strtotime(@$detail->pemakaian->tanggal)) >= $_GET['tanggal'] &&  date('Y-m-d',strtotime(@$detail->pemakaian->tanggal)) <= $_GET['tanggal2'] && @$detail->barang->unit->jenis_unit_id == $_GET['jenis_unit_id'])
                   <tr>
                       <td>{{ $no++ }}</td>
                       <td>{{ @$detail->created_at->format('d-m-Y') }}</td>
                       <?php $db = \App\DetailPemesananBarang::where('gabungan','like','%'.@$detail->gabungan_id.'%')->get();?>
                                                <td>
                                                    <?php if(@$detail->detail_bbk->detail_bbm->detail_pemesanan->kode_barang != null){ echo @$detail->detail_bbk->detail_bbm->detail_pemesanan->kode_barang; }else if(@$detail->detail_bbk == null){ echo $detail->camp_lama->kode_barang;} else { echo @$detail->barang->kode; }?>
                                                    <?php if($detail->detail_bbk != null):foreach($db as $dd): ?>
                                                     / <?php echo @$dd->barang->kode ?>
                                                    <?php endforeach;endif; ?>
                                                </td><td>
                                                    <?php if(@$detail->detail_bbk->detail_bbm->detail_pemesanan->nama_barang != null){ echo @$detail->detail_bbk->detail_bbm->detail_pemesanan->nama_barang; }else if(@$detail->detail_bbk == null){ echo $detail->camp_lama->nama_barang;} else { echo @$detail->barang->nama; }?> 
                                                    <?php if($detail->detail_bbk != null):foreach($db as $dd): ?>
                                                     / <?php echo @$dd->barang->nama ?>
                                                    <?php endforeach;endif; ?>
                                                </td>
                                                
                       <td>{{ @$detail->jumlah }} {{ @$detail->detail_bbk->detail_bbm->detail_pemesanan->detail_permintaan->satuan->nama }}<?php echo @$detail->camp_lama->satuan->nama ?></td>
                       <td>Rp.{{ number_format(@$detail->detail_bbk->detail_bbm->detail_pemesanan->detail_permintaan->harga+@$detail->camp_lama->harga) }}</td>
                       <td>Rp.{{ number_format(@$detail->jumlah*@$detail->detail_bbk->detail_bbm->detail_pemesanan->detail_permintaan->harga) }}</td>
                       <td>{{ @$detail->detail_bbk->keterangan }}</td>
                   </tr>
                   <?php $total_semua += @$detail->jumlah*@$detail->detail_bbk->detail_bbm->detail_pemesanan->detail_permintaan->harga; ?>
                @endif
            @endforeach
            <tr>
                <td colspan="8"></td>
            </tr>
            <tr>
                <td colspan="5"></td>
                <td>Total:</td>
                <td colspan="2"><strong><u>Rp.{{ number_format($total_semua) }}</u></strong></td>
            </tr>
        </table>
        <br>
        <br>

        <table style="width: 100%;text-align: center;">
            <tr>
                        <td colspan="4" style="text-align: right;">{{ date('d F Y') }}</td>
            </tr>
            <tr>
                <td><br></td>
            </tr>
            <tr>
                <td>Diketahui Oleh</td>
                <td>Disetujui I Oleh</td>
                <td>Disetujui II Oleh</td>
                <td>Dibuat Oleh</td>
            </tr>
            <tr>
                <td colspan="4"><br><br><br><br></td>
            </tr>
            <tr>
                <td>{{ $diketahui->nama }}<br>{{ $diketahui->jabatan->nama }}</td>
                <td>{{ $disetujui_1->nama }}<br>{{ $disetujui_1->jabatan->nama }}</td>
                <td>
                    <?php 
                        for ($i=0; $i < count($_GET['disetujui_2']); $i++) { 
                            echo User::findOrFail($_GET['disetujui_2'][$i])->nama." /";
                        }
                        echo "<br>";
                        for ($i=0; $i < count($_GET['disetujui_2']); $i++) { 
                            echo User::findOrFail($_GET['disetujui_2'][$i])->jabatan->nama." /";
                        }
                     ?>
                </td>
                <td>{{ $dibuat->nama }}<br>{{ $dibuat->jabatan->nama }}</td>
            </tr>
        </table>
    </div>
</div>
</body>
</html>
