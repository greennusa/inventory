@extends('layouts.app')



@section('content')

<div class="container">

    <div class="row">

        <div class="col-md-12">

            <div class="panel panel-default">

                <div class="panel-heading">Edit Permintaan Barang</div>



                <div class="panel-body">

                    <form class="form-horizontal" method="POST" action="{{ url('purchase_request/'.$r->id) }}">

                    	{{ csrf_field() }}

                    	<input type="hidden" name="_method" value="PUT">

						<div class="form-group">

						<label for="nomor" class="col-lg-2 control-label">Nomor Permintaan</label>

						<div class="col-lg-3">

							<input type="text" value="<?php echo @$r->nomor ?>" class="form-control" name="nomor" id="nomor" placeholder="Nomor Permintaan" required >

						</div>

					</div>

					<div class="form-group">

						<label for="tanggal" class="col-lg-2 control-label">Tanggal</label>

						<div class="col-lg-3">

							<input type="date" value="<?php echo @$r->tanggal ?>" class="form-control datepickers" name="tanggal" id="tanggal" placeholder="Tanggal" required>

						</div>

					</div>

					

					<div class="form-group">

						<label for="en_no" class="col-lg-2 control-label">Unit</label>

						<div class="col-lg-3">

							<input type="text" disabled value="<?php echo @$r->unit->kode ?>" class="form-control" name="unit->kode"   placeholder="Kode Unit">

						</div>

					</div>

				    <div class="form-group">

						<label for="en_no" class="col-lg-2 control-label">E/N No</label>

						<div class="col-lg-3">

							<input type="text" readonly value="<?php echo @$r->unit->no_en ?>" class="form-control" id="en_no" placeholder="E/N No">

						</div>

					</div>

					<div class="form-group">

						<label for="sn_no" class="col-lg-2 control-label">S/N No</label>

						<div class="col-lg-3">

							<input type="text" readonly value="<?php echo @$r->unit->no_sn ?>" class="form-control" id="sn_no" placeholder="S/N No">

						</div>

					</div>

					<div class="form-group">

						<label for="sifat" class="col-lg-2 control-label">Sifat</label>

						<div class="col-lg-3">

							<select class="form-control selectpicker" name="sifat" id="sifat" data-live-search="true">

								<option></option>

								<option value="0" <?php if (@$r->sifat == 0) {echo "selected";} ?>>Biasa</option>

								<option value="1" <?php if (@$r->sifat == 1) {echo "selected";} ?>>Urgent</option>			

							</select>

						</div>

					</div>

					<div class="form-group">

						<label for="destination" class="col-lg-2 control-label">Pilih Tujuan</label>

						<div class="col-lg-3">

							<select class="form-control selectpicker" name="destination" id="destination" data-live-search="true">

								<option value="Camp" <?php if (@$r->destination == "Camp") {echo "selected";} ?>>Camp</option>

								<option value="Kantor" <?php if (@$r->destination == "Kantor") {echo "selected";} ?>>Kantor</option>	

							</select>

						</div>

					</div>

					<div class="form-group">

						<label for="tanggal" class="col-lg-2 control-label">Keterangan</label>

						<div class="col-lg-3">

							<textarea class="form-control" name="keperluan" id="Keperluan" placeholder="Keterangan" maxlength="255" ><?php echo @$r->keperluan ?></textarea>

						</div>

					</div>



					<div class="form-group">

							<label for="pembuat_id" class="col-lg-2 control-label">Dibuat oleh</label>

							<div class="col-lg-3">

								<select class="form-control selectpicker" name="pembuat_id" id="pembuat_id" data-live-search="true" required>

									<option></option>

									<?php foreach ($user as $u): ?>

										<option value="<?php echo $u->id ?>" <?php if ($u->id == @$r->pembuat_id) {echo "selected";} ?>><?php echo $u->nama ?></option>

									<?php endforeach ?>				

								</select>

								<span style="color:red; font-size:13px" class="help-block">Wajib diisi</span>

							</div>

						</div>



						<div class="form-group">

						<label for="diperiksa_id" class="col-lg-2 control-label">Diperiksa oleh</label>

						<div class="col-lg-3">

							<select class="form-control selectpicker" name="diperiksa_id" id="diperiksa_id" data-live-search="true" required>

								<option></option>

								<?php foreach ($user as $u): ?>

									<option value="<?php echo $u->id ?>" <?php if ($u->id == @$r->diperiksa_id) {echo "selected";} ?>><?php echo $u->nama ?></option>

								<?php endforeach ?>				

							</select>

							<span style="color:red; font-size:13px" class="help-block">Wajib diisi</span>

						</div>

					</div>



					<div class="form-group">

						<label for="diketahui_id" class="col-lg-2 control-label">Diketahui oleh</label>

						<div class="col-lg-3">

							<select class="form-control selectpicker" name="diketahui_id" id="diketahui_id" data-live-search="true" >

								<option></option>

								<?php foreach ($user as $u): ?>

									<option value="<?php echo $u->id ?>" <?php if ($u->id == @$r->diketahui_id) {echo "selected";} ?>><?php echo $u->nama ?></option>

								<?php endforeach ?>				

							</select>

							

						</div>

					</div>

					

					<div class="form-group">

						<label for="disetujui_id" class="col-lg-2 control-label">Disetujui oleh</label>

						<div class="col-lg-3">

							<select class="form-control selectpicker" name="disetujui_id" id="disetujui_id" data-live-search="true">

								<option></option>

								<?php foreach ($user as $u): ?>

									<option value="<?php echo $u->id ?>" <?php if ($u->id == @$r->disetujui_id) {echo "selected";} ?>><?php echo $u->nama ?></option>

								<?php endforeach ?>

							</select>

							

						</div>

					</div>

					<div class="form-group">

						<div class="col-lg-10 col-lg-offset-2">

							

								<button type="submit" class="btn btn-primary">Ubah</button>

								<a href="{{ url('purchase_request?page='.$page) }}" class="btn btn-success">Selesai</a>

							

						</div>

					</div>

				</form>







					<form class="form-inline" method="POST" action="{{ url('detail_purchase_request') }}">

						<input type="hidden" name="permintaan_id" value="<?php echo $r->id ?>">

						{{ csrf_field() }}

						<div class="form-group" style="max-width: 30%;">

							<select class="form-control selectpicker" name="barang_id[]" multiple id="barang_id" data-live-search="true">

								<option>Barkode/Kode Barang</option>

								<?php foreach ($barang as $b): ?>

									<option value="<?php echo $b->id ?>"><?php echo $b->kode." - ".$b->nama." - hal : ".$b->halaman." - indeks : ".$b->indeks ?></option>

								<?php endforeach ?>				

							</select>

						</div>

						<button type="submit" class="btn btn-default">Tambahkan</button>

						<button type="button" data-toggle="modal" data-target="#new-item" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> Barang Baru</button>

					</form>

					<p></p>

					<form action="{{ url('detail_purchase_request/'.$r->id) }}" method="POST">

						{{ csrf_field() }}

						<input type="hidden" name="_method" value="PUT">

						<table class="table table-bordered table-hover">

							<thead>

								<tr>

									<th>#</th>

									<th>Kode Barang</th>

									<th>Nama Barang</th>

									

									<th>Kode Unit</th>

									<th>Halaman</th>

									<th>Indeks</th>

									<th width="100px">Jumlah</th>

									<th>Satuan</th>

									<th>Harga</th>

									<th>Keterangan</th>

									<th width="160px">Aksi</th>

								</tr>

							</thead>

							<tbody>

								<?php $no=1 ?>

								<?php foreach ($r->detail as $d): ?>

									<tr>

										

											<input type="hidden" name="id_detail[]" value="<?php echo $d->id ?>">

											

										

											<td><?php echo $no ?></td>

											<td><?php echo $d->barang->kode ?></td>

											<td>
                                                @if($d->nama_barang == null){{ $d->barang->nama }}@else{{ $d->nama_barang }}@endif
                                            </td>

											

											<td><?php echo $d->barang->unit->kode ?></td>

											<td><?php echo $d->barang->halaman ?></td>

											<td><?php echo $d->barang->indeks ?></td>

											<td>

												<input class="form-control" type="number" name="jumlah[]" value="<?php echo $d->jumlah ?>">

												

											</td>

											<td>

												

												<select  class="form-control selectpicker" name="satuan_id[]"  data-live-search="true" required>

													

													<?php foreach ($satuan as $s): ?>



														<option  value="<?php echo $s->id ?>" <?php if($d->satuan_id == $s->id){ echo "selected";} ?>><?php echo $s->nama ?></option>

													<?php endforeach ?>				

												</select>

											</td>

											<td>Rp.<?php echo number_format($d->barang->harga) ?></td>

											<td><input class="form-control" type="text" name="keterangan[]" value="<?php if($d->keterangan == null) {

												echo $d->barang->keterangan	;

											} else {

												echo $d->keterangan;

											} ?>"></td>

											<td>

												

												<a class="btn btn-danger" onclick="event.preventDefault();

	                                                     document.getElementById('delete<?php echo $d->id;  ?>').submit();return confirm('Apakah anda yakin akan menghapus data ini?');"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Hapus</a>

												<a class="btn btn-primary" href="{{ url('item/'.$d->barang->id.'/edit?page=1') }}" target="_blank"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Ubah</a>

											</td>

										

									</tr>

									<?php $no++ ?>



			                                    

								<?php endforeach ?>

							</tbody>

						</table>

						<button type="submit" class="btn btn-primary">Ubah Detail Permintaan</button>

					</form>



					<?php foreach ($r->detail as $dd): ?>

						<form action="{{ url('detail_purchase_request/'.$dd->id) }}" id="delete<?php echo $dd->id;  ?>" method="POST">

                            {{ csrf_field() }}

                            <input type="hidden" name="_method" value="DELETE">

	                    </form>

                    <?php endforeach ?>





                </div>

            </div>

        </div>

    </div>

</div>



<!-- Modal -->

<div id="new-item" class="modal fade" role="dialog">

  <div class="modal-dialog">



    <!-- Modal content-->

    <div class="modal-content">

      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal">&times;</button>

        <h4 class="modal-title">Barang Baru</h4>

      </div>

      <div class="modal-body">

        <form class="form-horizontal" enctype="multipart/form-data" method="post" accept-charset="utf-8" action="{{ url('item_baru') }}">

        	<div class="row">

        		<div class="col-md-6">

	        		 {{ csrf_field() }}

	        		 <input type="hidden" name="permintaan_id" value="{{ $r->id }}">

	                <div class="form-group">



	                    <label for="nama" class="col-lg-6 control-label">Nama Barang</label>



	                    <div class="col-lg-6">



	                        <input type="text"  class="form-control" name="nama" id="nama" placeholder="Nama Barang" required>



	                    </div>



	                </div>



	                <div class="form-group">



	                    <label for="kode" class="col-lg-6 control-label">No. Part / Kode</label>



	                    <div class="col-lg-6">



	                        <input type="text"  class="form-control" name="kode" id="kode" placeholder="No. Part / Kode Pabrikan" required>



	                    </div>



	                </div>



	                <div class="form-group">



	                    <label for="kategori_id" class="col-lg-6 control-label">Kategori</label>



	                    <div class="col-lg-6">



	                        <select class="form-control selectpicker"  name="kategori_id" id="kategori_id" data-live-search="true">



	                            <option></option>   



	                            @foreach ($kategori as $k)



	                                <option value="<?php echo $k->id ?>"><?php echo $k->nama ?></option>



	                            @endforeach            



	                        </select>

	                        @if ($errors->has('kategori_id'))

	                            <span class="help-block">

	                                <strong>{{ $errors->first('kategori_id') }}</strong>

	                            </span>

	                        @endif



	                    </div>



	                </div>



	                <div class="form-group">



	                    <label for="unit_id" class="col-lg-6 control-label">Unit</label>



	                    <div class="col-lg-6">



	                        <input type="text" class="form-control "  value="{{ @$r->unit->kode }}" disabled="" readonly="">

	                        <input type="hidden" name="unit_id" value="{{ @$r->unit->id }}">



	                        @if ($errors->has('unit_id'))

	                            <span class="help-block">

	                                <strong>{{ $errors->first('unit_id') }}</strong>

	                            </span>

	                        @endif



	                    </div>



	                </div>





	                



	                <div class="form-group">



	                    <label for="harga" class="col-lg-6 control-label">Harga Barang</label>



	                    <div class="col-lg-6">



	                        <input type="text"  class="form-control" name="harga" id="harga" placeholder="Harga Barang" required>



	                    </div>



	                </div>



	                <div class="form-group">



	                    <div class="col-lg-10 col-lg-offset-2">



	                        <input  type=button value=Batal class="btn btn-default" data-dismiss="modal">



	                        <button type="submit" class="btn btn-primary">Simpan</button>



	                    </div>



	                </div>



	        	</div>



	        	<div class="col-md-6">

	        		<div class="form-group">



	                    <label for="halaman" class="col-lg-6 control-label">Halaman</label>



	                    <div class="col-lg-6">



	                        <input type="text"  class="form-control" name="halaman" id="halaman" placeholder="Halaman" >



	                    </div>



	                </div>



	                <div class="form-group">



	                    <label for="indeks" class="col-lg-6 control-label">Indeks</label>



	                    <div class="col-lg-6">



	                        <input type="text"  class="form-control" name="indeks" id="indeks" placeholder="Indeks" >



	                    </div>



	                </div>



	                <div class="form-group">



	                    <label for="satuan_id" class="col-lg-6 control-label">Satuan</label>



	                    <div class="col-lg-6">



	                        <select class="form-control selectpicker"  name="satuan_id" id="satuan_id" data-live-search="true">



	                            <option></option>



	                            @foreach ($satuan as $s)



	                                <option value="<?php echo $s->id ?>" ><?php echo $s->nama ?></option>



	                            @endforeach          



	                        </select>

	                        @if ($errors->has('satuan_id'))

	                            <span class="help-block">

	                                <strong>{{ $errors->first('satuan_id') }}</strong>

	                            </span>

	                        @endif



	                    </div>



	                </div>



	                <div class="form-group">



	                    <label for="keterangan" class="col-lg-6 control-label">Keterangan</label>



	                    <div class="col-lg-6">



	                        <input type="text"  class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan">



	                    </div>



	                </div>



	                    



	                <div class="form-group">



	                    <label for="gambar" class="col-lg-6 control-label">Gambar Barang</label>



	                    <div class="col-lg-6">



	                        <input type="file" name="userfile" id="userfile" class="form-control">



	                    </div>



	                </div>



	                <div class="form-group">



	                    <label for="pakai_sn" class="col-lg-6 control-label">Menggunakan Serial Number?</label>



	                    <div class="col-lg-6">



	                        <select class="form-control" name="pakai_sn" id="pakai_sn">



	                            

	                                <option value="1" > Iya</option>   



	                            

	                                <option value="0" > Tidak</option>  



	                            

	                        </select>

	                        <span style="color:red; font-size:13px" class="help-block">Disarankan pilih "Tidak" untuk barang yang pada saat di pesan berjumlah banyak</span>

	                    </div>



	                </div>   



	                

	        	</div>

        	</div>

	        	

        </form>

      </div>

      <div class="modal-footer">

        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

      </div>

    </div>



  </div>

</div>

@endsection



