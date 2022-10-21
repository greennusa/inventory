@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Persetujuan<br><br> <a class="btn btn-default" href="{{ url('/') }}">Kembali</a></div>

                <div class="panel-body">
                    <form class="form-inline">
                        <div class="form-group">
                            <input type="text" class="form-control" name="q" placeholder="Pencarian" value="@if(isset($_GET['q'])){{$_GET['q']}}@endif">
                        </div>
                        <button type="submit" class="btn btn-default">Cari</button>
                        <div class="form-group">
                            <label class="label-control">Filter : </label>
                            <select class="form-control" name="status">
                                <option @if(isset($_GET['status']) && $_GET['status'] == 0) selected @endif value="0">Semua</option>
                                <option @if(isset($_GET['status']) && $_GET['status'] == 1) selected @endif value="1">Tidak Disetujui</option>
                                <option @if(isset($_GET['status']) && $_GET['status'] == 2) selected @endif value="2">Disetujui</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-default">Terapkan</button>
                        
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
                            <th>Diketahui</th>
                           
                            <th>Pemeriksa</th>
                            <th>Setuju</th>
                            <th>Penyetuju</th>
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
                        @foreach ($tables as $t)
                            <tr>
                                <td><?php echo $no ?></td>
                                <td><?php echo $t->nomor ?></td>
                                <td><?php echo $t->tanggal ?></td>
                                <td><?php echo $t->lokasi->nama ?></td>
                                <td><?php echo $t->unit->kode; ?></td>
                                
                                <td><?php echo $t->unit->no_en ?></td>
                                <td><?php echo $t->unit->no_sn ?></td>
                                <td><?php echo $t->pembuat->nama ?></td>
                                
                                <td><?php echo $t->diperiksa->nama ?></td>
                                <td>
                                    <?php if ($t->setuju == 1): ?>
                                        Tidak
                                    <?php elseif($t->setuju == 2): ?>
                                        Ya
                                    <?php endif ?>
                                </td>
                                <td><?php echo ($t->disetujui_id_2!=0) ? $t->disetujui2->nama : "" ?></td>
                                <td>
                                    
                                    
                                    <a class="btn btn-success" href="<?php echo url('approval/'.$t->id.'?page='.$tables->currentPage()) ?>"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> Detail</a>
                                    
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
