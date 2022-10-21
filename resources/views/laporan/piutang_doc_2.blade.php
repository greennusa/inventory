<?php   



        $from = (int)date('m',strtotime($_GET['tanggal']));

        $to = (int)date('m',strtotime($_GET['tanggal2']));

        $tahun = (int)date('Y',strtotime($_GET['tanggal']));

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



<?php  



    use App\Barang;

            use App\DetailPemakaianBarang;

            use App\DetailPemakaianBarangLama;

            use App\Camp;

            use App\CampLama;

            use App\DetailBuktiBarangKeluar;

            use App\User;

            

            $diketahui = User::findOrFail($_GET['diketahui']);

            $disetujui= User::findOrFail($_GET['disetujui']);

            use App\DetailPemesananBarang;

            $dibuat = User::findOrFail($_GET['dibuat']);

            // $tables = Camp::all()->toBase()->merge(CampLama::all());

            $tables = DetailPemakaianBarang::whereHas('pemakaian', function ($q){ $q->where('piutang',1); })->get()->toBase()->merge(DetailPemakaianBarangLama::whereHas('pemakaian', function ($q){ $q->where('piutang',1); })->get());

            $barang = Barang::with('detail_pemakaian')->where('kategori_id', 40)->get()->merge(Barang::with('detail_pemakaian_lama')->where('kategori_id', 40)->get());

            $kategori = '';

            $id = '';

            $no = 1;

            $span = 0;





?>



                    @foreach($barang as $b)

                    

                    @foreach($b->detail_pemakaian as $dp)

                    

                    <?php

                    if ($id != $dp->barang_id) {

                        

                        $span++;



                        $id = $dp->barang_id;

                    }



                    ?>



                    

                    @endforeach

                    @endforeach



    <body onload="window.print()">

    

        <div class="container">

            <br>

            <br>

            <p class="ok">PT. UTAMA DAMAI INDAH TIMBER</p><br>  

            <center>

                <h5>LAPORAN BON BAHAN BAKAR MINYAK (BBM) KARYAWAN CAMP</h5>



                <u>PERIODE BULAN <?php echo $bulannya[$from]; ?> - <?php echo $bulannya[$to]; ?> <?php echo $tahun; ?></u>

            </center>

            <br>

            <table class="table table-bordered table-hover">

                

                <tr>

                    <th width="1" >No.</th>

                    <th>Nama</th>

                    <th>Jabatan</th>

                    @foreach($barang as $b)

                    

                    @foreach($b->detail_pemakaian as $dp)

                    

                    <?php

                    if ($id != $dp->barang_id) {

                        

                        echo "<th>".$dp->barang->nama."</th>";



                        $id = $dp->barang_id;

                    }



                    ?>



                    

                    @endforeach

                    @endforeach

                    <th>Jumlah Bon</th>

                    <th>Harga Bensin per liter</th>

                </tr>



                @foreach($tables as $detail)

                @if($detail->barang->kategori->id == 40 && date('m',strtotime(@$detail->pemakaian->tanggal)) >= $from && date('m',strtotime(@$detail->pemakaian->tanggal)) <= $to)

                <tr>

                    <td>{{ $no++ }}</td>

                    <td>{{ $detail->pemakaian->diterima }}</td>

                    <td>{{ $detail->pemakaian->unit->kode   }}</td>

                    @foreach($barang as $b)

                    @foreach($b->detail_pemakaian as $dp)



                    <?php

                        if ($id != $dp->barang_id){

                            if ($dp->barang_id == $detail->barang_id) {

                                $bon = 0;

                                echo "<td>".$detail->jumlah."</td>";

                                $bon += $dp->detail_bbk->harga;

                            }else{

                                echo "<td> - </td>";

                            }

                            $id = $dp->barang_id;

                        }

                    ?>



                    @endforeach

                    @endforeach

                    <td>{{ $bon }}</td>

                    <td>Rp. {{ @$detail->detail_bbk->detail_bbm->detail_pemesanan->harga }}</td>

                </tr>

                @endif

                @endforeach

            </table>

        </div>

    </body>