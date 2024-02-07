<?php

$from = (int) date('m', strtotime($_GET['tanggal']));

$tahun = date('Y', strtotime($_GET['tanggal']));

$bulannya = ['array_bulan', 'JANUARI', 'FEBRUARI', 'MARET', 'APRIL', 'MEI', 'JUNI', 'JULI', 'AGUSTUS', 'SEPTEMBER', 'NOVEMBER', 'OKTOBER', 'DESEMBER'];

$penggunaan = ['Skidding', 'Road Counstruction', 'Produksi', 'Penimbunan', 'Penunjang', 'Alkon + Genset', 'PMDH/Umum', 'Mutasi'];

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
        
        function transpose_2d_array($array)
        {
            $transposed_array = [];
            foreach ($array as $row_index => $row) {
                foreach ($row as $col_index => $value) {
                    $transposed_array[$col_index][$row_index] = $value;
                }
            }
            return $transposed_array;
        }
        
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
        
        $tanggal_lama = $tahun . '-' . $from . '-01';
        $unit = Unit::whereHas('pemakaian', function ($s) use ($tanggal_lama) {
            $s->whereBetween('tanggal', [$tanggal_lama, date('Y-m-t', strtotime($tanggal_lama))]);
        })->get();
        
        $kategori = '';
        
        // $to = date('m',strtotime($_GET['tanggal2']));
        
        $barang = Barang::where('kategori_id', 40)->get();
        
        $details = DetailPemakaianBarang::with('pemakaian')->get();
        
        $c = DetailPemakaianBarangLama::with('pemakaian')->get();
        
        $x = $details
            ->toBase()
            ->merge($c)
            ->sortBy(function ($user, $key) {
                return $user->pemakaian->unit->kode;
            });
        
        $z = PemakaianBarang::all();
        
        $total_semua = 0;
        
        // $total = [];
        // for ($k = 0; $k < count($barang); $k++) {
        //     $total[$k] = 0;
        // }
        
        ?>
        <table class="table table-bordered table-hover">
            <tr>

                <th>No.</th>

                <th>Kode Unit</th>

                <th>Jenis Unit</th>

                @foreach ($barang as $b)
                    <th>{{ $b->nama }}</th>
                @endforeach

            </tr>
            @php
                $totalSepenuhnya = [];
            @endphp
            @foreach ($penggunaan as $penggunan_value => $b)
                <tr>
                    <th colspan="{{ 3 + count($barang) }}">{{ $b }}</th>
                </tr>
                @php
                    $tanggal_lama = $tahun . '-' . $from . '-01';
                    $pemakaianBarang = PemakaianBarang::where('penggunaan', $b)
                        ->whereBetween('tanggal', [$tanggal_lama, date('Y-m-t', strtotime($tanggal_lama))])
                        ->groupBy('unit_id')
                        ->get();
                    $pemakaian1 = 0;
                    $total = [];
                    // $totalSepenuhnya[$penggunan_value] = [$b];
                @endphp
                @foreach ($pemakaianBarang as $sapi => $a)
                    @if ($a->unit->jenis_unit_id == 26 || $a->unit->jenis_unit_id == 7)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
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
                                        ->where('penggunaan', $b)
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
                                        ->where('penggunaan', $b)
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
                    @endif
                @endforeach
                </tr>
                <tr>
                    <td colspan="3">Total </td>
                    @php
                        // dd(count($total[1]));
                        $totalTerbalik = transpose_2d_array($total);
                        // dd($totalTerbalik[3]);
                        if (count($total) == 1) {
                            $totalSpesial = array_values($total);
                            // dd($totalSpesial);
                            foreach ($totalSpesial[0] as $key => $value) {
                                // dd($value);
                                $total_apalah = 0;
                                $total_apalah = $total_apalah + $value;
                                echo '<td>' . $total_apalah . '</td>';
                                $totalSepenuhnya[$penggunan_value][$key] = $total_apalah;
                            }
                        } else {
                            for ($x = 0; $x < count($totalTerbalik); $x++) {
                                $total_apalah = 0;
                                for ($y = 0; $y < count($totalTerbalik[$x]); $y++) {
                                    $total_apalah = $total_apalah + $totalTerbalik[$x][$y];
                                }
                                $totalSepenuhnya[$penggunan_value][$x] = $total_apalah;
                                echo '<td>' . $total_apalah . '</td>';
                            }
                        }
                        // foreach ($barang as $b => $value) {
                        //     $total_apalah = 0;
                        //     // $total[$sapi] = [$b->id];
                        //     for ($i = 0; $i < count($total); $i++) {
                        //         # code...
                        //         // echo $i . '<br>';
                        //         $total_apalah = $total_apalah + $total[$i][$b];
                        //     }
                        //     $totalSepenuhnya[$penggunan_value][$b] = $total_apalah;
                        //     echo '<td>' . $total_apalah . '</td>';
                        // }
                    @endphp
                </tr>
            @endforeach
            <tr>
                <th colspan="3">Total Sepenuhnya </th>
                @php
                    // dd($totalSepenuhnya);
                    $totalSepenuhnyaTerbalik = transpose_2d_array($totalSepenuhnya);
                    for ($x = 0; $x < count($totalSepenuhnyaTerbalik); $x++) {
                        $total_apalah = 0;
                        for ($y = 0; $y < count($totalSepenuhnyaTerbalik[$x]); $y++) {
                            $total_apalah = $total_apalah + $totalSepenuhnyaTerbalik[$x][$y];
                        }
                        echo '<th>' . $total_apalah . '</th>';
                    }
                @endphp
            </tr>
        </table>

        {{-- <table class="table table-bordered table-hover">

            <tr>

                <th>No.</th>

                <th>Kode Unit</th>

                <th>Jenis Unit</th>

                @foreach ($barang as $b)
                    <th>{{ $b->nama }}</th>
                @endforeach

            </tr>


            @php $no = 1;                             @endphp

            <tr>
                <td><strong>Skidding</strong></td>
            </tr>

            @foreach ($unit as $u)
                @if ($u->jenis_unit_id == 26 || $u->jenis_unit_id == 7)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $u->kode }}</td>
                        <td>{{ $u->jenis_unit->nama }}</td>

                        @for ($j = 0; $j < count($barang); $j++)
                            @php
                            $jumlah = DetailPemakaianBarang::whereHas('barang', function ($q) use ($from, $tahun, $u, $barang, $j) {
                                $q->where('barang_id', $barang[$j]->id);
                            })
                                ->whereHas('pemakaian', function ($q) use ($from, $tahun, $u, $penggunaan) {
                                    $q->whereMonth('tanggal', $from)
                                        ->whereYear('tanggal', $tahun)
                                        ->where('penggunaan', $penggunaan[0])
                                        ->where('unit_id', $u->id);
                                })
                                ->sum('jumlah');
                            
                            $jumlahLama = DetailPemakaianBarangLama::whereHas('barang', function ($q) use ($from, $tahun, $u, $barang, $j) {
                                $q->where('barang_id', $barang[$j]->id);
                            })
                                ->whereHas('pemakaian', function ($q) use ($from, $tahun, $u, $penggunaan) {
                                    $q->whereMonth('tanggal', $from)
                                        ->whereYear('tanggal', $tahun)
                                        ->where('penggunaan', $penggunaan[0])
                                        ->where('unit_id', $u->id);
                                })
                                ->sum('jumlah');
                            
                            $total[$j] += $jumlah + $jumlahLama;
                            @endphp




                            <td>
                                @if ($jumlah != 0 || $jumlahLama != 0)
                                    {{ number_format($jumlah + $jumlahLama) }}
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
                @for ($l = 0; $l < count($total); $l++)
                    <td>
                        @if (!isset($total[$l]) || $total[$l] == 0)
                            0
                        @elseif(isset($total[$l]))
                            {{ number_format($total[$l]) }}
                        @endif
                    </td>
                @endfor
            </tr>

            @php
            $total = array_map(function ($val) {
                return 0;
            }, $total);
            @endphp

            <tr>
                <td><strong>Road Construction</strong></td>
            </tr>

            @foreach ($unit as $u)
                @if ($u->jenis_unit_id == 26 || $u->jenis_unit_id == 7)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $u->kode }}</td>
                        <td>{{ $u->jenis_unit->nama }}</td>

                        @for ($j = 0; $j < count($barang); $j++)
                            @php
                            $jumlah = DetailPemakaianBarang::whereHas('barang', function ($q) use ($from, $tahun, $u, $barang, $j) {
                                $q->where('barang_id', $barang[$j]->id);
                            })
                                ->whereHas('pemakaian', function ($q) use ($from, $tahun, $u, $penggunaan) {
                                    $q->whereMonth('tanggal', $from)
                                        ->whereYear('tanggal', $tahun)
                                        ->where('penggunaan', $penggunaan[1])
                                        ->where('unit_id', $u->id);
                                })
                                ->sum('jumlah');
                            $jumlahLama = DetailPemakaianBarangLama::whereHas('barang', function ($q) use ($from, $tahun, $u, $barang, $j) {
                                $q->where('barang_id', $barang[$j]->id);
                            })
                                ->whereHas('pemakaian', function ($q) use ($from, $tahun, $u, $penggunaan) {
                                    $q->whereMonth('tanggal', $from)
                                        ->whereYear('tanggal', $tahun)
                                        ->where('penggunaan', $penggunaan[1])
                                        ->where('unit_id', $u->id);
                                })
                                ->sum('jumlah');
                            
                            $total[$j] += $jumlah + $jumlahLama;
                            @endphp



                            <td>
                                @if ($jumlah != 0 || $jumlahLama != 0)
                                    {{ number_format($jumlah + $jumlahLama) }}
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
                @for ($l = 0; $l < count($total); $l++)
                    <td>
                        @if (!isset($total[$l]) || $total[$l] == 0)
                            0
                        @elseif(isset($total[$l]))
                            {{ number_format($total[$l]) }}
                        @endif
                    </td>
                @endfor
            </tr>

            @php
            $total = array_map(function ($val) {
                return 0;
            }, $total);
            @endphp

            <tr>
                <td><strong>Produksi</strong></td>
            </tr>

            @foreach ($unit as $u)
                @if ($u->jenis_unit_id == 27 || $u->jenis_unit_id == 49 || $u->jenis_unit_id == 50 || $u->jenis_unit_id == 31 || $u->jenis_unit_id == 33)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $u->kode }}</td>
                        <td>{{ $u->jenis_unit->nama }}</td>

                        @for ($j = 0; $j < count($barang); $j++)
                            @php
                            $jumlah = DetailPemakaianBarang::whereHas('barang', function ($q) use ($from, $tahun, $u, $barang, $j) {
                                $q->where('barang_id', $barang[$j]->id);
                            })
                                ->whereHas('pemakaian', function ($q) use ($from, $tahun, $u, $penggunaan) {
                                    $q->whereMonth('tanggal', $from)
                                        ->whereYear('tanggal', $tahun)
                                        ->where('penggunaan', $penggunaan[2])
                                        ->where('unit_id', $u->id);
                                })
                                ->sum('jumlah');
                            $jumlahLama = DetailPemakaianBarangLama::whereHas('barang', function ($q) use ($from, $tahun, $u, $barang, $j) {
                                $q->where('barang_id', $barang[$j]->id);
                            })
                                ->whereHas('pemakaian', function ($q) use ($from, $tahun, $u, $penggunaan) {
                                    $q->whereMonth('tanggal', $from)
                                        ->whereYear('tanggal', $tahun)
                                        ->where('penggunaan', $penggunaan[2])
                                        ->where('unit_id', $u->id);
                                })
                                ->sum('jumlah');
                            
                            $total[$j] += $jumlah + $jumlahLama;
                            @endphp



                            <td>
                                @if ($jumlah != 0 || $jumlahLama != 0)
                                    {{ number_format($jumlah + $jumlahLama) }}
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
                @for ($l = 0; $l < count($total); $l++)
                    <td>
                        @if (!isset($total[$l]) || $total[$l] == 0)
                            0
                        @elseif(isset($total[$l]))
                            {{ number_format($total[$l]) }}
                        @endif
                    </td>
                @endfor
            </tr>

            @php
            $total = array_map(function ($val) {
                return 0;
            }, $total);
            @endphp

            <tr>
                <td><strong>Penimbunan</strong></td>
            </tr>

            @foreach ($unit as $u)
                @if ($u->jenis_unit_id == 51 || $u->jenis_unit_id == 21 || $u->jenis_unit_id == 52 || $u->jenis_unit_id == 53 || $u->jenis_unit_id == 36 || $u->jenis_unit_id == 29 || $u->jenis_unit_id == 30)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $u->kode }}</td>
                        <td>{{ $u->jenis_unit->nama }}</td>

                        @for ($j = 0; $j < count($barang); $j++)
                            @php
                            $jumlah = DetailPemakaianBarang::whereHas('barang', function ($q) use ($from, $tahun, $u, $barang, $j) {
                                $q->where('barang_id', $barang[$j]->id);
                            })
                                ->whereHas('pemakaian', function ($q) use ($from, $tahun, $u, $penggunaan) {
                                    $q->whereMonth('tanggal', $from)
                                        ->whereYear('tanggal', $tahun)
                                        ->where('penggunaan', $penggunaan[3])
                                        ->where('unit_id', $u->id);
                                })
                                ->sum('jumlah');
                            $jumlahLama = DetailPemakaianBarangLama::whereHas('barang', function ($q) use ($from, $tahun, $u, $barang, $j) {
                                $q->where('barang_id', $barang[$j]->id);
                            })
                                ->whereHas('pemakaian', function ($q) use ($from, $tahun, $u, $penggunaan) {
                                    $q->whereMonth('tanggal', $from)
                                        ->whereYear('tanggal', $tahun)
                                        ->where('penggunaan', $penggunaan[3])
                                        ->where('unit_id', $u->id);
                                })
                                ->sum('jumlah');
                            
                            $total[$j] += $jumlah + $jumlahLama;
                            @endphp



                            <td>
                                @if ($jumlah != 0 || $jumlahLama != 0)
                                    {{ number_format($jumlah + $jumlahLama) }}
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
                @for ($l = 0; $l < count($total); $l++)
                    <td>
                        @if (!isset($total[$l]) || $total[$l] == 0)
                            0
                        @elseif(isset($total[$l]))
                            {{ number_format($total[$l]) }}
                        @endif
                    </td>
                @endfor
            </tr>

            @php
            $total = array_map(function ($val) {
                return 0;
            }, $total);
            @endphp

            <tr>
                <td><strong>Penunjang</strong></td>
            </tr>

            @foreach ($unit as $u)
                @if ($u->jenis_unit_id == 35 || $u->jenis_unit_id == 38 || $u->jenis_unit_id == 24 || $u->jenis_unit_id == 17 || $u->jenis_unit_id == 39 || $u->jenis_unit_id == 54 || $u->jenis_unit_id == 60 || $u->jenis_unit_id == 18 || $u->jenis_unit_id == 42 || $u->jenis_unit_id == 25)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $u->kode }}</td>
                        <td>{{ $u->jenis_unit->nama }}</td>

                        @for ($j = 0; $j < count($barang); $j++)
                            @php
                            $jumlah = DetailPemakaianBarang::whereHas('barang', function ($q) use ($from, $tahun, $u, $barang, $j) {
                                $q->where('barang_id', $barang[$j]->id);
                            })
                                ->whereHas('pemakaian', function ($q) use ($from, $tahun, $u, $penggunaan) {
                                    $q->whereMonth('tanggal', $from)
                                        ->whereYear('tanggal', $tahun)
                                        ->where('penggunaan', $penggunaan[4])
                                        ->where('unit_id', $u->id);
                                })
                                ->sum('jumlah');
                            $jumlahLama = DetailPemakaianBarangLama::whereHas('barang', function ($q) use ($from, $tahun, $u, $barang, $j) {
                                $q->where('barang_id', $barang[$j]->id);
                            })
                                ->whereHas('pemakaian', function ($q) use ($from, $tahun, $u, $penggunaan) {
                                    $q->whereMonth('tanggal', $from)
                                        ->whereYear('tanggal', $tahun)
                                        ->where('penggunaan', $penggunaan[4])
                                        ->where('unit_id', $u->id);
                                })
                                ->sum('jumlah');
                            
                            $total[$j] += $jumlah + $jumlahLama;
                            @endphp



                            <td>
                                @if ($jumlah != 0 || $jumlahLama != 0)
                                    {{ number_format($jumlah + $jumlahLama) }}
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
                @for ($l = 0; $l < count($total); $l++)
                    <td>
                        @if (!isset($total[$l]) || $total[$l] == 0)
                            0
                        @elseif(isset($total[$l]))
                            {{ number_format($total[$l]) }}
                        @endif
                    </td>
                @endfor
            </tr>

            @php
            $total = array_map(function ($val) {
                return 0;
            }, $total);
            @endphp

            <tr>
                <td><strong>Alkon + Genset</strong></td>
            </tr>

            @foreach ($unit as $u)
                @if ($u->jenis_unit_id == 45)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $u->kode }}</td>
                        <td>{{ $u->jenis_unit->nama }}</td>

                        @for ($j = 0; $j < count($barang); $j++)
                            @php
                            $jumlah = DetailPemakaianBarang::whereHas('barang', function ($q) use ($from, $tahun, $u, $barang, $j) {
                                $q->where('barang_id', $barang[$j]->id);
                            })
                                ->whereHas('pemakaian', function ($q) use ($from, $tahun, $u, $penggunaan) {
                                    $q->whereMonth('tanggal', $from)
                                        ->whereYear('tanggal', $tahun)
                                        ->where('penggunaan', $penggunaan[5])
                                        ->where('unit_id', $u->id);
                                })
                                ->sum('jumlah');
                            $jumlahLama = DetailPemakaianBarangLama::whereHas('barang', function ($q) use ($from, $tahun, $u, $barang, $j) {
                                $q->where('barang_id', $barang[$j]->id);
                            })
                                ->whereHas('pemakaian', function ($q) use ($from, $tahun, $u, $penggunaan) {
                                    $q->whereMonth('tanggal', $from)
                                        ->whereYear('tanggal', $tahun)
                                        ->where('penggunaan', $penggunaan[5])
                                        ->where('unit_id', $u->id);
                                })
                                ->sum('jumlah');
                            
                            $total[$j] += $jumlah + $jumlahLama;
                            @endphp



                            <td>
                                @if ($jumlah != 0 || $jumlahLama != 0)
                                    {{ number_format($jumlah + $jumlahLama) }}
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
                @for ($l = 0; $l < count($total); $l++)
                    <td>
                        @if (!isset($total[$l]) || $total[$l] == 0)
                            0
                        @elseif(isset($total[$l]))
                            {{ number_format($total[$l]) }}
                        @endif
                    </td>
                @endfor
            </tr>

            @php
            $total = array_map(function ($val) {
                return 0;
            }, $total);
            @endphp

            <tr>
                <td><strong>PMDH / Umum</strong></td>
            </tr>

            @foreach ($unit as $u)
                @if ($u->jenis_unit_id == 45)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $u->kode }}</td>
                        <td>{{ $u->jenis_unit->nama }}</td>

                        @for ($j = 0; $j < count($barang); $j++)
                            @php
                            $jumlah = DetailPemakaianBarang::whereHas('barang', function ($q) use ($from, $tahun, $u, $barang, $j) {
                                $q->where('barang_id', $barang[$j]->id);
                            })
                                ->whereHas('pemakaian', function ($q) use ($from, $tahun, $u, $penggunaan) {
                                    $q->whereMonth('tanggal', $from)
                                        ->whereYear('tanggal', $tahun)
                                        ->where('penggunaan', $penggunaan[6])
                                        ->where('unit_id', $u->id);
                                })
                                ->sum('jumlah');
                            $jumlahLama = DetailPemakaianBarangLama::whereHas('barang', function ($q) use ($from, $tahun, $u, $barang, $j) {
                                $q->where('barang_id', $barang[$j]->id);
                            })
                                ->whereHas('pemakaian', function ($q) use ($from, $tahun, $u, $penggunaan) {
                                    $q->whereMonth('tanggal', $from)
                                        ->whereYear('tanggal', $tahun)
                                        ->where('penggunaan', $penggunaan[6])
                                        ->where('unit_id', $u->id);
                                })
                                ->sum('jumlah');
                            
                            $total[$j] += $jumlah + $jumlahLama;
                            @endphp



                            <td>
                                @if ($jumlah != 0 || $jumlahLama != 0)
                                    {{ number_format($jumlah + $jumlahLama) }}
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
                @for ($l = 0; $l < count($total); $l++)
                    <td>
                        @if (!isset($total[$l]) || $total[$l] == 0)
                            0
                        @elseif(isset($total[$l]))
                            {{ number_format($total[$l]) }}
                        @endif
                    </td>
                @endfor
            </tr>

            @php
            $total = array_map(function ($val) {
                return 0;
            }, $total);
            @endphp

            <tr>
                <td><strong>Mutasi</strong></td>
            </tr>

            @foreach ($unit as $u)
                @if ($u->jenis_unit_id == 45)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $u->kode }}</td>
                        <td>{{ $u->jenis_unit->nama }}</td>

                        @for ($j = 0; $j < count($barang); $j++)
                            @php 
                            $jumlah = DetailPemakaianBarang::whereHas('barang', function ($q) use ($from, $tahun, $u, $barang, $j) {
                                $q->where('barang_id', $barang[$j]->id);
                            })
                                ->whereHas('pemakaian', function ($q) use ($from, $tahun, $u, $penggunaan) {
                                    $q->whereMonth('tanggal', $from)
                                        ->whereYear('tanggal', $tahun)
                                        ->where('penggunaan', $penggunaan[7])
                                        ->where('unit_id', $u->id);
                                })
                                ->sum('jumlah');
                            $jumlahLama = DetailPemakaianBarangLama::whereHas('barang', function ($q) use ($from, $tahun, $u, $barang, $j) {
                                $q->where('barang_id', $barang[$j]->id);
                            })
                                ->whereHas('pemakaian', function ($q) use ($from, $tahun, $u, $penggunaan) {
                                    $q->whereMonth('tanggal', $from)
                                        ->whereYear('tanggal', $tahun)
                                        ->where('penggunaan', $penggunaan[7])
                                        ->where('unit_id', $u->id);
                                })
                                ->sum('jumlah');
                            
                            $total[$j] += $jumlah + $jumlahLama;
                            @endphp



                            <td>
                                @if ($jumlah != 0 || $jumlahLama != 0)
                                    {{ number_format($jumlah + $jumlahLama) }}
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
                @for ($l = 0; $l < count($total); $l++)
                    <td>
                        @if (!isset($total[$l]) || $total[$l] == 0)
                            0
                        @elseif(isset($total[$l]))
                            {{ number_format($total[$l]) }}
                        @endif
                    </td>
                @endfor
            </tr>
        </table> --}}

        <br>

        <br>



        <table style="width: 100%;text-align: center;">

            <tr>

                <td colspan="4" style="text-align: right;">Base Camp Sei Bunut, {{ date('d F Y') }}</td>

            </tr>

            <tr>
                <td><br><br></td>
            </tr>

            <tr>
                @if (isset($diketahui))
                    <td>Diketahui Oleh</td>
                @endif
                @if (isset($disetujui_1))
                    <td>Disetujui I Oleh</td>
                @endif
                @if (isset($_GET['disetujui_2']))
                    <td>Disetujui II Oleh</td>
                @endif
                @if (isset($dibuat))
                    <td>Dibuat Oleh</td>
                @endif
            </tr>

            <tr>

                <td colspan="4"><br><br><br><br></td>

            </tr>

            <tr>
                @if (isset($diketahui))
                    <td>{{ $diketahui->nama }}<br>{{ $diketahui->jabatan->nama }}</td>
                @endif
                @if (isset($disetujui_1))
                    <td>{{ $disetujui_1->nama }}<br>{{ $disetujui_1->jabatan->nama }}</td>
                @endif
                @if (isset($_GET['disetujui_2']))
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
                @endif
                @if (isset($dibuat))
                    <td>{{ $dibuat->nama }}<br>{{ $dibuat->jabatan->nama }}</td>
                @endif
            </tr>

        </table>

    </div>

</body>

</html>
