@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Tambah Permintaan Barang</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ url('purchase_request') }}">
                    	{{ csrf_field() }}
						<div class="form-group">
							<label for="nomor" class="col-lg-2 control-label">Nomor Permintaan</label>
							<div class="col-lg-3">
								<input type="text" class="form-control" name="nomor" id="nomor" placeholder="Nomor Permintaan" required >
							</div>
						</div>
						<div class="form-group">
							<label for="tanggal" class="col-lg-2 control-label">Tanggal</label>
							<div class="col-lg-3">
								<input type="date" class="form-control datepickers" name="tanggal" id="tanggal" placeholder="Tanggal" required>
							</div>
						</div>
						<div class="form-group">
							<label for="jenis_unit_id" class="col-lg-2 control-label">Jenis Unit</label>
							<div class="col-lg-3">
								<select onchange="get_kode_unit(this.value)" class="form-control selectpicker"  data-live-search="true">
									<option></option>
									<?php foreach ($jenisunit as $m): ?>
										<option value="<?php echo $m->id ?>" ><?php echo $m->kode ?> - <?php echo $m->nama ?></option>
									<?php endforeach ?>				
								</select>


								@if ($errors->has('jenis_unit_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('jenis_unit_id') }}</strong>
                                    </span>
                                @endif
							</div>
						</div>
						<div class="form-group">
							<label for="en_no" class="col-lg-2 control-label">Unit</label>
							<div class="col-lg-3">
								<select class="form-control" name="unit_id" id="unit_id" required="">
									<option></option>
								</select>
								<!-- <input type="text"  class="form-control" name="kode_unit" id="kode_unit" placeholder="Kode Unit"> -->
							</div>
						</div>
					   
						<div class="form-group">
							<label for="sifat" class="col-lg-2 control-label">Sifat</label>
							<div class="col-lg-3">
								<select class="form-control selectpicker" name="sifat" id="sifat" data-live-search="true">
									
									<option value="0" >Biasa</option>
									<option value="1" >Urgent</option>			
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="destination" class="col-lg-2 control-label">Pilih Tujuan</label>
							<div class="col-lg-3">
								<select class="form-control selectpicker" name="destination" id="destination" data-live-search="true">
									<option value="Camp">Camp</option>
									<option value="Kantor">Kantor</option>	
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="tanggal" class="col-lg-2 control-label">Keterangan</label>
							<div class="col-lg-3">
								<textarea class="form-control" name="keperluan" id="Keterangan" placeholder="Keterangan" maxlength="255" ></textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="pembuat_id" class="col-lg-2 control-label">Dibuat oleh</label>
							<div class="col-lg-3">
								<select class="form-control selectpicker" name="pembuat_id" id="pembuat_id" data-live-search="true" required>
									<option></option>
									<?php foreach ($user as $u): ?>
										<option value="<?php echo $u->id ?>" ><?php echo $u->nama ?></option>
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
										<option value="<?php echo $u->id ?>" ><?php echo $u->nama ?></option>
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
										<option value="<?php echo $u->id ?>" ><?php echo $u->nama ?></option>
									<?php endforeach ?>				
								</select>
								
							</div>
						</div>
						
						<div class="form-group">
							<label for="disetujui_id" class="col-lg-2 control-label">Disetujui oleh</label>
							<div class="col-lg-3">
								<select class="form-control selectpicker" name="disetujui_id" id="disetujui_id" data-live-search="true" >
									<option></option>
									<?php foreach ($user as $u): ?>
										<option value="<?php echo $u->id ?>" ><?php echo $u->nama ?></option>
									<?php endforeach ?>
								</select>
								
							</div>
						</div>
						<div class="form-group">
							<div class="col-lg-10 col-lg-offset-2">
								
									<input type=button value=Batal class="btn btn-default" onclick=self.history.back()>
									<button type="submit" class="btn btn-primary">Simpan</button>
								
							</div>
						</div>
					</form>




                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
	function get_kode_unit(id){
        $('#loading-list-menu').show();
        $.ajax({
            url: '<?php echo url('ajax/get_kode_unit/') ?>/'+id,
            type: 'GET',
            cache:false,
            async: true,
            success: function(data) {
                $("#unit_id").html(data);
                
                $('#loading-list-menu').hide();
            }
           
        }).fail(function() {
            $("#unit_id").html('<option></option>');
        }).always(function() {
            $('#loading-list-menu').hide();
        });
        
        
    }
</script>
@endsection

