@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Edit BBK<br><br> <a class="btn btn-default" href="{{ url('/item_out') }}">Kembali</a></div>

                <div class="panel-body">
                    

                    
                    <form class="form-horizontal" method="POST" action="{{ url('item_out/'.$r->id) }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="page" value="{{ @$_GET['page'] }}">
                        <div class="form-group">
                            <label for="nomor" class="col-lg-2 control-label">Nomor BBK</label>
                            <div class="col-lg-3">
                                <input type="text"  class="form-control" name="nomor" id="nomor" placeholder="Nomor BBK" value="{{ $r->nomor }}" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tanggal" class="col-lg-2 control-label">Tanggal</label>
                            <div class="col-lg-3">
                                <input type="date" class="form-control datepickers" value="{{ $r->tanggal }}" name="tanggal" id="tanggal" placeholder="Tanggal" required >
                            </div>
                        </div>
                       
                        <div class="form-group">
                            <label for="keterangan" class="col-lg-2 control-label">Keterangan</label>
                            <div class="col-lg-3">
                                <input type="text"  class="form-control" name="keterangan" value="{{ $r->keterangan }}" id="keterangan" placeholder="Keterangan" >
                            </div>
                        </div>
                            
                       

                        <div class="form-group">
                            <label for="dikirim" class="col-lg-2 control-label">Dikirim Melalui</label>
                            <div class="col-lg-3">
                                <input type="text"  class="form-control" name="dikirim" id="dikirim" placeholder="Dikirim Melalui" value="{{ $r->dikirim }}">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="kepada" class="col-lg-2 control-label">Kepada</label>
                            <div class="col-lg-3">
                                <input type="text"  class="form-control" name="kepada" id="kepada" placeholder="Kepada" value="{{ $r->kepada }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="mengetahui" class="col-lg-2 control-label">Diketahui oleh</label>
                            <div class="col-lg-3">
                                <select class="form-control selectpicker" name="mengetahui" id="mengetahui" data-live-search="true" required>
                                    <option></option>
                                    <?php foreach ($user as $u): ?>
                                        <option @if($u->id == $r->mengetahui) selected @endif value="<?php echo $u->id ?>" ><?php echo $u->nama ?></option>
                                    <?php endforeach ?>             
                                </select>
                                <span style="color:red; font-size:13px" class="help-block">Wajib diisi</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="pengantar" class="col-lg-2 control-label">Pengantar oleh</label>
                            <div class="col-lg-3">
                                <input type="text"  class="form-control" name="pengantar" id="pengantar" placeholder="Pengantar" value="{{ $r->pengantar }}" required>
                                <span style="color:red; font-size:13px" class="help-block">Wajib diisi</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="penerima" class="col-lg-2 control-label">Penerima oleh</label>
                            <div class="col-lg-3">
                                <select class="form-control selectpicker" name="penerima" id="penerima" data-live-search="true" required>
                                    <option></option>
                                    <?php foreach ($user as $u): ?>
                                        <option @if($u->id == $r->penerima) selected @endif value="<?php echo $u->id ?>" ><?php echo $u->nama ?></option>
                                    <?php endforeach ?>
                                </select>
                                <span style="color:red; font-size:13px" class="help-block">Wajib diisi</span>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="pengirim" class="col-lg-2 control-label">Pengirim oleh</label>
                            <div class="col-lg-3">
                                <select class="form-control selectpicker" name="pengirim" id="pengirim" data-live-search="true" required>
                                    <option></option>
                                    <?php foreach ($user as $u): ?>
                                        <option @if($u->id == $r->pengirim) selected @endif value="<?php echo $u->id ?>" ><?php echo $u->nama ?></option>
                                    <?php endforeach ?>
                                </select>
                                <span style="color:red; font-size:13px" class="help-block">Wajib diisi</span>
                            </div>
                        </div>

                        <div class="form-group">

                            <div class="col-lg-10 col-lg-offset-2">

                                <a href="{{ url('item_out?page='.@$_GET['page']) }}" class="btn btn-default">Batal</a>

                                <button type="submit" class="btn btn-primary">Simpan</button>

                            </div>

                        </div>
                        

                    </form>

                    @if($r->status == 0)
                        <form style="border: red 1px solid;border-radius: 10px;padding: 10px;margin: 10px;" class="form-horizontal" action="{{ url('item_out/cancel/'.$r->id) }}" method="post">
                            {{ csrf_field() }}
                            <div class="form-group" >
                                <div class="col-lg-10 col-lg-offset-2" id="list_barang">

                                </div>
                            </div>

                            <div class="form-group">

                                <div class="col-lg-10 ">

                                 
                                    <a href="{{ url('item_out?page='.@$_GET['page']) }}" class="btn btn-default">Kembali</a>
                                    <button type="submit" class="btn btn-danger">Batalkan Pengiriman</button>
                                    

                                </div>

                            </div>
                        </form>
                    @endif

                    @if($r->status == 2)
                    <hr>
                    <form class="form-horizontal" id="myform" method="post" action="{{ url('item_in/get_bbm') }}" style="border: red 1px solid;border-radius: 10px;padding: 10px;margin: 10px;">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="bbm_id" class="col-lg-2 control-label">Bukti Barang Masuk</label>
                            <div class="col-lg-3">
                                <select class="form-control selectpicker" multiple name="bukti_barang_masuk_id[]" id="bukti_barang_masuk_id" data-live-search="true" required>
                                    <option></option>
                                    <?php foreach ($bbm as $p): ?>
                                        <option @if($p->kelengkapan != 0) class="bg-danger" @endif value="<?php echo $p->id ?>" >PO : <?php echo $p->pemesanan->nomor ?> Supplier : <?php echo $p->pemesanan->pemasok->nama ?> @if($p->kelengkapan != 0) (Belum Lengkap) @endif</option>
                                    <?php endforeach ?> 
                                </select>
                            </div>
                        </div>
                        <div class="form-group">

                            <div class="col-lg-10 col-lg-offset-2">
                                <input type=button value="Batal" class="btn btn-default" onclick="$('#list_barang').html('');//$('#scan').hide();">
                                <button type="submit" class="btn btn-primary">Tampilkan Barang</button>

                            </div>

                        </div>
                    </form>
                    <form style="border: red 1px solid;border-radius: 10px;padding: 10px;margin: 10px;" class="form-horizontal" id="scan" method="post" action="{{ url('item_in/check_serial') }}" >
                        {{ csrf_field() }}
                        
                        <div class="form-group">
                            <label for="sn" class="col-lg-2 control-label">Serial Number Barang</label>
                            <div class="col-lg-3">
                                <input type="text"  class="form-control" name="sn" id="sn" placeholder="Serial Number Barang" required>
                            </div>

                            <div class="col-lg-3">
                                <button type="button" class="btn btn-primary" data-toggle="modal" id="qrcode_btn" data-target="#qrmodal">QrCode</button>
                            </div>
                        </div>
                    </form>
                    <form style="border: red 1px solid;border-radius: 10px;padding: 10px;margin: 10px;" class="form-horizontal" action="{{ url('item_out/new_item/'.$r->id) }}" method="post">
                        {{ csrf_field() }}
                        <div class="form-group" >
                            <div class="col-lg-10 col-lg-offset-2" id="list_barang">

                            </div>
                        </div>

                        <div class="form-group">

                            <div class="col-lg-10 ">

                             

                                <button type="submit" class="btn btn-warning">Simpan Barang</button>

                            </div>

                        </div>
                    </form>
                    <br>
                    <br>
                    <form style="border: green 1px solid;border-radius: 10px;padding: 10px;margin: 10px;" class="form-horizontal" action="{{ url('item_out/send/'.$r->id) }}" method="post">
                        {{ csrf_field() }}
                        <div class="form-group" >
                            <div class="col-lg-10 col-lg-offset-2" id="list_barang">

                            </div>
                        </div>

                        <div class="form-group">

                            <div class="col-lg-10 ">

                             
                              
                                <button type="submit" class="btn btn-success">Kirim</button>
                                <i>NB. : Klik Kirim, jika ada pengiriman barang!</i>

                            </div>

                        </div>
                    </form>
                    <br>
                    <br>
                    @endif

                    <form>
                        
                        <div id="list-barang">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>NO PO</th>
                                        <th>NO OPB</th>
                                    
                                        <th>Kode Barang</th>
                                        <th>Nama Barang</th>
                                        
                                        <th>Kode Unit</th>
                                        <th>Supplier</th>
                                        <th>Halaman</th>
                                        <th>Indeks</th>
                                        <th>Keterangan</th>
                                        <th>Jumlah</th>
                                        <th>Satuan</th>
                                        <th>Harga</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no=1;
                                    $jml_total = 0;
                                      $total = 0;
                                      $jumlahItem = 0;
                                      $jumlahPengeluaran = 0; 
                                      use App\DetailPemesananBarang;
                                      $po = '';

                                      ?>
                                    <?php foreach ($r->detail as $d):  ?>
                                        @if($d->gabungan == '' || $d->gabungan == null)
                                        <?php 
                                        //$db = DetailPemesananBarang::where('gabungan','like','%'.$d->gabungan_id.'%')->get();?>
                                        @if($po != $d->detail_bbm->bbm->pemesanan->nomor)
                                        <tr>
                                            <input type="hidden" name="id[]" value="<?php echo $d->id ?>">
                                            <input type="hidden" name="barang_id[]" value="<?php echo $d->barang_id ?>">
                                            <td><?php //echo $no ?></td>
                                            <td><?php echo $d->detail_bbm->bbm->pemesanan->nomor ?></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                    
                                            
                                       
                                            <td></td>
                                          
                                            <td>
                                               {{ $d->detail_bbm->bbm->pemesanan->pemasok->nama }} 
                                            </td>
                                            <td>
                                                
                                            </td>
                                            
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <?php $po = $d->detail_bbm->bbm->pemesanan->nomor; //$no++ ?>
                                        @endif
                                        <?php 

                                                
                                                    $jumlah_row = $d->jumlah*$d->detail_bbm->detail_pemesanan->harga;
                                                    ?>  
                                                        @if($d->gabungan == '' || $d->gabungan == null)
                                                        <tr>
                                                            
                                                            <td><?php echo $no ?></td>
                                                            <td></td>
                                                            <td>{{ $d->detail_bbm->detail_pemesanan->detail_permintaan->permintaan->nomor }}</td>
                                                            
                                                            <?php $db = \App\DetailPemesananBarang::where('gabungan','like','%'.$d->gabungan_id.'%')->where('pemesanan_barang_id',$d->detail_bbm->detail_pemesanan->pemesanan_barang_id)->get();?>
                                                            <td><?php if($d->detail_bbm->detail_pemesanan->kode_barang != null || $d->detail_bbm->detail_pemesanan->kode_barang != ''){ echo $d->detail_bbm->detail_pemesanan->kode_barang; }else { echo $d->barang->kode; }?>@foreach($db as $aa)
                                                                 / <?php echo $aa->barang->kode ?>
                                                                @endforeach</td>
                                                            <td><?php if($d->detail_bbm->detail_pemesanan->nama_barang != null || $d->detail_bbm->detail_pemesanan->nama_barang != ''){ echo $d->detail_bbm->detail_pemesanan->nama_barang; }else { echo $d->barang->nama; }?>@foreach($db as $aa)
                                                                 / <?php echo $aa->barang->nama ?>
                                                                @endforeach</td>
                                                            
                                                            <td><?php echo $d->barang->unit->kode ?></td>
                                                            <td></td>
                                                            <td><?php echo $d->barang->halaman ?></td>
                                                            <td><?php echo $d->barang->indeks ?></td>

                                                            <td><?php echo $d->detail_bbm->keterangan ?></td>
                                                            <td>
                                                                <?php echo $d->jumlah ?>
                                                            </td>
                                                            
                                                            <td><?php echo $d->detail_bbm->detail_pemesanan->detail_permintaan->satuan->nama ?></td>
                                                            <td>
                                                                Rp.<?php echo number_format($d->detail_bbm->detail_pemesanan->harga) ?>
                                                            </td>
                                                            <td>Rp.{{ number_format($jumlah_row) }}</td>
                                                        </tr>
                                                        <?php $no++ ?>
                                                    <?php $jumlahItem += $d->jumlah; ?>
                                                    <?php $jumlahPengeluaran += ($d->jumlah * $d->harga); ?>
                                                    @endif
                                                    <?php

                                                
                                                
                                           
                                                        
                                            
                                         ?>

                                        @endif
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="12" align="right"><b>Total : </b></td>
                                    <td><b><center><?php echo $jumlahItem ?></center></b></td>
                                    <td colspan="6"><b>Rp. <?=number_format($jumlahPengeluaran)?></b></td>
                                </tr>
                            </tfoot>
                            </table>
                        </div>
                    </form>
                        
                    

                </div>
            </div>
        </div>
    </div>
</div>

<?php 
    $kode = '';
    $char = array_merge(range('0', '9'),range('A', 'Z'));
    $max = count($char)-1;
    for ($i=0; $i < 10; $i++) { 
        $r = mt_rand(0,$max);
        $kode .= $char[$r];
    }
 ?>

<script type="text/javascript">
    $(document).ready(function () {
        var terhubung = false;
        var scan = false;
        var sesi_kode = '';

        $(document).on('click', '#qrcode_btn', function(event) {
            scan = true;
        });
        
        //check sesi app
        setInterval(function cek_sesi() {
            if(scan){
                $.ajax({
                    url: '<?php echo url('qrcode/cek/'.$kode) ?>',
                    type: 'GET',
                    cache:false,
            async: true,
                    success: function (data) {
                        if(data){
                            alert('terhubung');
                            $(".close").click();
                            scan = false;
                            sesi_kode = data;
                            terhubung = true;
                        }
                    }
                });
            }
        },3000);
        



        //cek detail app
        setInterval(function cek_detail() {
            if(terhubung){
                $.ajax({
                    url: '<?php echo url('qrcode/cek_detail/'.$kode) ?>',
                    type: 'GET',
                    success: function (data) {
                        
                        var pilih = $("#pilih-"+data);
                        if(pilih){
                            pilih.attr('checked', 'checked');
                        }
                        
                    }
                });
            }
                
        },2000);
        





        $('#myform').on('submit', function(e) {
            $('#loading-list-menu').show();
            e.preventDefault();
            $.ajax({
                url : $(this).attr('action') || window.location.pathname,
                type: "POST",
                data: $(this).serialize(),
                success: function (data) {
                    $("#list_barang").html(data);
                    //$("#scan").show();
                },
                error: function (jXHR, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            }).always(function() {
                $('#loading-list-menu').hide();
            });
        });

        $('#scan').on('submit', function(e) {
            $('#loading-list-menu').show();
            e.preventDefault();
            $.ajax({
                url : $(this).attr('action') || window.location.pathname,
                type: "POST",
                data: $(this).serialize(),
                success: function (data) {
                    $("#sn").val('');
                    var pilih = $("#pilih-"+data);
                    if(pilih){
                        pilih.attr('checked', 'checked');
                    }
                    if(data == null || data == ""){
                        alert('barang tidak ditemukan');
                    }
                },
                error: function (jXHR, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            }).always(function() {
                $('#loading-list-menu').hide();
            });
        });
    });
</script>

@endsection
