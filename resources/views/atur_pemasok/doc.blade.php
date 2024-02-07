<?php 
$date = date('d/m/Y');
header("Content-type: application/vhd.ms-word");
header("Content-Disposition: attachment; filename=Laporan_Supplier - ".$date.".doc");
header("Pragma: no-cache");
header("Expires: 0"); 
?>

<table width="100%">
	<tr>
		
		<td>From</td>
		<td width="1%">:</td>
		<td><b><?php echo @$r->lokasi->nama; ?></b></td>
	</tr>
	<tr>
		
		<td>Telp</td>
		<td width="1%">:</td>
		<td><b>0541-742756</b></td>
	</tr>
	<tr>
		
		<td>Fax</td>
		<td width="1%">:</td>
		<td><b>0541-731305</b></td>
	</tr>
	<tr>
		<td>Tanggal</td>
		<td width="1%">:</td>
		<td align="left"><b><?=$r->tanggal; ?></b></td>
		
		
	</tr>
	<tr>
		<td>Di</td>
		<td width="1%">:</td>
		<td ><b>S a m a r i n d a</b></td>
	</tr>
</table>
<br>
	<table border="1" width="100%">
		<thead>
			<tr>
				<th>No.</th>
				<th>Kode Barang</th>
				<th>Nama Barang</th>
				<th>Qty</th>
				<th>Harga Satuan</th>
				<th>Total</th>
				<th>Keterangan</th>
				<th>Pemasok</th>
			</tr>
		</thead>
		<tbody>
			<?php $no=1 ?>
			<?php foreach ($r->detail as $d): ?>
				<tr>
						<td><?php echo $no ?></td>
						<td><?php echo $d->barang->kode ?></td>
						<td><?php echo $d->barang->nama ?></td>
						<td><?php echo $d->jumlah." ".$d->nama_satuan; ?></td>
						
						<td>Rp.<?php echo number_format($d->harga); ?></td>
						<td>Rp.<?php echo number_format($d->jumlah * $d->harga); ?></td>
						<td><?php echo $d->keterangan ?></td>
						<td><?php echo $d->pemasok->nama; ?></td>
					</form>
				</tr>
				<?php $no++ ?>
			<?php endforeach ?>
		</tbody>
	</table>