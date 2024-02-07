<?php
use App\Barang;
use App\PemakaianBarang;
use App\DetailPemakaianBarang;
use App\DetailPemakaianBarangLama;
use App\Camp;
use App\CampLama;
use App\CampLog;
use App\DetailBuktiBarangKeluar;
use App\User;
use App\DetailPemesananBarang;

$from = (int) date('m', strtotime($_GET['tanggal']));
$to = (int) date('m', strtotime($_GET['tanggal2']));
$tahun = (int) date('Y', strtotime($_GET['tanggal']));
$bulannya = ['array_bulan', 'JANUARI', 'FEBRUARI', 'MARET', 'APRIL', 'MEI', 'JUNI', 'JULI', 'AGUSTUS', 'SEPTEMBER', 'NOVEMBER', 'OKTOBER', 'DESEMBER'];

$date = date('d/m/Y');
header('Content-type: application/vhd.ms-word');
header('Content-Disposition: attachment; filename=Rekap-BBM-' . $bulannya[$from] . '_' . $bulannya[$to] . '-' . $tahun . '.doc');
header('Pragma: no-cache');
header('Expires: 0');

$begin = new DateTime($_GET['tanggal']);
$end = new DateTime($tahun . '-' . $to . '-30');

$interval = DateInterval::createFromDateString('1 month');
$period = new DatePeriod($begin, $interval, $end);

$month = [];

foreach ($period as $dt) {
    // echo $dt->format("l Y-m-d H:i:s\n");
    $month[] = $dt->format('m');
}

$diketahui = User::findOrFail($_GET['diketahui']);
$disetujui = User::findOrFail($_GET['disetujui']);
$dibuat = User::findOrFail($_GET['dibuat']);
// $tables = Barang::where('kategori_id', 40)->get();
$kategori = '';

function aasort(&$array, $key)
{
    $sorter = [];
    $ret = [];
    reset($array);
    foreach ($array as $ii => $va) {
        $sorter[$ii] = $va[$key];
    }
    asort($sorter);
    foreach ($sorter as $ii => $va) {
        $ret[$ii] = $array[$ii];
    }
    $array = $ret;
}

// dd($month);

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
</style>

<body onload="window.print()">

    <div class="container">
        <br>
        <br>
        <center>
            <h5>REKAPITULASI PENERIMAAN DAN PEMAKAIAN BAHAN BAKAR MINYAK & PELUMAS</h5>
        </center>
        @foreach ($month as $laluna)
            <center>
                {{-- <u>PERIODE BULAN @php echo $bulannya[$from]; @endphp - @php echo $bulannya[$to]; @endphp @php echo $tahun; @endphp</u> --}}
                <u>BULAN : {{ date('F', mktime(0, 0, 0, $laluna, 10)) }} {{ $tahun }}</u>
            </center>
            <br>
            <?php
            $no = 1;
            
            // $to = date('m',strtotime($_GET['tanggal2']));
            $oldMonth = $laluna - 1;
            if ($oldMonth == 0) {
                $oldMonth = 12;
            }
            $tanggal_lama = $tahun . '-' . $oldMonth . '-01';
            $tables = PemakaianBarang::whereBetween('tanggal', ['2000-01-01', date('Y-m-t', strtotime($tanggal_lama))])
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
            $total_semua = 0;
            ?>
            <table class="table table-bordered table-hover">
                {{-- <tr align="center">
                <th rowspan="2">No</th>

                <th rowspan="2">Kode Barang</th>
                <th rowspan="2">Nama Barang</th>

                <th rowspan="2">Unit</th>
                <th rowspan="2">Harga Satuan</th>
                <th colspan="4" style="text-align: center;">Jumlah</th>
                <th rowspan="2">Nilai Akhir</th>
                <th rowspan="2">Keterangan</th>
            </tr>
            <tr>
                <th>Stok Awal</th>
                <th>Penambahan</th>
                <th>Pemakaian</th>
                <th>Stok Akhir</th>
            </tr> --}}
                <tr>
                    <th>NO</th>
                    <th>Jenis Fol</th>
                    <th>Stock Awal</th>
                    <th>Penerimaan</th>
                    <th>Pemakaian</th>
                    <th>Stock Akhir</th>
                    <th>Keterangan</th>
                </tr>
                <?php
                $page = 0;
                if (isset($_GET['page']) && $_GET['page'] > 1) {
                    $page = $_GET['page'] * 10;
                }
                $no = 1 * $page + 1;
                $grand_total = 0;
                $keterangan = $_GET['keterangan'];
                $barang = [];
                $hasil = [];
                ?>
                @php
                    $listbarang = barang::where('kategori_id', 40)->get();
                    $NoBarang = -1;
                @endphp
                @foreach ($listbarang as $apalah)
                    @php

                        $NoBarang++;
                        $hasil[] = ['jenis_pot' => $apalah->nama_barang, 'stock_awal' => 0, 'penerimaan' => 0, 'pemakaian' => 0, 'stock_akhir' => 0];
                        $pemakaianJumlah = 0;
                    @endphp
                    @foreach ($tables as $data)
                        {{-- <tr>
                            <td>{{ $data->$no }}</td>
                            <td>{{ $data->tanggal }}</td>
                        </tr> --}}
                        @foreach ($data->detail_lama as $b)
                            @php
                                if ($b->barang_id == $apalah->id) {
                                    $pemakaianJumlah = $pemakaianJumlah + $b->jumlah;
                                    $hasil[$NoBarang]['jenis_pot'] = $b->barang->nama == 'BBM Solar' ? $b->nama_barang : $b->barang->nama;
                                    $hasil[$NoBarang]['stock_awal'] = $b->jumlah_awal;
                                    $hasil[$NoBarang]['penerimaan'] = $b->jumlah;
                                    $hasil[$NoBarang]['pemakaian'] = $b->jumlah;
                                    $hasil[$NoBarang]['stock_akhir'] = 0;
                                    // dd($NoBarang);
                                    $barang[] = ['tanggal' => $b->pemakaian->tanggal, 'nama_barang' => $b->barang->nama == 'BBM Solar' ? $b->nama_barang : $b->barang->nama, 'jumlah_awal' => $b->jumlah_awal, 'jumlah' => $b->jumlah];
                                }
                            @endphp
                        @endforeach
                        @foreach ($data->detail as $a)
                            @php
                                if ($a->barang_id == $apalah->id) {
                                    $pemakaianJumlah = $pemakaianJumlah + $b->jumlah;
                                    // $hasil[$no] = ['jenis_pot' => $a->nama_barang, 'stock_awal' => $a->jumlah_awal, 'pemakaian' => $a->jumlah, 'stock_akhir' => 0];
                                    $hasil[$NoBarang]['jenis_pot'] = $a->barang->nama == 'BBM Solar' ? $a->nama_barang : $a->barang->nama;
                                    $hasil[$NoBarang]['stock_awal'] = $a->jumlah_awal;
                                    $hasil[$NoBarang]['penerimaan'] = $b->jumlah;
                                    $hasil[$NoBarang]['pemakaian'] = $a->jumlah;
                                    $hasil[$NoBarang]['stock_akhir'] = 0;

                                    $barang[] = ['tanggal' => $a->pemakaian->tanggal, 'nama_barang' => $a->barang->nama == 'BBM Solar' ? $a->nama_barang : $a->barang->nama, 'jumlah_awal' => $a->jumlah_awal, 'jumlah' => $a->jumlah];
                                }
                            @endphp
                        @endforeach
                        {{-- @foreach ($data->detail_lama as $b)
                            <tr>
                                <td>{{ $b->pemakaian->tanggal }}</td>
                                <td>{{ $b->nama_barang }}</td>
                                <td>{{ $a->jumlah_awal }}</td>
                                <td>-</td>
                                <td>{{ $a->jumlah }}</td>
                            </tr>
                        @endforeach
                        @foreach ($data->detail as $a)
                            <tr>
                                <td>{{ $a->pemakaian->tanggal }}</td>
                                <td>{{ $a->nama_barang }}</td>
                                <td>{{ $a->jumlah_awal }}</td>
                                <td>-</td>
                                <td>{{ $a->jumlah }}</td>
                            </tr>
                        @endforeach --}}
                        {{-- @if ($data->detail_pemakaian->count() != 0 || $data->detail_pemakaian_lama->count() != 0)
                        @php
                            $araMonth = $laluna - 1;
                            if ($araMonth == 0) {
                                $araMonth = 12;
                            }
                            $lastday = $tahun . '-' . $araMonth . '-01';
                            $detailbarang = PemakaianBarang::where('tanggal', '<=', date('Y-m-t', strtotime($lastday)))
                                ->OrderBy('tanggal', 'ASC')
                                ->get();
                            $harga_awal = 0;
                            // $detailbarang = PemakaianBarang::whereBetween('tanggal', [$tahun . '-' . $laluna . '-01', $tahun . '-' . $laluna . '-31'])->get();
                            // $harga_awal = 0;
                            foreach ($detailbarang as $item) {
                                foreach ($item->detail as $a) {
                                    if ($a->barang_id == $data->id) {
                                        $harga_awal = $a->jumlah_awal;
                                    }
                                }
                                foreach ($item->detail_lama as $a) {
                                    if ($a->barang_id == $data->id) {
                                        $harga_awal = $a->jumlah;
                                    }
                                }
                                // if ($harga_awal != 0) {
                                //     break;
                                // }
                            }
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $data->nama }}</td>
                            <td>
                                {{ number_format($harga_awal, 0) }}
                            </td>
                            <td>
                                @php
                                    $lastdaylaluna = $tahun . '-' . $laluna . '-01';
                                    $penerimaan_total = 0;
                                    $penerimaan = CampLog::whereBetween('tanggal', [$tahun . '-' . $laluna . '-01', date('Y-m-t', strtotime($lastdaylaluna))])
                                        ->where('aksi', 'penambahan')
                                        ->where('barang_id', $data->id)
                                        ->OrderBy('tanggal', 'ASC')
                                        ->get();
                                    foreach ($penerimaan as $key) {
                                        $penerimaan_total = $penerimaan_total + $key->jumlah;
                                    }
                                    echo number_format($penerimaan_total, 0);
                                @endphp
                    </td>
                    <td>
                        @php
                                    $pemakaian_total = 0;
                                    $pemakaian = CampLog::whereBetween('tanggal', [$tahun . '-' . $laluna . '-01', date('Y-m-t', strtotime($lastdaylaluna))])
                                        ->where('aksi', 'pemakaian')
                                        ->where('barang_id', $data->id)
                                        ->OrderBy('tanggal', 'ASC')
                                        ->get();
                                    foreach ($pemakaian as $key) {
                                        $pemakaian_total = $pemakaian_total + $key->jumlah;
                                    }
                                    echo number_format($pemakaian_total, 0);
                                @endphp
                    </td>
                    <td>
                        @php
                                    echo number_format($harga_awal + $penerimaan_total - $pemakaian_total, 0);
                                @endphp
                    </td>
                    <td>
                        <p>
                            {{ $_GET['keterangan'] != '' ? $keterangan : '-' }}
                            @php
                                $keterangan = '';
                            @endphp
                        </p>
                    </td>
                    </tr>

                    @endif --}}
                        {{-- @php
                    $detailbarang = PemakaianBarang::whereBetween('tanggal', [$_GET['tanggal'], $_GET['tanggal2']])
                        ->OrderBy('tanggal', 'ASC')
                        ->get();
                @endphp
                @foreach ($detailbarang as $item)
                    @foreach ($item->detail as $a)
                        @if ($a->barang_id == $data->id)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->tanggal }}</td>
                                <td>{{ $a->nama_barang }}</td>
                                <td>{{ $a->jumlah_awal }}</td>
                                <td>@php
                                    $penambahan_stok = 0;
                                @endphp</td>
                                <td>{{ $a->jumlah }}</td>
                                <td>{{ number_format(max($a->jumlah_awal + $penambahan_stok - $a->jumlah, 0)) }}</td>
                            </tr>
                        @endif
                    @endforeach
                    @foreach ($item->detail_lama as $a)
                        @if ($a->barang_id == $data->id)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->tanggal }}</td>
                                <td>{{ $a->nama_barang }}</td>
                                <td>{{ $a->jumlah_awal }}</td>
                                <td>@php
                                    $penambahan_stok = 0;
                                @endphp</td>
                                <td>{{ $a->jumlah }}</td>
                                <td>{{ number_format(max($a->jumlah_awal + $penambahan_stok - $a->jumlah, 0)) }}</td>
                            </tr>
                        @endif
                    @endforeach --}}
                        {{-- @endforeach --}}
                        {{-- @if (date('m', strtotime(@$data->tanggal)) >= $from && date('m', strtotime(@$data->tanggal)) <= $to) --}}
                        <?php $no++;
                        // $grand_total += $total;
                        ?>
                        {{-- @endif --}}
                    @endforeach
                @endforeach
                @php
                    // foreach ($barang as $key => $row) {
                    //     $return_fare[$key] = $row['tanggal'];
                    //     $one_way_fare[$key] = $row['nama_barang'];
                    // }
                    // array_multisort($barang, $one_way_fare, SORT_ASC, $return_fare, SORT_ASC);
                    // aasort($barang, 'tanggal');
                    // dd($hasil);
                    $noHasil = 1;
                    $NoBarang = 0;
                    foreach ($listbarang as $apalah) {
                        $penambahan = 0;
                        $pemakaian = 0;
                        $tanggal_convert = $tahun . '-' . $laluna . '-01';
                        $camplog = CampLog::where('barang_id', $apalah->id)
                            ->whereBetween('tanggal', [$tanggal_convert, date('Y-m-t', strtotime($tanggal_convert))])
                            ->get();
                        // dd($camplog);
                        foreach ($camplog as $sans) {
                            if ($sans->aksi == 'penambahan') {
                                $penambahan = $penambahan + $sans->jumlah;
                            } elseif ($sans->aksi == 'pemakaian') {
                                $pemakaian = $pemakaian + $sans->jumlah;
                            }
                        }

                        $hasil[$NoBarang]['penerimaan'] = $penambahan;
                        $hasil[$NoBarang]['pemakaian'] = $pemakaian;

                        $hasil[$NoBarang]['stock_akhir'] = number_format($hasil[$NoBarang]['stock_awal'] + $hasil[$NoBarang]['penerimaan'] - $hasil[$NoBarang]['pemakaian'], 0);
                        $NoBarang++;
                    }
                @endphp
                @foreach ($hasil as $data)
                    @if ($data['jenis_pot'] != null)
                        @if ($data['penerimaan'] != 0 || $data['pemakaian'] != 0)
                            <tr>
                                <td>{{ $noHasil++ }}</td>
                                <td>{{ $data['jenis_pot'] }}</td>
                                <td>{{ $data['stock_awal'] }}</td>
                                <td>{{ $data['penerimaan'] }}</td>
                                <td>{{ $data['pemakaian'] }}</td>
                                <td>{{ $data['stock_akhir'] }}</td>
                                <td>{{ $_GET['keterangan'] != '' ? $keterangan : '-' }}</td>
                                @php
                                    $keterangan = '';
                                @endphp
                            </tr>
                        @endif
                    @endif
                @endforeach
                <tr>
                    <td colspan="7">

                    </td>
                </tr>
                {{-- <tr>
                    <td colspan="8"></td>
                    <td colspan="1">Total:</td>
                    <td colspan="2">Rp.{{ number_format($grand_total) }}</td>
                </tr> --}}
            </table>
        @endforeach
        <br>
        {{-- <p>
            Keterangan : {{ $_GET['keterangan'] != '' ? $_GET['keterangan'] : '-' }}
        </p> --}}
        <br>

        <table style="width: 100%;text-align: center;">
            <tr>
                <td colspan="3" style="text-align: right;">Base Camp Sei Bunut, {{ date('d F Y') }}</td>
            </tr>
            <tr>
                <td>Diketahui Oleh</td>
                <td>Disetujui</td>

                <td>Dibuat Oleh</td>
            </tr>
            <tr>
                <td colspan="3"><br><br><br><br></td>
            </tr>
            <tr>
                <td>{{ $diketahui->nama }}<br>{{ $diketahui->jabatan->nama }}</td>
                <td>{{ $disetujui->nama }}<br>{{ $disetujui->jabatan->nama }}</td>

                <td>{{ $dibuat->nama }}<br>{{ $dibuat->jabatan->nama }}</td>
            </tr>
        </table>
    </div>
    </div>
    <script src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.replace('myTextArea');
    </script>
</body>

</html>
