@extends('layouts.app')

@section('content')

<div class="container">
	<div class="row">
		 <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Edit Monitoring Unit<br><br> <a class="btn btn-default" href="{{ url('monitoring') }}">Kembali</a></div> 
          	<div class="panel-body">
          		  
              <form class="form-horizontal" method="POST" action="{{ url("monitoring/".$r->id) }}">
                {{ csrf_field() }}
                <input type="hidden" name="_method" value="PUT">
                <div class="form-group">
                  <label for="unit" class="col-lg-2 control-label">No. Unit</label>
                  <div class="col-lg-3">
                    <input type="text" class="form-control" name="kode" value="{{ $r->unit->kode }}" readonly="">
                    <input type="hidden" name="unit" value="{{ $r->id }}">
                  </div>
                </div>

                <div class="form-group">
                  <label for="tanggal" class="col-lg-2 control-label">Tanggal</label>
                  <div class="col-lg-3">
                    <input type="date" class="form-control" name="tanggal" value="{{ $r->tanggal }}">
                  </div>
                </div>

                <div class="form-group">
                  <label for="status" class="col-lg-2 control-label">Status</label>
                  <div class="col-lg-3">
                    <select name="status" class="form-control selectpicker">
                      <option value="operasional" @if ($r == "operasional") selected @endif>Operasional</option>
                      <option value="standby" @if ($r->status == "standby") selected @endif>Standby</option>
                      <option value="rusak" @if ($r->status == "rusak") selected @endif>Rusak</option>
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label for="keterangan" class="col-lg-2 control-label">Keterangan</label>
                  <div class="col-lg-3">
                    <input type="text" class="form-control" name="keterangan" value="{{ $r->keterangan }}">
                  </div>
                </div>

                <div class="form-group">
                  <label for="libur" class="col-lg-2 control-label">Libur</label>
                  <div class="col-lg-3">
                    <select name="libur" class="form-control selectpicker">
                      <option value="0">Tidak</option>
                      <option value="1">Ya</option>
                      
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
</div>

@endsection