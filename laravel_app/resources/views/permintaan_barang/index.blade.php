@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Permintaan Barang<br><br> <a class="btn btn-default" href="{{ url('/') }}">Kembali</a></div>

                <div class="panel-body">
                    <form class="form-inline">
                        <div class="form-group">
                            <input type="text" class="form-control" name="q" placeholder="Pencarian" value="@if(isset($_GET['q'])){{$_GET['q']}}@endif">
                        </div>
                        <button type="submit" class="btn btn-default">Cari</button>
                        <a href="{{ url('purchase_request/create') }}" class='btn btn-primary'><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Tambah Data</a> 
                    </form>
                    <p></p>

                    <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nomor Permintaan</th>
                            <th>Tanggal</th>
                            <th>Kantor</th>
                            <th>Kode Unit</th>
                            
                            <th>E/N No</th>
                            <th>S/N No</th>
                           
                            <th>Dibuat</th>
                            <th>Diketahui</th>
                            <th>Diperiksa</th>
                            <th>Disetujui</th>
                            <th>Sifat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                         <?php 
                         $page = 0;
                         if(isset($_GET['page']) && $_GET['page'] > 1){
                            $page = $_GET['page']*10-10;
                         }
                         $no = 2*$page+1; 
                         ?>
                        @foreach ($tables as $data)
                            
                            <tr @if($data->sifat == 1) class="danger" @endif>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $data->nomor; ?></td>
                                <td><?php echo $data->tanggal; ?></td>
                                <td><?php echo $data->lokasi->nama; ?></td>
                                <td><?php echo $data->unit->kode; ?></td>
                                
                                <td><?php echo $data->unit->no_en ?></td>
                                <td><?php echo $data->unit->no_sn ?></td>

                                <td><?php echo @$data->pembuat->nama ?></td>
                                <td><?php echo @$data->diketahui->nama ?></td>
                                <td><?php echo @$data->diperiksa->nama ?></td>
                                <td><?php echo @$data->disetujui->nama ?></td>
                                <td><?php if($data->sifat == 0){echo "Biasa";}else{echo "Urgent";} ?></td>
                                <td>
                                    <a class="btn btn-primary" href="{{ url('purchase_request/'.$data->id.'/edit?p='.$tables->currentPage()) }}"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Ubah</a>
                                    <a class="btn btn-danger" onclick="event.preventDefault();
                                                    if(confirm('Apakah anda yakin akan menghapus data ini?'))
                                                     document.getElementById('delete<?php echo $data->id;  ?>').submit();"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Hapus</a>
                                    
                                    <a target="_blank" class="btn btn-info" href="<?php echo url('purchase_request/'.$data->id.'/doc') ?>" target="_blank"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> DOC</a>
                                    <a class="btn btn-info" href="<?php echo url('purchase_request/'.$data->id.'/print') ?>" target="_blank"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</a>
                                    <form action="{{ url('purchase_request/'.$data->id) }}" id="delete<?php echo $data->id;  ?>" method="POST">
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
