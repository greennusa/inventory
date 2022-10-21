<?php 
	$date = date('d/m/Y');
	header("Content-type: application/vhd.ms-word");
	header("Content-Disposition: attachment; filename=retur_barang-".$r->nomor."- ".$date.".doc");
	header("Pragma: no-cache");
	header("Expires: 0");
 ?>
<link rel="stylesheet" type="text/css" href="{{ asset('bootstrap/theme/16/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('selectbox/css/bootstrap-select.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('jquery-ui/jquery-ui.min.css') }}">
<style type="text/css" media="print">
    @page {
        size: auto;   /* auto is the initial value */
        margin-bottom: 0;  /* this affects the margin in the printer settings */
    }
</style>
<style type="text/css">
    th,td {
        padding: 5px;
    }
</style>
<body >
<div class="container">
    <div class="row" style="margin:0;padding: 0;">
        <div class="col-md-12"  style="margin:0;padding: 0;">
            <div class="panel panel-default"  style="border: none;margin:0;padding: 0;">
               

                <div class="panel-body" style="border: none;margin:0;padding: 0;">
                	<br>
                	<br>
                	<br>
                	<br>
                	<br>
                	<table width="100%" style="width: 100%;font-size: 10px;text-align: center;">
						<tr>
							<td  colspan="2" ></td>

						</tr>
						
						
						<tr>
							<td colspan="6" align="center"><h5>SURAT PENGIRIMAN BARANG</h5><h6>NO : {{ $r->nomor }}</h6></td>
						</tr>
						
						<tr>
							<td colspan="6" style="text-align: left;">Harap diterima dengan baik <br>Barang tersebut dibawah ini</td>
						</tr>
						
					</table>
					<table style="word-break: break-all;width: 100%;font-size: 10px;text-align: center;" border="1">
					    <thead>
					        <tr>
					        	<th>No</th>
					            <th>Nama Barang</th>
								<th>Kode Barang/No Part</th>
								<th>Qty</th>
								
								<th>Keterangan</th>
					        </tr>
					    </thead>
					    <tbody>
					        
					        <?php $no = 1;foreach ($r->detail as $d): $total = $d->jumlah * $d->detail_bbk->harga; ?>
					            <?php $db = \App\DetailPemesananBarang::where('gabungan','like','%'.$d->detail_bbk->gabungan_id.'%')->get();?>
					            <tr align="center">
					                <td>
					                	{{ $no++ }}
					                </td>
					                <td>
					                	<?php if($d->detail_bbk->detail_bbm->detail_pemesanan->nama_barang != null || $d->detail_bbk->detail_bbm->detail_pemesanan->nama_barang != ''){ echo $d->detail_bbk->detail_bbm->detail_pemesanan->nama_barang; }else { echo $d->barang->nama; }?> 
				                                                    <?php foreach($db as $dd): ?>
				                                                                     / <?php echo $dd->barang->nama ?>
				                                                                    <?php endforeach; ?>
					                </td>
					                <td>
					                	<?php if($d->detail_bbk->detail_bbm->detail_pemesanan->kode_barang != null || $d->detail_bbk->detail_bbm->detail_pemesanan->kode_barang != ''){ echo $d->detail_bbk->detail_bbm->detail_pemesanan->kode_barang; }else { echo $d->barang->kode; }?>
				                                                    <?php foreach($db as $dd): ?>
				                                                                     / <?php echo $dd->barang->kode ?>
				                                                                    <?php endforeach; ?>
					                </td>
					                
					                <td>
					                    <?php echo $d->jumlah ?> <?php echo $d->detail_bbk->detail_bbm->detail_pemesanan->detail_permintaan->satuan->nama ?>
					                </td>
					                
					               
					                <td>
					                    <?php echo $d->keterangan ?>
					                    <input disabled type="hidden" name="detail_keterangan[]" class="form-control" value="<?php echo $d->keterangan ?>">
					                </td>
					                
					            </tr>
					           
					        <?php endforeach ?>
					    </tbody>
					</table>

					<table width="100%" >
						<tr>
							<td colspan="6" align="right">Tanggal : {{ $r->tanggal }}</td>
						</tr>
						<tr>
							<td colspan="6"><br><br></td>
						</tr>

						<tr align="center">
							<td colspan="2">
								Diterima Oleh
							</td>
							<td colspan="2">
								Dibawa Oleh
							</td>
							<td colspan="2">
								Dikirim Oleh
							</td>
						</tr>
						<tr >
							<td colspan="6"><br><br></td>
						</tr>
						<tr>
							<td colspan="6"><br><br></td>
						</tr>
						<tr align="center">
							<td colspan="2">
								{{ $r->diterima->nama }}
							</td>
							<td colspan="2">
								{{ $r->dibawa->nama }}
							</td>
							<td colspan="2">
								{{ $r->dikirim->nama }}
							</td>
						</tr>
					</table>
                </div>
            </div>
        </div>
    </div>
</div>
					
</body>
	