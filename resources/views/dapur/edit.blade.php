@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Edit Dapur<br><br> <a class="btn btn-default" href="{{ url('/camp_list') }}">Kembali</a></div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ url('camp_list/'.$dapur->id) }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="page" value="{{ $_GET['page'] }}">
                        <div class="form-group">

                            <label for="nama" class="col-lg-2 control-label">Nama Dapur</label>

                            <div class="col-lg-3">

                                <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama Dapur" required value="{{ $dapur->nama }}">

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
