@extends('layouts.app')

@section('content')
	<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Pemakaian Gudang<br><br> <a class="btn btn-default" href="{{ url('/') }}">Kembali</a></div>

                <div class="panel-body">
                    <form class="form-inline">
                        <div class="form-group">
                            <input type="text" class="form-control" name="q" placeholder="Pencarian" value="@if(isset($_GET['q'])){{$_GET['q']}}@endif">
                        </div>
                        <button type="submit" class="btn btn-default">Cari</button>
                        <a href="{{ url('warehouse_use/create') }}" class='btn btn-primary'><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Tambah Data</a> 
                    </form>
                    <p></p>
                    <?php $no = 1; ?>
                    <table class="table table-bordered table-hover">
                        <tr>
                            <th>No</th>
                            <th>PO</th>
                            <th>Tanggal</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
					
                    @foreach($tables as $t)


                    	<tr>
                    		<td>{{ $no }} <?php $no++ ?></td>
                            <td>
                                <?php
                                foreach($t->detail as $ok){
                                    echo $ok->detail_bbm->detail_pemesanan->pemesanan->nomor."<br>";
                                };
                                ?>
                            </td>
                    		<td>{{$t->tanggal}}</td>
                    		<td>{{$t->keterangan}}</td>
                    		<td><a href="{{ url("warehouse_use/". $t->id ."/edit") }}" class="btn btn-primary"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Ubah</a>
                    			<a class="btn btn-danger" onclick="event.preventDefault();
                                                    if(confirm('Apakah anda yakin akan menghapus data ini?'))
                                                     document.getElementById('delete<?php echo $t->id;  ?>').submit();"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Hapus</a>

                                    <form action="{{ url('warehouse_use/'.$t->id) }}" id="delete<?php echo $t->id;  ?>" method="POST">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="_method" value="DELETE">
                                    </form>
                    		</td>
                    	</tr>
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
