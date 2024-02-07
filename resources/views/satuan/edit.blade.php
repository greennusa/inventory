@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Tambah Merek<br><br> <a class="btn btn-default" href="{{ url('/satuan') }}">Kembali</a></div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ url('satuan/'.$satuan->id) }}">
                    	{{ csrf_field() }}

                    	<input type="hidden" name="_method" value="PUT">
                    	<input type="hidden" name="page" value="{{ $_GET['page'] }}">
						<div class="form-group">

							<label for="kode" class="col-lg-2 control-label">Kode Unit</label>

							<div class="col-lg-3">

								<input type="text" value="{{ $satuan->kode }}" class="form-control" name="kode" id="kode" placeholder="Kode Unit" required>

							</div>

						</div>

						<div class="form-group">

							<label for="nama" class="col-lg-2 control-label">Nama Unit</label>

							<div class="col-lg-3">

								<input type="text" value="{{ $satuan->nama }}" class="form-control" name="nama" id="nama" placeholder="Nama Unit" required>

							</div>

						</div>

						<div class="form-group">

							<label for="jenis" class="col-lg-2 control-label">Nama Unit</label>

							<div class="col-lg-3">

								<select class="form-control" name="jenis" id="jenis">

									
										<?php foreach (['0'=>'Cair','1'=>'Padat'] as $key => $value): ?>

											<option value="<?php echo $key ?>" <?php echo (!is_null(@$satuan->jenis) && @$satuan->jenis == $key) ? 'selected' : '' ?>> <?php echo $value ?></option>	

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
@endsection

