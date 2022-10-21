@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Atur Supplier<br><br> <a class="btn btn-default" href="{{ url('/') }}">Kembali</a></div>

                <div class="panel-body">
                    <form class="form-inline">
                        <div class="form-group">
                            <input type="text" class="form-control" name="q" placeholder="Pencarian" value="@if(isset($_GET['q'])){{$_GET['q']}}@endif">
                        </div>
                        <button type="submit" class="btn btn-default">Cari</button>
                       
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
                            <th>Diketahui (Atur Pemasok)</th>
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
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $data->nomor; ?></td>
                                <td><?php echo $data->tanggal; ?></td>
                                <td><?php echo @$data->lokasi->nama; ?></td>
                                <td><?php echo $data->unit->kode; ?></td>
                                    
                                <td><?php echo $data->unit->no_en ?></td>
                                <td><?php echo $data->unit->no_sn ?></td>
                                <td><?php echo @$data->pembuat->nama ?></td>
                                <td><?php echo @$data->diketahui->nama ?></td>
                                <td><?php echo @$data->diperiksa->nama ?></td>
                                <td><?php echo @$data->disetujui->nama ?></td>
                                <td>{{ @$data->diketahui2->nama }}</td>
                                <td>
                                    
                                    <a class="btn btn-success" href="<?php echo url('set_supplier/'.$data->id.'?p='.$tables->currentPage()) ?>"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> Detail</a>
                                    <a class="btn btn-info" href="<?php echo url('set_supplier/'.$data->id.'/doc/') ?>" target="_blank"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> DOC</a>
                                    
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
