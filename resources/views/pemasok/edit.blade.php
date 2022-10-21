@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Edit Supplier</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ url('supplier/'.$r->id) }}">
                    	{{ csrf_field() }}
                    	<input type="hidden" name="_method" value="PUT">
						

						<div class="form-group">

							<label for="nama" class="col-lg-2 control-label">Nama Pemasok</label>

							<div class="col-lg-3">

								<input type="text"  value="<?php echo @$r->nama ?>" class="form-control" name="nama" id="nama" placeholder="Nama Pemasok" required>

							</div>

						</div>

						<div class="form-group">

							<label for="alamat" class="col-lg-2 control-label">Alamat Pemasok</label>

							<div class="col-lg-3">

								<input type="text" value="<?php echo @$r->alamat ?>" class="form-control" name="alamat" id="alamat" placeholder="Alamat Pemasok" required>

							</div>

						</div>

						<div class="form-group">

							<label for="kota" class="col-lg-2 control-label">Kota</label>

							<div class="col-lg-3">

								<input type="text" value="<?php echo @$r->kota ?>" class="form-control" name="kota" id="kota" placeholder="Nama Kota" required>

							</div>

						</div>

						<div class="form-group">

							<label for="telepon" class="col-lg-2 control-label">Telepon</label>

							<div class="col-lg-3">

								<input type="text" value="<?php echo @$r->telepon ?>" class="form-control" name="telepon" id="telepon" placeholder="Telepon" required>

							</div>

						</div>

						<div class="form-group">

							<div class="col-lg-10 col-lg-offset-2">

								<a href="{{ url('supplier?page='.$_GET['page']) }}" class="btn btn-default">Batal</a>

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

