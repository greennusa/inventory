@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Group<br><br> <a class="btn btn-default" href="{{ url('/') }}">Kembali</a></div>

                <div class="panel-body">
                    <form class="form-inline">
                        <div class="form-group">
                            <input type="text" class="form-control" name="q" placeholder="Pencarian" value="@if(isset($_GET['q'])){{$_GET['q']}}@endif">
                        </div>
                        <button type="submit" class="btn btn-default">Cari</button>
                        <a href="{{ url('group/create') }}" class='btn btn-primary'><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Tambah Data</a> 
                    </form>
                    <p></p>

                    <table class="table table-bordered table-hover">
                        <tr>
                            <th>No</th>
                            
                            <th>Nama Group</th>
                           
                            
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
                                <td>{{ $no }}</td>
                                
                                <td>{{ $data->nama }}</td>
                             
                                
                                <td>
                                    @if(($data->id == 1 && Auth::user()->group_id = 1) || Auth::user()->group_id = 1)
                                    <a class="btn btn-primary" href="{{ url('group/'.$data->id.'/edit?page='.$tables->currentPage()) }}"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Ubah</a>
                                    @endif
                                    @if($data->id != 1)
                                    <a class="btn btn-danger" onclick="event.preventDefault();
                                                    if(confirm('Apakah anda yakin akan menghapus data ini?'))
                                                     document.getElementById('delete<?php echo $data->id;  ?>').submit();"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Hapus</a>

                                    <form action="{{ url('group/'.$data->id) }}" id="delete<?php echo $data->id;  ?>" method="POST">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="_method" value="DELETE">
                                    </form>
                                    @endif
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
