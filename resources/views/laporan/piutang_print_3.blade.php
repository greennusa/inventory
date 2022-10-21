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

    use App\PemakaianBarang;

    use App\DetailPemakaianBarang;

    use App\Camp;

    use App\User;

    use App\DetailPemakaianBarangLama;

    $diketahui = User::findOrFail($_GET['diketahui']);

    $disetujui_1 = User::findOrFail($_GET['disetujui_1']);

    $dibuat = User::findOrFail($_GET['dibuat']);

    $no = 1;

    $total_semua = 0;

    $nama = '';

    // $data = PemakaianBarang::where('piutang', '=', 1)->get();

    // $p = DetailPemakaianBarang::whereHas('pemakaian', function($query){

    //     $query->where('piutang', '=', 1);

    // })->whereHas('barang', function($query){
    //     $query->where('kategori_id','!=','40');
    // })->groupBy('pemakaian_barang_id')->get();

    // $l = DetailPemakaianBarangLama::whereHas('pemakaian', function($query){

    //     $query->where('piutang', '=', 1);

    // })->whereHas('barang', function($query){
    //     $query->where('kategori_id','!=','40');
    // })->groupBy('pemakaian_barang_id')->get();
    
    $p = DetailPemakaianBarang::whereHas('pemakaian', function($query){

        $query->where('piutang', '=', 1);

    })->groupBy('pemakaian_barang_id')->get();

    $l = DetailPemakaianBarangLama::whereHas('pemakaian', function($query){

        $query->where('piutang', '=', 1);

    })->groupBy('pemakaian_barang_id')->get();

    $x = $p->toBase()->merge($l);

?>

    <body onload="window.print()">

        <div class="container">

            <br>

            <br>

            <p class="ok">PT. UTAMA DAMAI INDAH TIMBER</p><br>  

            <center>

                <h5>REKAPITULASI BON PENGAMBILAN SPARE PART CHAINSAW OLEH KARYAWAN</h5>



                <u>PERIODE BULAN <?php echo $bulannya[$from]; ?> <?php echo $tahun; ?></u>

            </center>







            <table class="table table-bordered table-hover">

                <thead>

                    <tr>

                        <th width="10">No.</th>

                        <th>Nama Karyawan</th>

                        <th>Jabatan</th>
                        
                        <th>Besar Pinjaman</th>

                        <th>Keterangan</th>

                    </tr>

                </thead>



                <tbody>



                    @foreach( $x as $detail)

                    @if(date('m',strtotime(@$detail->pemakaian->tanggal)) == $from && date('Y',strtotime(@$detail->pemakaian->tanggal)) == $tahun && @$detail->pemakaian->unit->operator != $nama)

                    <tr>

                        <?php $db = \App\DetailPemesananBarang::where('gabungan','like','%'.@$detail->gabungan_id.'%')->get();?>

                        <td>{{ $no++ }}</td>

                        <td>{{ @$detail->pemakaian->unit->operator  }}  </td>

                        <td>{{ @$detail->pemakaian->unit->kode }}</td>

                        

                        <?php
						$nama = @$detail->pemakaian->unit->operator;
						$d = DetailPemakaianBarang::whereHas('pemakaian',function ($q) use ($from,$tahun,$detail) {

                                $q->where('piutang', '=', 1)->whereMonth('tanggal',$from)->whereYear('tanggal',$tahun)->whereHas('unit', function($q1) use($detail){
									$q1->where('operator', @$detail->pemakaian->unit->operator);
								});

                            })->get();$total = 0;

                                $dl = DetailPemakaianBarangLama::whereHas('pemakaian',function ($q) use ($from,$tahun,$detail) {

                                $q->where('piutang', '=', 1)->whereMonth('tanggal',$from)->whereYear('tanggal',$tahun)->whereHas('unit', function($q1) use($detail){
									$q1->where('operator', @$detail->pemakaian->unit->operator);
								});

                            })->get();$total = 0;

                                $dll = $d->toBase()->merge($dl);

                             ?>

                            @foreach($dll as $dd)

                                <?php $total+=(int)@$dd->detail_bbk->harga+@$dd->camp_lama->harga*$dd->jumlah; ?>

                            @endforeach

                            <td>Rp.{{ number_format($total) }} </td>

                            <?php $total_semua += $total; ?>

                            <td>{{ @$detail->pemakaian->keterangan }}</td>

                    </tr>



                    @endif

                    @endforeach

                    <tr>
                        <td colspan="2"></td>
                        <td >Total</td>
                        <td>Rp. {{ number_format($total_semua) }}</td>
                        <td></td>
                    </tr>

                </tbody>



            </table>





             <br>

        <br>



        <table style="width: 100%;text-align: center;">

            <tr>

                        <td colspan="4" style="text-align: right;">Base Camp Sei Seleq, {{ date('d F Y') }}</td>

                      </tr>

                    <tr><td><br><br></td></tr>

            <tr>

                <td>Diketahui Oleh</td>

                <td>Dilaporkan Oleh</td>

            </tr>

            <tr>

                <td colspan="4"><br><br><br><br></td>

            </tr>

            <tr>

                <td>{{ $diketahui->nama }}<br>{{ $diketahui->jabatan->nama }}</td>

                <td>{{ $dibuat->nama }}<br>{{ $dibuat->jabatan->nama }}</td>

            </tr>

        </table>



        </div>

    </body>

    </html>

