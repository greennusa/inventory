@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Laporan<br><br> <a class="btn btn-default" href="{{ url('/') }}">Kembali</a></div>

                <div class="panel-body">
                    <div class="col-md-3">
                        <div class="panel panel-default">
                            <div class="panel-body">
                            <a class="link" href="<?=url('report/pemakaian')?>">
                                <center><h2 class="glyphicon glyphicon-book"></h2></center>
                                <center><h4>Laporan Pemakaian</h4></center>
                            </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="panel panel-default">
                            <div class="panel-body">
                            <a class="link" href="<?=url('report/penerimaan')?>">
                                <center><h2 class="glyphicon glyphicon-book"></h2></center>
                                <center><h4>Laporan Penerimaan</h4></center>
                            </a>
                            </div>
                        </div>
                    </div>

                   

                    <div class="col-md-3">
                        <div class="panel panel-default">
                            <div class="panel-body">
                            <a class="link" href="<?=url('report/pemakaian_per_unit')?>">
                                <center><h2 class="glyphicon glyphicon-book"></h2></center>
                                <center><h4>Laporan Pemakaian per Jenis Unit </h4></center>
                            </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="panel panel-default">
                            <div class="panel-body">
                            <a class="link" href="<?=url('report/opname')?>">
                                <center><h2 class="glyphicon glyphicon-book"></h2></center>
                                <center><h4>Laporan Stok Opname Per Jenis Unit/Kategori</h4></center>
                            </a>
                            </div>
                        </div>
                    </div>

                    

                    <div class="col-md-3">
                      <div class="panel panel-default">
                          <div class="panel-body">
                          <a class="link" href="<?=url('report/monitoring')?>">
                            <center><h2 class="glyphicon glyphicon-book"></h2></center>
                            <center><h4>Laporan Monitoring</h4></center>
                          </a>
                          </div>
                      </div>
                    </div>

                    <div class="col-md-3">
                      <div class="panel panel-default">
                          <div class="panel-body">
                          <a class="link" href="<?=url('report/piutang')?>">
                            <center><h2 class="glyphicon glyphicon-book"></h2></center>
                            <center><h4>Laporan Piutang</h4></center>
                          </a>
                          </div>
                      </div>
                    </div>

                    <div class="col-md-3">
                      <div class="panel panel-default">
                          <div class="panel-body">
                          <a class="link" href="<?=url('report/supplier')?>">
                            <center><h2 class="glyphicon glyphicon-book"></h2></center>
                            <center><h4>Laporan Supplier</h4></center>
                          </a>
                          </div>
                      </div>
                    </div>
                    
                    
                    <div class="col-md-3">
                      <div class="panel panel-default">
                          <div class="panel-body">
                          <a class="link" href="<?=url('report/pemakaian_gudang')?>">
                            <center><h2 class="glyphicon glyphicon-book"></h2></center>
                            <center><h4>Laporan Pemakaian Gudang</h4></center>
                          </a>
                          </div>
                      </div>
                    </div>


                    <div class="col-md-3">
                      <div class="panel panel-default">
                          <div class="panel-body">
                          <a class="link" href="<?=url('report/dapur')?>">
                            <center><h2 class="glyphicon glyphicon-book"></h2></center>
                            <center><h4>Laporan Dapur</h4></center>
                          </a>
                          </div>
                      </div>
                    </div>

                    <div class="col-md-3">
                      <div class="panel panel-default">
                          <div class="panel-body">
                          <a class="link" href="<?=url('arsip')?>">
                            <center><h2 class="glyphicon glyphicon-book"></h2></center>
                            <center><h4>Arsip</h4></center>
                          </a>
                          </div>
                      </div>
                    </div>

                    <div class="col-md-3">
                      <div class="panel panel-default">
                          <div class="panel-body">
                          <a class="link" href="<?=url('report/bbm')?>">
                            <center><h2 class="glyphicon glyphicon-book"></h2></center>
                            <center><h4>Laporan Bahan Bakar Minyak</h4></center>
                          </a>
                          </div>
                      </div>
                    </div>

                    

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
