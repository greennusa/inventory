@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Edit BBM<br><br> <a class="btn btn-default" href="{{ url('/item_in') }}">Kembali</a></div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ url('item_in/'.$r->id) }}">
                        <input type="hidden" name="page" value="{{ $_GET['page'] }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="PUT">
                        <div class="form-group">
                            <label for="nomor" class="col-lg-2 control-label">Nomor BBM</label>
                            <div class="col-lg-3">
                                <input type="text"  class="form-control" name="nomor" id="nomor" placeholder="Nomor BBM"  value="{{ $r->nomor }}" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tanggal" class="col-lg-2 control-label">Tanggal</label>
                            <div class="col-lg-3">
                                <input type="date" class="form-control datepickers" name="tanggal" id="tanggal" placeholder="Tanggal" required value="{{ $r->tanggal }}">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="pemesanan_barang_id" class="col-lg-2 control-label">Pemesanan Barang</label>
                            <div class="col-lg-3">
                                <input type="text" disabled class="form-control" name="pemesanan_barang_id" value="{{ $r->pemesanan->nomor }}">
                            </div>
                        </div>
                            
                            
                        <div class="form-group">
                            <label for="keterangan" class="col-lg-2 control-label">Keterangan</label>
                            <div class="col-lg-3">
                                <input type="text"  class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan" value="{{ $r->keterangan }}">
                            </div>
                        </div>

                        <div class="form-group">

                            <div class="col-lg-10 col-lg-offset-2">

                                <input type=button value=Batal class="btn btn-default" onclick=self.history.back()>

                                <button type="submit" class="btn btn-primary">Simpan</button>

                            </div>

                        </div>
                        </form>
                        <form action="{{ url('detail_item_in/'.$r->id) }}" method="post">
                            {{ csrf_field() }}
                            <input type="hidden" name="_method" value="PUT">
                            <input type="hidden" name="pemesanan_barang_id" value="{{ $r->pemesanan->id }}">
                            <div id="list-barang">
                                
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Kode Barang</th>
                                            <th>Nama Barang</th>
                                            
                                            <th>Kode Unit</th>
                                            <th>Halaman</th>
                                            <th>Indeks</th>
                                            <th>SN</th>
                                            <th>Jumlah</th>
                                            <th>Harga</th>
                                            
                                            <th width="170px">Kelengkapan</th>
                                            
                                            <th>Keterangan</th>
                                            <th>No OPB</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no=1;use App\DetailPemesananBarang; ?>
                                        <?php foreach ($r->detail as $d): ?>
                                            @if($d->gabungan == '' || $d->gabungan == null)
                                            <tr @if($d->kelengkapan == 0) class="bg-danger" @endif>
                                                <input type="hidden" name="id[]" value="<?php echo $d->id ?>">
                                                <input type="hidden" name="barang_id[]" value="<?php echo $d->barang_id ?>">
                                                <td><?php echo $no ?></td>
                                                <?php $db = DetailPemesananBarang::where('gabungan','like','%'.$d->gabungan_id.'%')->where('pemesanan_barang_id',$d->detail_pemesanan->pemesanan_barang_id)->get();?>
                                                <td><?php if($d->detail_pemesanan->kode_barang == null || $d->detail_pemesanan->kode_barang == ''){ echo $d->barang->kode; } else { echo $d->detail_pemesanan->kode_barang; } ?>
                                                    @foreach($db as $aa)/ <?php echo $aa->barang->kode ?>@endforeach
                                                </td>
                                                <td><?php if($d->detail_pemesanan->nama_barang == null || $d->detail_pemesanan->nama_barang == ''){ echo $d->barang->nama; } else { echo $d->detail_pemesanan->nama_barang; } ?>
                                                     @foreach($db as $aa) / <?php echo $aa->barang->nama ?>@endforeach
                                                </td>
                                              
                                                <td><?php echo $d->barang->unit->kode ?></td>
                                                <td><?php echo $d->barang->halaman ?></td>
                                                <td><?php echo $d->barang->indeks ?></td>
                                                <td><?php if($d->barang->pakai_sn == 1): ?><button type="button" class="btn btn-primary " id="id_<?=$no?>" data-toggle="modal" data-target="#myModal<?=$d->id?>"><i class="glyphicon glyphicon-plus"></i></button><?php endif; ?></td>
                                                <td>
                                                    <?php echo $d->jumlah ?> <?php echo $d->detail_pemesanan->detail_permintaan->satuan->nama ?>
                                                    <input readonly class="form-control" type="hidden" name="jumlah[]" value="<?php echo $d->jumlah ?>">
                                                </td>
                                                <td>
                                                    Rp.<?php echo number_format($d->detail_pemesanan->harga) ?>
                                                    <input readonly class="form-control" type="hidden" name="harga[]" value="<?php echo $d->harga ?>">
                                                </td>
                                                
                                                <td>
                                                    <select name="kelengkapan[]" class="form-control "   required>
                                                        <option @if($d->kelengkapan == 1) selected @endif value="1">Lengkap</option>
                                                        <option @if($d->kelengkapan == 0) selected @endif value="0">Tidak Lengkap</option>
                                                    </select>
                                                </td>
                                               
                                                <td><input type="text" name="detail_keterangan[]" class="form-control" value="<?php echo $d->keterangan ?>"></td>
                                                <td>
                                                    <?php echo $d->detail_pemesanan->detail_permintaan->permintaan->nomor ?>
                                                </td>
                                            </tr>
                                            <?php $no++ ?>
                                            @endif
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                            <button type="submit" class="btn btn-primary">Ubah</button>
                        
                            

            <?php foreach ($r->detail as $detail_barang): ?>
                <?php if($d->barang->pakai_sn == 1): ?>
                <div id="myModal<?=$detail_barang->id?>" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Tambah Serial Number</h4>
                            </div>
                            <div class="modal-body" style="padding:0;">
                                
                                    
                                    <table class="table table-bordered table-responsive" style="padding:0">
                                        <thead>
                                            <tr>
                                                <th>Nomor</th>
                                                <th>Serial Number Barang</th>
                                                <th>Barcode</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $x = 1; ?>
                                            <?php if($detail_barang->barang->pakai_sn == 1): ?>
                                            <?php for ($i=0; $i < $detail_barang->jumlah; $i++) { 
                                                $idnya = $i;
                                                if(count($detail_barang->serial) > 0 && isset($detail_barang->serial[$i])){
                                                    $idnya = $detail_barang->serial[$i]->id;
                                                }
                                                ?>
                                                    <tr>
                                                        <input type="hidden" name="serial_id[]" value="{{ $idnya }}">
                                                        <td valign="midlle"><?php echo $x++ ?></td>
                                                        <td><input type="text" name="sn_<?php echo $idnya ?>[]" class="form-control input-submit-query input_sn" value="<?php echo @$detail_barang->serial[$i]->sn ?>" placeholder="Serial number <?php echo $detail_barang->barang->nama ?>"></td>
                                                        <td>@if(@$detail_barang->serial[$i]->sn != '') <?php echo '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG(@$detail_barang->serial[$i]->sn, "C39+") . '" alt="barcode"   />'; ?> @endif</td>
                                                    </tr>
                                                <?php
                                            } ?>
                                        <?php endif; ?>
                                           
                                        </tbody>
                                    </table>
                                
                            </div>
                            <div class="modal-footer">
                               
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>

                    </div>
                </div>
            <?php endif;endforeach ?>
                    
            </form>
                    

                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('.input_sn').keypress(function(event) {
        if (event.keyCode == 13) {
            event.preventDefault();
            var index = $('.input_sn').index(this) + 1;
            $('.input_sn').eq(index).focus();
        }
    });
</script>
            
@endsection
