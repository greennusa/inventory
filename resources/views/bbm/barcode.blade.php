<!DOCTYPE html>
<html>
<head>
	<title>Download Barcode</title>
</head>

<style type="text/css">
	@media print {
		body {
			width: 10,5cm;
			height: 3cm;
		}
	}

	body {
			width: 10,5cm;
			height: 3cm;
		}
</style>
<body onload="window.print()">
	<h1>Barcode BBM {{ $bbm->nomor }}</h1>
	@foreach($bbm->detail as $d)
		<?php echo "Barang : ".$d->detail_pemesanan->kode_barang." - ".$d->detail_pemesanan->nama_barang ?>
		<?php echo "<br>"; ?>
		@foreach($d->serial as $s)
			@if($s->sn != '') 
				<?php echo "<br>"; ?>
				<?php echo $s->sn; ?>
				<?php echo "<br>"; ?>
				<?php echo '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG($s->sn, "C39+") . '" alt="barcode"   />'; ?> 
				<?php echo "<br>"; ?>
			@endif
		@endforeach
		<?php echo "<hr>"; ?>
		<?php echo "<br>"; ?>
	@endforeach

</body>
</html>