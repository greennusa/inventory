@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Detail Retur Barang</div>

                <div class="panel-body">
                    <form class="form-horizontal" action="<?php echo url('retur_item') ?>" method="POST">
                        {{ csrf_field() }}
                        
                            <div class="form-group">

                                <label for="nama" class="col-lg-2 control-label" >Nomor Retur</label>

                                <div class="col-lg-6">

                                    <input disabled type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Nomor Retur" required value="{{ $r->nomor }}">

                                </div>

                            </div>

                            <div class="form-group">

                                <label for="nama" class="col-lg-2 control-label" >Tanggal Retur</label>

                                <div class="col-lg-6">

                                    <input disabled type="date" class="form-control datepickers" id="tanggal" name="tanggal" placeholder="Tanggal Retur" required value="{{ $r->tanggal }}">

                                </div>

                            </div>

                            

                            <div class="form-group">
                                <label for="diterima_id" class="col-lg-2 control-label">Diterima</label>
                                <div class="col-lg-6">
                                    <select disabled  class="form-control selectpicker" name="diterima_id" id="diterima_id" data-live-search="true">
                                        <option></option>
                                        <?php foreach ($user as $u): ?>
                                            <option @if($r->diterima_id == $u->id) selected @endif value="<?php echo $u->id ?>" ><?php echo $u->nama ?></option>
                                        <?php endforeach ?>             
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="dibawa_id" class="col-lg-2 control-label">Dibawa</label>
                                <div class="col-lg-6">
                                    <select disabled  class="form-control selectpicker" name="dibawa_id" id="dibawa_id" data-live-search="true">
                                        <option></option>
                                        <?php foreach ($user as $u): ?>
                                            <option @if($r->dibawa_id == $u->id) selected @endif value="<?php echo $u->id ?>" ><?php echo $u->nama ?></option>
                                        <?php endforeach ?>             
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="dikirim_id" class="col-lg-2 control-label">Dikirim</label>
                                <div class="col-lg-6">
                                    <select disabled  class="form-control selectpicker" name="dikirim_id" id="dikirim_id" data-live-search="true">
                                        <option></option>
                                        <?php foreach ($user as $u): ?>
                                            <option @if($r->dikirim_id == $u->id) selected @endif value="<?php echo $u->id ?>" ><?php echo $u->nama ?></option>
                                        <?php endforeach ?>             
                                    </select>
                                </div>
                            </div>


                         

                            
                        <div class="form-group">

                            <div class="col-lg-10 col-lg-offset-2">
                            	<a href="{{ url('retur_item') }}" class="btn btn-success">Kembali</a>

                            

                            </div>

                        </div>
                            
                    </form>

                    <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>NPB</th>
                                            <th>OPB</th>
                                            <th>Kode Barang</th>
                                            <th>Nama Barang</th>
                                           
                                            <th>Unit</th>
                                            
                                         
                                            <th>Jumlah</th>
                                            <th>Harga</th>
                                            
                               
                                            
                                            <th>Keterangan</th>
                                            <th>Aksi</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no=1?>
                                        <?php foreach ($r->detail_semua as $d): ?>
                                            
                                            <tr>
                                                
                                                <td><?php echo $no ?></td>

                                                <td>{{ @$d->detail_bbk->bbk->nomor }}</td>
                                                <td>{{ @$d->detail_bbk->detail_bbm->detail_pemesanan->detail_permintaan->permintaan->nomor }}</td>
                                                <?php $db = \App\DetailPemesananBarang::where('gabungan','like','%'.@$d->detail_bbk->gabungan_id.'%')->get();?>
                                                <td><?php if(@$d->detail_bbk->detail_bbm->detail_pemesanan->kode_barang != null){ echo @$d->detail_bbk->detail_bbm->detail_pemesanan->kode_barang; }else if(@$d->camp_lama != null){ echo @$d->camp_lama->kode_barang;} else { echo @$d->barang->kode; }?>
                                                    <?php if($d->camp_lama == null):foreach($db as $dd): ?>
                                                     / <?php echo @$dd->barang->kode ?>
                                                    <?php endforeach;endif; ?>
                                                </td>
                                                <td><?php if(@$d->detail_bbk->detail_bbm->detail_pemesanan->nama_barang != null){ echo @$d->detail_bbk->detail_bbm->detail_pemesanan->nama_barang; }else if(@$d->camp_lama != null){ echo @$d->camp_lama->nama_barang;} else { echo @$d->barang->nama; }?> 
                                                    <?php if($d->camp_lama == null):foreach($db as $dd): ?>
                                                     / <?php echo @$dd->barang->nama ?>
                                                    <?php endforeach;endif; ?>
                                                     
                                                </td>
                            
                                                <td><?php echo @$d->barang->unit->kode ?></td>
                                               
                                                
                                                <td>
                                                    <?php echo @$d->jumlah ?> <?php echo @$d->barang->satuan->nama ?><?php echo @$d->camp_lama->satuan->nama ?>
                                                    
                                                </td>
                                                <td>
                                                    Rp.<?php echo number_format(@$d->detail_bbk->harga+@$d->camp_lama->satuan->nama) ?>
                                                    
                                                </td>
                                                
                                               
                                                <td>
                                                    <?php echo @$d->keterangan ?>
                                                    <input disabled type="hidden" name="detail_keterangan[]" class="form-control" value="<?php echo @$d->keterangan ?>"></td>
                                                <td>
                                                    @if(@$d->status == 0)
                                                    <a class="btn btn-success" onclick="event.preventDefault();
                                                    if(confirm('Apakah anda yakin akan meretur barang ini?'))
                                                     document.getElementById('delete<?php echo @$d->id;  ?>').submit();"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Retur Selesai</a>

                                                    <form action="{{ url('detail_retur_item/'.@$d->id) }}" id="delete<?php echo @$d->id;  ?>" method="POST">
                                                        {{ csrf_field() }}
                                                        <input type="hidden" name="_method" value="DELETE">
                                                    </form>
                                                    @else
                                                    selesai diretur
                                                    @endif
                                                </td>
                                                
                                            </tr>
                                            <?php $no++ ?>
                                            <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
  
                        

                            


                </div>
            </div>
        </div>
    </div>
</div>

            
@endsection

