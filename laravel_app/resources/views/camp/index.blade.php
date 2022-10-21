@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Camp<br><br> <a class="btn btn-default" href="{{ url('/') }}">Kembali</a></div>

                <div class="panel-body">
                    <form class="form-inline">
                        <div class="form-group">
                            <input type="text" class="form-control" name="q" placeholder="Pencarian" value="@if(isset($_GET['q'])){{$_GET['q']}}@endif">


                            <select class="form-control" name="p">
                                @foreach($d as $detail)
                                <option value="{{ $detail->id }}" @if(isset($_GET['p'])) @if($_GET['p'] == $detail->id) selected @endif @endif>{{ $detail->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-default">Cari</button>
                        <a href="{{ url('warehouse_udit/create') }}" class='btn btn-primary'><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Tambah Data</a> 

                        <a href="{{ url('warehouse_udit_lama/create') }}" class='btn btn-primary'><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Stok Lama</a> 
                    </form>
                    <p></p>

                    <table class="table table-bordered table-hover">
                        <tr>
                            <th>No</th>

                            <th>Kode Barang</th>
                            <th>Nama</th>
                            <th>Stok</th>
                            <th>Satuan</th>
                           
                            <th>NPB</th>
                            <th>Kode Unit</th>
							<th></th>
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
                        @foreach($tables as $data)

                            <?php $db = \App\DetailPemesananBarang::where('gabungan','like','%'.$data->gabungan_id.'%')->get(); ?>
                           
                                <tr @if(@$data->status > 0 || @$data->detail_bbk->jumlah_di_camp < @$data->detail_bbk->jumlah) class="danger" @endif>
                                    <td><?php echo $no ?></td>

                                    <td><?php if(@$data->detail_bbk->detail_bbm->detail_pemesanan->kode_barang != null || @$data->detail_bbk->detail_bbm->detail_pemesanan->kode_barang != ''){ echo @$data->detail_bbk->detail_bbm->detail_pemesanan->kode_barang; }else { echo @$data->kode_barang; }?>
                                        @if(@$data->gabungan_id != null || @$data->gabungan_id != '')
                                            @foreach($db as $aa)
                                             / <?php echo $aa->barang->kode ?>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td><?php if(@$data->detail_bbk->detail_bbm->detail_pemesanan->nama_barang != null || @$data->detail_bbk->detail_bbm->detail_pemesanan->nama_barang != ''){ echo @$data->detail_bbk->detail_bbm->detail_pemesanan->nama_barang; }else { echo @$data->nama_barang; }?>
                                        @if(@$data->gabungan_id != null || @$data->gabungan_id != '')
                                            @foreach($db as $aa)
                                         / <?php echo $aa->barang->nama ?>
                                        @endforeach
                                        @endif
                                    </td>
                                    <td><?php echo @$data->stok-@$data->stok_retur ?> @if(@$data->stok_retur > 0) (Jumlah Diretur {{ @$data->stok_retur }}) @endif @if(@$data->detail_bbk->jumlah_di_camp < @$data->detail_bbk->jumlah) (Barang Belum Dikirim Semua) @endif </td>

                                    <td>@if(@$data->detail_bbk != null)<?php echo @$data->detail_bbk->detail_bbm->detail_pemesanan->detail_permintaan->satuan->nama ?> @else {{ @$data->satuan->nama }}@endif</td>
                                    
                                    <td>{{ @$data->detail_bbk->bbk->nomor }}</td>
                                    <td><?php echo @$data->barang->unit->kode ?> / <?php echo @$data->barang->unit->jenis_unit->nama ?></td>
									<td>{{ $data->camp->nama }}</td>
                                    <td>
                                        {{ $data->keterangan }}
                                    </td>
                                    <td>
                                        <?php 
                                        $url = "warehouse_udit";
                                        if($data->detail_bbk == null) {
                                            $url = "warehouse_udit_lama";
                                        } 

                                        ?>
                                        <a class="btn btn-success" href="{{ url($url.'/'.@$data->id.'?page='.$tables->currentPage()) }}"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> Detail</a>
                                        @if(@$data->status == 0 )
                                        <a class="btn btn-danger" onclick="event.preventDefault();if(confirm('Apakah anda yakin akan menghapus data ini?'))document.getElementById('delete<?php echo @$data->id;  ?>').submit();"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Hapus</a>
                                    @endif          
                                        @if(@$data->stok-@$data->stok_retur != 0 )
                                            <button type="button" class="btn btn-danger " id="id_<?=$no?>" data-toggle="modal" data-target="#myModal<?=@$data->id?>"><i class="glyphicon glyphicon-remove"></i> Retur</button>
                                        @else
                                            Barang Diretur Semua
                                        @endif
                                    @if(@$data->detail_bbk != null)
                                        
                                    @endif
                                        
                                        <form action="{{ url($url.'/'.@$data->id) }}" id="delete<?php echo @$data->id;  ?>" method="POST">
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

<?php foreach ($tables as $detail_barang): ?>
                <div id="myModal<?=$detail_barang->id?>" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Retur Barang Camp</h4>
                            </div>
                            <div class="modal-body" style="padding:0;">
                                
                                    
                                    <form class="form-horizontal" action="<?php echo url('retur_camp') ?>" method="POST">
                                        {{ csrf_field() }}
                                       
                                            <input type="hidden" name="camp_id" value="{{ $detail_barang->id }}">
                                            

                                                

                                                <div id="nomor_baru{{ $detail_barang->id }}">
                                                    <div class="form-group">
                                                        <label for="nama" class="col-lg-4 control-label" >Nomor Retur Barang</label>
                                                        <div class="col-lg-6" >
                                                            <input  type="text"  class="form-control" name="nomor_baru"    placeholder="Nomor Retur Barang" required >
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="nama" class="col-lg-4 control-label" >Tanggal</label>
                                                        <div class="col-lg-6" >
                                                            <input  type="date"  class="form-control" name="tanggal"    placeholder="Nomor Retur Barang" required >
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="diterima_id" class="col-lg-4 control-label">Diterima</label>
                                                        <div class="col-lg-6">
                                                            <select  class="form-control " name="diterima_id" id="diterima_id" data-live-search="true">
                                                                
                                                                <?php foreach ($user as $u): ?>
                                                                    <option   value="<?php echo $u->id ?>" ><?php echo $u->nama ?></option>
                                                                <?php endforeach ?>             
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="dibawa_id" class="col-lg-4 control-label">Dibawa</label>
                                                        <div class="col-lg-6">
                                                            <select  class="form-control " name="dibawa_id" id="dibawa_id" data-live-search="true">
                                                                
                                                                <?php foreach ($user as $u): ?>
                                                                    <option  value="<?php echo $u->id ?>" ><?php echo $u->nama ?></option>
                                                                <?php endforeach ?>             
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="dikirim_id" class="col-lg-4 control-label">Dikirim</label>
                                                        <div class="col-lg-6">
                                                            <select  class="form-control " name="dikirim_id" id="dikirim_id" data-live-search="true">
                                                               
                                                                <?php foreach ($user as $u): ?>
                                                                    <option value="<?php echo $u->id ?>" ><?php echo $u->nama ?></option>
                                                                <?php endforeach ?>             
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div id="divnya{{ $detail_barang->id }}" style="display: none;" >
                                                    <div class="form-group">
                                                        <label for="nama" class="col-lg-4 control-label" >Nomor Retur Barang</label>
                                                        <div class="col-lg-6" >
                                                            <select  class="form-control " name="nomor_lama"  data-live-search="true" >
                                                                <option></option>
                                                                <?php foreach ($retur as $u): ?>
                                                                    <option value="<?php echo $u->id ?>"><?php echo $u->nomor ?> - <?php echo $u->tanggal ?></option>
                                                                <?php endforeach ?>
                                                            </select>
                                                        </div>  
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="nama" class="col-lg-4 control-label" ></label>
                                                    <div class="col-lg-6" >
                                                        <input class="pilih" type="checkbox" id_baru="nomor_baru{{ $detail_barang->id }}" id_ada="divnya{{ $detail_barang->id }}" name="lama" value="lama"> Pilih Retur Yang Sudah Ada
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="nama" class="col-lg-4 control-label" >Barang</label>
                                                    <div class="col-lg-6" >

                                                        <input class="form-control" type="text" disabled readonly value="@if($detail_barang->detail_bbk != null){{ $detail_barang->detail_bbk->nama_barang }}@else {{ $detail_barang->nama_barang }} @endif">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="keterangan" class="col-lg-4 control-label" >Keterangan</label>
                                                    <div class="col-lg-6" >

                                                        <input class="form-control" type="text" name="keterangan" placeholder="Keterangan">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="jumlah" class="col-lg-4 control-label" >Jumlah</label>
                                                    <div class="col-lg-6" >

                                                        <input class="form-control" type="number" name="jumlah" placeholder="Jumlah" min="1" max="<?php echo $detail_barang->stok-$detail_barang->stok_retur ?>" >
                                                    </div>
                                                </div>

                                                @if(@$detail_barang->detail_bbk == null)
                                                    <input type="hidden" name="stok_lama" value="stok_lama">
                                                @endif

                                                <div class="form-group">
                                                    <label for="nama" class="col-lg-4 control-label" ></label>
                                                    <div class="col-lg-6" >

                                                        <button class="btn btn-default">Tambah</button>
                                                            
                                                    </div>
                                                </div>

                                    </form>
                                
                            </div>
                            <div class="modal-footer">
                               
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>

                    </div>
                </div>
            <?php endforeach ?>
<script type="text/javascript">
    $(document).on('click', '.pilih', function(event) {
        if($(this).is(':checked')){
            $("#"+$(this).attr('id_ada')).show();
            $("#"+$(this).attr('id_ada')+" input").attr('required','required');
            $("#"+$(this).attr('id_baru')).hide();
            $("#"+$(this).attr('id_baru')+" input").removeAttr('required');
        }
        else {
            $("#"+$(this).attr('id_ada')).hide();
            $("#"+$(this).attr('id_ada')+" input").removeAttr('required');
            $("#"+$(this).attr('id_baru')).show();
            $("#"+$(this).attr('id_baru')+" input").attr('required','required');
        }
        
    });
</script>
@endsection
