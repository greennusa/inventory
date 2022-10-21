@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Pengguna/User<br><br> <a class="btn btn-default" href="{{ url('/') }}">Kembali</a></div>

                <div class="panel-body">
                    <form class="form-inline">
                        <div class="form-group">
                            <input type="text" class="form-control" name="q" placeholder="Pencarian" value="@if(isset($_GET['q'])){{$_GET['q']}}@endif">
                        </div>
                        <button type="submit" class="btn btn-default">Cari</button>
                        <a href="{{ url('user/create') }}" class='btn btn-primary'><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Tambah Data</a> 
                    </form>
                    <p></p>

                    <table class="table table-bordered table-hover">
                        <tr>
                            <th>No</th>

                            <th>Username</th>

                            <th>Nama</th>

                            <th>Lokasi</th>

                            <th>Jabatan</th>

                            <th>Grup</th>

                            <th>Status</th>

                            <th>Aksi</th>
                        </tr>
                        <?php 
                         $page = 0;
                         if(isset($_GET['page']) && $_GET['page'] > 1){
                            $page = $_GET['page']*10-10;
                         }
                         $no = 1*$page+1; 
                         ?>
                        @foreach($tables as $t)
                            <tr>
                                <td><?php echo $no ?></td>

                                <td><?php echo $t->username ?></td>

                                <td><?php echo $t->nama ?></td>

                                <td><?php echo $t->lokasi->nama ?></td>

                                <td><?php echo $t->jabatan->nama ?></td>

                                <td><?php echo $t->group->nama ?></td>

                                <?php 

                                if ($t->active==1) {

                                    $status="Aktif";

                                 }else{

                                    $status="Tidak Aktif";

                                    } 

                                    ?>

                                <td><?php echo $status ?></td>
                                <td>
                                    <a class="btn btn-info" href="<?php echo url('log_user/'.$t->id) ?>"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> Log</a>
                                    <a class="btn btn-primary" href="{{ url('user/'.$t->id.'/edit?page='.$tables->currentPage()) }}"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Ubah</a>
                                    @if($t->id != 1 || $t->id != Auth::user()->id)
                                    <a class="btn btn-danger" onclick="event.preventDefault();
                                                    if(confirm('Apakah anda yakin akan menghapus data ini?'))
                                                     document.getElementById('delete<?php echo $t->id;  ?>').submit();"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Hapus</a>

                                    <form action="{{ url('user/'.$t->id) }}" id="delete<?php echo $t->id;  ?>" method="POST">
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
