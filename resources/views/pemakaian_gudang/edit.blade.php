

@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Edit Pemakaian Gudang<br><br> <a class="btn btn-default" href="{{ url('warehouse_use') }}">Kembali</a></div>

                <div class="panel-body">
                	
                	<form class="form-horizontal" id="myform" method="post" action="{{ url('warehouse_use/'.$t->id) }}">
                		{{ csrf_field() }}
                		<div class="form-group">
                			<input type="hidden" name="_method" value="PUT">
                		<input type="hidden" name="id" value="{{ $t->id }}">
                			<label for="keterangan" class="col-lg-2 control-label" >Keterangan</label>
                            <div class="col-lg-3">
                                <input type="text"  class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan" value="{{ $t->keterangan }}" required>
                            </div>

						</div>


						<div class="form-group">
                            <label for="tanggal" class="col-lg-2 control-label">Tanggal</label>
                            <div class="col-lg-3">
                                <input type="date"  class="form-control" name="tanggal" id="keterangan" value="{{ $t->tanggal }}" required>
                            </div>
                        </div>
                        
                        <div class="form-group">

                            <div class="col-lg-10 col-lg-offset-2">

                                <a  class="btn btn-default" href="{{ url('warehouse_use') }}">Batal</a>

                                <button type="submit" class="btn btn-primary">Simpan</button>

                            </div>

                        </div>
                			
                		
                	</form>
                	
                	<table class="table table-bordered table-hover">
                		<tr>
                			<th>Kode Barang</th>
                			<th>Nama Barang</th>
							<th>Harga</th>
                			<th>Jumlah</th>
							<th>No. Permintaan</th>
                		</tr>
                		@foreach($t->detail as $d)
                		<tr>
                			<td>{{ $d->detail_bbm->detail_pemesanan->kode_barang }}</td>
                			<td>{{ $d->detail_bbm->nama_barang }}</td>
							<td>{{ number_format($d->detail_bbm->detail_pemesanan->harga) }}</td>
                			<td>{{ $d->stok }}</td>
							<td>{{ $d->detail_bbm->detail_pemesanan->detail_permintaan->permintaan->nomor }}</td>
                		</tr>
                		@endforeach
                	</table>

                	</div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection