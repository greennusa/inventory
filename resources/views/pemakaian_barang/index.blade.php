@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Pemakaian Barang<br><br> <a class="btn btn-default" href="{{ url('/') }}">Kembali</a></div>

                <div class="panel-body">
                    <form class="form-inline">
                        <div class="form-group">
                            <input type="text" class="form-control" name="q" placeholder="Pencarian" value="@if(isset($_GET['q'])){{$_GET['q']}}@endif">

                            <select class="form-control" name="p">
                                <option value="0" @if(isset($_GET['p'])) @if($_GET['p'] == 0) selected @endif @endif >Pemakaian</option>
                                <option value="1" @if(isset($_GET['p'])) @if($_GET['p'] == 1) selected @endif @endif>Piutang</option>
                            </select>

                            <select class="form-control" name="r">
                                @foreach($d as $detail)
                                <option value="{{ $detail->id }}" @if(isset($_GET['r'])) @if($_GET['r'] == $detail->id) selected @endif @endif>{{ ucwords($detail->nama) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-default">Cari</button>
                        <a href="{{ url('item_use/create') }}" class='btn btn-primary'><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Tambah Data</a> 
 
                    </form>
                    <p></p>

                    <table class="table table-bitem_useed table-hover">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Unit</th>
                            <th>Keterangan</th>
                            <th>Diketahui</th>
                            <th>Diterima</th>
                            <th>Dibuat</th>
                            {{-- <th>Piutang</th> --}}
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
                            <tr @if($t->status > 0) class="danger" @endif>
                                <td><?php echo $no ?></td>
                                
                                <td>
                                    <?php 
                                    if ($t->tanggal != '0000-00-00') {
                                        echo $t->tanggal;
                                    }
                                    ?>
                                </td>
                                <td><?php echo $t->unit->kode ?></td>
                                <td><?php echo $t->keterangan ?></td>
                                <td><?php echo $t->diketahui->nama ?></td>
                                <td><?php echo $t->diterima ?></td>
                                <td><?php echo $t->dibuat->nama ?></td>
                                {{-- <td>{{ $t->piutang }}</td> --}}
                                <td>
                                    <a  class="btn btn-success" href="<?php echo url('item_use/'.$t->id.'/edit') ?>"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit</a>

                               <!--      <a  class="btn btn-primary" href="<?php echo url('item_use/'.$t->id) ?>"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> Detail</a> -->
                                    
                                    <a target="_blank" class="btn btn-info" href="<?php echo url('item_use/print/'.$t->id) ?>" target="_blank"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</a>
                                    <a target="_blank" class="btn btn-info" href="<?php echo url('item_use/'.$t->id.'/doc') ?>" target="_blank"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> DOC</a>
                                    <a class="btn btn-danger" onclick="event.preventDefault();
                                                    if(confirm('Apakah anda yakin akan menghapus data ini?'))
                                                     document.getElementById('delete<?php echo $t->id;  ?>').submit();"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Hapus</a>

                                    <form action="{{ url('item_use/'.$t->id) }}" id="delete<?php echo $t->id;  ?>" method="POST">
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
