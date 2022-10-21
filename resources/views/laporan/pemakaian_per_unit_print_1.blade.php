<?php 

        $from = (int)date('m',strtotime($_GET['tanggal']));

        $to = (int)date('m',strtotime($_GET['tanggal2']));

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

</style>

<body onload="window.print()">

    

    <div class="container">

        <br>

        <br>

        <center>

            <h5>LAPORAN PEMAKAIAN BARANG MATERIAL DAN SPARE PART</h5>



            <u>PERIODE BULAN <?php echo date('d',strtotime($_GET['tanggal'])); ?> <?php echo $bulannya[$from]; ?> <?php echo date('Y',strtotime($_GET['tanggal'])); ?> - <?php echo date('d',strtotime($_GET['tanggal2'])); ?> <?php echo $bulannya[$to]; ?> <?php echo date('Y',strtotime($_GET['tanggal2'])); ?></u>

        </center>

        <br>

        <?php 

            use App\Barang;

            use App\DetailPemakaianBarang;

            use App\DetailPemakaianBarangLama;

            use App\Camp;

            use App\User;

            $diketahui = User::findOrFail($_GET['diketahui']);

            $disetujui_1 = User::findOrFail($_GET['disetujui_1']);

            // $disetujui_2_1 = User::findOrFail($_GET['disetujui_2'][0]);

            // $disetujui_2_2 = User::findOrFail($_GET['disetujui_2'][1]);

            $dibuat = User::findOrFail($_GET['dibuat']);

            $camps = Camp::all();

            $kategori = '';

            $no = 1;

            $jenisUnit = '';

            // $to = date('m',strtotime($_GET['tanggal2']));

            $details = DetailPemakaianBarang::all()->toBase()->merge(DetailPemakaianBarangLama::all())->sortBy(function($user, $key)
    {
        return $user->pemakaian->unit->kode;
    });

           

            $total_semua = 0;



        ?>

        <table class="table table-bordered table-hover" border="1">

            



            @foreach($details as $detail)

                @if(date('Y-m-d',strtotime($detail->pemakaian->tanggal)) >= $_GET['tanggal'] &&  date('Y-m-d',strtotime($detail->pemakaian->tanggal)) <= $_GET['tanggal2'] && in_array($detail->pemakaian->unit->jenis_unit_id , $_GET['jenis_unit_id']))
			

                @if($jenisUnit != $detail->pemakaian->unit->kode)

                <?php $jenisUnit =  $detail->pemakaian->unit->kode?>

                <tr>

                <td colspan="8"><u> <?php echo \App\JenisUnit::find($detail->pemakaian->unit->jenis_unit_id)->nama; ?>, <?php echo $jenisUnit; ?> ({{ $detail->pemakaian->unit->operator }})</u></td>

            </tr>

            <tr>

                <th>No</th>

                <th>Tanggal</th>

                <th>Part Number</th>
				
                <th>Nama Barang</th>

                <th>Qty</th>

                <th>Harga Satuan</th>

                <th>Jumlah</th>

                <th>Keterangan</th>

            </tr>

            

            <tr>

                       <td>{{ $no++ }}</td>

                       <td>{{ @$detail->pemakaian->tanggal}}</td>

                       <?php $db = \App\DetailPemesananBarang::where('gabungan','like','%'.@$detail->gabungan_id.'%')->get();?>

                                                <td>

                                                    <?php if($detail->detail_bbk != null){ echo $detail->detail_bbk->detail_bbm->detail_pemesanan->kode_barang; }else if(@$detail->detail_bbk == null){ echo $detail->barang->kode;} else { echo $detail->barang->kode; }?>
													

                                                    <?php if($detail->detail_bbk != null):foreach($db as $dd): ?>

                                                     / <?php echo $dd->barang->kode ?>

                                                    <?php endforeach;endif; ?>

                                                </td><td>

                                                    <?php if(@$detail->detail_bbk != null){ echo @$detail->detail_bbk->detail_bbm->detail_pemesanan->nama_barang; }else if(@$detail->detail_bbk == null){ echo $detail->barang->nama;}else if(@$detail->nama_barang != null){echo @$detail->nama_barang;} else { echo $detail->barang->nama; }?> 

                                                    <?php if($detail->detail_bbk != null):foreach($db as $dd): ?>

                                                     / <?php echo $dd->barang->nama ?>

                                                    <?php endforeach;endif; ?>

                                                </td>

                                                

                       <td>{{ @$detail->jumlah }}<?php if(@$detail->detail_bbk->detail_bbm->detail_pemesanan->detail_permintaan->satuan->nama == null)
{echo @$detail->barang->satuan->nama;}
						   else{ echo @$detail->detail_bbk->detail_bbm->detail_pemesanan->detail_permintaan->satuan->nama; } ?></td>

                       @if(number_format(@$detail->detail_bbk->detail_bbm->detail_pemesanan->detail_permintaan->harga) != 0)
                       <td>Rp.{{ number_format(@$detail->detail_bbk->detail_bbm->detail_pemesanan->detail_permintaan->harga) }}</td>
				@else
				<td>Rp.{{ number_format(@$detail->detail_bbk->detail_bbm->detail_pemesanan->detail_permintaan->harga + @$detail->harga) }}</td>
				@endif
						
				
				@if(number_format(@$detail->detail_bbk->detail_bbm->detail_pemesanan->detail_permintaan->harga) != 0)
                       <td>Rp.{{ number_format(@$detail->jumlah*(@$detail->detail_bbk->detail_bbm->detail_pemesanan->detail_permintaan->harga)) }}</td>
				@else
				<td>Rp.{{ number_format(@$detail->jumlah*(@$detail->detail_bbk->detail_bbm->detail_pemesanan->detail_permintaan->harga + @$detail->harga)) }}</td>
				@endif
                       <td>{{ @$detail->detail_bbk->keterangan }}</td>

                   </tr>

                   <?php 
					if(number_format(@$detail->jumlah*@$detail->detail_bbk->detail_bbm->detail_pemesanan->detail_permintaan->harga != 0)){
						$total_semua += @$detail->jumlah*@$detail->detail_bbk->detail_bbm->detail_pemesanan->detail_permintaan->harga;
					}else{
						$total_semua += @$detail->jumlah*@$detail->harga;
					}
					?>

            @else

                   <tr>

                       <td>{{ $no++ }}</td>

                       <td>{{ @$detail->pemakaian->tanggal}}</td>

                       <?php $db = \App\DetailPemesananBarang::where('gabungan','like','%'.@$detail->gabungan_id.'%')->get();?>

                                                <td>

                                                    <?php if($detail->detail_bbk != null){ echo $detail->detail_bbk->detail_bbm->detail_pemesanan->kode_barang; }else if($detail->detail_bbk == null){ echo $detail->barang->kode;} else { echo $detail->barang->kode; }?>

                                                    <?php if(@$detail->detail_bbk != null):foreach($db as $dd): ?>

                                                     / <?php echo $dd->barang->kode ?>

                                                    <?php endforeach;endif; ?>

                                                </td><td>

                                                    <?php if($detail->detail_bbk != null){ echo $detail->detail_bbk->detail_bbm->detail_pemesanan->nama_barang; }else if($detail->detail_bbk == null){ echo $detail->barang->nama;}else if(@$detail->nama_barang != null){echo @$detail->nama_barang ;} else { echo $detail->barang->nama; }?> 

                                                    <?php if(@$detail->detail_bbk != null):foreach($db as $dd): ?>

                                                     / <?php echo $dd->barang->nama ?>

                                                    <?php endforeach;endif; ?>

                                                </td>

                                                

                       <td>{{ @$detail->jumlah }}<?php if(@$detail->detail_bbk->detail_bbm->detail_pemesanan->detail_permintaan->satuan->nama == null){echo @$detail->barang->satuan->nama;}else{ echo @$detail->detail_bbk->detail_bbm->detail_pemesanan->detail_permintaan->satuan->nama; }  ?></td>

                       @if(number_format(@$detail->detail_bbk->detail_bbm->detail_pemesanan->detail_permintaan->harga) != 0)
                       <td>Rp.{{ number_format(@$detail->detail_bbk->detail_bbm->detail_pemesanan->detail_permintaan->harga) }}</td>
				@else
				<td>Rp.{{ number_format(@$detail->detail_bbk->detail_bbm->detail_pemesanan->detail_permintaan->harga + @$detail->harga) }}</td>
				@endif

                       @if(number_format(@$detail->detail_bbk->detail_bbm->detail_pemesanan->detail_permintaan->harga) != 0)
                       <td>Rp.{{ number_format(@$detail->jumlah*(@$detail->detail_bbk->detail_bbm->detail_pemesanan->detail_permintaan->harga)) }}</td>
				@else
				<td>Rp.{{ number_format(@$detail->jumlah*(@$detail->detail_bbk->detail_bbm->detail_pemesanan->detail_permintaan->harga + @$detail->harga)) }}</td>
				@endif

                       <td>{{ @$detail->detail_bbk->keterangan }}</td>

                   </tr>

                   <?php 
					if(number_format(@$detail->jumlah*@$detail->detail_bbk->detail_bbm->detail_pemesanan->detail_permintaan->harga != 0)){
						$total_semua += @$detail->jumlah*@$detail->detail_bbk->detail_bbm->detail_pemesanan->detail_permintaan->harga;
					}else{
						$total_semua += @$detail->jumlah*@$detail->harga;
					}
					?>

                
                @endif
                @endif
            @endforeach

            <tr>

                <td colspan="8"></td>

            </tr>

            <tr>

                <td colspan="5"></td>

                <td>Total:</td>

                <td colspan="2"><strong><u>Rp.{{ number_format($total_semua) }}</u></strong></td>

            </tr>

        </table>

        <br>

        <br>



        <table style="width: 100%;text-align: center;">

            <tr>

                        <td colspan="4" style="text-align: right;">Camp Bunut, {{ date('d F Y') }}</td>

            </tr>

            <tr>

                <td><br></td>

            </tr>

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

