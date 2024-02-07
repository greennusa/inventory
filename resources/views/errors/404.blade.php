@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">404</div>
                <div class="panel-body">
                  <h3><i class="fa fa-warning text-yellow"></i> Oops! Halaman Tidak Ditemukan.</h3>
            
                  <p>
                    Halaman Yang Anda Cari Tidak Ditemukan.
                    <a href="{{ url('home') }}">kembali ke dashboard</a>
                  </p>
                </div>
            </div>
            
        </div>
    </div>
</div>

@endsection
