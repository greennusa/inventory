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



    .ok{

        top: -10px;

        display: inline;

        float: left;

    }

</style>



<?php

            use App\Barang;

            use App\DetailPemakaianGudang;

            use App\User;

            use App\PemakaianGudang;

            $diketahui = User::findOrFail($_GET['diketahui']);

            $disetujui_1 = User::findOrFail($_GET['disetujui_1']);

            $dibuat = User::findOrFail($_GET['dibuat']);

            $kategori = '';

            $no = 1;

            $total_semua = 0;

            $x = DetailPemakaianGudang::all();



?>



<body onload="window.print()">

    

    <div class="container">

        <br>

        <br>

        <center>

            <p class="ok">PT. UTAMA DAMAI INDAH TIMBER</p><br>  

            <h5>LAPORAN PEMAKAIAN GUDANG</h5>



            <u>PERIODE BULAN <?php echo $bulannya[$from]; ?> <?php echo $tahun; ?></u>

        </center>

        <br>





         <table class="table table-bordered table-hover">
            
            @foreach($x as $detail)
                
                @if(date('m',strtotime(@$detail->pemakaian->tanggal)) == $from && date('Y',strtotime(@$detail->pemakaian->tanggal)) == $tahun)

                    @if($kategori != @$detail->detail_bbm->barang->kategori_id)

                        <tr>

                            <th colspan="7"><u>{{ @$detail->detail_bbm->barang->kategori->nama }} </u></th>

                        </tr>

                        <?php $kategori = @$detail->detail_bbm->barang->kategori_id;$no = 1; ?>
                        <tr>
                            <th>No.</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>No. Permintaan Barang </th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Total Harga</th>
                            
                        </tr>
                        <tr>

                            <td>{{ $no++ }} </td>

                            <?php $db = \App\DetailPemesananBarang::where('gabungan','like','%'.@$detail->detail_bbm->gabungan_id.'%')->get();?>

                            <td>

                                <?php if(@$detail->detail_bbm->detail_pemesanan->kode_barang != null){ echo @$detail->detail_bbm->detail_pemesanan->kode_barang;} ?>                                                    

                            </td>

                            <td>

                                <?php if(@$detail->detail_bbm->detail_pemesanan->nama_barang != null){ echo @$detail->detail_bbm->detail_pemesanan->nama_barang; }?>

                            </td>
                            
                            <td>{{ @$detail->detail_bbm->detail_pemesanan->detail_permintaan->permintaan->nomor }}</td>
                            
                            <td>{{ number_format($detail->detail_bbm->harga) }}</td>
                            
                            <td>{{ number_format($detail->stok) }}</td>


                            <?php $total = 0;

                             ?>

                            

                            <td>Rp. {{ number_format($detail->detail_bbm->harga *  $detail->stok)}}</td>

                        </tr>

                        <?php $total_semua += $detail->detail_bbm->harga *  $detail->stok;

                             ?>

                    @else

                        <tr>

                            <td>{{ $no++ }}</td>

                            <td>{{ @$detail->detail_bbm->nama_barang }} </td>

                            <td>{{ @$detail->detail_bbm->barang->unit->kode }}</td>

                            <td>{{ @$detail->detail_bbm->detail_pemesanan->detail_permintaan->permintaan->nomor }}</td>

                            <td>{{ number_format($detail->detail_bbm->harga) }}</td>
                            
                            <td>{{ number_format($detail->stok) }}</td>

                            <?php $total_semua += $detail->detail_bbm->harga *  $detail->stok;

                             ?>

                            

                            <td>Rp. {{ number_format($detail->detail_bbm->harga *  $detail->stok)}}</td>

                            

                        </tr>

                        <?php $total_semua += $total; ?>

                    @endif

                @endif

            @endforeach

            <tr>

                <td colspan="7"></td>

            </tr>

            <tr>

                <td colspan="6">TOTAL LAPORAN PEMAKAIAN ........</td>

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

