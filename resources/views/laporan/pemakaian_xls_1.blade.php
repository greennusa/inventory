<?php 
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
            <h5>LAPORAN PEMAKAIAN SPARE PART & PERLENGKAPAN LAINNYA</h5>

            <u>PERIODE BULAN <?php echo $bulannya[$from]; ?> <?php echo $tahun; ?></u>
        </center>
        <br>
        <?php 
            use App\Barang;
            use App\DetailPemakaianBarang;
            use App\Camp;
            use App\User;
            use App\DetailPemakaianBarangLama;
            $diketahui = User::findOrFail($_GET['diketahui']);
            $disetujui_1 = User::findOrFail($_GET['disetujui_1']);
            // $disetujui_2_1 = User::findOrFail($_GET['disetujui_2'][0]);
            // $disetujui_2_2 = User::findOrFail($_GET['disetujui_2'][1]);
            $dibuat = User::findOrFail($_GET['dibuat']);
            $camps = Camp::all();
            $kategori = '';
            $no = 1;
            
            // $to = date('m',strtotime($_GET['tanggal2']));
            $details = DetailPemakaianBarang::all();
            $c = DetailPemakaianBarangLama::all();
            $x = $details->toBase()->merge($c);
            $total_semua = 0;
        ?>
        <table class="table table-bordered table-hover">
            @foreach($x as $detail)
                @if(date('m',strtotime(@$detail->pemakaian->tanggal)) == $from && date('Y',strtotime(@$detail->pemakaian->tanggal)) == $tahun)
                    @if($kategori != @$detail->barang->kategori_id)
                        <tr>
                            <th colspan="5"><u>{{ @$detail->barang->kategori->nama }}</u></th>
                        </tr>
                        <?php $kategori = @$detail->barang->kategori_id;$no = 1; ?>
                        <tr>
                            <td>{{ $no++ }}</td>
                            <?php $db = \App\DetailPemesananBarang::where('gabungan','like','%'.@$detail->gabungan_id.'%')->get();?>
                            <td>
                                <?php if(@$detail->detail_bbk->detail_bbm->detail_pemesanan->kode_barang != null){ echo @$detail->detail_bbk->detail_bbm->detail_pemesanan->kode_barang; }else if(@$detail->detail_bbk == null){ echo $detail->camp_lama->kode_barang;} else { echo @$detail->barang->kode; }?>
                                                    <?php if($detail->detail_bbk != null):foreach($db as $dd): ?>
                                                     / <?php echo @$dd->barang->kode ?>
                                                    <?php endforeach;endif; ?>
                            </td>
                            <td>
                                <?php if(@$detail->detail_bbk->detail_bbm->detail_pemesanan->nama_barang != null){ echo @$detail->detail_bbk->detail_bbm->detail_pemesanan->nama_barang; }else if(@$detail->detail_bbk == null){ echo $detail->camp_lama->nama_barang;} else { echo @$detail->barang->nama; }?> 
                                                    <?php if($detail->detail_bbk != null):foreach($db as $dd): ?>
                                                     / <?php echo @$dd->barang->nama ?>
                                                    <?php endforeach;endif; ?>
                            </td>
                            <td>Rp.</td>
                            <?php $d = DetailPemakaianBarang::where('barang_id',@$detail->barang->id)->whereHas('pemakaian',function ($q) use ($from,$tahun) {
                                $q->whereMonth('tanggal',$from)->whereYear('tanggal',$tahun);
                            })->get();$total = 0;
                                $dl = DetailPemakaianBarangLama::where('barang_id',@$detail->barang->id)->whereHas('pemakaian',function ($q) use ($from,$tahun) {
                                $q->whereMonth('tanggal',$from)->whereYear('tanggal',$tahun);
                            })->get();$total = 0;
                                $dll = $d->toBase()->merge($dl);
                             ?>
                            @foreach($dll as $dd)
                                <?php $total+=(int)@$dd->detail_bbk->harga+@$dd->camp_lama->harga*$dd->jumlah; ?>
                            @endforeach
                            <td>{{ number_format($total) }}</td>
                        </tr>
                        <?php $total_semua += $total; ?>
                    @else
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ @$detail->barang->nama }}</td>
                            <td>{{ @$detail->barang->unit->nama }}</td>
                            <td>Rp.</td>
                            <?php  $d = DetailPemakaianBarang::where('barang_id',@$detail->barang->id)->whereHas('pemakaian',function ($q) use ($from,$tahun) {
                                $q->whereMonth('tanggal',$from)->whereYear('tanggal',$tahun);
                            })->get();$total = 0;
                                $dl = DetailPemakaianBarangLama::where('barang_id',@$detail->barang->id)->whereHas('pemakaian',function ($q) use ($from,$tahun) {
                                $q->whereMonth('tanggal',$from)->whereYear('tanggal',$tahun);
                            })->get();$total = 0;
                                $dll = $d->toBase()->merge($dl);
                             ?>
                            @foreach($dll as $dd)
                                <?php $total+=(int)@$dd->detail_bbk->harga+@$dd->camp_lama->harga*$dd->jumlah; ?>
                            @endforeach
                            <td>{{ number_format($total) }}</td>
                        </tr>
                        <?php $total_semua += $total; ?>
                    @endif
                @endif
            @endforeach
            <tr>
                <td colspan="5"></td>
            </tr>
            <tr>
                <td colspan="4">TOTAL LAPORAN PEMAKAIAN SPARE PART & PERLENGKAPAN LAINNYA........</td>
                <td><strong><u>Rp.{{ number_format($total_semua) }}</u></strong></td>
            </tr>
        </table>
        <br>
        <br>

        <table style="width: 100%;text-align: center;">
            <tr>
                        <td colspan="4" style="text-align: right;">{{ date('d F Y') }}</td>
                      </tr>
                    <tr><td><br><br></td></tr>
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
