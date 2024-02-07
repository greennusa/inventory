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



 <?php 

            use App\Barang;

            use App\DetailBuktiBarangMasuk;

            use App\BuktiBarangMasuk;

            use App\PemesananBarang;

            use App\DetailPemesananBarang;

            use App\User;

            use App\Pemasok;



            $pemasok = Pemasok::findOrFail($_GET['supplier']);

            if (isset($_GET['diketahui'])) {
                $diketahui = User::find($_GET['diketahui']);
            }
            
            if (isset($_GET['disetujui_1'])) {
                $disetujui_1 = User::find($_GET['disetujui_1']);
            }
            
            if (isset($_GET['disetujui_2'])) {
            $disetujui_2_1 = User::find($_GET['disetujui_2'][0]);
            $disetujui_2_2 = User::find($_GET['disetujui_2'][1]);
            }

            if (isset($_GET['dibuat'])) {
             $dibuat = User::find($_GET['dibuat']);
            }

            $kategori = '';

            $no = 1;

            

            // $to = date('m',strtotime($_GET['tanggal2']));

            //$details = DetailBuktiBarangKeluar::groupBy('barang_id')->get();

            $data = DetailBuktiBarangMasuk::whereHas('detail_pemesanan', function($query) use($pemasok){

                $query->whereHas('pemesanan', function($query) use($pemasok){

                    $query->where('pemasok_id', '=', $pemasok->id);

                });

            })->get();

            $total_semua = 0;

        ?>



<body onload="window.print()">

    

    <div class="container">

        <br>

        <br>

        <p class="ok">PT. UTAMA DAMAI INDAH TIMBER</p><br>  

        <center>

            <h5>LAPORAN SUPPLIER {{ strtoupper($pemasok->nama) }}</h5>



            <u>PERIODE BULAN <?php echo $bulannya[$from]; ?> <?php echo $tahun; ?></u>

        </center>

        <br>

       

        



                    <table class="table table-bordered table-hover">

                                <thead>

                                    <tr>

                                        <th>#</th>

                                        <th style="width: 80px;">Date</th>

                                        <th style="width: 140px;">No. OPB</th>

                                        <th>PO</th>

                                     

                                        

                                        <th>Nama Barang</th>

                                        

                                        <th align="center">Qty</th>

                                        <th>Unit Price</th>

                                        <th>Grand Total</th>

                                        <th>Keterangan</th>

                                       

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

                                    @foreach($data as $d)

                                    @if(date('m',strtotime(@$d->detail_pemesanan->pemesanan->tanggal)) == $from && date('Y',strtotime(@$d->detail_pemesanan->pemesanan->tanggal)) == $tahun)

                                    <tr>

                                        <td>{{$no}}</td>

                                        <?php $no++ ?>

                                        <td>{{ $d->detail_pemesanan->pemesanan->tanggal}}</td>

                                        <td>{{ $d->detail_pemesanan->detail_permintaan->permintaan->nomor }}</td>

                                        <td>{{ $d->detail_pemesanan->pemesanan->nomor }}</td>

                                        <td>{{ $d->nama_barang }}</td>

                                        <td  align="center">{{ $d->jumlah }}</td>

                                        <td> {{ number_format($d->harga) }} </td>

                                        <td> {{ number_format($d->harga * $d->jumlah) }} </td>

                                        <td> {{ $d->keterangan }} </td>

                                    </tr>

                                    

                                    <?php

                                    $total += ($d->harga * $d->jumlah);

                                     ?>

                                     @endif

                                    @endforeach



                                </tbody>

                                <tfoot>

                                <tr>
                                    <td>Total</td>
                                    <td colspan="7" align="right"><?php echo number_format($total)  ?></td>

                                </tr>

                            </tfoot>

                            </table>

        <br>

        <br>



        <table style="width: 100%;text-align: center;">

            <tr>

                        <td colspan="4" style="text-align: right;">{{ date('d F Y') }}</td>

                      </tr>

            <tr>
                @if(isset($diketahui))
                <td>Diketahui Oleh</td>
                @endif
            @if(isset($disetujui_1))
                <td>Dibenarkan I Oleh</td>
                @endif
            @if(isset($disetujui_2_1))
                <td>Dibenarkan II Oleh</td>
                @endif
            @if(isset($dibuat))
                <td>Dibuat Oleh</td>
            @endif
            </tr>

            <tr>

                <td colspan="4"><br><br><br><br></td>

            </tr>

            <tr>

            @if(isset($diketahui))
                <td>{{ $diketahui->nama }}<br>{{ $diketahui->jabatan->nama }}</td>
            @endif
            @if(isset($disetujui_1))
                <td>{{ $disetujui_1->nama }}<br>{{ $disetujui_1->jabatan->nama }}</td>
            @endif
            @if(isset($disetujui_2_1))
                <td>{{ $disetujui_2_1->nama }} / {{ $disetujui_2_1->nama }}<br>{{ $disetujui_2_1->jabatan->nama }} / {{ $disetujui_2_1->jabatan->nama }}</td>
            @endif
            @if(isset($dibuat))
                <td>{{ $dibuat->nama }}<br>{{ $dibuat->jabatan->nama }}</td>
            @endif
            </tr>

        </table>

    </div>



</body>

</html>

            }
