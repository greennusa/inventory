@extends('layouts.app')



@section('content')

<div class="container">

    <div class="row">

        <div class="col-md-12">

            <div class="panel panel-default">

                <div class="panel-heading">Edit Pemakaian Barang</div>



                <div class="panel-body">

                    <form class="form-horizontal" action="<?php echo url('item_use/'.$r->id) ?>" method="POST">

                        {{ csrf_field() }}

                        <input type="hidden" name="_method" value="PUT">



                            <div class="form-group">



                                <label for="nama" class="col-lg-2 control-label" >Tanggal Pemakaian</label>



                                <div class="col-lg-6">



                                    <input  type="date" class="form-control datepickers" id="tanggal" name="tanggal" placeholder="Tanggal Pemakaian" required value="{{ $r->tanggal }}">



                                </div>



                            </div>



                            <div class="form-group">



                                <label for="nama" class="col-lg-2 control-label" >Keterangan Pemakaian</label>



                                <div class="col-lg-6">



                                    <input  type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Keterangan Pemakaian" required value="{{ $r->keterangan }}">



                                </div>



                            </div>



                           



                            <div class="form-group">



                                <label for="merek_id" class="col-lg-2 control-label">Unit</label>



                                <div class="col-lg-6">



                                    <input disabled type="text"  class="form-control"  value="{{ $r->unit->kode }}">



                                </div>



                            </div>



                            <div class="form-group">

                                <label for="diketahui_id" class="col-lg-2 control-label">Diketahui</label>

                                <div class="col-lg-6">

                                    <select class="form-control selectpicker" name="diketahui_id" id="diketahui_id" data-live-search="true">

                                        <option></option>

                                        <?php foreach ($user as $u): ?>

                                            <option @if($r->diketahui_id == $u->id) selected @endif value="<?php echo $u->id ?>" ><?php echo $u->nama ?></option>

                                        <?php endforeach ?>             

                                    </select>

                                </div>

                            </div>



                            <div class="form-group">



                                <label for="nama" class="col-lg-2 control-label" >Diterima</label>



                                <div class="col-lg-6">



                                    <input  type="text" class="form-control" id="diterima" name="diterima" placeholder="Keterangan Pemakaian" required value="{{ $r->diterima }}" >



                                </div>



                            </div>



                            <div class="form-group">

                                <label for="dibuat_id" class="col-lg-2 control-label">Dibuat</label>

                                <div class="col-lg-6">

                                    <select  class="form-control selectpicker" name="dibuat_id" id="dibuat_id" data-live-search="true">

                                        <option></option>

                                        <?php foreach ($user as $u): ?>

                                            <option @if($r->dibuat_id == $u->id) selected @endif value="<?php echo $u->id ?>" ><?php echo $u->nama ?></option>

                                        <?php endforeach ?>             

                                    </select>

                                </div>

                            </div>



                            



                            <div class="form-group">



                                <label for="nama" class="col-lg-2 control-label" >Lokasi Pemakaian</label>



                                <div class="col-lg-6">



                                    <input  type="text" class="form-control" id="lokasi" name="lokasi" placeholder="Keterangan Pemakaian" required value="{{ $r->lokasi }}" >



                                </div>



                            </div>


							<div class="form-group">

                                <label for="penggunaan" class="col-lg-2 control-label">Untuk Penggunaan</label>

                                <div class="col-lg-6">

                                    <select class="form-control selectpicker" name="penggunaan" id="penggunaan">

                                        <option></option>

                                        <?php foreach ($penggunaan as $u): ?>

                                            <option @if($r->penggunaan == $u) selected @endif value="<?php echo $u ?>" ><?php echo $u ?></option>

                                        <?php endforeach ?>             

                                    </select>

                                </div>

                            </div>
							

                            <div class="form-group">

                                    <label for="piutang" class="col-lg-2 control-label">Piutang</label>

                                    <div class="col-lg-6">

                                        <select class="form-control selectpicker" name="piutang">

                                            <option value="0" @if($r->piutang == 0) selected @endif>Tidak</option>

                                            <option value="1" @if($r->piutang == 1) selected @endif>Ya</option>

                                        </select>

                                    </div>

                            </div>





                            <!-- <div class="form-group">



                                <label for="unit_barang" class="col-lg-2 control-label">Unit Barang</label>



                                <div class="col-lg-6">



                                    <select onchange="get_barang_camp(this.value)" class="form-control selectpicker" id="unit_barang" data-live-search="true" >

                                        <option></option>

                                        <?php foreach ($unit as $u): ?>



                                        <option value="<?php echo $u->id ?>">{{ $u->kode }}</option>

                                    <?php endforeach ?>

                                    </select>



                                </div>



                            </div>



                            <div class="form-group">

                                <label for="barang_id" class="col-lg-2 control-label">Barang Di Camp</label>

                                <div class="col-lg-6" id="barang_id">

                                    

                                </div>

                            </div> -->

                        <div class="form-group">



                            <div class="col-lg-10 col-lg-offset-2">

                            	<a href="{{ url('item_use') }}" class="btn btn-success">Kembali</a>



                                <button type="submit" class="btn btn-primary">Simpan</button>



                            </div>



                        </div>

                            

                    </form>



                     <form class="form-horizontal" action="{{ url('detail_item_use/'.$r->id) }}"  method="post">

                        {{ csrf_field() }}

                        <input type="hidden" name="_method" value="PUT"> 

                    <table class="table table-bordered table-hover">

                                    <thead>

                                        <tr>

                                            <th>#</th>

                                            <th>NPB</th>

                                            <th>Kode Barang</th>

                                            <th>Nama Barang</th>

                                            

                                            <th>Kode Unit</th>

                                            

                                         

                                            <th>Jumlah</th>

                                            <th>Harga</th>

                                            

                               

                                            

                                            <th>Keterangan</th>

                                            <th>Aksi</th>

                                        </tr>

                                    </thead>

                                    <tbody>

                                        <?php $no=1;use App\DetailPemesananBarang;?>

                                        <?php foreach($r->detail_semua as $d): ?>



                                            @if(@$d->gabungan == '' || @$d->gabungan == null)

                                            <tr>

                                                <input class="form-control" type="hidden" name="detail_id[]" value="<?php echo $d->id ?>">

                                                <td><?php echo $no ?></td>

                                                <td>
                                                    @if(isset($d->detail_bbk))
                                                    {{ @$d->detail_bbk->bbk->nomor }}
                                                    <input type="hidden" name="nomor[]" value="{{$d->detail_bbk->bbk->nomor}}">
                                                    @else
                                                    Stok Lama
                                                    <input type="hidden" name="nomor[]" value="stok_lama">
                                                    @endif
                                                </td>

                                                <?php $db = DetailPemesananBarang::where('gabungan','like','%'.@$d->gabungan_id.'%')->get();?>

                                                <td>

                                                    <?php if(@$d->detail_bbk->detail_bbm->detail_pemesanan->kode_barang != null){ echo @$d->detail_bbk->detail_bbm->detail_pemesanan->kode_barang; }else if(@$d->detail_bbk == null){ echo @$d->barang->kode;} else { echo @$d->barang->kode; }?>

                                                    <?php if($d->detail_bbk != null):foreach($db as $dd): ?>

                                                     / <?php echo @$dd->barang->kode ?>

                                                    <?php endforeach;endif; ?>

                                                </td>

                                                <td>

                                                    <?php if(@$d->detail_bbk->detail_bbm->detail_pemesanan->nama_barang != null){ echo @$d->barang->nama; }else if(@$d->detail_bbk == null){ echo @$d->barang->nama;} else { echo @$d->barang->nama; }?> 

                                                    <?php if($d->detail_bbk != null):foreach($db as $dd): ?>

                                                     / <?php echo @$dd->barang->nama ?>

                                                    <?php endforeach;endif; ?>

                                                </td>

                                                

                                                <td><?php echo @$d->barang->unit->kode ?></td>

                                               

                                                

                                                <td>
                                                    
                                                    <?php echo @$d->jumlah-@$d->jumlah_retur ?> @if(@$d->jumlah_retur > 0) (Jumlah Diretur {{ @$d->jumlah_retur }}) @endif <?php echo @$d->detail_bbk->detail_bbm->detail_pemesanan->detail_permintaan->satuan->nama ?><?php echo @$d->camp_lama->satuan->nama ?>

                                                    

                                                </td>

                                                <td>

                                                    Rp.<?php
															if(number_format(@$d->detail_bbk->harga) != 0){
															echo number_format(@$d->detail_bbk->harga);
																}else{
																echo number_format(@$d->detail_bbk->harga + @$d->harga);
															}
														?>

                                                    

                                                </td>

                                                

                                               

                                                <td>

                                                    <?php echo @$d->detail_bbk->detail_bbm->detail_pemesanan->keterangan ?>
                                        
                                                    <input  type="text" name="detail_keterangan[]" class="form-control" value="<?php if(isset($d->keterangan)){ echo $d->keterangan; }else if(!isset($d->keterangan)){echo @$d->detail_bbk->detail_bbm->detail_pemesanan->keterangan;}else if(!isset($d->detail_bbk->detail_bb)){$d->keterangan;} ?>"></td>

                                                <td>

                                                    @if(@$d->jumlah-@$d->jumlah_retur != 0)

                                                    <button type="button" class="btn btn-danger " id="id_<?=$no?>" data-toggle="modal" data-target="#myModal<?=@$d->id?>"><i class="glyphicon glyphicon-remove"></i> Retur</button>

                                                    @else

                                                    Barang Diretur Semua

                                                    @endif

                                                </td>

                                            </tr>

                                            <?php $no++ ?>

                                            @endif

                                        <?php endforeach ?>

                                    </tbody>

                                </table>

                                <button name="submit" class="btn btn-primary">Ubah</button>

                            </form>

                            </div>

  

                        



                            





                </div>

            </div>

        </div>

    </div>

</div>

<script type="text/javascript">

    function get_barang_camp(id){

        $('#loading-list-menu').show();

        $.ajax({

            url: '<?php echo url('ajax/get_barang_camp/') ?>/'+id,

            type: 'GET',

            success: function(data) {

                if(data == null || data == '' || data == '<option></option>'){

                    alert('barang dengan unit/merek ini tidak di temukan di camp');

                }

                $('#barang_id').html(data);

                

                $('#loading-list-menu').hide();

            }

           

        }).fail(function() {

            $("#list-barang").html('');

        }).always(function() {

            $('#loading-list-menu').hide();

        });

        

        

    }

</script>



            <?php foreach ($r->detail_semua as $detail_barang): ?>

                <div id="myModal<?=@$detail_barang->id?>" class="modal fade" role="dialog">

                    <div class="modal-dialog">

                        <div class="modal-content">

                            <div class="modal-header">

                                <button type="button" class="close" data-dismiss="modal">&times;</button>

                                <h4 class="modal-title">Retur Barang</h4>

                            </div>

                            <div class="modal-body" style="padding:0;">

                                

                                    

                                    <form class="form-horizontal" action="<?php echo url('retur_item') ?>" method="POST">

                                        {{ csrf_field() }}

                                       

                                            <input type="hidden" name="detail_pemakaian_id" value="{{ @$detail_barang->id }}">

                                            



                                                



                                                <div id="nomor_baru{{ @$detail_barang->id }}">

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





                                                <div id="divnya{{ @$detail_barang->id }}" style="display: none;" >

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

                                                        <input class="pilih" type="checkbox" id_baru="nomor_baru{{ @$detail_barang->id }}" id_ada="divnya{{ @$detail_barang->id }}" name="lama" value="lama"> Pilih Retur Yang Sudah Ada

                                                    </div>

                                                </div>

                                                <div class="form-group">

                                                    <label for="nama" class="col-lg-4 control-label" >Barang</label>

                                                    <div class="col-lg-6" >



                                                        <input class="form-control" type="text"  readonly value="{{ @$detail_barang->detail_bbk->nama_barang }}{{ @$detail_barang->camp_lama->nama_barang }}">

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



                                                        <input class="form-control" type="number" name="jumlah" placeholder="Jumlah" min="1" max="<?php echo @$detail_barang->jumlah-@$detail_barang->jumlah_retur ?>" >

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



