@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Detail Barang Di Gudang</div>

                <div class="panel-body">
                    
                	<div class="col-md-4">
						<h2>Detail Barang</h2>
 
<?php use App\DetailPemesananBarang;$db = DetailPemesananBarang::where('gabungan','like','%'.$r->gabungan_id.'%')->get();?>
						<table class="table">
							<tr><th>Kode Barang</th><td>:</td><td><?php if($r->detail_bbm->detail_pemesanan->kode_barang != null || $r->detail_bbm->detail_pemesanan->kode_barang != ''){ echo $r->detail_bbm->detail_pemesanan->kode_barang; }else { echo $r->barang->kode; }?>
							@if($r->gabungan_id != null || $r->gabungan_id != '')
								@foreach($db as $aa)
                                                                 / <?php echo $aa->barang->kode ?>
                                                                @endforeach
                                                            @endif
							</td></tr>
							<tr><th>No OPB</th><td>:</td><td>{{ $r->detail_bbm->detail_pemesanan->detail_permintaan->permintaan->nomor }}</td></tr>
							<tr><th>No PO</th><td>:</td><td>{{ $r->detail_bbm->detail_pemesanan->pemesanan->nomor }}</td></tr>
							<tr><th>Nama Barang</th><td>:</td><td><?php if($r->detail_bbm->detail_pemesanan->nama_barang != null || $r->detail_bbm->detail_pemesanan->nama_barang != ''){ echo $r->detail_bbm->detail_pemesanan->nama_barang; }else { echo $r->barang->nama; }?>
							@if($r->gabungan_id != null || $r->gabungan_id != '')
								@foreach($db as $aa)
                                                                 / <?php echo $aa->barang->nama ?>
                                                                @endforeach
                                                                @endif
							</td></tr>
							
							<tr><th>Kode Unit</th><td>:</td><td><?php echo $r->barang->unit->kode ?></td></tr>
							<tr><th>Keterangan</th><td>:</td><td><?php echo $r->barang->keterangan ?></td></tr>
							<tr><th>Stok</th><td>:</td><td><?php echo $r->stok ?>
								
							</td></tr>
							<tr><th>Harga</th><td>:</td><td>Rp. <?php echo number_format($r->detail_bbm->detail_pemesanan->harga) ?>
						
							</td></tr>
							<tr><th>Satuan</th><td>:</td><td><?php echo $r->detail_bbm->detail_pemesanan->detail_permintaan->satuan->nama ?></td></tr>
						</table>

						<p></p>
						<a href="{{ url('warehouse?page='.$_GET['page']) }}" class="btn btn-default">Kembali</a>
					</div>
					<div class="col-md-4">
						<h2>Serial Barang</h2>
						<table class="table">
							<tr>
								<th>No</th>
								<th>SN</th>
								<th>Barcode</th>
							</tr>
							<?php $no = 1; ?>
							<?php foreach ($r->serial as $item) {
								?>
								<tr>
									<td>{{ $no++ }}</td>
									<td>{{ $item->sn }}</td>
									<td>@if($item->sn != '') <?php echo '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG($item->sn, "C39+") . '" alt="barcode"   />'; ?> @endif</td>
								</tr>
								<?php
							} ?>
							
							
						</table>

						
					</div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

