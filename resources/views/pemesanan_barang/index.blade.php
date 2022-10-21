@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Pemesanan Barang<br><br> <a class="btn btn-default" href="{{ url('/') }}">Kembali</a></div>

                <div class="panel-body">
                    <form class="form-inline">
                        <div class="form-group">
                            <input type="text" class="form-control" name="q" placeholder="Pencarian" value="@if(isset($_GET['q'])){{$_GET['q']}}@endif">
                            <select class="selectpicker" name="r" data-live-search="true">
                                @foreach($pemasok as $pe)
                                <option value="{{ $pe->id }}" @if(isset($_GET['r'])) @if($_GET['r'] == $pe->id) selected @endif @endif >{{$pe->nama}}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-default">Cari</button>
                        <a href="{{ url('order/create') }}" class='btn btn-primary'><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Tambah Data</a> 
                    </form>
                    <p></p>

                    <table class="table table-bordered table-hover">
                        <tr>
                            <th>No</th>
                            <th>Nomor Pemesanan</th>
                            <th>Tanggal</th>
                            
                            <th>Supplier</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                        <?php 
                        $page = 0;
                        if(isset($_GET['page']) && $_GET['page'] > 1){
                            $page = $_GET['page']*10-10;
                        }
                        $no = 2*$page+1; 
                        ?>
                        @foreach($tables as $t)
                            <tr>
                                <td><?php echo $no ?></td>
                                <td><?php echo $t->nomor ?></td>
                                <td>
                                    <?php 
                                    if ($t->tanggal != '0000-00-00') {
                                        echo $t->tanggal;
                                    }
                                    ?>
                                </td>
                                <td><?php echo $t->pemasok->nama ?></td>
                                <td>{{$t->keterangan}}</td>
                                <td>
                                    <a  class="btn btn-primary" href="<?php echo url('order/'.$t->id) ?>"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> Detail</a>
                                    <a target="_blank" class="btn btn-info" href="<?php echo url('order/doc/'.$t->id) ?>" target="_blank"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> DOC</a>
                                    <a target="_blank" class="btn btn-info" href="<?php echo url('order/print/'.$t->id) ?>" target="_blank"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</a>
                                    <a class="btn btn-danger" onclick="event.preventDefault();
                                                    if(confirm('Apakah anda yakin akan menghapus data ini?'))
                                                     document.getElementById('delete<?php echo $t->id;  ?>').submit();"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Hapus</a>

                                    <form action="{{ url('order/'.$t->id) }}" id="delete<?php echo $t->id;  ?>" method="POST">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="_method" value="DELETE">
                                    </form>
                                </td>
                            </tr>
                            <?php $no++; ?>
                        @endforeach
                    </table>
                    <center>
                        {{$tables->appends(request()->input())->render()}}
                    </center>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
