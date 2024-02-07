@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Bukti Barang Keluar<br><br> <a class="btn btn-default" href="{{ url('/') }}">Kembali</a></div>

                <div class="panel-body">
                    <form class="form-inline">
                        <div class="form-group">
                            <input type="text" class="form-control" name="q" placeholder="Pencarian" value="@if(isset($_GET['q'])){{$_GET['q']}}@endif">
                        </div>
                        <button type="submit" class="btn btn-default">Cari</button>
                        <a href="{{ url('item_out/create') }}" class='btn btn-primary'><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Tambah Data</a> 
                        
                    </form>
                    <p></p>

                    <table class="table table-bordered table-hover">
                        <tr>
                            <th>No</th>
                            <th>Nomor BBK</th>
                            <th>Tanggal</th>
                         
                            <th>Keterangan</th>
                            <th>Status</th>
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
                            <tr @if($t->kelengkapan > 0) class="danger" @endif @if($t->status == 2) class="danger" @endif>
                                <td ><?php echo $no;?> </td>
                                <td><?php echo $t->nomor ?></td>
                                <td><?php echo $t->tanggal ?></td>
                           
                                <td><?php echo $t->keterangan ?></td>
                                <td>
                                    @if($t->status == 0)
                                        Belum Masuk Gudang
                                    @elseif($t->status == 1)
                                        Sudah Masuk Gudang
                                    @elseif($t->status == 2)
                                        Belum Selesai
                                    @endif
                                </td>
                                <td>
                                    <a class="btn btn-primary" href="{{ url('item_out/'.$t->id.'/edit?page='.$tables->currentPage()) }}"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Ubah</a>
                                    <a class="btn btn-danger" onclick="event.preventDefault();
                                                    if(confirm('Apakah anda yakin akan menghapus data ini?'))
                                                     document.getElementById('delete<?php echo $t->id;  ?>').submit();"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Hapus</a>
                                    <a target="_blank" class="btn btn-info" href="<?php echo url('item_out/'.$t->id.'/doc') ?>" target="_blank"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> DOC</a>
                                    <a class="btn btn-info" target="_blank" href="{{ url('item_out/'.$t->id.'/print') }}"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</a>

                                    <form action="{{ url('item_out/'.$t->id) }}" id="delete<?php echo $t->id;  ?>" method="POST">
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
