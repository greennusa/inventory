<?php 
	$date = date('d/m/Y');
	header("Content-type: application/vhd.ms-word");
	header("Content-Disposition: attachment; filename=pemakaian-".$r->tanggal."- ".$date.".doc");
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

    th,td {
    	padding: 5px;
    }
</style>
<body onload="window.print()">
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default"  style="border: none;">
                <div class="panel-body" style="border: none;">
                	<table width="100%" >
						<tr>
							<td colspan="6" align="right">Lokasi : {{ $r->lokasi }}</td>
						</tr>
						<tr>
							<td colspan="6" align="right">Tanggal : {{ $r->tanggal }}</td>
						</tr>
						<tr>
							<td colspan="6" align="center"><h5>BON PENYERAHAN BARANG</h5><h5>PT.Utama Damai Indah Timber</h5></td>
						</tr>
						<tr>
							<td colspan="6"><br><br><br></td>
						</tr>
						
					</table>
					<table style="width: 100%;word-break: break-all;text-align: center;" border="1">
					    <thead>
					        <tr>
					        	<th>Kode Barang/No Part</th>
					            <th>Nama Barang</th>
								
								<th>Qty</th>
								<th>Harga Satuan</th>
								<th>Jumlah</th>
								<th>Keterangan</th>
					        </tr>
					    </thead>
					    <tbody>
					        
					        <?php $ttl_jumlah = 0;$ttl_harga =0; foreach ($r->detail_semua as $d): $total = @$d->jumlah * @$d->detail_bbk->detail_bbm->detail_pemesanan->harga+@$d->camp_lama->harga; ?>
					            @if(@$d->gabungan == '' || @$d->gabungan == null)
						            <tr align="center">
						               <?php $db = \App\DetailPemesananBarang::where('gabungan','like','%'.@$d->gabungan_id.'%')->get();?>
				                                                <td>
				                                                    <<?php if(@$d->detail_bbk->detail_bbm->detail_pemesanan->kode_barang != null){ echo @$d->detail_bbk->detail_bbm->detail_pemesanan->kode_barang; }else if(@$d->detail_bbk == null){ echo $d->camp_lama->kode_barang;} else { echo @$d->barang->kode; }?>
					                                                    <?php if($d->detail_bbk != null):foreach($db as $dd): ?>
					                                                     / <?php echo @$dd->barang->kode ?>
					                                                    <?php endforeach;endif; ?>
				                                                </td>
				                                                <td>
				                                                    <?php if(@$d->detail_bbk->detail_bbm->detail_pemesanan->nama_barang != null){ echo @$d->detail_bbk->detail_bbm->detail_pemesanan->nama_barang; }else if(@$d->detail_bbk == null){ echo $d->camp_lama->nama_barang;} else { echo @$d->barang->nama; }?> 
					                                                    <?php if($d->detail_bbk != null):foreach($db as $dd): ?>
					                                                     / <?php echo @$dd->barang->nama ?>
					                                                    <?php endforeach;endif; ?>
				                                                </td>
						                
						                <td>
						                    <?php echo @$d->jumlah;$ttl_jumlah+=@$d->jumlah; ?> <?php echo @$d->detail_bbk->detail_bbm->detail_pemesanan->detail_permintaan->satuan->nama ?><?php echo @$d->camp_lama->satuan->nama ?>
						                </td>
						                <td>
						                    Rp.<?php echo number_format(@$d->detail_bbk->detail_bbm->detail_pemesanan->harga+@$d->camp_lama->harga) ?>
						                </td>
						                <td>
						                	Rp.<?php $ttl_harga += $total; echo number_format($total) ?>
						                </td>
						               
						                <td>
						                    <?php echo @$d->detail_bbk->keterangan ?>
						                    <input disabled type="hidden" name="detail_keterangan[]" class="form-control" value="<?php echo @$d->keterangan ?>">
						                </td>
						                
						            </tr>
						         @endif
					            
					        <?php endforeach ?>
					        <tr>
					        	
					        	<td colspan="2" style="text-align: right;">Total :</td>
					        	<td>{{ $ttl_jumlah }}</td>
					        	<td ></td>
					        	<td colspan="2">Rp.{{ number_format($ttl_harga) }}</td>
					        	
					        </tr>
					    </tbody>
					</table>

					<table width="100%" style="text-align: center;">
						<tr>
							<td colspan="6"><br><br></td>
						</tr>
						<tr>
							<td colspan="2">
								Diketahui Oleh
							</td>
							<td colspan="2">
								Diterima Oleh
							</td>
							<td colspan="2">
								Dibuat Oleh
							</td>
						</tr>
						<tr>
							<td colspan="6"><br><br></td>
						</tr>
						<tr>
							<td colspan="6"><br><br></td>
						</tr>
						<tr>
							<td colspan="2">
								{{ $r->diketahui->nama }}
								</strong>
							</td>
							<td colspan="2">
								{{ $r->diterima }}
								</strong>
							</td>
							<td colspan="2">
								{{ $r->dibuat->nama }}
								</strong>
							</td>
						</tr>
					</table>
                </div>
            </div>
        </div>
    </div>
</div>
					
</body>
	