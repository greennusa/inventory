@extends('layouts.app')



@section('content')

<div class="container">

    <div class="row">

        <div class="col-md-12">

            <div class="panel panel-default">

                <div class="panel-heading">Bukti Barang Masuk<br><br> <a class="btn btn-default" href="{{ url('/') }}">Kembali</a></div>



                <div class="panel-body">

                    <form class="form-inline">

                        <div class="form-group">

                            <input type="text" class="form-control" name="q" placeholder="Pencarian" value="@if(isset($_GET['q'])){{$_GET['q']}}@endif">

                        </div>

                        <button type="submit" class="btn btn-default">Cari</button>

                        <!-- <a href="{{ url('item_in/create') }}" class='btn btn-primary'><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Tambah Data</a>  -->

                    </form>

                    <p></p>



                    <table class="table table-bordered table-hover">
                        <tr>
                            <th>No</th>
                            <th>Nomor Pemesanan</th>
                            <th>Supplier</th>
                            <th>Tanggal</th>
                            <th>BBM</th>
                            <th>Keterangan</th>
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



                        <tr @if(count($t->bbm) == 0) class="danger" @endif>

                            <td ><?php echo $no;?> </td>

                            <td><?php echo $t->nomor ?></td>

                            <td><?php echo $t->pemasok->nama ?></td>

                            <td><?php 

                            if(count($t->bbm) == 0){

                                echo $t->tanggal;

                            } else {

                                echo $t->bbmnya->tanggal;

                            }

                            ?></td>

                            <td><?php 

                            if(count($t->bbm) == 0){

                                echo "Belum Masuk";

                            } else {

                                echo "Sudah Masuk (".$t->bbmnya->nomor.")";

                            }

                            ?></td>

                            <td><?php 

                            if(count($t->bbm) == 0){

                                echo $t->keterangan;

                            } else {

                                echo $t->bbmnya->keterangan;

                            }

                            ?></td>

                            <td>

                                @if(count($t->bbm) > 0)

                                <a class="btn btn-primary" href="{{ url('item_in/'.$t->bbmnya->id.'/edit?page='.$tables->currentPage()) }}"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Ubah</a>

                                <a class="btn btn-danger" onclick="event.preventDefault();

                                if(confirm('Apakah anda yakin akan menghapus data ini?'))

                                   document.getElementById('delete<?php echo $t->bbmnya->id;  ?>').submit();"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Hapus</a>

                               <a class="btn btn-primary" href="{{ url('item_in/barcode/'.$t->bbmnya->id) }}" target="_blank"><span class="glyphicon glyphicon-print" aria-hidden="true" ></span> Barcode</a>

                               <a class="btn btn-primary" href="{{ url('item_in/qrcode/'.$t->bbmnya->id) }}" target="_blank"><span class="glyphicon glyphicon-print" aria-hidden="true" ></span> QrCode</a>

                            <form action="{{ url('item_in/'.$t->bbmnya->id) }}" id="delete<?php echo $t->bbmnya->id;  ?>" method="POST">

                                {{ csrf_field() }}

                                <input type="hidden" name="_method" value="DELETE">

                            </form>

                            @else

                            <!-- <button type="button" data-toggle="modal" data-target="#myModal<?=$t->id?>" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i>  Buat BBM</button> -->

                            <a class="btn btn-primary" href="{{ url('item_in/'.$t->id.'/buat_bbm?page='.$tables->currentPage()) }}"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Buat BBM</a>

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

