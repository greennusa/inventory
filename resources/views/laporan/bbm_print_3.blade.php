<?php 

        $from = (int)date('m',strtotime($_GET['tanggal']));

        $tahun = date('Y',strtotime($_GET['tanggal']));

        $bulannya = ['array_bulan','JANUARI','FEBRUARI','MARET','APRIL','MEI','JUNI','JULI','AGUSTUS','SEPTEMBER','NOVEMBER','OKTOBER','DESEMBER']; 

        $penggunaan = ['Skidding','Road Counstruction','Produksi','Penimbunan','Penunjang','Alkon + Genset','PMDH/Umum','Mutasi'];

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

    

    <div class="col">

        <br>

        <br>

        <center>

            <p class="ok">PT. UTAMA DAMAI INDAH TIMBER</p><br>  

            <h5>LAPORAN PEMAKAIAN BBM DAN PELUMAS, SKIDDING, ROAD CONSTRUCTION, PRODUKSI DLL</h5>



            <u>PERIODE BULAN <?php echo $bulannya[$from]; ?> <?php echo $tahun; ?></u>

        </center>

        <br>

        <?php 

            use App\Barang;

            use App\DetailPemakaianBarang;

            use App\Camp;

            use App\User;

            use App\DetailPemakaianBarangLama;

            use App\PemakaianBarang;

            use App\Unit;

            if (isset($_GET['diketahui'])) {
                $diketahui = User::find($_GET['diketahui']);
            }
            
            if (isset($_GET['disetujui_1'])) {
                $disetujui_1 = User::find($_GET['disetujui_1']);
            }
            

            // $disetujui_2_1 = User::findOrFail($_GET['disetujui_2'][0]);

            // $disetujui_2_2 = User::findOrFail($_GET['disetujui_2'][1]);

            if (isset($_GET['dibuat'])) {
                $dibuat = User::find($_GET['dibuat']);
            }
            

            $camps = Camp::all();

            $unit = Unit::whereHas('pemakaian')->get();

            $kategori = '';

            

            

            // $to = date('m',strtotime($_GET['tanggal2']));

            $barang = Barang::where('kategori_id', 40)->get();

            $details = DetailPemakaianBarang::with('pemakaian')->get();

            $c = DetailPemakaianBarangLama::with('pemakaian')->get();

            $x = $details->toBase()->merge($c)->sortBy(function($user, $key)
    {
        return $user->pemakaian->unit->kode;
    });

            $z = PemakaianBarang::all();

            $total_semua = 0;

            $total = array(); 
            for($k = 0; $k < count($barang); $k++){
                $total[$k] = 0 ;
            }

        ?>

        <table class="table table-bordered table-hover">

            <tr>

            <th>No.</th>

            <th>Kode Unit</th>

            <th>Jenis Unit</th>

            @foreach($barang as $b)

                <th>{{ $b->nama }}</th>

            @endforeach

            </tr>

            
            <?php $no = 1; ?>
            <tr><td><strong>Skidding</strong></td></tr>

            @foreach($unit as $u)
            @if($u->jenis_unit_id == 26 || $u->jenis_unit_id == 7)
            <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $u->kode }}</td>
            <td>{{ $u->jenis_unit->nama }}</td>

                @for($j = 0; $j < count($barang); $j++)

                <?php  
                $jumlah = DetailPemakaianBarang::whereHas('barang',function ($q) use ($from,$tahun,$u,$barang,$j) {
                    $q->where('barang_id', $barang[$j]->id);})->whereHas('pemakaian', function ($q) use ($from,$tahun,$u,$penggunaan){
                        $q->whereMonth('tanggal',$from)->whereYear('tanggal',$tahun)->where('penggunaan', $penggunaan[0])->where('unit_id',$u->id);
                    })->sum('jumlah');
                
                $jumlahLama = DetailPemakaianBarangLama::whereHas('barang',function ($q) use ($from,$tahun,$u,$barang,$j) {
                    $q->where('barang_id', $barang[$j]->id);})->whereHas('pemakaian', function ($q) use ($from,$tahun,$u,$penggunaan){
                        $q->whereMonth('tanggal',$from)->whereYear('tanggal',$tahun)->where('penggunaan', $penggunaan[0])->where('unit_id',$u->id);
                    })->sum('jumlah');
                
                $total[$j] += $jumlah + $jumlahLama;
                ?>

                

                <td> 
                    @if($jumlah != 0 || $jumlahLama != 0) {{number_format($jumlah + $jumlahLama)}}
                    @elseif($jumlahLama + $jumlah == 0)
                        -
                    @endif 
                </td>

                @endfor

            </tr>
            @endif
            @endforeach
            
            <tr>
                <td colspan="3">Total</td>
                @for($l = 0; $l < count($total);$l++)
                
                <td> 
                    @if(!isset($total[$l]) || $total[$l] == 0) 
                        0 
                    @elseif(isset($total[$l])) {{number_format($total[$l])}} 
                    @endif 
                </td>
                @endfor
            </tr>
            
            <?php
                $total = array_map(function($val) { return 0; }, $total);
            ?>
            <tr><td><strong>Road Construction</strong></td></tr>

            @foreach($unit as $u)
            @if($u->jenis_unit_id == 26 || $u->jenis_unit_id == 7)
            <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $u->kode }}</td>
            <td>{{ $u->jenis_unit->nama }}</td>

                @for($j = 0; $j < count($barang); $j++)

                <?php  
                $jumlah = DetailPemakaianBarang::whereHas('barang',function ($q) use ($from,$tahun,$u,$barang,$j) {
                    $q->where('barang_id', $barang[$j]->id);})->whereHas('pemakaian', function ($q) use ($from,$tahun,$u,$penggunaan){
                        $q->whereMonth('tanggal',$from)->whereYear('tanggal',$tahun)->where('penggunaan', $penggunaan[1])->where('unit_id',$u->id);
                    })->sum('jumlah');
                $jumlahLama = DetailPemakaianBarangLama::whereHas('barang',function ($q) use ($from,$tahun,$u,$barang,$j) {
                    $q->where('barang_id', $barang[$j]->id);})->whereHas('pemakaian', function ($q) use ($from,$tahun,$u,$penggunaan){
                        $q->whereMonth('tanggal',$from)->whereYear('tanggal',$tahun)->where('penggunaan', $penggunaan[1])->where('unit_id',$u->id);
                    })->sum('jumlah');
                
                $total[$j] += $jumlah + $jumlahLama;
                ?>

                

                <td> 
                    @if($jumlah != 0 || $jumlahLama != 0) {{number_format($jumlah + $jumlahLama)}}
                    @elseif($jumlahLama + $jumlah == 0)
                        -
                    @endif 
                </td>
                @endfor

            </tr>
            @endif
            @endforeach

            <tr>
                <td colspan="3">Total</td>
                @for($l = 0; $l < count($total);$l++)
                
                <td> 
                    @if(!isset($total[$l]) || $total[$l] == 0) 
                        0 
                    @elseif(isset($total[$l])) {{number_format($total[$l])}} 
                    @endif 
                </td>
                @endfor
            </tr>
            
            <?php
                $total = array_map(function($val) { return 0; }, $total);
            ?>
            
            <tr><td><strong>Produksi</strong></td></tr>

            @foreach($unit as $u)
            @if($u->jenis_unit_id == 27 || $u->jenis_unit_id == 49 || $u->jenis_unit_id == 50 || $u->jenis_unit_id == 31 || $u->jenis_unit_id == 33)
            <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $u->kode }}</td>
            <td>{{ $u->jenis_unit->nama }}</td>

                @for($j = 0; $j < count($barang); $j++)

                <?php  
                $jumlah = DetailPemakaianBarang::whereHas('barang',function ($q) use ($from,$tahun,$u,$barang,$j) {
                    $q->where('barang_id', $barang[$j]->id);})->whereHas('pemakaian', function ($q) use ($from,$tahun,$u,$penggunaan){
                        $q->whereMonth('tanggal',$from)->whereYear('tanggal',$tahun)->where('penggunaan', $penggunaan[2])->where('unit_id',$u->id);
                    })->sum('jumlah');
                $jumlahLama = DetailPemakaianBarangLama::whereHas('barang',function ($q) use ($from,$tahun,$u,$barang,$j) {
                    $q->where('barang_id', $barang[$j]->id);})->whereHas('pemakaian', function ($q) use ($from,$tahun,$u,$penggunaan){
                        $q->whereMonth('tanggal',$from)->whereYear('tanggal',$tahun)->where('penggunaan', $penggunaan[2])->where('unit_id',$u->id);
                    })->sum('jumlah');
                
                $total[$j] += $jumlah + $jumlahLama;
                ?>

                

                <td> 
                    @if($jumlah != 0 || $jumlahLama != 0) {{number_format($jumlah + $jumlahLama)}}
                    @elseif($jumlahLama + $jumlah == 0)
                        -
                    @endif 
                </td>
                @endfor

            </tr>
            @endif
            @endforeach

            <tr>
                <td colspan="3">Total</td>
                @for($l = 0; $l < count($total);$l++)
                
                <td> 
                    @if(!isset($total[$l]) || $total[$l] == 0) 
                        0 
                    @elseif(isset($total[$l])) {{number_format($total[$l])}} 
                    @endif 
                </td>
                @endfor
            </tr>
            
            <?php
                $total = array_map(function($val) { return 0; }, $total);
            ?>
            
            <tr><td><strong>Penimbunan</strong></td></tr>

            @foreach($unit as $u)
            @if($u->jenis_unit_id == 51 || $u->jenis_unit_id == 21 || $u->jenis_unit_id == 52 || $u->jenis_unit_id == 53 || $u->jenis_unit_id == 36 || $u->jenis_unit_id == 29 || $u->jenis_unit_id == 30)
            <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $u->kode }}</td>
            <td>{{ $u->jenis_unit->nama }}</td>

                @for($j = 0; $j < count($barang); $j++)

                <?php  
                $jumlah = DetailPemakaianBarang::whereHas('barang',function ($q) use ($from,$tahun,$u,$barang,$j) {
                    $q->where('barang_id', $barang[$j]->id);})->whereHas('pemakaian', function ($q) use ($from,$tahun,$u,$penggunaan){
                        $q->whereMonth('tanggal',$from)->whereYear('tanggal',$tahun)->where('penggunaan', $penggunaan[3])->where('unit_id',$u->id);
                    })->sum('jumlah');
                $jumlahLama = DetailPemakaianBarangLama::whereHas('barang',function ($q) use ($from,$tahun,$u,$barang,$j) {
                    $q->where('barang_id', $barang[$j]->id);})->whereHas('pemakaian', function ($q) use ($from,$tahun,$u,$penggunaan){
                        $q->whereMonth('tanggal',$from)->whereYear('tanggal',$tahun)->where('penggunaan', $penggunaan[3])->where('unit_id',$u->id);
                    })->sum('jumlah');
                
                $total[$j] += $jumlah + $jumlahLama;
                ?>

                

                <td> 
                    @if($jumlah != 0 || $jumlahLama != 0) {{number_format($jumlah + $jumlahLama)}}
                    @elseif($jumlahLama + $jumlah == 0)
                        -
                    @endif 
                </td>
                @endfor

            </tr>
            @endif
            @endforeach
            
            <tr>
                <td colspan="3">Total</td>
                @for($l = 0; $l < count($total);$l++)
                
                <td> 
                    @if(!isset($total[$l]) || $total[$l] == 0) 
                        0 
                    @elseif(isset($total[$l])) {{number_format($total[$l])}} 
                    @endif 
                </td>
                @endfor
            </tr>
            
            <?php
                $total = array_map(function($val) { return 0; }, $total);
            ?>

            <tr><td><strong>Penunjang</strong></td></tr>

            @foreach($unit as $u)
            @if($u->jenis_unit_id == 35 || $u->jenis_unit_id == 38 || $u->jenis_unit_id == 24 || $u->jenis_unit_id == 17 || $u->jenis_unit_id == 39 || $u->jenis_unit_id == 54 || $u->jenis_unit_id == 60 || $u->jenis_unit_id == 18 || $u->jenis_unit_id == 42 || $u->jenis_unit_id == 25)
            <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $u->kode }}</td>
            <td>{{ $u->jenis_unit->nama }}</td>

                @for($j = 0; $j < count($barang); $j++)

                <?php  
                $jumlah = DetailPemakaianBarang::whereHas('barang',function ($q) use ($from,$tahun,$u,$barang,$j) {
                    $q->where('barang_id', $barang[$j]->id);})->whereHas('pemakaian', function ($q) use ($from,$tahun,$u,$penggunaan){
                        $q->whereMonth('tanggal',$from)->whereYear('tanggal',$tahun)->where('penggunaan', $penggunaan[4])->where('unit_id',$u->id);
                    })->sum('jumlah');
                $jumlahLama = DetailPemakaianBarangLama::whereHas('barang',function ($q) use ($from,$tahun,$u,$barang,$j) {
                    $q->where('barang_id', $barang[$j]->id);})->whereHas('pemakaian', function ($q) use ($from,$tahun,$u,$penggunaan){
                        $q->whereMonth('tanggal',$from)->whereYear('tanggal',$tahun)->where('penggunaan', $penggunaan[4])->where('unit_id',$u->id);
                    })->sum('jumlah');
                
                $total[$j] += $jumlah + $jumlahLama;
                ?>

                

                <td> 
                    @if($jumlah != 0 || $jumlahLama != 0) {{number_format($jumlah + $jumlahLama)}}
                    @elseif($jumlahLama + $jumlah == 0)
                        -
                    @endif 
                </td>
                @endfor

            </tr>
            @endif
            @endforeach
            
            <tr>
                <td colspan="3">Total</td>
                @for($l = 0; $l < count($total);$l++)
                
                <td> 
                    @if(!isset($total[$l]) || $total[$l] == 0) 
                        0 
                    @elseif(isset($total[$l])) {{number_format($total[$l])}} 
                    @endif 
                </td>
                @endfor
            </tr>
            
            <?php
                $total = array_map(function($val) { return 0; }, $total);
            ?>
            
            <tr><td><strong>Alkon + Genset</strong></td></tr>

            @foreach($unit as $u)
            @if($u->jenis_unit_id == 45)
            <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $u->kode }}</td>
            <td>{{ $u->jenis_unit->nama }}</td>

                @for($j = 0; $j < count($barang); $j++)

                <?php  
                $jumlah = DetailPemakaianBarang::whereHas('barang',function ($q) use ($from,$tahun,$u,$barang,$j) {
                    $q->where('barang_id', $barang[$j]->id);})->whereHas('pemakaian', function ($q) use ($from,$tahun,$u,$penggunaan){
                        $q->whereMonth('tanggal',$from)->whereYear('tanggal',$tahun)->where('penggunaan', $penggunaan[5])->where('unit_id',$u->id);
                    })->sum('jumlah');
                $jumlahLama = DetailPemakaianBarangLama::whereHas('barang',function ($q) use ($from,$tahun,$u,$barang,$j) {
                    $q->where('barang_id', $barang[$j]->id);})->whereHas('pemakaian', function ($q) use ($from,$tahun,$u,$penggunaan){
                        $q->whereMonth('tanggal',$from)->whereYear('tanggal',$tahun)->where('penggunaan', $penggunaan[5])->where('unit_id',$u->id);
                    })->sum('jumlah');
                
                $total[$j] += $jumlah + $jumlahLama;
                ?>

                

                <td> 
                    @if($jumlah != 0 || $jumlahLama != 0) {{number_format($jumlah + $jumlahLama)}}
                    @elseif($jumlahLama + $jumlah == 0)
                        -
                    @endif 
                </td>
                @endfor

            </tr>
            @endif
            @endforeach
            
            <tr>
                <td colspan="3">Total</td>
                @for($l = 0; $l < count($total);$l++)
                
                <td> 
                    @if(!isset($total[$l]) || $total[$l] == 0) 
                        0 
                    @elseif(isset($total[$l])) {{number_format($total[$l])}} 
                    @endif 
                </td>
                @endfor
            </tr>
            
            <?php
                $total = array_map(function($val) { return 0; }, $total);
            ?>
            
            <tr><td><strong>PMDH / Umum</strong></td></tr>

            @foreach($unit as $u)
            @if($u->jenis_unit_id == 45)
            <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $u->kode }}</td>
            <td>{{ $u->jenis_unit->nama }}</td>

                @for($j = 0; $j < count($barang); $j++)

                <?php  
                $jumlah = DetailPemakaianBarang::whereHas('barang',function ($q) use ($from,$tahun,$u,$barang,$j) {
                    $q->where('barang_id', $barang[$j]->id);})->whereHas('pemakaian', function ($q) use ($from,$tahun,$u,$penggunaan){
                        $q->whereMonth('tanggal',$from)->whereYear('tanggal',$tahun)->where('penggunaan', $penggunaan[6])->where('unit_id',$u->id);
                    })->sum('jumlah');
                $jumlahLama = DetailPemakaianBarangLama::whereHas('barang',function ($q) use ($from,$tahun,$u,$barang,$j) {
                    $q->where('barang_id', $barang[$j]->id);})->whereHas('pemakaian', function ($q) use ($from,$tahun,$u,$penggunaan){
                        $q->whereMonth('tanggal',$from)->whereYear('tanggal',$tahun)->where('penggunaan', $penggunaan[6])->where('unit_id',$u->id);
                    })->sum('jumlah');
                
                $total[$j] += $jumlah + $jumlahLama;
                ?>

                

                <td> 
                    @if($jumlah != 0 || $jumlahLama != 0) {{number_format($jumlah + $jumlahLama)}}
                    @elseif($jumlahLama + $jumlah == 0)
                        -
                    @endif 
                </td>
                @endfor

            </tr>
            @endif
            @endforeach
            
            <tr>
                <td colspan="3">Total</td>
                @for($l = 0; $l < count($total);$l++)
                
                <td> 
                    @if(!isset($total[$l]) || $total[$l] == 0) 
                        0 
                    @elseif(isset($total[$l])) {{number_format($total[$l])}} 
                    @endif 
                </td>
                @endfor
            </tr>
            
            <?php
                $total = array_map(function($val) { return 0; }, $total);
            ?>
            
            <tr><td><strong>Mutasi</strong></td></tr>

            @foreach($unit as $u)
            @if($u->jenis_unit_id == 45)
            <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $u->kode }}</td>
            <td>{{ $u->jenis_unit->nama }}</td>

                @for($j = 0; $j < count($barang); $j++)

                <?php  
                $jumlah = DetailPemakaianBarang::whereHas('barang',function ($q) use ($from,$tahun,$u,$barang,$j) {
                    $q->where('barang_id', $barang[$j]->id);})->whereHas('pemakaian', function ($q) use ($from,$tahun,$u,$penggunaan){
                        $q->whereMonth('tanggal',$from)->whereYear('tanggal',$tahun)->where('penggunaan', $penggunaan[7])->where('unit_id',$u->id);
                    })->sum('jumlah');
                $jumlahLama = DetailPemakaianBarangLama::whereHas('barang',function ($q) use ($from,$tahun,$u,$barang,$j) {
                    $q->where('barang_id', $barang[$j]->id);})->whereHas('pemakaian', function ($q) use ($from,$tahun,$u,$penggunaan){
                        $q->whereMonth('tanggal',$from)->whereYear('tanggal',$tahun)->where('penggunaan', $penggunaan[7])->where('unit_id',$u->id);
                    })->sum('jumlah');
                
                $total[$j] += $jumlah + $jumlahLama;
                ?>

                

                <td> 
                    @if($jumlah != 0 || $jumlahLama != 0) {{number_format($jumlah + $jumlahLama)}}
                    @elseif($jumlahLama + $jumlah == 0)
                        -
                    @endif 
                </td>
                @endfor

            </tr>
            @endif
            @endforeach

            
           


            <!-- <tr>

                <td colspan="5"></td>

            </tr>

            <tr>

                <td colspan="4">TOTAL LAPORAN PEMAKAIAN SPARE PART & PERLENGKAPAN LAINNYA........</td>

                <td><strong><u>Rp.{{ number_format($total_semua) }}</u></strong></td>

            </tr> -->
            <tr>
                <td colspan="3">Total</td>
                @for($l = 0; $l < count($total);$l++)
                
                <td> 
                    @if(!isset($total[$l]) || $total[$l] == 0) 
                        0 
                    @elseif(isset($total[$l])) {{number_format($total[$l])}} 
                    @endif 
                </td>
                @endfor
            </tr>
        </table>

        <br>

        <br>



        <table style="width: 100%;text-align: center;">

            <tr>

                        <td colspan="4" style="text-align: right;">Base Camp Sei Bunut, {{ date('d F Y') }}</td>

                      </tr>

                    <tr><td><br><br></td></tr>

            <tr>
            @if(isset($diketahui))
                <td>Diketahui Oleh</td>
            @endif
            @if(isset($disetujui_1))
                <td>Disetujui I Oleh</td>
            @endif
            @if(isset($_GET['disetujui_2']))
                <td>Disetujui II Oleh</td>
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
            @if(isset($_GET['disetujui_2']))
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
            @endif
            @if(isset($dibuat))
                <td>{{ $dibuat->nama }}<br>{{ $dibuat->jabatan->nama }}</td>
            @endif
            </tr>

        </table>

    </div>

</body>

</html>