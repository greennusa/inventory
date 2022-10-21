<?php   



        $from = (int)date('m',strtotime($_GET['tanggal']));

        $to = (int)date('m',strtotime($_GET['tanggal2']));

        $tahun = (int)date('Y',strtotime($_GET['tanggal']));
        $bon = 0;
        $harga = 0;
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
            
            $tables_barang = DetailPemakaianBarang::whereHas('pemakaian', function ($q){ $q->where('piutang',1); })->get()->toBase()->merge(DetailPemakaianBarangLama::whereHas('pemakaian', function ($q){ $q->where('piutang',1); })->get())->unique('barang_id');
            // $barang = Barang::with('detail_pemakaian')->where('kategori_id', 40)->get()->merge(Barang::with('detail_pemakaian_lama')->where('kategori_id', 40)->get());
            
            $barang = Barang::with('detail_pemakaian')->get()->merge(Barang::with('detail_pemakaian_lama')->get());

            $kategori = '';

            $id = '';

            $no = 1;

            $span = 0;

            $nama = '';

            $total_semua = 0;
            


?>



                    @foreach($barang as $b)

                    

                    @foreach($tables_barang as $tdp)

                    

                    <?php
                    if ($b->id == $tdp->barang_id) {

                        

                            $span++;
    
    
    
                            $id = $tdp->barang_id;
    
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

                    

                    @foreach($tables_barang as $dp)

                    

                    <?php

                    if ($b->id == $dp->barang_id) {

                        

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
                
                <?php $nama = $detail->pemakaian->diterima; ?>
                <tr>

                    <td>{{ $no++ }}</td>

                    <td>{{ $detail->pemakaian->unit->operator }}</td>

                    <td>{{ $detail->pemakaian->unit->kode   }}</td>

                    @foreach($barang as $b)

                    @foreach($tables_barang as $dp)



                    <?php

                        if ($b->id == $dp->barang_id){
                            $jumlah_bon = DetailPemakaianBarang::whereHas('pemakaian', function ($q) use ($detail,$from,$to){ $q->where('id', $detail->pemakaian->id)->where('piutang',1)->where('diterima', $detail->pemakaian->diterima); })->where('barang_id', $dp->barang->id)->get()->toBase()->merge(DetailPemakaianBarangLama::whereHas('pemakaian', function ($q) use ($detail,$from,$to){ $q->where('id', $detail->pemakaian->id)->where('piutang',1)->where('diterima', $detail->pemakaian->diterima); })->where('barang_id', $dp->barang->id)->get());
                            

                                $bon = 0;

                                echo "<td>".$jumlah_bon->sum('jumlah')."</td>";

                                
                                foreach($jumlah_bon as $jb){
                                    $bon = $jb->harga * $jumlah_bon->sum('jumlah') ;
                                    $harga = $jb->harga;
                                }
                                
                                

                            $id = $dp->barang_id;

                        }

                    ?>



                    @endforeach

                    @endforeach

                    <td>Rp.{{ number_format($bon) }}</td>
                        <?php $total_semua += $bon; ?>
                    <td>Rp.{{ number_format($harga) }}</td>

                </tr>

                
                @endif
                @endforeach
                
                <tr>
                    <td colspan="3"></td>
                    <td >Total</td>
                    <td>Rp. {{ number_format($total_semua) }}</td>
                    <td></td>
                </tr>

                
            </table>


            <table style="width: 100%;text-align: center;">

                <tr>
    
                            <td colspan="4" style="text-align: right;">Base Camp Sei Bunut, {{ date('d F Y') }}</td>
    
                          </tr>
    
                        <tr><td><br><br></td></tr>
    
                <tr>
    
                    <td>Diketahui Oleh</td>
    
                    <td>Disetujui I Oleh</td>
    
                    <td>Dibuat Oleh</td>
    
                </tr>
    
                <tr>
    
                    <td colspan="4"><br><br><br><br></td>
    
                </tr>
    
                <tr>
    
                    <td>{{ $diketahui->nama }}<br>{{ $diketahui->jabatan->nama }}</td>
    
                    <td>{{ $disetujui->nama }}<br>{{ $disetujui->jabatan->nama }}</td>
    
                    
    
                    <td>{{ $dibuat->nama }}<br>{{ $dibuat->jabatan->nama }}</td>
    
                </tr>
    
            </table>
        </div>

    </body>