<?php 
	$date = date('d/m/Y');
	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=permintaan_barang-".$r->nomor."- ".$date.".xls");
	header("Pragma: no-cache");
	header("Expires: 0");
 ?>

 

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{$r->nomor."-".$r->tanggal}}</title>

    <!-- Styles -->
    
    <link rel="stylesheet" type="text/css" href="{{ asset('bootstrap/theme/16/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('selectbox/css/bootstrap-select.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('jquery-ui/jquery-ui.min.css') }}">




    <script src="{{ asset('jquery/jquery-1.11.3.min.js') }}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('selectbox/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-notify.min.js') }}" ></script>

    <style type="text/css">
		body {
		    margin:8px;
		   
		    
		}

	</style>

	<style type="text/css" media="print">
	    @page {
	        
	        margin-right: 0;  /* this affects the margin in the printer settings */
	        margin-left: 0;
	        margin-top: 0;
	    }

	    
	</style>
    



</head>
<body>
<div class="container">
    <div class="row" style="margin:0;padding: 0;">
        <div class="col-md-12"  style="margin:0;padding: 0;">
            <div class="panel panel-default"  style="border: none;margin:0;padding: 0;">
               

                <div class="panel-body" style="border: none;margin:0;padding: 0;">
                	
                
                	<table width="70%">
                		<tr>
							<td>PT Utama Damai Indah Timber</td>
							<td align="center" ><h4><b>Permintaan Barang</b></h4><h6><b>Nomor : <?php echo @$r->nomor ?></b></h6></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>

                	</table>
                    <table border="0" cellpadding="5" cellspacing="0" width="100%" >

						

						<tr>
							<td rowspan="6"><img src="{{ url('images/udit.png') }}" width="125" height="90">
								<br><br><u>BC-Sei.Sentiang</u></td>
							<td ></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						
						<tr>
							<td style="width: 65%;"></td>
							<td></td>
							<td style="width: 15%;">Unit Code</td>
							<td style="width: 5%;" >:</td>
							<td  style="width: 25%;"><?php echo  $r->unit->kode; ?></td>
						</tr>
						<tr>
							<td style="width: 65%;"></td>
							<td></td>
							<td style="width: 15%;">Jenis Unit</td>
							<td style="width: 5%;">:</td>
							<td style="width: 25%;"><?php echo  $r->unit->jenis_unit->nama; ?></td>
						</tr>
						<tr>
							<td style="width: 65%;" ></td>
							<td></td>
							<td style="width: 15%;">E/N No</td>
							<td style="width: 5%;">:</td>
							<td style="width: 25%;"><?php echo @$r->unit->no_en ?></td>

						</tr>

						<tr>
							<td style="width: 65%;" ></td>
							<td></td>
							<td style="width: 15%;">S/N No</td>
							<td style="width: 5%;">:</td>
							<td style="width: 25%;"><?php echo @$r->unit->no_sn ?></td>

						</tr>

						
						<tr>
							<td style="width: 65%;" ></td>
							<td></td>
							<td style="width: 15%;">Tanggal</td>
							<td style="width: 5%;">:</td>
							<td style="width: 25%;"><?php echo @$r->tanggal ?></td>
						</tr>
						
						
					</table>

					
					
					<div style="clear: both;"></div>
					
					<br>


						<table border="1" cellpadding="5" cellspacing="0" width="100%">

							<thead style="text-align: center;">

								<tr  align="center" valign="center" style="text-align: center;">

									<th style="text-align: center;" rowspan="2">No</th>

									<th style="text-align: center;" colspan="2" >Spesifikasi Barang</th>

									<th style="text-align: center;">Fig /</th>

									<th style="text-align: center;">Item /</th>

									<th style="text-align: center;">Jumlah</th>
									<th style="text-align: center;">Keterangan</th>

								</tr >

								<tr align="center" style="text-align: center;">

									<th style="text-align: center;">Kode</th>

									<th style="text-align: center;">Nama</th>

									<th style="text-align: center;">Hal</th>

									<th style="text-align: center;">Indek</th>

									<th style="text-align: center;">Dipesan</th>

									<th style="text-align: center;"></th>

								</tr>

								

							</thead>

							<tbody>

								<?php $no=1 ?>

								<?php foreach ($r->detail as $d): ?>

									<tr align="center">

										<form  method="POST">

											<input type="hidden" name="id" value="<?php echo $d->id ?>">

											

											<td><?php echo $no ?></td>

											<td><?php echo $d->barang->kode ?></td>

											<td><?php echo $d->barang->nama ?></td>

											

											<td><?php echo $d->barang->halaman ?></td>

											<td><?php echo $d->barang->indeks ?></td>

											<td><?php echo $d->jumlah ?> <?php echo $d->barang->satuan->nama ?></td>

											<td><?php echo $d->keterangan ?></td>

										</form>

									</tr>

									<?php $no++ ?>

								<?php endforeach ?>
								@if($r->sifat == 1)
								<tr>
									<td colspan="6"></td>
									<td><img style="position: absolute;z-index: 99;bottom: 50px;right: 80px;" src="{{ url('images/urgent.png') }}"></td>
								</tr>
								@endif
							</tbody>

						</table>

						<br>

						<table border="0" cellpadding="5" cellspacing="0" width="100%">

							


							<tr align="center"  style="border: none;">

								<td>Dibuat Oleh</td>
								<td>Diperiksa Oleh</td>
								@if($r->diketahui != null)
									<td>Diketahui Oleh</td>
								@endif

								@if($r->disetujui != null)
									<td>Disetujui Oleh</td>
								@endif

							</tr>
							<tr align="center">
								<td >

									
									<div style="min-height: 100px;"></div>
								</td>
								<td>
									
								</td>
								<td>
									
								</td>
								<td>
									
								</td>
							</tr>

                            
                            <tr align="center" style="border: none;">
                                <td >{{ $r->pembuat->nama }}<br>{{ $r->pembuat->jabatan->nama }}</td>
                                <td >{{ $r->diperiksa->nama }}<br>{{ $r->diperiksa->jabatan->nama }}</td>
                                @if($r->diketahui != null)
                                	<td >{{ $r->diketahui->nama }}<br>{{ $r->diketahui->jabatan->nama }}</td>
                                @endif

                                @if($r->disetujui != null)
                                	<td >{{ $r->disetujui->nama }}<br>{{ $r->disetujui->jabatan->nama }}</td>
                                @endif
                            </tr>
							

						</table>
                    

                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>

		