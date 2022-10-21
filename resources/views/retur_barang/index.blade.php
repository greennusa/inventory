@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Retur Barang<br><br> <a class="btn btn-default" href="{{ url('/') }}">Kembali</a></div>

                <div class="panel-body">
                    <form class="form-inline">
                        <div class="form-group">
                            <input type="text" class="form-control" name="q" placeholder="Pencarian" value="@if(isset($_GET['q'])){{$_GET['q']}}@endif">
                        </div>
                        <button type="submit" class="btn btn-default">Cari</button>
                        
                    </form>
                    <p></p>

                    <table class="table table-bordered table-hover">
                        <tr>
                            <th>No</th>

                            <th>Nomor</th>

                            <th>Tanggal</th>

                            <th>Diterima</th>

                            <th>Dibawa</th>

                            <th>Dikirim</th>

                            <th>Aksi</th>
                        </tr>
                        <?php 
                        $page = 0;
                        if(isset($_GET['page']) && $_GET['page'] > 1){
                            $page = $_GET['page']*10-10;
                        }
                        $no = 1*$page+1; 
                        ?>
                        @foreach($tables as $data)
                            <tr>
                                <td><?php echo $no ?></td>

                                <td><?php echo $data->nomor ?></td>

                                <td><?php echo $data->tanggal ?></td>

                                <td><?php echo $data->diterima->nama ?></td>

                                <td><?php echo $data->dibawa->nama ?></td>

                                <td><?php echo $data->dikirim->nama ?></td>
                                <td>
                                    <a  class="btn btn-primary" href="<?php echo url('retur_item/'.$data->id) ?>"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> Detail</a>
                                    <a target="_blank" class="btn btn-info" href="<?php echo url('retur_item/print/'.$data->id) ?>" target="_blank"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</a>
                                    <a target="_blank" class="btn btn-info" href="<?php echo url('retur_item/'.$data->id.'/doc') ?>" target="_blank"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> DOC</a>
                                    <a class="btn btn-danger" onclick="event.preventDefault();
                                                    if(confirm('Apakah anda yakin akan menghapus data ini?'))
                                                     document.getElementById('delete<?php echo $data->id;  ?>').submit();"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Hapus</a>

                                    <form action="{{ url('retur_item/'.$data->id) }}" id="delete<?php echo $data->id;  ?>" method="POST">
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
