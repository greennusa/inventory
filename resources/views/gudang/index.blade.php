@extends('layouts.app')



@section('content')

<div class="container">

    <div class="row">

        <div class="col-md-12">

            <div class="panel panel-default">

                <div class="panel-heading">Gudang<br><br> <a class="btn btn-default" href="{{ url('/') }}">Kembali</a></div>



                <div class="panel-body">

                    <form class="form-inline">

                        <div class="form-group">

                            <input type="text" class="form-control" name="q" placeholder="Pencarian" value="@if(isset($_GET['q'])){{$_GET['q']}}@endif">

                        </div>

                        <button type="submit" class="btn btn-default">Cari</button>

                        <a href="{{ url('warehouse/create') }}" class='btn btn-primary'><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Tambah Data</a> <a href="{{ url('warehouse_all') }}" class='btn btn-primary'><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print Semua Barang</a> 

                    </form>

                    <p></p>



                    <table class="table table-bordered table-hover">

                        <tr>

                            <th>No</th>

                            <th>PO</th>

                            

                            <th>Kode Barang</th>

                            <th>Nama</th>

                            <th>Stok</th>



                            



                            <th>Satuan</th>



                            <th>Kode Unit</th>

                            

                            <th>Aksi</th>

                        </tr>

                        <?php 

                        $page = 0;

                        if(isset($_GET['page']) && $_GET['page'] > 1){

                            $page = $_GET['page']*10-10;

                        }

                        $no = 2*$page+1; 

                        use App\DetailPemesananBarang;

                        ?>

                        @foreach($tables as $data)

                        @if($data->gabungan == '' || $data->gabungan == null)

                        

                            <tr>

                                <td><?php echo $no ?></td>

                                <td>{{ @$data->detail_bbm->bbm->pemesanan->nomor }}</td>

                               

                                <?php $db = DetailPemesananBarang::where('gabungan','like','%'.$data->gabungan_id.'%')->get();?>

                                <td><?php if(@$data->detail_bbm->detail_pemesanan->kode_barang != null || @$data->detail_bbm->detail_pemesanan->kode_barang != ''){ echo @$data->detail_bbm->detail_pemesanan->kode_barang; }else { echo $data->barang->kode; }?>

                                @if($data->gabungan_id != null || $data->gabungan_id != '')

                                    @foreach($db as $aa)

                                         / <?php echo $aa->barang->kode ?>

                                      @endforeach

                                @endif

                                </td>

                                <td><?php if(@$data->detail_bbm->detail_pemesanan->nama_barang != null || @$data->detail_bbm->detail_pemesanan->nama_barang != ''){ echo @$data->detail_bbm->detail_pemesanan->nama_barang; }else { echo $data->barang->nama; }?>

                                @if($data->gabungan_id != null || $data->gabungan_id != '')

                                    @foreach($db as $aa)

                                                                 / <?php echo $aa->barang->nama ?>

                                                                @endforeach

                                                                @endif

                                </td>

                                <td><?php echo $data->stok ?></td>



                                <td><?php echo @$data->detail_bbm->detail_pemesanan->detail_permintaan->satuan->nama ?></td>



                                <td><?php echo $data->barang->unit->kode ?></td>



                               

                                <td>

                                    <a class="btn btn-success" href="{{ url('warehouse/'.$data->id.'?page='.$tables->currentPage()) }}"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> Detail</a>

                                    <a class="btn btn-danger" onclick="event.preventDefault();

                                                    if(confirm('Apakah anda yakin akan menghapus data ini?'))

                                                     document.getElementById('delete<?php echo $data->id;  ?>').submit();"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Hapus</a>



                                    <form action="{{ url('warehouse/'.$data->id) }}" id="delete<?php echo $data->id;  ?>" method="POST">

                                        {{ csrf_field() }}

                                        <input type="hidden" name="_method" value="DELETE">

                                    </form>

                                </td>

                            </tr>

                            <?php $no++; ?>

                            @endif

                           

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

