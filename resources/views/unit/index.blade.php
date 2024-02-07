@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Kode Unit<br><br> <a class="btn btn-default" href="{{ url('/') }}">Kembali</a></div>

                <div class="panel-body">
                    <form class="form-inline">
                        <div class="form-group">
                            <input type="text" class="form-control" name="q" placeholder="Pencarian" value="@if(isset($_GET['q'])){{$_GET['q']}}@endif">
                        </div>
                        <button type="submit" class="btn btn-default">Cari</button>
                        <a href="{{ url('unit/create') }}" class='btn btn-primary'><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Tambah Data</a> <a target="_blank" class="btn btn-info" href="<?php echo url('unit/excel') ?>" target="_blank"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Xls</a>
                    </form>
                    <p></p>

                    <table class="table table-bordered table-hover">
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                          
                            <th>Jenis Unit</th>
                            <th>No.S/N</th>
                            <th>No.E/N</th>
                            <th>Operator</th>
                            <th>Aksi</th>
                        </tr>
                        <?php 
                        $page = 0;
                        if(isset($_GET['page']) && $_GET['page'] > 1){
                            $page = $_GET['page']*10-10;
                        }
                        $no = 2*$page+1; 
                        ?>
                        @foreach($mereks as $data)
                            <tr>
                                <td>{{ $no }}</td>
                                <td>{{ $data->kode }}</td>
                              
                                <td>{{ $data->jenis_unit->nama }}</td>
                                <td>{{ $data->no_sn }}</td>
                                <td>{{ $data->no_en }}</td>
                                <td>{{ $data->operator }}</td>
                                <td>
                                    <a class="btn btn-primary" href="{{ url('unit/'.$data->id.'/edit?page='.$mereks->currentPage()) }}"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Ubah</a>
                                    <a class="btn btn-danger" onclick="event.preventDefault();
                                                    if(confirm('Apakah anda yakin akan menghapus data ini?'))
                                                     document.getElementById('delete<?php echo $data->id;  ?>').submit();"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Hapus</a>

                                    <form action="{{ url('unit/'.$data->id) }}" id="delete<?php echo $data->id;  ?>" method="POST">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="_method" value="DELETE">
                                    </form>
                                </td>
                            </tr>
                            <?php $no++; ?>
                        @endforeach
                    </table>
                    <center>
                        {{$mereks->appends(request()->input())->render()}}
                    </center>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
