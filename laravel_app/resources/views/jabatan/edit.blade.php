@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Edit Jabatan</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ url('job/'.$r->id) }}">
                    	{{ csrf_field() }}
                    	<input type="hidden" name="_method" value="PUT">
						<div class="form-group">
							<label for="nama" class="col-lg-2 control-label">Nama Jabatan</label>
							<div class="col-lg-3">
								<input type="text"  class="form-control" name="nama" id="nama" placeholder="Nama Jabatan" required value="{{ $r->nama }}">
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

