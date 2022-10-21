@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Persetujuan</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" >
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
								<input disabled type="text" name="" class="form-control" value="{{ $r->unit->jenis_unit->nama }}-{{ $r->unit->jenis_unit->kode }}">
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
						<label for="disetujui_id_2" class="col-lg-2 control-label">Disetujui oleh</label>
						<div class="col-lg-3">
							<select class="form-control selectpicker" name="disetujui_id_2" id="disetujui_id_2" data-live-search="true" required>
								<option></option>
								<?php foreach ($user as $u): ?>
									<option value="<?php echo $u->id ?>" <?php if ($u->id == @$r->disetujui_id_2) {echo "selected";} ?>><?php echo $u->nama ?></option>
								<?php endforeach ?>
							</select>
							
						</div>
					</div>
						<div class="form-group">
							<label for="setuju" class="col-lg-2 control-label">Setuju</label>
							<div class="col-lg-3">
								
								<select class="form-control selectpicker" name="setuju" id="setuju" data-live-search="true" required>
									<option></option>
									<option value="1" <?php if (@$r->setuju == 1) {echo "selected";} ?>>Tidak</option>
									<option value="2" <?php if (@$r->setuju == 2) {echo "selected";} ?>>Ya</option>			
								</select>
							</div>
						</div>
						<div class="form-group">
							<div class="col-lg-10 col-lg-offset-2">
									<a class="btn btn-default" href="<?php echo url('approval?page='.$_GET['page']) ?>">Kembali</a>
									<button type="submit" class="btn btn-success" >Selesai</button>
							</div>
						</div>
						<input type="hidden" name="page" value="{{ $_GET['page'] }}">
					</form>
					setujui semua <input type="checkbox" id="setujui_semua">

					<form  method="POST" action="{{ url('approval/'.$r->id.'/detail') }}">
						<input type="hidden" name="page" value="{{ $_GET['page'] }}">
						{{ csrf_field() }}
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th>#</th>
									<th>Kode Barang</th>
									<th>Nama Barang</th>
								
									<th>Pemasok</th>
									<th>Jumlah Permintaan</th>
									<th>Satuan</th>
									<th>Jumlah Disetujui</th>
									<th>Harga Satuan</th>
									<th>Keterangan</th>
									<th>Status</th>
									
								</tr>
							</thead>
							<tbody>
								<?php $no=1;
									  $jml_total = 0;
									  $total = 0;
									  $jumlahItem = 0;
									  $jumlahPengeluaran = 0;
									  use App\DetailPermintaanBarang;
								?>
								<?php foreach ($r->detail as $d): ?>
									@if($d->gabungan == '' || $d->gabungan == null)
									<tr>
										
											
											<input type="hidden" name="id_detail[]" value="<?php echo $d->id ?>">
					                        <input type="hidden" name="id_barang[]" value="<?php echo $d->barang_id ?>">
											
											<td><?php echo $no ?></td>
											<?php $db = DetailPermintaanBarang::where('gabungan','like','%'.$d->id.'%')->get();?>
											<td><?php echo $d->kode_barang ?>
												@foreach($db as $dd)
												 / <?php echo $dd->kode_barang ?>
												@endforeach
											</td>
											<td>@if($d->nama_barang == null){{ $d->barang->nama }}@else{{ $d->nama_barang }}@endif
												@foreach($db as $dd)
												 / <?php echo $dd->nama_barang ?>
												@endforeach
											</td>
										
											<td><?php if($d->pemasok){ echo $d->pemasok->nama; } else{ echo "Belum Ada Pemasok"; } ?></td>
											<input type="hidden" class="jumlah_asli" disetujui_id_2="id_{{ $d->id }}" value="{{ $d->jumlah }}">
											<td><?php echo $d->jumlah ?></td>
											<td><?php echo $d->satuan->nama ?></td>
											<td><input class="form-control"  type="number" name="jumlah[]"  id="id_{{ $d->id }}" min="0" onchange="if($(this).val() != 0) {$(this).parent().parent().children('td').children('select').children('option[value=2]').attr('selected','selected')} " max="<?php echo $d->jumlah ?>" value="<?php echo $d->jumlah_disetujui ?>"></td>
											<td><input class="form-control" type="text" name="harga[]" value="<?php echo number_format($d->harga) ?>"></td>
											<td><textarea  name="keterangan[]"><?php echo $d->keterangan ?></textarea></td>
											
											<td>
												<?php if($d->pemasok){ ?>
												<select class=" status" name="status[]" id="status" data-live-search="true" required>
													
													<option value="1" <?php if (@$d->status == 1) {echo "selected";} ?>>Tidak Ada</option>
													<option value="2" <?php if (@$d->status == 2) {echo "selected";} ?>>Ada</option>
													<option value="3" <?php if (@$d->status == 3) {echo "selected";} ?>>Pending</option>			
												</select>
											<?php } else{ echo "Belum Ada Pemasok"; } ?>
													
												
											</td>
										
										
									</tr>
									<?php $no++; ?>
									@endif
									<?php $jumlahItem += $d->jumlah_disetujui; ?>
									<?php $jumlahPengeluaran += ($d->jumlah_disetujui * $d->harga); ?>

								<?php endforeach ?>
							</tbody>
							<tfoot>
								<tr>
									<td colspan="7" align="right"><b>Total : </b></td>
									<td><b><center><?php echo $jumlahItem ?></center></b></td>
									<td colspan="3"><b>Rp. <?=number_format($jumlahPengeluaran)?></b></td>
								</tr>
							</tfoot>
						</table>
							<button type="submit" class="btn btn-success">Ubah</button>
						</form>




                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
	var i = true;
	$("#setujui_semua").click(function(event) {
		var c = $(".jumlah_asli");
		
		if(i){
			c.each(function() {
				
					$("#"+$(this).attr('disetujui_id_2')).val($(this).val());

					$(".status option[value=2]").attr('selected', 'selected');

			});
			i =false;
		}
		else  {
			c.each(function() {
				
					$("#"+$(this).attr('disetujui_id_2')).val(0);

			});
			i =true;
		}
			

	});

	function change(){
		
	}
</script>

@endsection

