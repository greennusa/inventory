<?php 

        $from = (int)date('m',strtotime($_GET['tanggal']));

        $tahun = date('Y',strtotime($_GET['tanggal']));

        $bulannya = ['array_bulan','JANUARI','FEBRUARI','MARET','APRIL','MEI','JUNI','JULI','AGUSTUS','SEPTEMBER','NOVEMBER','OKTOBER','DESEMBER'];  

        ?>

         <?php 

    $date = date('d/m/Y');

    header("Content-type: application/vhd.ms-word");

    header("Content-Disposition: attachment; filename=Dapur-".$bulannya[$from]."-".$tahun.".doc");

    header("Pragma: no-cache");

    header("Expires: 0");

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

	.container{
		margin-left:1px;
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

	use App\CampLama;

    use App\DetailBuktiBarangKeluar;

    use App\User;

    use App\DetailPemakaianBarangLama;

    use App\Dapur;

    $diketahui = User::findOrFail($_GET['diketahui']);


    $dibuat = User::findOrFail($_GET['dibuat']);

    $no = 1;

    $total_semua = 0;

    //$dapur = Dapur::all();

	$dapur = Dapur::where('id', '!=' , 0)->orWhereNull('id')->get();

    // $data = PemakaianBarang::where('piutang', '=', 1)->get();

    $p = Camp::where('dapur','>',0)->groupBy('nama_barang')->whereMonth('tanggal',$from)->whereYear('tanggal',$tahun)->get();

    $l = CampLama::where('dapur','>',0)->groupBy('nama_barang')->whereMonth('tanggal',$from)->whereYear('tanggal',$tahun)->get();

    $x = $p->toBase()->merge($l);
	
	$total_stok_awal = 0;
	$total_pembelian = 0;
	$total_pengeluaran = 0;
	$total_stok_akhir = 0;
	foreach($dapur as $d){
			$total_dapur[] = 0;
		}	
	
	
?>



<body onload="window.print()">

        <div class="col">

            <br>

            <br>

            <p class="ok">PT. UTAMA DAMAI INDAH TIMBER</p><br>  

            <center>

                <h5>LAPORAN DAPUR</h5>



                <u>PERIODE BULAN <?php echo $bulannya[$from]; ?> <?php echo $tahun; ?></u>

            </center>



	<?php
			
	?>

	

            <table class="table table-bordered table-hover">

                <thead>

                	<tr>

                    	<th rowspan="1">No</th>

                    	<th rowspan="1">Nama Barang</th>

                        <th colspan="2">Stok Awal</th>

                        <th colspan="2">Pembelian</th>

                    	@foreach($dapur as $d)

                    	@if($d->id != 0)

                    		<th colspan="2">{{ ucfirst($d->nama) }}</th>

                    	@endif

                    	@endforeach
						
						<th colspan="2">Jumlah Pengeluaran</th>
						<th colspan="2">Stok Akhir</th>

                    </tr>



                    <tr>

                    	<th></th>

                    	<th></th>

                        <th>Jumlah Barang</th>

                        <th>Total Harga</th>

                        <th>Jumlah Barang</th>

                        <th>Total Harga</th>

                    	@foreach($dapur as $d)

                    	@if($d->id != 0)

                    		<th>Jumlah Barang</th>

                    		<th>Total Harga</th>

                    	@endif

                    	@endforeach
						
						<th>Jumlah Barang</th>

                        <th>Total Harga</th>
						<th>Jumlah Barang</th>

                        <th>Total Harga</th>

                    </tr>

                </thead>



                <tbody>



                   @foreach($x as $detail)
					<?php $satuan = ""; 
						$total_awal = Camp::where('barang_id', $detail->barang_id)->sum('stok_awal');
					?>
                   	<tr>

                   		<td>{{ $no++ }}</td>

                   		<td>{{ $detail->barang->nama }}</td>

                        <?php $camp = Camp::where('barang_id', $detail->barang_id)->first() ?>

                        @if($camp != null)

                        <td>{{ $total_awal }} <?php echo @$camp->detail_bbk->detail_bbm->detail_pemesanan->detail_permintaan->satuan->nama; ?> </td>

                        <td>{{ number_format($camp->harga * $camp->stok_awal) }}</td>
						
						<?php $total_stok_awal += $camp->harga * $camp->stok_awal ?>

                        @else

                        <td> 0 </td>

                        <td> 0 </td>

                        @endif



                        <?php
							/*$total_stok = Camp::where('nama_barang', $detail->nama_barang)->whereMonth('tanggal',$from)->whereYear('tanggal',$tahun)->get();
							$tst = 0;
							foreach($total_stok as $ts){
								 $tst += $ts->detail_bbk->jumlah;
							}*/
							$pembelian = DetailBuktiBarangKeluar::findOrFail($detail->detail_bukti_barang_keluar_id); 
							$total_pembelian += $pembelian->harga * $pembelian->jumlah;
						?>

                        <td>{{ $pembelian->jumlah }} <?php echo @$pembelian->detail_bbm->detail_pemesanan->detail_permintaan->satuan->nama; ?>  </td>

                        <td>{{ number_format($pembelian->harga * $pembelian->jumlah) }}</td>

                        <?php
							$total = 0;
							$total_harga = 0;
							
						?>

                   		@foreach($dapur as $k => $d)
								<?php
									$p1 = Camp::where('dapur', $d->id)->whereMonth('tanggal',$from)->whereYear('tanggal',$tahun)->where('nama_barang', $detail->nama_barang)->first();

    								$l1 = CampLama::where('dapur', $d->id)->whereMonth('tanggal',$from)->whereYear('tanggal',$tahun)->where('nama_barang', $detail->nama_barang)->first();

    								$x1 = $p->toBase()->merge($l);
									
								?>
                   			
								
                   				

                   				<td>{{ number_format(@$p1->stok + @$l1->stok) }} @if(@$p1->detail_bbk != null)<?php echo @$p1->detail_bbk->detail_bbm->detail_pemesanan->detail_permintaan->satuan->nama;$total += @$p1->stok + @$l1->stok;?> @else <?php echo @$p1->satuan->nama; $total += @$p1->stok + @$l1->stok; ?>@endif</td>

                   				<td>{{ number_format(@$p1->harga * (@$p1->stok + @$l1->stok)) }} <?php $total_harga +=@$p1->harga * (@$p1->stok + @$l1->stok);?></td>

                   				

                   		<?php $total_dapur[$k] += @$p1->harga * (@$p1->stok + @$l1->stok); ?>

                   		@endforeach
						
						<td><?php echo $total; ?> <?php echo @$camp->detail_bbk->detail_bbm->detail_pemesanan->detail_permintaan->satuan->nama; ?> </td>
						<td>{{ number_format($total_harga) }} <?php $total_pengeluaran += $total_harga;?></td>
						<td><?php echo $camp->stok;   //echo ($pembelian->jumlah-$total) + $total_awal; echo "(".$camp->stok.")";  ?> <?php echo @$camp->detail_bbk->detail_bbm->detail_pemesanan->detail_permintaan->satuan->nama; ?></td>
						<td><?php echo number_format((($pembelian->harga * $pembelian->jumlah)-$total_harga) +($camp->harga * $camp->stok_awal)); $total_stok_akhir +=(($pembelian->harga * $pembelian->jumlah)-$total_harga) +($camp->harga * $camp->stok_awal);?></td>
						<?php
						
						
						
						?>
                   	</tr>

                   @endforeach
					<tr style="font-weight:bold">
						<td></td>
						<td>Total</td>
						<td></td>
						<td>{{ number_format($total_stok_awal) }}</td>
						<td></td>
						<td>{{ number_format($total_pembelian) }}</td>
						@foreach($dapur as $k => $d)
						<td></td>
						<td>{{number_format($total_dapur[$k])}}</td>
						@endforeach
						<td></td>
						<td>{{ number_format($total_pengeluaran) }}</td>
						<td></td>
						<td>{{ number_format($total_stok_akhir) }}</td>
						
					</tr>





                </tbody>



            </table>





             <br>

        <br>



        <table style="width: 100%;text-align: center;">

            <tr>

                        <td colspan="4" style="text-align: right;">{{ date('d F Y') }}</td>

                      </tr>

                    <tr><td><br><br></td></tr>

            <tr>

                <td>Diketahui Oleh</td>



                <td>Dibuat Oleh</td>

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

