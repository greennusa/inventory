@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Edit Kode Unit<br><br> <a class="btn btn-default" href="{{ url('/unit') }}">Kembali</a></div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ url('unit/'.$r->id) }}">
                    	{{ csrf_field() }}
                    	<input type="hidden" name="_method" value="PUT">	
                    	<input type="hidden" name="page" value="{{ $_GET['page'] }}">
						<div class="form-group">
							<label for="kode" class="col-lg-2 control-label">Kode</label>
							<div class="col-lg-3">
								<input type="text"  class="form-control" name="kode" id="kode" placeholder="Kode" required value="{{ $r->kode }}">
							</div>
						</div>
					
						<div class="form-group">

                            <label for="jenis_unit_id" class="col-lg-2 control-label">Jenis Unit</label>

                            <div class="col-lg-3">

                                <select class="form-control selectpicker"  name="jenis_unit_id" id="jenis_unit_id" data-live-search="true">

                                    <option></option>

                                    @foreach ($jenisunit as $j)

                                        <option @if($r->jenis_unit_id == $j->id) selected @endif value="<?php echo $j->id ?>"><?php echo $j->kode ?> - <?php echo $j->nama ?></option>

                                    @endforeach             

                                </select>
                                @if ($errors->has('jenis_unit_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('merek_id') }}</strong>
                                    </span>
                                @endif

                            </div>

                        </div>
                        
					    <div class="form-group">
							<label for="no_sn" class="col-lg-2 control-label">No. S/N</label>
							<div class="col-lg-3">
								<input type="text"  class="form-control" name="no_sn" id="no_sn" placeholder="No. S/N" required value="{{ $r->no_sn }}">
							</div>
						</div>
						<div class="form-group">
							<label for="no_en" class="col-lg-2 control-label">No. E/N</label>
							<div class="col-lg-3">
								<input type="text" value="{{ $r->no_en }}" class="form-control" name="no_en" id="no_en" placeholder="No. E/N" required>
							</div>
						</div>
                        <div class="form-group">
                            <label for="operator" class="col-lg-2 control-label">Operator</label>
                            <div class="col-lg-3">
                                <input type="text" value="{{ $r->operator }}" class="form-control" name="operator" id="operator" placeholder="Operator" required>
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

