@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Tambah Lokasi</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ url('lokasi') }}">
                        {{ csrf_field() }}
                        <div class="form-group">

                            <label for="nama" class="col-lg-2 control-label">Nama Lokasi</label>

                            <div class="col-lg-3">

                                <input type="text" value="" class="form-control" name="nama" id="nama" placeholder="Nama Lokasi" required>

                            </div>

                        </div>

                        <div class="form-group">

                            <label for="kode" class="col-lg-2 control-label">Kode Lokasi</label>

                            <div class="col-lg-3">

                                <input type="text" value="" class="form-control" name="kode" id="kode" placeholder="Kode Lokasi" required>

                            </div>

                        </div>

                        <div class="form-group">

                            <label for="alamat" class="col-lg-2 control-label">Alamat Lokasi</label>

                            <div class="col-lg-3">

                                <input type="text" value="" class="form-control" name="alamat" id="alamat" placeholder="Alamat Lokasi" required>

                            </div>

                        </div>

                        <div class="form-group">

                            <div class="col-lg-10 col-lg-offset-2">

                                <a href="{{ url('lokasi') }}" class="btn btn-default">Batal</a>

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
