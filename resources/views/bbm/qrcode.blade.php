<!DOCTYPE html>
<html>
<head>
	<title>Download QrCode</title>
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
	img {
		width: 100px;
	}
</style>
<body onload="window.print()">
	<h1>QrCode BBM {{ $bbm->nomor }}</h1>
	@foreach($bbm->detail as $d)
		<?php echo "Barang : ".$d->barang->kode." - ".$d->detail_pemesanan->nama_barang." - Hal/Indeks : ".$d->barang->halaman."/".$d->barang->indeks ?>
		<?php echo "<br>"; ?>
		<br>
		<?php echo '<img src="data:image/png;base64,' . DNS2D::getBarcodePNG($d->barang->qrcode, "QRCODE") . '" alt="barcode"   />'; ?> 
		<br>
		<br>
		<?php echo $d->barang->qrcode; ?>
		<br>
		<?php echo "<hr>"; ?>
		<?php echo "<br>"; ?>
	@endforeach

</body>
</html>