@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Tambah Satuan<br><br> <a class="btn btn-default" href="{{ url('/satuan') }}">Kembali</a></div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ url('satuan') }}">
                    	{{ csrf_field() }}

                    	<div class="form-group">

							<label for="kode" class="col-lg-2 control-label">Kode Satuan</label>

							<div class="col-lg-3">

								<input type="text" value="" class="form-control" name="kode" id="kode" placeholder="Kode Unit" required>

							</div>

						</div>

						<div class="form-group">

							<label for="nama" class="col-lg-2 control-label">Nama Satuan</label>

							<div class="col-lg-3">

								<input type="text" value="" class="form-control" name="nama" id="nama" placeholder="Nama Unit" required>

							</div>

						</div>

						<div class="form-group">

							<label for="jenis" class="col-lg-2 control-label">Jenis Satuan</label>

							<div class="col-lg-3">

								<select class="form-control" name="jenis" id="jenis">

									
										<option value="0" > Cair</option>	

									
										<option value="1" > Padat</option>	

									
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

