@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Barang<br><br> <a class="btn btn-default" href="{{ url('/') }}">Kembali</a></div>

                <div class="panel-body">
                    <form class="form-inline">
                        <div class="form-group">
                            <input type="text" class="form-control" name="q" placeholder="Pencarian" value="@if(isset($_GET['q'])){{$_GET['q']}}@endif">
                        </div>
                        <button type="submit" class="btn btn-default">Cari</button>
                        <a href="{{ url('item/create') }}" class='btn btn-primary'><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Tambah Data</a> 
                    </form>
                    <p></p>

                    <table class="table table-bordered table-hover">
                        <tr>
                            <th>No</th>
                            <th>No. Part</th>
                            <th>Nama Barang</th>
                            <th>Kategori</th>
                            <th>Jenis Unit</th>
                            <th>Kode Unit</th>
                            <th>Harga Barang</th>
                            <th>Satuan</th>
                            <th>Keterangan</th>
                            <th>Halaman</th>
                            <th>Indek</th>
                            <th>Gambar</th>
                            <th>QrCode</th>
                            <th >Aksi</th>
                        </tr>
                        <?php 
                         $page = 0;
                         if(isset($_GET['page']) && $_GET['page'] > 1){
                            $page = $_GET['page']*10-10;
                         }
                         $no = 2*$page+1; 
                         ?>
                        @foreach($tables as $data)
                        
                            <tr>
                                <td>{{ $no }}</td>
                                <td>{{ $data->kode }}</td>
                                <td>{{ $data->nama }}</td>
                                <td>{{ $data->kategori->nama }}</td>
                                <td>{{ $data->unit->jenis_unit->nama }}</td>
                                <td>{{ $data->unit->kode }}</td>
                                
                                <td>Rp.{{ number_format($data->harga) }}</td>
                                <td>{{ $data->satuan->nama }}</td>
                                <td>{{ $data->keterangan }}</td>
                                <td>{{ $data->halaman }}</td>
                                <td>{{ $data->indeks }}</td>
                                <td><img style="max-width: 100px;"  class="zoom" src="{{ url('images/images/barang/'.$data->gambar) }}"></td>
                                <td>@if($data->qrcode != null)<?php echo '<img class="zoom" src="data:image/png;base64,' . DNS2D::getBarcodePNG($data->qrcode, "QRCODE") . '" alt="barcode"   />'; ?>{{ $data->qrcode }}@endif</td>
                                <td>
                                    <a class="btn btn-primary" href="{{ url('item/'.$data->id.'/edit?page='.$tables->currentPage()) }}"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Ubah</a>
                                    <a class="btn btn-danger" onclick="event.preventDefault();
                                                    if(confirm('Apakah anda yakin akan menghapus data ini?'))
                                                     document.getElementById('delete<?php echo $data->id;  ?>').submit();"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Hapus</a>

                                    <form action="{{ url('item/'.$data->id) }}" id="delete<?php echo $data->id;  ?>" method="POST">
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
