@extends('layouts.app')



@section('content')

<div class="container">

    <div class="row">

        <div class="col-md-12">

            <div class="panel panel-default">

                <div class="panel-heading">Detail Barang Di Camp<br><br> <a class="btn btn-default" href="{{ url('/warehouse_udit') }}">Kembali</a></div>



                <div class="panel-body">

                    

                	<div class="col-md-4">

						<h2>Detail Barang</h2>

						<?php use App\DetailPemesananBarang;$db = DetailPemesananBarang::where('gabungan','like','%'.@$r->gabungan_id.'%')->get();?>

						<table class="table">

							<tr><th>Kode Barang</th><td>:</td><td><?php if(@$r->detail_bbk->detail_bbm->detail_pemesanan->kode_barang != null || @$r->detail_bbk->detail_bbm->detail_pemesanan->kode_barang != ''){ echo @$r->detail_bbk->detail_bbm->detail_pemesanan->kode_barang; }else { echo @$r->barang->kode; }?>

							@if(@@$r->gabungan_id != null || @$r->gabungan_id != '')

								@foreach($db as $aa)

                                                                 / <?php echo $aa->barang->kode ?>

                                                                @endforeach

                                                            @endif

							</td></tr>

							

							<tr><th>Nama Barang</th><td>:</td><td><?php if(@$r->detail_bbk->detail_bbm->detail_pemesanan->nama_barang != null || @$r->detail_bbk->detail_bbm->detail_pemesanan->nama_barang != ''){ echo @$r->detail_bbk->detail_bbm->detail_pemesanan->nama_barang; }else { echo @$r->barang->nama; }?>

							@if(@$r->gabungan_id != null || @$r->gabungan_id != '')

								@foreach($db as $aa)

                                                                 / <?php echo $aa->barang->nama ?>

                                                                @endforeach

                                                                @endif</td></tr>

							

							<tr><th>Unit</th><td>:</td><td>{{ @$r->barang->unit->kode }} / <?php echo @$r->barang->unit->jenis_unit->nama ?></td></tr>

							<tr><th>Keterangan</th><td>:</td><td><?php echo @$r->keterangan ?></td></tr>

							<tr><th>Stok</th><td>:</td><td><?php echo @$r->stok ?></td></tr>

							<tr><th>Satuan</th><td>:</td><td><?php echo @$r->detail_bbk->detail_bbm->detail_pemesanan->detail_permintaan->satuan->nama ?>{{ @$r->satuan->nama }}</td></tr>

							

							

						</table>



						<p></p>

						<a href="{{ url('warehouse_udit?page='.$_GET['page']) }}" class="btn btn-default">Kembali</a>

					</div>

					<div class="col-md-6">

						<h2>Serial Barang</h2>

						<table class="table">

							<tr>

								<th>No</th>

								<th>SN</th>

								<th>OPB</th>

								<th>Barcode</th>

								<th>No. PO</th>

								<th>Tanggal</th>

								<th>Harga</th>

							</tr>

							<?php $no = 1; ?>

							<?php foreach (@$r->serial as $item) {

								?>

								<tr>

									<td>{{ $no++ }}</td>

									<td>{{ $item->sn }}</td>

									<td>{{ @$item->permintaan->nomor }}</td>

									<td>@if($item->sn != '') <?php echo '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG($item->sn, "C39+") . '" alt="barcode"   />'; ?> @endif</td>

									<td>{{ @$item->detail_bbk->detail_bbm->detail_pemesanan->pemesanan->nomor }}</td>

									<td>{{ $item->created_at->format('Y-m-d') }}</td>

									<td>Rp. <?php
									echo number_format(@$item->detail_bbk->detail_bbm->detail_pemesanan->harga + @$item->camp_lama->harga);
									//  echo number_format(@$item->detail_bbk->detail_bbm->detail_pemesanan->harga);
										//echo number_format(@$item->camp->harga + @$item->camp_lama->harga);
									?></td>

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



