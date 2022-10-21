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

    table{
        font-size: 8px;
    }
</style>
<body onload="window.print()">
    
    <div class="container">
        <br>
        <br>
        <p class="ok">PT. UTAMA DAMAI INDAH TIMBER</p><br>  
        <center>
            <h5>LAPORAN PENERIMAAN SPARE PART & PERLENGKAPAN LAINNYA</h5>

            <u>PERIODE BULAN <?php echo $bulannya[$from]; ?> <?php echo $tahun; ?></u>
        </center>
        <br>
        <?php 
            use App\Barang;
            use App\DetailBuktiBarangKeluar;
            use App\Camp;
            use App\User;
            $diketahui = User::findOrFail($_GET['diketahui']);
            $disetujui_1 = User::findOrFail($_GET['disetujui_1']);
            $disetujui_2_1 = User::findOrFail($_GET['disetujui_2'][0]);
            $disetujui_2_2 = User::findOrFail($_GET['disetujui_2'][1]);
            $dibuat = User::findOrFail($_GET['dibuat']);
            $camps = Camp::all();
            $kategori = '';
            $no = 1;
            
            // $to = date('m',strtotime($_GET['tanggal2']));
            $details = DetailBuktiBarangKeluar::groupBy('barang_id')->get();
            
            $total_semua = 0;
        ?>
        

                    <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th style="width: 60px;">Date</th>
                                        <th>Supplier</th>
                                        <th>OPB</th>
                                        <th>PO</th>
                                        
                                        <th>Delivery/No</th>
                                        <th>Part Number</th>
                                        <th>Part Name</th>
                                        <th>Qty</th>
                                        <th>Unit Price</th>
                                        <th>Grand Total</th>
                                        <th>Keperluan/Kode Unit</th>
                                       
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no=1;
                                    $jml_total = 0;
                                      $total = 0;
                                      $jumlahItem = 0;
                                      $jumlahPengeluaran = 0; 
                                      
                                      $po = '';

                                      ?>
                                    <?php foreach ($details as $d):  ?>
                                        @if(date('m',strtotime(@$d->bbk->tanggal)) == $from )
                                        @if(@$d->gabungan == '' || @$d->gabungan == null)
                                        <?php 
                                                    $jumlah_row = @$d->jumlah*@$d->harga;
                                                    $po = explode("/", @$d->detail_bbm->detail_pemesanan->pemesanan->nomor );
                                                    $opb = explode("/", @$d->detail_bbm->detail_pemesanan->detail_permintaan->permintaan->nomor);
                                                    ?>  
                                                    
                                                        <tr>
                                                            
                                                            <td>{{ $no++ }}</td>
                                                            <td>{{ date('d-m-Y',strtotime(@$d->bbk->tanggal)) }}</td>
                                                            <td>{{ @$d->detail_bbm->bbm->pemesanan->pemasok->nama }}</td>
                                                            <td>{{  $opb[0]}}</td>
                                                            <td>{{ $po[0] }}</td>
                                                            
                                                           
                                                            <td>{{ @$d->bbk->nomor }}</td>
                                                            <?php $db = \App\DetailPemesananBarang::where('gabungan','like','%'.@$d->gabungan_id.'%')->get();?>
                                                            <td><?php if(@$d->detail_bbm->detail_pemesanan->kode_barang != null || @$d->detail_bbm->detail_pemesanan->kode_barang != ''){ echo @$d->detail_bbm->detail_pemesanan->kode_barang; }else { echo @$d->barang->kode; }?>@foreach($db as $aa)
                                                                 / <?php echo $aa->barang->kode ?>
                                                                @endforeach</td>
                                                            <td><?php if(@$d->detail_bbm->detail_pemesanan->nama_barang != null || @$d->detail_bbm->detail_pemesanan->nama_barang != ''){ echo @$d->detail_bbm->detail_pemesanan->nama_barang; }else { echo @$d->barang->nama; }?>@foreach($db as $aa)
                                                                 / <?php echo $aa->barang->nama ?>
                                                                @endforeach</td>
                                                            <td><?php echo @$d->jumlah ?> <?php echo @$d->detail_bbm->detail_pemesanan->detail_permintaan->satuan->nama; ?></td>
                                                            <td>
                                                                Rp.<?php echo number_format(@$d->harga) ?>
                                                            </td>
                                                                
                                                           
                                                            <td>Rp.{{ number_format($jumlah_row) }}</td>
                                                            <td>{{ @$d->detail_bbm->detail_pemesanan->keperluan }} <?php echo @$d->barang->unit->kode ?>,<?php echo @$d->barang->unit->jenis_unit->kode ?> </td>

                                                        </tr>
                                                        
                                                    <?php $jumlahItem += @$d->jumlah; ?>
                                                    <?php $jumlahPengeluaran += (@$d->jumlah * @$d->harga); ?>
                                                   

                                        @endif
                                        @endif
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="10" align="right"><b>Total : </b></td>

                                    <td colspan="2"><b>Rp. <?=number_format($jumlahPengeluaran)?></b></td>
                                </tr>
                            </tfoot>
                            </table>
        <br>
        <br>

        <table style="width: 100%;text-align: center;">
            <tr>
                        <td colspan="4" style="text-align: right;">BC Bunut-Pana'an, {{ date('d F Y') }}</td>
                      </tr>
            <tr>
                <td>Diketahui Oleh</td>
                <td>Dibenarkan I Oleh</td>
                <td>Dibenarkan II Oleh</td>
                <td>Dibuat Oleh</td>
            </tr>
            <tr>
                <td colspan="4"><br><br><br><br></td>
            </tr>
            <tr>
                <td>{{ $diketahui->nama }}<br>{{ $diketahui->jabatan->nama }}</td>
                <td>{{ $disetujui_1->nama }}<br>{{ $disetujui_1->jabatan->nama }}</td>
                <td>{{ $disetujui_2_1->nama }} / {{ $disetujui_2_1->nama }}<br>{{ $disetujui_2_1->jabatan->nama }} / {{ $disetujui_2_1->jabatan->nama }}</td>
                <td>{{ $dibuat->nama }}<br>{{ $dibuat->jabatan->nama }}</td>
            </tr>
        </table>
    </div>
</div>
</body>
</html>
