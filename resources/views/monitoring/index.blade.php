@extends('layouts.app')

@section('content')

<div class="container">
	<div class="row">
		 <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Monitoring Unit<br><br> <a class="btn btn-default" href="{{ url('/') }}">Kembali</a></div>
                <br>

                
          	<div class="panel-body">
          		<form class="form-inline">
                        <div class="form-group">
                            <input type="hidden" class="form-control" name="q" placeholder="Pencarian" value="@if(isset($_GET['q'])){{$_GET['q']}}@endif">
                            
                            <select class="selectpicker" name="z" data-live-search="true">
                                <option value="">Semua</option>
                                @foreach($units as $unit)
                                <option value="{{ $unit->id }}" @if(isset($_GET['z'])) @if($_GET['z'] == $unit->id) selected @endif @endif >{{$unit->kode}}</option>
                                @endforeach
                            </select>

                        
                            <input type="date" class="form-control" name="r" value="@if(isset($_GET['r'])){{$_GET['r']}}@endif">
                        
                        
                        <button type="submit" class="btn btn-default">Cari</button>
                            <a href="{{ url("monitoring") }}" class="btn btn-default">Reset</a>
                			<a href="{{url("monitoring/create")}} " class="btn btn-primary"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Tambah Data </a>
                    </div>
            	</form>
            	<p></p>
            	<?php 
                         $page = 0;
                         if(isset($_GET['page']) && $_GET['page'] > 1){
                            $page = $_GET['page']*10-10;
                         }
                         $no = 1*$page+1; 
                         ?>
          		<table class="table table-bordered table hover">
          			<tr>
          				<th>No.</th>
          				<th>Kode Unit</th>
          				<th>Status</th>
          				<th>Tanggal</th>
          				<th>Keterangan</th>
          				<th>Aksi</th>
          			</tr>

          			<?php
          				

          			?>

          			@foreach( $monitoring as $m)
          			<tr>
          				<td>{{ $no }}</td>
          				<td>{{ $m->unit->kode }}</td>
          				<td>{{ $m->status  }}</td>
          				<td>{{ $m->tanggal }}</td>
          				<td>{{ $m->keterangan }}</td>
          				<td>
          					<a href="{{ url("monitoring/". $m->id ."/edit") }}" class="btn btn-primary"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Ubah</a>
          					<a class="btn btn-danger" onclick="event.preventDefault();
                                                    if(confirm('Apakah anda yakin akan menghapus data ini?'))
                                                     document.getElementById('delete<?php echo $m->id;  ?>').submit();"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Hapus</a>
          					<form action="{{ url('monitoring/'.$m->id) }}" id="delete<?php echo $m->id;  ?>" method="POST">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="_method" value="DELETE">
                                    </form>
          				</td>

          			</tr>
          			<?php $no++; ?>
          			@endforeach
          		</table>

          		<center>
                        {{$monitoring->appends(request()->input())->render()}}
                    </center>

          	</div>  

            </div>
        </div>
    </div>
</div>


@endsection