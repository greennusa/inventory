<?php

$from = (int) date('m', strtotime($_GET['tanggal']));

$tahun = date('Y', strtotime($_GET['tanggal']));

$bulannya = ['array_bulan', 'JANUARI', 'FEBRUARI', 'MARET', 'APRIL', 'MEI', 'JUNI', 'JULI', 'AGUSTUS', 'SEPTEMBER', 'NOVEMBER', 'OKTOBER', 'DESEMBER'];

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

    <script src="{{ asset('js/bootstrap-notify.min.js') }}"></script>

</head>

<style type="text/css" media="print">
    @page {

        size: auto;
        /* auto is the initial value */

        margin-bottom: 0;
        /* this affects the margin in the printer settings */

    }



    .ok {

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

            <h5>LAPORAN PEMAKAIAN BBM DAN PELUMAS</h5>



            <u>PERIODE BULAN <?php echo $bulannya[$from]; ?> <?php echo $tahun; ?></u>

        </center>

        <br>

        <?php
        
        use App\Barang;
        
        use App\PemakaianBarang;
        
        use App\DetailPemakaianBarang;
        
        use App\Camp;
        
        use App\User;
        
        use App\DetailPemakaianBarangLama;
        
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
        
        $kategori = '';
        
        $no = 1;
        
        $nama = '';
        
        // $to = date('m',strtotime($_GET['tanggal2']));
        
        $barang = Barang::where('kategori_id', 40)->get();
        
        // $details = DetailPemakaianBarang::with('pemakaian')
        //     ->get()
        //     ->sortBy(function ($user, $key) {
        //         return $user->pemakaian->unit->kode;
        //     });
        
        $tanggal_lama = $tahun . '-' . $from . '-01';
        $pemakaian = PemakaianBarang::whereBetween('tanggal', [$tanggal_lama, date('Y-m-t', strtotime($tanggal_lama))])
            ->with([
                'detail' => function ($a) {
                    $a->whereHas('barang', function ($b) {
                        $b->where('kategori_id', 40);
                    })->orderBy('nama_barang', 'ASC');
                },
                'detail_lama' => function ($c) {
                    $c->whereHas('barang', function ($d) {
                        $d->where('kategori_id', 40);
                    })->orderBy('nama_barang', 'ASC');
                },
            ])
            ->orderBy('tanggal', 'ASC')
            ->get();
        
        // $c = DetailPemakaianBarangLama::with('pemakaian')
        //     ->get()
        //     ->sortBy(function ($user, $key) {
        //         return $user->pemakaian->unit->kode;
        //     });
        
        // $x = $details
        //     ->toBase()
        //     ->merge($c)
        //     ->sortBy(function ($user, $key) {
        //         return $user->pemakaian->unit->kode;
        //     });
        
        $total_semua = [];
        
        ?>

        <table id="table" class="table table-bordered table-hover">

            <tr>

                {{-- <th>No.</th> --}}

                <th>Kode Unit</th>

                <th>Jenis Unit</th>

                @foreach ($barang as $k => $b)
                    <th>{{ $b->nama }}</th>
                    <?php $total_semua[$k] = 0; ?>
                @endforeach

            </tr>
            @php
                $pemakaian1 = 0;
            @endphp
            @foreach ($pemakaian as $sapi => $a)
                @php
                    $barangIsian = 0;
                    foreach ($barang as $b) {
                        $total[$sapi] = [$b->id];
                    }
                @endphp
                <tr>
                    <td>{{ $a->unit->kode }}</td>
                    <td>{{ $a->unit->jenis_unit->nama }}</td>
                    @foreach ($barang as $kuda => $c)
                        @php
                            $total_barang = 0;
                            $barangid = 0;
                            // $detailP = PemakaianBarang::with('pemakaian')->whereBetween('tanggal', [$tanggal_lama, date('Y-m-t', strtotime($tanggal_lama))]);
                            $detailP = PemakaianBarang::join('detail_pemakaian_barangs', 'pemakaian_barangs.id', '=', 'detail_pemakaian_barangs.pemakaian_barang_id')
                                ->whereBetween('pemakaian_barangs.tanggal', [$tanggal_lama, date('Y-m-t', strtotime($tanggal_lama))])
                                ->where('pemakaian_barangs.id', $a->id)
                                ->get();
                            // dd($detailP);
                            foreach ($detailP as $key) {
                                if ($key->barang_id == $c->id) {
                                    $total_barang = $total_barang + $key->jumlah;
                                    $barangid = $key->barang_id;
                                }
                            }

                            // $detailPLama = DetailPemakaianBarangLama::whereHas('pemakaian', function ($q) use ($tanggal_lama) {
                            //     $q->whereBetween('tanggal', [$tanggal_lama, date('Y-m-t', strtotime($tanggal_lama))]);
                            // });
                            $detailPLama = PemakaianBarang::join('detail_pemakaian_barang_lamas', 'pemakaian_barangs.id', '=', 'detail_pemakaian_barang_lamas.pemakaian_barang_id')
                                ->whereBetween('pemakaian_barangs.tanggal', [$tanggal_lama, date('Y-m-t', strtotime($tanggal_lama))])
                                ->where('pemakaian_barangs.id', $a->id)
                                ->get();
                            foreach ($detailPLama as $key) {
                                if ($key->barang_id == $c->id) {
                                    $total_barang = $total_barang + $key->jumlah;
                                    $barangid = $key->barang_id;
                                }
                            }
                            // $total[$sapi] = [];
                            $total[$sapi][$kuda] = $total_barang;

                            // array_push($total[$pemakaian1], $total_barang);
                            // use App\DetailPemakaianBarangLama;

                        @endphp
                        @if ($barangid == $c->id)
                            <td>{{ $total_barang != 0 ? $total_barang : '-' }}</td>
                        @else
                            <td>-</td>
                        @endif
                    @endforeach
                    @php
                        $pemakaian1 += 1;
                    @endphp
                </tr>
            @endforeach
            <tr>
                <td colspan="2">Total</td>
                @php
                    // dd($total);
                    foreach ($barang as $b => $value) {
                        $total_apalah = 0;
                        // $total[$sapi] = [$b->id];
                        for ($i = 0; $i < count($total); $i++) {
                            # code...
                            $total_apalah = $total_apalah + $total[$i][$b];
                        }

                        echo '<td>' . $total_apalah . '</td>';
                    }
                @endphp
            </tr>


            {{-- <tr>
                <td colspan="2"><strong>Total</strong></td>
                @for ($l = 0; $l < count($total_semua); $l++)
                    <td>{{ $total_semua[$l] }}</td>
                @endfor
            </tr> --}}

            <!-- <tr>

                <td colspan="5"></td>

            </tr>

            <tr>

                <td colspan="4">TOTAL LAPORAN PEMAKAIAN SPARE PART & PERLENGKAPAN LAINNYA........</td>

                <td><strong><u>Rp.</u></strong></td>

            </tr> -->

        </table>

        <br>

        <br>



        <table style="width: 100%;text-align: center;">

            <tr>

                <td colspan="4" style="text-align: right;">Base Camp Sei Bunut {{ date('d F Y') }}</td>

            </tr>

            <tr>
                <td><br><br></td>
            </tr>

            <tr>
                <?php if (isset($diketahui)) {?>
                <td>Diketahui Oleh</td>
                <?php }?>
                <?php if (isset($disetujui)) {?>
                <td>Disetujui I Oleh</td>
                <?php }?>
                <?php if (isset($_GET['disetujui_2'])) {?>
                <td>Disetujui II Oleh</td>
                <?php }?>
                <?php if (isset($disetujui)) {?>
                <td>Dibuat Oleh</td>
                <?php }?>
            </tr>

            <tr>

                <td colspan="4"><br><br><br><br></td>

            </tr>

            <tr>
                <?php if (isset($diketahui)) {?>
                <td>{{ $diketahui->nama }}<br>{{ $diketahui->jabatan->nama }}</td>

                <?php }?>
                <?php if (isset($disetujui)) {?>
                <td>{{ $disetujui_1->nama }}<br>{{ $disetujui_1->jabatan->nama }}</td>
                <?php }?>


                <?php if (isset($_GET['disetujui_2'])) {?>
                <td>

                    <?php
                    
                    for ($i = 0; $i < count($_GET['disetujui_2']); $i++) {
                        echo User::findOrFail($_GET['disetujui_2'][$i])->nama . ' /';
                    }
                    
                    echo '<br>';
                    
                    for ($i = 0; $i < count($_GET['disetujui_2']); $i++) {
                        echo User::findOrFail($_GET['disetujui_2'][$i])->jabatan->nama . ' /';
                    }
                    
                    ?>

                </td>
                <?php }?>

                <?php if (isset($disetujui)) {?>
                <td>{{ $dibuat->nama }}<br>{{ $dibuat->jabatan->nama }}</td>
                <?php }?>


            </tr>

        </table>

    </div>

    </div>

</body>

</html>

<script type="text/javascript">
    // var table, rows, switching, i, x, y, shouldSwitch;
    // table = document.getElementById("table");
    // switching = true;

    // while (switching) {

    //   switching = false;
    //   rows = table.rows;

    //   for (i = 1; i < (rows.length - 1); i++) {

    //     shouldSwitch = false;

    //     x = rows[i].getElementsByTagName("TD")[0];
    //     y = rows[i + 1].getElementsByTagName("TD")[0];

    //     if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {

    //       shouldSwitch = true;
    //       break;
    //     }
    //   }
    //   if (shouldSwitch) {

    //     rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
    //     switching = true;
    //   }
    // }
</script>
