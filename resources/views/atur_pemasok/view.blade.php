@extends('layouts.app')

@section('content')
<div class="container" style="width: 100%;">
    <div class="row">
        <div class="col-md-12" >
            <div class="panel panel-default">
                <div class="panel-heading">Atur Supplier<br><br> <a class="btn btn-default" href="{{ url('/set_supplier') }}">Kembali</a></div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ url('set_supplier/'.$r->id) }}">
                    	{{ csrf_field() }}
                    	<input type="hidden" name="_method" value="PUT">
						<div class="form-group">
							<label for="nomor" class="col-lg-2 control-label">Nomor Permintaan</label>
							<div class="col-lg-3">
								<input type="text" value="<?php echo @$r->nomor ?>" class="form-control" name="nomor" id="nomor" placeholder="Nomor Permintaan" required disabled>
							</div>
						</div>
						<div class="form-group">
							<label for="tanggal" class="col-lg-2 control-label">Tanggal</label>
							<div class="col-lg-3">
								<input type="text" value="<?php echo @$r->tanggal ?>" class="form-control datepickers" name="tanggal" id="tanggal" placeholder="Tanggal" required disabled>
							</div>
						</div>
						<div class="form-group">
							<label for="lokasi_id" class="col-lg-2 control-label">Kantor</label>
							<div class="col-lg-3">
								<select class="form-control selectpicker" name="lokasi_id" id="lokasi_id" data-live-search="true" disabled>
									<option></option>
									<?php foreach ($lokasi as $j): ?>
										<option value="<?php echo $j->id ?>" <?php if ($j->id == @$r->lokasi_id) {echo "selected";} ?>><?php echo $j->nama ?></option>
									<?php endforeach ?>				
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="merek_id" class="col-lg-2 control-label">Jenis Unit</label>
							<div class="col-lg-3">
								<input type="text" disabled class="form-control" value="{{ $r->unit->jenis_unit->nama }}-{{ $r->unit->jenis_unit->kode }}">
							</div>
						</div>
					    <div class="form-group">
							<label for="en_no" class="col-lg-2 control-label">Kode Unit</label>
							<div class="col-lg-3">
								<input type="text" disabled value="<?php echo @$r->unit->kode ?>" class="form-control" name="kode_unit" id="kode_unit" placeholder="Kode Unit">
							</div>
						</div>
						<div class="form-group">
							<label for="en_no" class="col-lg-2 control-label">E/N No</label>
							<div class="col-lg-3">
								<input type="text" disabled value="<?php echo @$r->unit->no_en ?>" class="form-control" name="en_no" id="en_no" placeholder="E/N No">
							</div>
						</div>
						<div class="form-group">
							<label for="sn_no" class="col-lg-2 control-label">S/N No</label>
							<div class="col-lg-3">
								<input type="text" disabled value="<?php echo @$r->unit->no_sn ?>" class="form-control" name="sn_no" id="sn_no" placeholder="S/N No">
							</div>
						</div>
					  
					    <div class="form-group">
							<label for="sn_no" class="col-lg-2 control-label">Unit</label>
							<div class="col-lg-3">
								<input type="text" disabled value="<?php echo @$r->unit->kode ?>" class="form-control" name="merek_unit" id="sn_no" placeholder="Unit">
							</div>
						</div>
						<div class="form-group">
							<label for="sifat" class="col-lg-2 control-label">Sifat</label>
							<div class="col-lg-3">
								<select class="form-control selectpicker" disabled name="sifat" id="sifat" data-live-search="true">
									<option></option>
									<option value="0" <?php if (@$r->sifat == 0) {echo "selected";} ?>>Biasa</option>
									<option value="1" <?php if (@$r->sifat == 1) {echo "selected";} ?>>Urgent</option>			
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="diketahui_id_2" class="col-lg-2 control-label">Diketahui oleh</label>
							<div class="col-lg-3">
								<select class="form-control selectpicker" name="diketahui_id_2" id="diketahui_id_2" data-live-search="true">
									<option></option>
									<?php foreach ($user as $u): ?>
										<option value="<?php echo $u->id ?>" <?php if ($u->id == @$r->diketahui_id_2) {echo "selected";} ?>><?php echo $u->nama ?></option>
									<?php endforeach ?>				
								</select>
							</div>
						</div>
						
						<div class="form-group">
							<div class="col-lg-10 col-lg-offset-2">
								
									
									<a href="{{ url('set_supplier?page='.$page) }}" class="btn btn-success">Selesai</a>
									
							</div>
						</div>
					
					<table class="table table-bordered table-hover" >
						<thead>
							<tr>
								<th>#</th>
								<th width="10%">Kode Barang</th>
								<th width="10%">Nama Barang</th>
								
								<th>Kode Unit</th>
							
								<th width="10%">Jumlah</th>
								<th>Satuan</th>
								<th width="10%">Harga</th>
								<th >Keterangan</th>
								<th>Pemasok</th>
								<th>Status</th>
								
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$no=1;
							
							use App\DetailPermintaanBarang;
							use App\Satuan;
							$satuan = Satuan::all();
							?>
							<?php foreach ($r->detail as $d): ?>
								
								@if($d->gabungan == '' || $d->gabungan == null)
								<tr>			
									
									@if($d->status != 2)

											
											
											<td><?php echo $no ?></td>
											<?php $db = DetailPermintaanBarang::where('gabungan','like','%'.$d->id.'%')->where('permintaan_id',$r->id)->get(); ?>
											<td><input class="form-control" type="text" name="kode_barang[]" value="@if($d->kode_barang == null ||  $d->kode_barang == ''){{ $d->barang->kode }}@else{{ $d->kode_barang }}<?php endif; ?>@if(count($db) > 0 || $d->gabungan != '')@foreach($db as $aa)/<?php echo $aa->barang->kode ?>@endforeach @endif"></td>
                                            <td><input class="form-control" type="text" name="nama_barang[]" value="@if($d->nama_barang == null){{ $d->barang->nama }}@else{{ $d->nama_barang }}<?php endif; ?>@if(count($db) > 0 || $d->gabungan != '')@foreach($db as $aa)/<?php echo $aa->barang->nama ?>@endforeach @endif"><input type="hidden" name="id_detail[]" value="<?php echo $d->id ?>"></td>
											<td><?php echo $d->barang->unit->kode ?> </td>
								
											<td>
												<input class="form-control" type="number" name="jumlah[]" value="<?php echo $d->jumlah ?>">
												
											</td>
											<td><select  class="form-control selectpicker" name="satuan_id[]"  data-live-search="true" required>
													
													<?php foreach ($satuan as $s): ?>

														<option  value="<?php echo $s->id ?>" <?php if(count($db) > 0 && $d->satuan_id == $s->id){ echo "selected";} ?> <?php if(count($db) == 0 && $d->satuan_id == $s->id) { echo "selected"; }?>><?php echo $s->nama ?></option>
													<?php endforeach ?>				
												</select></td>
											<td><input class="form-control format_harga" type="text" name="harga[]" harga_id="harga_{{ $d->id }}" value="<?php echo number_format($d->harga); ?>">
												<input class="form-control" type="hidden"   id="harga_{{ $d->id }}" value="<?php echo $d->harga ?>"></td>
											<td><textarea name="keterangan[]"><?php echo $d->keterangan ?></textarea></td>
											<td>
												<select  class="form-control selectpicker" name="pemasok_id[]" id="pemasok_id" data-live-search="true" required style="font-size: 10px;">
													
													<?php foreach ($pemasok as $p): ?>
														<option value="<?php echo $p->id ?>" <?php if ($p->id == @$d->pemasok_id) {echo "selected";} ?>><?php echo $p->nama ?></option>
													<?php endforeach ?>				
												</select>
											</td>
											<td>
												<?php if (@$d->status == 1) {echo "Tidak Ada";} ?>
												<?php if (@$d->status == 2) {echo "Ada";} ?>
												<?php if (@$d->status == 3) {echo "Pending";} ?>
											</td>
										
											<td><button idnya="{{ $d->id }}" type="button" class="btn btn-primary tombol_modal"  data-toggle="modal" data-target="#myModal"><i class="glyphicon glyphicon-plus"></i> Gabung Barang</button></td>
											
										
									@else
											
											<td><?php echo $no ?></td>
											<?php $db = DetailPermintaanBarang::where('gabungan','like','%'.$d->id.'%')->where('permintaan_id',$r->id)->get(); ?>
											<td><input disabled="" readonly="" class="form-control" type="text" name="kode_barang[]" value="@if($d->kode_barang == null ||  $d->kode_barang == ''){{ $d->barang->kode }}@else{{ $d->kode_barang }}<?php endif; ?>@if(count($db) > 0 || $d->gabungan != '')@foreach($db as $aa)/<?php echo $aa->barang->kode ?>@endforeach @endif"></td>
                                            <td><input disabled="" readonly="" class="form-control" type="text" name="nama_barang[]" value="@if($d->nama_barang == null){{ $d->barang->nama }}@else{{ $d->nama_barang }}<?php endif; ?>@if(count($db) > 0 || $d->gabungan != '')@foreach($db as $aa)/<?php echo $aa->barang->nama ?>@endforeach @endif"></td>
											<td><?php echo $d->barang->unit->kode ?></td>
										
											<td>
												<input disabled class="form-control" type="number" name="jumlah" value="<?php echo $d->jumlah ?>">
												<input disabled type="hidden" name="detail_id" value="<?php echo $d->id ?>">
											</td>
											
											<td>
												<select disabled class="form-control selectpicker" name="satuan_id[]"  data-live-search="true" required>
													
													<?php foreach ($satuan as $s): ?>

														<option  value="<?php echo $s->id ?>" <?php if(count($db) > 0 && $d->satuan_id == $s->id){ echo "selected";} ?> <?php if(count($db) == 0 && $d->satuan_id == $s->id) { echo "selected"; }?>><?php echo $s->nama ?></option>
													<?php endforeach ?>				
												</select>
											</td>
											<td><?php echo number_format($d->harga) ?></td>
											<td><textarea disabled name="keterangan"><?php echo $d->keterangan ?></textarea></td>
											<td>
												<select disabled class="form-control selectpicker" name="pemasok_id" id="pemasok_id" data-live-search="true" required>
													
													<?php foreach ($pemasok as $p): ?>

														<option value="<?php echo $p->id ?>" <?php if ($p->id == @$d->pemasok_id) {echo "selected";} ?>><?php echo $p->nama ?></option>
													<?php endforeach ?>				
												</select>
											</td>
											<td>
												<?php if (@$d->status == 1) {echo "Tidak Ada";} ?>
												<?php if (@$d->status == 2) {echo "Ada";} ?>
												<?php if (@$d->status == 3) {echo "Pending";} ?>
											</td>
											<td></td>
											
									@endif
								
								</tr>	
								<?php $no++ ?>		
								@endif
								
							<?php endforeach ?>
						</tbody>
					</table>
					<button type="submit" class="btn btn-success">Ubah</button>
					</form>

					<?php foreach ($r->detail as $d): ?>
						<form action="{{ url('detail_purchase_request/'.$d->id) }}" id="delete<?php echo $d->id;  ?>" method="POST">
                            {{ csrf_field() }}
                            <input type="hidden" name="_method" value="DELETE">
	                    </form>
                    <?php endforeach ?>

                    <div id="myModal" class="modal fade" role="dialog">
	                    <div class="modal-dialog">
	                        <div class="modal-content">
	                            <div class="modal-header">
	                                <button type="button" class="close" data-dismiss="modal">&times;</button>
	                                <h4 class="modal-title">Gabung Barang</h4>
	                            </div>
	                            <div class="modal-body" id="isi_modal">
	                                	<h4>Disarankan hanya gabungkan barang yang mempunya sn saja</h4>
	                                    <form method="post" action="{{ url('/set_supplier/gabung') }}">
	                                    	{{ csrf_field() }}
	                                    	<input type="hidden" name="id_parent" id="id_parent">
	                                    	<table class="table table-bordered table-hover" >
		                                    	<thead>
													<tr>
														
														<th width="10%">Kode Barang</th>
														<th width="10%">Nama Barang</th>
														
														<th>Pilih</th>
													</tr>
													
												</thead>
												<?php foreach ($r->detail as $d): ?>
													@if($d->gabungan == '' || $d->gabungan == null)
														<tr class="list-modal" id="idnya-{{ $d->id }}">
															<td>{{ $d->barang->kode }}</td>
															<td>{{ $d->barang->nama }}</td>
															<td><input type="checkbox" class="checkbox" name="gabung[]" value="{{ $d->id }}"></td>
														</tr>
														@endif

													<?php endforeach; ?>

		                                    </table>
		                                    <input type="submit" name="submit" value="Selesai">
	                                    </form>
	                                    
	                                
	                            </div>
	                            <div class="modal-footer">
	                               
	                                <button type="button" class="btn btn-default keluar_modal" data-dismiss="modal">Close</button>
	                            </div>
	                        </div>

	                    </div>
	                </div>

                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
	$(document).on('click', '.tombol_modal', function(event) {
		$("#idnya-"+$(this).attr("idnya")).hide();

		$("#id_parent").val($(this).attr("idnya"));
	});

	$(document).on('click', '.keluar_modal', function(event) {
		
		$(".list-modal").show();
	});

	// $(document).on('change', '.format_harga', function(event) {
		
	// 	var formatter = new Intl.NumberFormat('en-US', {
	  
	// 	  minimumFractionDigits: 3,
	// 	});
	// 	var amount = $(this).val();
	// 	$("#harga_"+$(this).attr('harga_id')).val(amount);
	// 	$(this).val(formatter.format(amount));
		
	// });

	// $(document).on('keyup', '.format_harga', function(event) {
		
	// 	var formatter = new Intl.NumberFormat('en-US', {
	  
	// 	  minimumFractionDigits: 3,
	// 	});
	// 	var amount = $(this).val();
	// 	$("#harga_"+$(this).attr('harga_id')).val(parseInt(amount));
	// 	$(this).val(formatter.format(parseInt(amount)));
		
	// });

	
</script>
@endsection




