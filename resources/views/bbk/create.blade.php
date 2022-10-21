@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Tambah BBK<br><br> <a class="btn btn-default" href="{{ url('/item_out') }}">Kembali</a></div>

                <div class="panel-body">
                    <form class="form-horizontal" id="myform" method="post" action="{{ url('item_in/get_bbm') }}">
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

                    <form class="form-horizontal" id="scan" method="post" action="{{ url('item_in/check_serial') }}" >
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

                   <form class="form-horizontal" method="POST" action="{{ url('item_out') }}">
                        <div class="form-group" >
                            <div class="col-lg-10 col-lg-offset-2" id="list_barang">

                            </div>
                        </div>
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="nomor" class="col-lg-2 control-label">Nomor BBK</label>
                            <div class="col-lg-3">
                                <input type="text"  class="form-control" name="nomor" id="nomor" placeholder="Nomor BBK" required>
                            </div>
                        </div>
                        
                    <!-- 
                        <div class="form-group">
                            <label for="tanggal" class="col-lg-2 control-label">Tanggal</label>
                            <div class="col-lg-3">
                                <input type="date" class="form-control datepickers" name="tanggal" id="tanggal" placeholder="Tanggal" required >
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="keterangan" class="col-lg-2 control-label">Keterangan</label>
                            <div class="col-lg-3">
                                <input type="text"  class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan" >
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="dikirim" class="col-lg-2 control-label">Dikirim Melalui</label>
                            <div class="col-lg-3">
                                <input type="text"  class="form-control" name="dikirim" id="dikirim" placeholder="Dikirim Melalui" >
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="kepada" class="col-lg-2 control-label">Kepada</label>
                            <div class="col-lg-3">
                                <input type="text"  class="form-control" name="kepada" id="kepada" placeholder="Kepada" >
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="mengetahui" class="col-lg-2 control-label">Diketahui oleh</label>
                            <div class="col-lg-3">
                                <select class="form-control selectpicker" name="mengetahui" id="mengetahui" data-live-search="true" required>
                                    <option></option>
                                    <?php foreach ($user as $u): ?>
                                        <option value="<?php echo $u->id ?>" ><?php echo $u->nama ?></option>
                                    <?php endforeach ?>             
                                </select>
                                <span style="color:red; font-size:13px" class="help-block">Wajib diisi</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="pengantar" class="col-lg-2 control-label">Pengantar oleh</label>
                            <div class="col-lg-3">
                                <input type="text"  class="form-control" name="pengantar" id="pengantar" placeholder="Pengantar" required>
                                <span style="color:red; font-size:13px" class="help-block">Wajib diisi</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="penerima" class="col-lg-2 control-label">Penerima oleh</label>
                            <div class="col-lg-3">
                                <select class="form-control selectpicker" name="penerima" id="penerima" data-live-search="true" required>
                                    <option></option>
                                    <?php foreach ($user as $u): ?>
                                        <option value="<?php echo $u->id ?>" ><?php echo $u->nama ?></option>
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
                                        <option value="<?php echo $u->id ?>" ><?php echo $u->nama ?></option>
                                    <?php endforeach ?>
                                </select>
                                <span style="color:red; font-size:13px" class="help-block">Wajib diisi</span>
                            </div>
                        </div>-->

                        <div class="form-group">

                            <div class="col-lg-10 col-lg-offset-2">

                                <a  class="btn btn-default" href="{{ url('item_out') }}">Batal</a>

                                <button type="submit" class="btn btn-primary">Simpan</button>

                            </div>

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

 <style type="text/css">
     img {
        width: 200px;
     }
 </style>
<div id="qrmodal" class="modal fade" role="dialog" style="width: 50%;margin: auto;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">QrCode</h4>
            </div>
            <div class="modal-body" >
                <center>
                    <?php 
                
                        echo '<img  style="width=300px;"  src="data:image/png;base64,' . DNS2D::getBarcodePNG(url('qrcode/scan/'.$kode), "QRCODE") . '" alt="barcode"   />';
                     ?>
                     <br>
                    {{ $kode }}
                </center>
                
                <br>
                <br>
                buka aplikasi <strong>UditScanner</strong> dan scan qrcode diatas untuk menghubungkan aplikasi <strong>UditScanner</strong> Android dengan aplikasi web
                <br>
                <a href="https://drive.google.com/open?id=1Hv2x7iGkBpggk0e82kti_9XyrVbou4Ck" style="color: red;text-decoration: none;">Download Aplikasinya Disini</a>
                
            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-default close" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

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
                    cache:false,
            async: true,
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
                cache:false,
            async: true,
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
                cache:false,
            async: true,
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
