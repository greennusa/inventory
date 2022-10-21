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

<body onload="window.print()">

    

    <div class="container">

        <br>

        <br>

        <center>

            <p class="ok">PT. UTAMA DAMAI INDAH TIMBER</p><br>  

            <h5>LAPORAN PEMAKAIAN SPARE PART & PERLENGKAPAN LAINNYA</h5>



            <u>PERIODE BULAN <?php echo $bulannya[$from]; ?> <?php echo $tahun; ?></u>

        </center>

        <br>

        <?php 

            use App\Barang;

            use App\DetailPemakaianBarang;

            use App\Camp;

            use App\User;

            use App\Unit;

            use App\DetailPemakaianBarangLama;

            $diketahui = User::findOrFail($_GET['diketahui']);

            $disetujui_1 = User::findOrFail($_GET['disetujui_1']);

            // $disetujui_2_1 = User::findOrFail($_GET['disetujui_2'][0]);

            // $disetujui_2_2 = User::findOrFail($_GET['disetujui_2'][1]);

            $dibuat = User::findOrFail($_GET['dibuat']);

            $camps = Camp::all();

            $units = Unit::orderBy('kode','ASC')->orderBY('jenis_unit_id','ASC')->get();

            $kategori = '';

            $no = 1;

            

            // $to = date('m',strtotime($_GET['tanggal2']));

            $details = DetailPemakaianBarang::whereHas('barang', function($q){
                $q->where('kategori_id','!=',40);  
            })->get();

            $c = DetailPemakaianBarangLama::whereHas('barang', function($q){
                $q->where('kategori_id','!=',40);  
            })->get();

            $x = $details->toBase()->merge($c);

            $total_semua = 0;



        ?>

        <table class="table table-bordered table-hover">

            <tr>
                <td colspan="5"><strong>A. Unit Tractor Produksi</strong></td>
            </tr>
            <?php $no = 1; ?>
            @foreach($units as $u)
            @if($u->jenis_unit->id == 26 || $u->jenis_unit->id == 7)
            <?php $total = 0; ?>
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $u->jenis_unit->nama }}</td>
                <td>{{ $u->kode }}</td>
                <?php 
                    $d = DetailPemakaianBarang::whereHas('pemakaian',function ($q) use ($from,$tahun,$u) {
                    $q->where('unit_id', $u->id)->whereMonth('tanggal',$from)->whereYear('tanggal',$tahun);})->whereHas('barang', function($q){
                $q->where('kategori_id','!=',40);  
            })->get();
                    
                    $dl = DetailPemakaianBarangLama::whereHas('pemakaian',function ($q) use ($from,$tahun,$u) {
                    $q->where('unit_id', $u->id)->whereMonth('tanggal',$from)->whereYear('tanggal',$tahun);})->whereHas('barang', function($q){
                $q->where('kategori_id','!=',40);  
            })->get();  
                    
                    $dll = $d->toBase()->merge($dl);
                ?>

                @foreach($dll as $dd)

                                <?php $total+=(int)(@$dd->detail_bbk->harga*$dd->jumlah)+(@$dd->camp_lama->harga*$dd->jumlah); ?>

                @endforeach
                <td>Rp.</td>
                <td>{{ number_format($total) }}</td>
                <?php $total_semua += $total; ?>
            </tr>
            @endif
            @endforeach



            <tr>
                <td colspan="5"><strong>B. Unit Tractor Penunjang</strong></td>
            </tr>
            <?php $no = 1; ?>
            @foreach($units as $u)
            @if($u->jenis_unit->id == 27 || $u->jenis_unit->id == 28 || $u->jenis_unit->id == 49 || $u->jenis_unit->id == 31 || $u->jenis_unit->id == 51 || $u->jenis_unit->id == 30 || $u->jenis_unit->id == 29)
            <?php $total = 0; ?>
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $u->jenis_unit->nama }}</td>
                <td>{{ $u->kode }}</td>
                <?php 
                    $d = DetailPemakaianBarang::whereHas('pemakaian',function ($q) use ($from,$tahun,$u) {
                    $q->where('unit_id', $u->id)->whereMonth('tanggal',$from)->whereYear('tanggal',$tahun);})->whereHas('barang', function($q){
                $q->where('kategori_id','!=',40);  
            })->get();
                    
                    $dl = DetailPemakaianBarangLama::whereHas('pemakaian',function ($q) use ($from,$tahun,$u) {
                    $q->where('unit_id', $u->id)->whereMonth('tanggal',$from)->whereYear('tanggal',$tahun);})->whereHas('barang', function($q){
                $q->where('kategori_id','!=',40);  
            })->get();  
                    
                    $dll = $d->toBase()->merge($dl);
                ?>

                @foreach($dll as $dd)

                                <?php $total+=(int)(@$dd->detail_bbk->harga*$dd->jumlah)+(@$dd->camp_lama->harga*$dd->jumlah); ?>

                @endforeach
                <td>Rp.</td>
                <td>{{ number_format($total) }}</td>
                <?php $total_semua += $total; ?>
            </tr>
            @endif
            @endforeach




            <tr>
                <td colspan="5"><strong>C. Unit Logging Produksi</strong></td>
            </tr>
            <?php $no = 1; ?>
            @foreach($units as $u)
            @if($u->jenis_unit->id == 33 || $u->jenis_unit->id == 34)
            <?php $total = 0; ?>
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $u->jenis_unit->nama }}</td>
                <td>{{ $u->kode }}</td>
                <?php 
                    $d = DetailPemakaianBarang::whereHas('pemakaian',function ($q) use ($from,$tahun,$u) {
                    $q->where('unit_id', $u->id)->whereMonth('tanggal',$from)->whereYear('tanggal',$tahun);})->whereHas('barang', function($q){
                $q->where('kategori_id','!=',40);  
            })->get();
                    
                    $dl = DetailPemakaianBarangLama::whereHas('pemakaian',function ($q) use ($from,$tahun,$u) {
                    $q->where('unit_id', $u->id)->whereMonth('tanggal',$from)->whereYear('tanggal',$tahun);})->whereHas('barang', function($q){
                $q->where('kategori_id','!=',40);  
            })->get();  
                    
                    $dll = $d->toBase()->merge($dl);
                ?>

                @foreach($dll as $dd)

                                <?php $total+=(int)(@$dd->detail_bbk->harga*$dd->jumlah)+(@$dd->camp_lama->harga*$dd->jumlah); ?>

                @endforeach
                <td>Rp.</td>
                <td>{{ number_format($total) }}</td>
                <?php $total_semua += $total; ?>
            </tr>
            @endif
            @endforeach



            <tr>
                <td colspan="5"><strong>D. Unit Logging Penunjang</strong></td>
            </tr>
            <?php $no = 1; ?>
            @foreach($units as $u)
            @if($u->jenis_unit->id == 36 || $u->jenis_unit->id == 21 || $u->jenis_unit->id == 53 || $u->jenis_unit->id == 52 || $u->jenis_unit->id == 35 || $u->jenis_unit->id == 37 || $u->jenis_unit->id == 54 || $u->jenis_unit->id == 42 || $u->jenis_unit->id == 39 || $u->jenis_unit->id == 38 || $u->jenis_unit->id == 60 || $u->jenis_unit->id == 25 || $u->jenis_unit->id == 24 || $u->jenis_unit->id == 17 || $u->jenis_unit->id == 18)
            <?php $total = 0; ?>
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $u->jenis_unit->nama }}</td>
                <td>{{ $u->kode }}</td>
                <?php 
                    $d = DetailPemakaianBarang::whereHas('pemakaian',function ($q) use ($from,$tahun,$u) {
                    $q->where('unit_id', $u->id)->whereMonth('tanggal',$from)->whereYear('tanggal',$tahun);})->whereHas('barang', function($q){
                $q->where('kategori_id','!=',40);  
            })->get();
                    
                    $dl = DetailPemakaianBarangLama::whereHas('pemakaian',function ($q) use ($from,$tahun,$u) {
                    $q->where('unit_id', $u->id)->whereMonth('tanggal',$from)->whereYear('tanggal',$tahun);})->whereHas('barang', function($q){
                $q->where('kategori_id','!=',40);  
            })->get();  
                    
                    $dll = $d->toBase()->merge($dl);
                ?>

                @foreach($dll as $dd)

                                <?php $total+=(int)(@$dd->detail_bbk->harga*$dd->jumlah)+(@$dd->camp_lama->harga*$dd->jumlah); ?>

                @endforeach
                <td>Rp.</td>
                <td>{{ number_format($total) }}</td>
                <?php $total_semua += $total; ?>
            </tr>
            @endif
            @endforeach





            

            <?php $total_workshop = 0 ?>
            <?php $no = 1; ?>
            @foreach($units as $u)
            @if($u->jenis_unit->id == 44 || $u->jenis_unit->id == 45 || $u->jenis_unit->id == 23 || $u->jenis_unit->id == 59 || $u->jenis_unit->id == 57 || $u->jenis_unit->id == 55 || $u->jenis_unit->id == 56)
            <?php $total = 0; ?>
           
                <?php 
                    $d = DetailPemakaianBarang::whereHas('pemakaian',function ($q) use ($from,$tahun,$u) {
                    $q->where('unit_id', $u->id)->whereMonth('tanggal',$from)->whereYear('tanggal',$tahun);})->whereHas('barang', function($q){
                $q->where('kategori_id','!=',40);  
            })->get();
                    
                    $dl = DetailPemakaianBarangLama::whereHas('pemakaian',function ($q) use ($from,$tahun,$u) {
                    $q->where('unit_id', $u->id)->whereMonth('tanggal',$from)->whereYear('tanggal',$tahun);})->whereHas('barang', function($q){
                $q->where('kategori_id','!=',40);  
            })->get();  
                    
                    $dll = $d->toBase()->merge($dl);
                ?>

                @foreach($dll as $dd)

                                <?php $total+=(int)(@$dd->detail_bbk->harga*$dd->jumlah)+(@$dd->camp_lama->harga*$dd->jumlah); ?>

                @endforeach

                
                <?php $total_semua += $total; $total_workshop += $total ?>
            
            @endif
            @endforeach
            <tr>
                <td colspan="5"><strong>D. Unit Workshop & Bengkel</strong></td>
            </tr>

            <tr>
                <td>{{$no}}</td>
                <td colspan="2">Workshop, Kantor & Bengkel</td>
                <td>Rp.</td>
                <td>{{ number_format($total_workshop) }}</td>
            </tr>

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

                        <td colspan="4" style="text-align: right;">Camp Bunut, {{ date('d F Y') }}</td>

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

