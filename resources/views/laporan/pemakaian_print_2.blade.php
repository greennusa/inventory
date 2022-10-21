<?php 

        

        $tahun = $_GET['tahun'];

        $bulannya = ['array_bulan','JANUARI','FEBRUARI','MARET','APRIL','MEI','JUNI','JULI','AGUSTUS','SEPTEMBER','NOVEMBER','OKTOBER','DESEMBER'];  

        $penggunaan = '';
        $kode_unit = '';
        $p1 = '';
        $p2 = '';
        ?>

<!DOCTYPE html>

<html>

<head>

    <title>PERIODE TAHUN <?php echo $tahun; ?></title>

    <link rel="stylesheet" type="text/css" href="{{ asset('bootstrap/theme/16/bootstrap.min.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('selectbox/css/bootstrap-select.min.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('jquery-ui/jquery-ui.min.css') }}">









    <script src="{{ asset('jquery/jquery-1.11.3.min.js') }}"></script>

    <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>

    <script src="{{ asset('selectbox/js/bootstrap-select.min.js') }}"></script>

    <script src="{{ asset('jquery-ui/jquery-ui.min.js') }}"></script>

    <script src="{{ asset('js/bootstrap-notify.min.js') }}" ></script>

</head>



<style type="text/css">

    .table {

        font-size: 8px;

       

    }





</style>



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

            <h5>REKAPITULASI PEMAKAIAN SPARE PART & PERLENGKAPAN LAINNYA</h5>



            <u>PERIODE TAHUN <?php echo $tahun; ?></u>

        </center>

        <br>

        <?php 

            use App\Barang;

            use App\DetailPemakaianBarang;

             use App\DetailPemakaianBarangLama;

            use App\Camp;

            use App\User;



            if (isset($_GET['diketahui'])) {

                $diketahui = User::find($_GET['diketahui']);

            }

            

           

            if (isset($_GET['dibuat'])) {

                $dibuat = User::find($_GET['dibuat']);

            }

            

            $camps = Camp::all();

            $kategori = '';

            $no = 1;

            

            // $to = date('m',strtotime($_GET['tanggal2']));

            $details = DetailPemakaianBarang::whereYear('created_at',$tahun)->get()->toBase()->merge(DetailPemakaianBarangLama::whereYear('created_at',$tahun)->get())->sortBy(function($user, $key)
    {
        return $user->barang->unit->kode;
    });;

            

            //dd($details);

            $total_semua = 0;

            $total_col = [0,0,0,0,0,0,0,0,0,0,0,0,0];

            $grand_col = [0,0,0,0,0,0,0,0,0,0,0,0,0];

            $x = 0;



        ?>

        <table class="table table-bordered table-hover">

            <tr>

                <th>No</th>

                <th>Jenis Unit</th>

                <th>Kode Unit</th>

                <th>January</th>

                <th>Februari</th>

                <th>Maret</th>

                <th>April</th>

                <th>Mei</th>

                <th>Juni</th>

                <th>Juli</th>

                <th>Agustus</th>

                <th>September</th>

                <th>Oktober</th>

                <th>November</th>

                <th>Desember</th>

                <th>Total</th>

                <th>Operator</th>

            </tr>

            @foreach($details as $detail)



               @if($detail->barang->kategori->id != 40)
               @if($detail->barang->unit->kode != $kode_unit)
                <?php 
                $total_row = 0;
                $kode_unit = $detail->barang->unit->kode; 
                ?>

                    @if($kategori != @$detail->barang->kategori_id)

                        <?php $ci = @$detail->barang->kategori_id;

                        $sub = DetailPemakaianBarang::whereHas('pemakaian',function ($q) use ($tahun) {

                                $q->whereYear('tanggal',$tahun);

                            })->whereHas('barang',function ($q) use ($ci)

                            {

                                $q->where('kategori_id',$ci);

                            })->count()+DetailPemakaianBarangLama::whereHas('pemakaian',function ($q) use ($tahun) {

                                $q->whereYear('tanggal',$tahun);

                            })->whereHas('barang',function ($q) use ($ci)

                            {

                                $q->where('kategori_id',$ci);

                            })->count();

                            

                            $total_col = [0,0,0,0,0,0,0,0,0,0,0,0,0]; ?>

                        <tr>

                            <th colspan="17"><u>
                                @if(@$detail->barang->unit->jenis_unit->kode == 'LB')
                                UNIT TRAKTOR PRODUKSI
                                @elseif(@$detail->barang->unit->jenis_unit->kode == 'LL' || @$detail->barang->unit->jenis_unit->kode == 'LS' || @$detail->barang->unit->jenis_unit->kode == 'LC' || @$detail->barang->unit->jenis_unit->kode == 'LG')
                                UNIT TRAKTOR PENUNJANG
                                @elseif(@$detail->barang->unit->jenis_unit->kode == 'LT')
                                UNIT LOGGING PRODUKSI
                                @elseif(@$detail->barang->unit->jenis_unit->kode == 'LD' || @$detail->barang->unit->jenis_unit->kode == 'MT' || @$detail->barang->unit->jenis_unit->kode == 'LJ')
                                UNIT TRANSPORT PENUNJANG
                                @endif
                            </u></th>

                        </tr>

                        <?php $kategori = @$detail->barang->kategori_id;$no = 1; ?>

                        <tr>

                            <td>{{ $no++ }}</td>

                            <td><?php $db = \App\DetailPemesananBarang::where('gabungan','like','%'.@$detail->gabungan_id.'%')->get();?>

                                <?php if(@$detail->detail_bbk->detail_bbm->detail_pemesanan->nama_barang != null){ echo @$detail->detail_bbk->detail_bbm->detail_pemesanan->barang->unit->jenis_unit->nama; } else if(@$detail->camp_lama->barang == null) { echo @$detail->barang->unit->jenis_unit->nama; } else if(@$detail->detail_bbk == null){ echo @$detail->camp_lama->barang->unit->jenis_unit->nama;} ?> 

                                                    

                             {{ @$detail->barang->unit->nama }}</td>

                            <td>{{ @$detail->barang->unit->kode }}</td>

                            
                            <!-- list total 1 -->
                            <?php $d = DetailPemakaianBarang::whereHas('pemakaian',function ($q) use ($tahun) {

                                $q->whereYear('tanggal',$tahun);

                            })->whereHas('barang', function ($q) use ($detail){
                                $q->where('unit_id', @$detail->barang->unit->id);
                            })->get()->toBase()->merge(DetailPemakaianBarangLama::whereHas('pemakaian',function ($q) use ($tahun) {

                                $q->whereYear('tanggal',$tahun);

                            })->whereHas('barang', function ($q) use ($detail){
                                $q->where('unit_id', @$detail->barang->unit->id);
                            })->get());$total = 0; ?>

                            <?php $total = 0; ?>

                            @foreach($d as $dd)

                                @if(@$dd->created_at->format('m') == 1)

                                <?php $total+=(int)(@$dd->detail_bbk->harga+@$dd->camp_lama->harga)*@$dd->jumlah; ?>

                                @endif

                            @endforeach

                            <td>Rp.{{ number_format($total) }}</td>

                            <?php $total_row += $total; ?>

                            <?php $total_col[0] += $total; ?>

                            <?php $total = 0; ?>

                            @foreach($d as $dd)

                                @if(@$dd->created_at->format('m') == 2)

                                <?php $total+=(int)(@$dd->detail_bbk->harga+@$dd->camp_lama->harga)*@$dd->jumlah; ?>

                                @endif

                            @endforeach

                            <td>Rp.{{ number_format($total) }}</td>

                            <?php $total_row += $total; ?>

                            <?php $total_col[1] += $total; ?>

                            <?php $total = 0; ?>

                            @foreach($d as $dd)

                                @if(@$dd->created_at->format('m') == 3)

                                <?php $total+=(int)(@$dd->detail_bbk->harga+@$dd->camp_lama->harga)*@$dd->jumlah; ?>

                                @endif

                            @endforeach

                            <td>Rp.{{ number_format($total) }}</td>

                            <?php $total_row += $total; ?>

                            <?php $total_col[2] += $total; ?>

                            <?php $total = 0; ?>

                            @foreach($d as $dd)

                                @if(@$dd->created_at->format('m') == 4)

                                <?php $total+=(int)(@$dd->detail_bbk->harga+@$dd->camp_lama->harga)*@$dd->jumlah; ?>

                                @endif

                            @endforeach

                            <td>Rp.{{ number_format($total) }}</td>

                            <?php $total_row += $total; ?>

                            <?php $total_col[3] += $total; ?>

                            <?php $total = 0; ?>

                            @foreach($d as $dd)

                                @if(@$dd->created_at->format('m') == 5)

                                <?php $total+=(int)(@$dd->detail_bbk->harga+@$dd->camp_lama->harga)*@$dd->jumlah; ?>

                                @endif

                            @endforeach

                            <td>Rp.{{ number_format($total) }}</td>

                            <?php $total_row += $total; ?>

                            <?php $total_col[4] += $total; ?>

                            <?php $total = 0; ?>

                            @foreach($d as $dd)

                                @if(@$dd->created_at->format('m') == 6)

                                <?php $total+=(int)(@$dd->detail_bbk->harga+@$dd->camp_lama->harga)*@$dd->jumlah; ?>

                                @endif

                            @endforeach

                            <td>Rp.{{ number_format($total) }}</td>

                            <?php $total_row += $total; ?>

                            <?php $total_col[5] += $total; ?>

                            <?php $total = 0; ?>

                            @foreach($d as $dd)

                                @if(@$dd->created_at->format('m') == 7)

                                <?php $total+=(int)(@$dd->detail_bbk->harga+@$dd->camp_lama->harga)*@$dd->jumlah; ?>

                                @endif

                            @endforeach

                            <td>Rp.{{ number_format($total) }}</td>

                            <?php $total_row += $total; ?>

                            <?php $total_col[6] += $total; ?>

                            <?php $total = 0; ?>

                            @foreach($d as $dd)

                                @if(@$dd->created_at->format('m') == 8)

                                <?php $total+=(int)(@$dd->detail_bbk->harga+@$dd->camp_lama->harga)*@$dd->jumlah; ?>

                                @endif

                            @endforeach

                            <td>Rp.{{ number_format($total) }}</td>

                            <?php $total_row += $total; ?>

                            <?php $total_col[7] += $total; ?>

                            <?php $total = 0; ?>

                            @foreach($d as $dd)

                                @if(@$dd->created_at->format('m') == 9)

                                <?php $total+=(int)(@$dd->detail_bbk->harga+@$dd->camp_lama->harga)*@$dd->jumlah; ?>

                                @endif

                            @endforeach

                            <td>Rp.{{ number_format($total) }}</td>

                            <?php $total_row += $total; ?>

                            <?php $total_col[8] += $total; ?>

                            <?php $total = 0; ?>

                            @foreach($d as $dd)

                                @if(@$dd->created_at->format('m') == 10)

                                <?php $total+=(int)(@$dd->detail_bbk->harga+@$dd->camp_lama->harga)*@$dd->jumlah; ?>

                                @endif

                            @endforeach

                            <td>Rp.{{ number_format($total) }}</td>

                            <?php $total_row += $total; ?>

                            <?php $total_col[9] += $total; ?>

                            <?php $total = 0; ?>

                            @foreach($d as $dd)

                                @if(@$dd->created_at->format('m') == 11)

                                <?php $total+=(int)(@$dd->detail_bbk->harga+@$dd->camp_lama->harga)*@$dd->jumlah; ?>

                                @endif

                            @endforeach

                            <td>Rp.{{ number_format($total) }}</td>

                            <?php $total_row += $total; ?>

                            <?php $total_col[10] += $total; ?>

                            <?php $total = 0; ?>

                            @foreach($d as $dd)

                                @if(@$dd->created_at->format('m') == 12)

                                <?php $total+=(int)(@$dd->detail_bbk->harga+@$dd->camp_lama->harga)*@$dd->jumlah; ?>

                                @endif

                            @endforeach

                            <td>Rp.{{ number_format($total) }}</td> 

                            <?php $total_row += $total; ?>

                            <?php $total_col[11] += $total; ?>

                            <?php $total_col[12] += $total_row; ?>

                            <td>Rp.{{ number_format($total_row) }}</td>

                            @if( $detail->barang->unit->operator != null )

                            <td>{{ $detail->barang->unit->operator }}</td>

                            @else

                            <td> - </td>

                            @endif



                        </tr>

                        <?php $total_semua += $total; ?>

                    @else

                        <tr>

                            <td>{{ $no++ }}</td>

                            <td><?php $db = \App\DetailPemesananBarang::where('gabungan','like','%'.@$detail->gabungan_id.'%')->get();?>

                                <?php if(@$detail->detail_bbk->detail_bbm->detail_pemesanan->nama_barang != null){ echo @$detail->detail_bbk->detail_bbm->detail_pemesanan->barang->unit->jenis_unit->nama; } else if(@$detail->camp_lama->barang == null) { echo @$detail->barang->nama; } else if(@$detail->detail_bbk == null ){ echo @$detail->camp_lama->barang->unit->jenis_unit->nama;}?> 

                                                    

                             {{ @$detail->barang->unit->nama }}</td>

                            <td>{{ @$detail->barang->unit->kode }}</td>

                            
                            <!-- list total 2 -->
                            <?php $d = DetailPemakaianBarang::whereHas('pemakaian',function ($q) use ($tahun) {

                                $q->whereYear('tanggal',$tahun);

                            })->whereHas('barang', function ($q) use ($detail){
                                $q->where('unit_id', @$detail->barang->unit->id);
                            })->get()->toBase()->merge(DetailPemakaianBarangLama::whereHas('pemakaian',function ($q) use ($tahun) {

                                $q->whereYear('tanggal',$tahun);

                            })->whereHas('barang', function ($q) use ($detail){
                                $q->where('unit_id', @$detail->barang->unit->id);
                            })->get());$total = 0; ?>

                            <?php $total = 0; ?>

                            @foreach($d as $dd)

                                @if(@$dd->created_at->format('m') == 1)

                                <?php $total+=(int)(@$dd->detail_bbk->harga+@$dd->camp_lama->harga)*@$dd->jumlah; ?>

                                @endif

                            @endforeach

                            <td>Rp.{{ number_format($total) }}</td>

                            <?php $total_row += $total; ?>

                            <?php $total_col[0] += $total; ?>

                            <?php $total = 0; ?>

                            @foreach($d as $dd)

                                @if(@$dd->created_at->format('m') == 2)

                                <?php $total+=(int)(@$dd->detail_bbk->harga+@$dd->camp_lama->harga)*@$dd->jumlah; ?>

                                @endif

                            @endforeach

                            <td>Rp.{{ number_format($total) }}</td>

                            <?php $total_row += $total; ?>

                            <?php $total_col[1] += $total; ?>

                            <?php $total = 0; ?>

                            @foreach($d as $dd)

                                @if(@$dd->created_at->format('m') == 3)

                                <?php $total+=(int)(@$dd->detail_bbk->harga+@$dd->camp_lama->harga)*@$dd->jumlah; ?>

                                @endif

                            @endforeach

                            <td>Rp.{{ number_format($total) }}</td>

                            <?php $total_row += $total; ?>

                            <?php $total_col[2] += $total; ?>

                            <?php $total = 0; ?>

                            @foreach($d as $dd)

                                @if(@$dd->created_at->format('m') == 4)

                                <?php $total+=(int)(@$dd->detail_bbk->harga+@$dd->camp_lama->harga)*@$dd->jumlah; ?>

                                @endif

                            @endforeach

                            <td>Rp.{{ number_format($total) }}</td>

                            <?php $total_row += $total; ?>

                            <?php $total_col[3] += $total; ?>

                            <?php $total = 0; ?>

                            @foreach($d as $dd)

                                @if(@$dd->created_at->format('m') == 5)

                                <?php $total+=(int)(@$dd->detail_bbk->harga+@$dd->camp_lama->harga)*@$dd->jumlah; ?>

                                @endif

                            @endforeach

                            <td>Rp.{{ number_format($total) }}</td>

                            <?php $total_row += $total; ?>

                            <?php $total_col[4] += $total; ?>

                            <?php $total = 0; ?>

                            @foreach($d as $dd)

                                @if(@$dd->created_at->format('m') == 6)

                                <?php $total+=(int)(@$dd->detail_bbk->harga+@$dd->camp_lama->harga)*@$dd->jumlah; ?>

                                @endif

                            @endforeach

                            <td>Rp.{{ number_format($total) }}</td>

                            <?php $total_row += $total; ?>

                            <?php $total_col[5] += $total; ?>

                            <?php $total = 0; ?>

                            @foreach($d as $dd)

                                @if(@$dd->created_at->format('m') == 7)

                                <?php $total+=(int)(@$dd->detail_bbk->harga+@$dd->camp_lama->harga)*@$dd->jumlah; ?>

                                @endif

                            @endforeach

                            <td>Rp.{{ number_format($total) }}</td>

                            <?php $total_row += $total; ?>

                            <?php $total_col[6] += $total; ?>

                            <?php $total = 0; ?>

                            @foreach($d as $dd)

                                @if(@$dd->created_at->format('m') == 8)

                                <?php $total+=(int)(@$dd->detail_bbk->harga+@$dd->camp_lama->harga)*@$dd->jumlah; ?>

                                @endif

                            @endforeach

                            <td>Rp.{{ number_format($total) }}</td>

                            <?php $total_row += $total; ?>

                            <?php $total_col[7] += $total; ?>

                            <?php $total = 0; ?>

                            @foreach($d as $dd)

                                @if(@$dd->created_at->format('m') == 9)

                                <?php $total+=(int)(@$dd->detail_bbk->harga+@$dd->camp_lama->harga)*@$dd->jumlah; ?>

                                @endif

                            @endforeach

                            <td>Rp.{{ number_format($total) }}</td>

                            <?php $total_row += $total; ?>

                            <?php $total_col[8] += $total; ?>

                            <?php $total = 0; ?>

                            @foreach($d as $dd)

                                @if(@$dd->created_at->format('m') == 10)

                                <?php $total+=(int)(@$dd->detail_bbk->harga+@$dd->camp_lama->harga)*@$dd->jumlah; ?>

                                @endif

                            @endforeach

                            <td>Rp.{{ number_format($total) }}</td>

                            <?php $total_row += $total; ?>

                            <?php $total_col[9] += $total; ?>

                            <?php $total = 0; ?>

                            @foreach($d as $dd)

                                @if(@$dd->created_at->format('m') == 11)

                                <?php $total+=(int)(@$dd->detail_bbk->harga+@$dd->camp_lama->harga)*@$dd->jumlah; ?>

                                @endif

                            @endforeach

                            <td>Rp.{{ number_format($total) }}</td>

                            <?php $total_row += $total; ?>

                            <?php $total_col[10] += $total; ?>

                            <?php $total = 0; ?>

                            @foreach($d as $dd)

                                @if(@$dd->created_at->format('m') == 12)

                                <?php $total+=(int)(@$dd->detail_bbk->harga+@$dd->camp_lama->harga)*@$dd->jumlah; ?>

                                @endif

                            @endforeach

                            <td>Rp.{{ number_format($total) }}</td> 

                            <?php $total_row += $total; ?>

                            <?php $total_col[11] += $total; ?>

                            <?php $total_col[12] += $total_row; ?>

                            <td>Rp.{{ number_format($total_row) }}</td>

                            <td></td>

                        </tr>

                        <?php $total_semua += $total_row; ?>



                        

                    @endif

                    @if(($no-1) == $sub)

                        <tr>    

                            <td colspan="2">Sub Total</td>

                            <td></td>

                            <td>Rp.{{ number_format($total_col[0]) }}</td>

                            <td>Rp.{{ number_format($total_col[1]) }}</td>

                            <td>Rp.{{ number_format($total_col[2]) }}</td>

                            <td>Rp.{{ number_format($total_col[3]) }}</td>

                            <td>Rp.{{ number_format($total_col[4]) }}</td>

                            <td>Rp.{{ number_format($total_col[5]) }}</td>

                            <td>Rp.{{ number_format($total_col[6]) }}</td>

                            <td>Rp.{{ number_format($total_col[7]) }}</td>

                            <td>Rp.{{ number_format($total_col[8]) }}</td>

                            <td>Rp.{{ number_format($total_col[9]) }}</td>

                            <td>Rp.{{ number_format($total_col[10]) }}</td>

                            <td>Rp.{{ number_format($total_col[11]) }}</td>

                            <td>Rp.{{ number_format($total_col[12]) }}</td>

                            <td></td>

                        </tr>

                        

                    @endif
                    <?php for ($i=0; $i < count($total_col); $i++) { 

                                $grand_col[$i] += $total_col[$i];

                            } ?>
            @endif
            @endif
            @endforeach

            <tr style="border:none;">

                <td style="border:none;" colspan="17"></td>

            </tr>

              <tr>

                <td colspan="2">Grand Total</td>

                <td></td>

                <td>Rp.{{ number_format($grand_col[0]) }}</td>

                <td>Rp.{{ number_format($grand_col[1]) }}</td>

                <td>Rp.{{ number_format($grand_col[2]) }}</td>

                <td>Rp.{{ number_format($grand_col[3]) }}</td>

                <td>Rp.{{ number_format($grand_col[4]) }}</td>

                <td>Rp.{{ number_format($grand_col[5]) }}</td>

                <td>Rp.{{ number_format($grand_col[6]) }}</td>

                <td>Rp.{{ number_format($grand_col[7]) }}</td>

                <td>Rp.{{ number_format($grand_col[8]) }}</td>

                <td>Rp.{{ number_format($grand_col[9]) }}</td>

                <td>Rp.{{ number_format($grand_col[10]) }}</td>

                <td>Rp.{{ number_format($grand_col[11]) }}</td>

                <td>Rp.{{ number_format($grand_col[12]) }}</td>

                <td></td>

            </tr>          

        </table>

      

        <br>

        <br>

        @if( isset($diketahui) || isset($diketahui))

        <table style="width: 100%;text-align: center;">

            <tr>

                        <td colspan="2" style="text-align: right;">BC Bunut-Pana'an, {{ date('d F Y') }}</td>

                      </tr>

                      <tr><td><br><br></td></tr>

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

        @endif

       

    </div>

</div>

</body>

</html>

