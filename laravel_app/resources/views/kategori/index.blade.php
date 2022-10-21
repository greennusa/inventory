@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Kategori<br><br> <a class="btn btn-default" href="{{ url('/') }}">Kembali</a></div>

                <div class="panel-body">
                    <form class="form-inline">
                        <div class="form-group">
                            <input type="text" class="form-control" name="q" placeholder="Pencarian" value="@if(isset($_GET['q'])){{$_GET['q']}}@endif">
                        </div>
                        <button type="submit" class="btn btn-default">Cari</button>
                        <a href="{{ url('category/create') }}" class='btn btn-primary'><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Tambah Data</a> <a target="_blank" class="btn btn-info" href="<?php echo url('category/excel') ?>" target="_blank"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Xls</a>
                    </form>
                    <p></p>

                    <table class="table table-bordered table-hover">
                        <tr>
                            <th>No</th>
                            <th>Nama Kategori</th>
                            <th>Aksi</th>
                        </tr>
                        <?php 
                        $page = 0;
                        if(isset($_GET['page']) && $_GET['page'] > 1){
                            $page = $_GET['page']*10-10;
                        }
                        $no = 2*$page+1; 
                        ?>
                        @foreach($kategoris as $data)
                            <tr>
                                <td>{{ $no }}</td>
                                <td>{{ $data->nama }}</td>
                                <td>
                                    <a class="btn btn-primary" href="{{ url('category/'.$data->id.'/edit?page='.$kategoris->currentPage()) }}"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Ubah</a>
                                    <a class="btn btn-danger" onclick="event.preventDefault();
                                                    if(confirm('Apakah anda yakin akan menghapus data ini?'))
                                                     document.getElementById('delete<?php echo $data->id;  ?>').submit();"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Hapus</a>

                                    <form action="{{ url('category/'.$data->id) }}" id="delete<?php echo $data->id;  ?>" method="POST">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="_method" value="DELETE">
                                    </form>
                                </td>
                            </tr>
                            <?php $no++; ?>
                        @endforeach
                    </table>
                    <center>
                        {{$kategoris->appends(request()->input())->render()}}
                    </center>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
