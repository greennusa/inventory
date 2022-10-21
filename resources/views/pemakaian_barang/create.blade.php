@extends('layouts.app')



@section('content')

<div class="container">

    <div class="row">

        <div class="col-md-12">

            <div class="panel panel-default">

                <div class="panel-heading">Tambah Pemakaian Barang</div>



                <div class="panel-body">

                    <div class="col-md-6">

                        <form class="form-horizontal" action="<?php echo url('item_use') ?>" method="POST">

                            

                            <input type="hidden" name="pemesanan_baru" id="pemesanan_baru" value="tidak">

                            

                            



                                <div class="form-group">



                                    <label for="nama" class="col-lg-4 control-label" >Tanggal Pemakaian</label>



                                    <div class="col-lg-8">



                                        <input type="date" class="form-control datepickers" id="tanggal" name="tanggal" placeholder="Tanggal Pemakaian" required value="{{ old('tanggal') }}">



                                    </div>



                                </div>



                                <div class="form-group">



                                    <label for="nama" class="col-lg-4 control-label" >Keterangan Pemakaian</label>



                                    <div class="col-lg-8">



                                        <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Keterangan Pemakaian" value="{{ old('keterangan') }}">



                                    </div>



                                </div>



                                <div class="form-group">

                                    <label for="diketahui_id" class="col-lg-4 control-label">Diketahui</label>

                                    <div class="col-lg-8">

                                        <select class="form-control selectpicker" name="diketahui_id" id="diketahui_id" data-live-search="true">

                                            <option></option>

                                            <?php foreach ($user as $u): ?>

                                                <option value="<?php echo $u->id ?>" ><?php echo $u->nama ?></option>

                                            <?php endforeach ?>             

                                        </select>

                                    </div>

                                </div>



                                <div class="form-group">

                                    <label for="diterima_id" class="col-lg-4 control-label">Diterima</label>

                                    <div class="col-lg-8">

                                        <input type="text" name="diterima" class="form-control" value="{{ old('diterima') }}">

                                    </div>

                                </div>



                                <div class="form-group">

                                    <label for="dibuat_id" class="col-lg-4 control-label">Dibuat</label>

                                    <div class="col-lg-8">

                                        <select  class="form-control selectpicker" name="dibuat_id" id="dibuat_id" data-live-search="true">

                                            <option></option>

                                            <?php foreach ($user as $u): ?>

                                                <option value="<?php echo $u->id ?>" ><?php echo $u->nama ?></option>

                                            <?php endforeach ?>             

                                        </select>

                                    </div>

                                </div>



                                <div class="form-group">

                                    <label for="penggunaan" class="col-lg-4 control-label">Untuk Penggunaan</label>

                                    <div class="col-lg-8">

                                        <select class="form-control selectpicker" name="penggunaan" id="penggunaan" data-live-search="true">

                                            <option></option>

                                            <?php foreach ($penggunaan as $p): ?>

                                                <option value="<?php echo $p ?>" ><?php echo $p ?></option>

                                            <?php endforeach ?>             

                                        </select>

                                    </div>

                                </div>



                                <div class="form-group">



                                    <label for="nama" class="col-lg-4 control-label" >Lokasi Pemakaian</label>



                                    <div class="col-lg-8">



                                        <input type="text" class="form-control" id="lokasi" name="lokasi" placeholder="Lokasi Pemakaian" required value="{{ old('lokasi') }}">



                                    </div>



                                </div>



                                <div class="form-group">



                                    <label for="unit_id" class="col-lg-4 control-label">Untuk Unit</label>



                                    <div class="col-lg-8">



                                        <select  class="form-control selectpicker" name="unit_id" id="unit_id" data-live-search="true" required>

                                            <option></option>

                                            <?php foreach ($unit as $u): ?>



                                            <option value="<?php echo $u->id ?>">{{ $u->kode }}</option>

                                        <?php endforeach ?>

                                        </select>



                                    </div>



                                </div>



                                <div class="form-group">

                                    <label for="piutang" class="col-lg-4 control-label">Piutang</label>

                                    <div class="col-lg-8">

                                        <select class="form-control selectpicker" name="piutang">

                                            <option value="0" selected>Tidak</option>

                                            <option value="1">Ya</option>

                                        </select>

                                    </div>

                                </div>





                                <div class="form-group" id="myform" action="{{ url('ajax/get_barang_camp/') }}">

                                    {{ csrf_field() }}

                                    <label for="unit_barang" class="col-lg-4 control-label">Unit Barang</label>



                                    <div class="col-lg-8">



                                        <select  class="form-control selectpicker" multiple id="unit_barang" data-live-search="true" required>

                                            <option></option>

                                            <?php foreach ($unit as $u): ?>



                                            <option value="<?php echo $u->id ?>">{{ $u->kode }}</option>

                                        <?php endforeach ?>

                                        </select>



                                    </div>
                                    <label for="unit_barang" class="col-lg-4 control-label">Nama Barang</label>
                                    <div class="col-lg-8">

                                         <input type="text" class="form-control" name="barang_nama" id="barang_nama">
                                    </div>


                                </div>



                              



                                <div class="form-group">



                                    <div class="col-lg-8 col-lg-offset-4">

                                        <input type=button value="Batal" class="btn btn-default" onclick="$('#barang_id').html('')">

                                        <button type="button" class="btn btn-primary" id="tampilkan">Tampilkan Barang</button>



                                    </div>



                                </div>



                                



                                <div class="form-group">

                                    <label for="barang_id" class="col-lg-4 control-label">Barang Di Camp</label>

                                    <div class="col-lg-8" id="barang_id">

                                        

                                    </div>

                                </div>



                                

                                

                            <div class="form-group">



                                <div class="col-lg-8 col-lg-offset-4">



                                    <input type=button value=Batal class="btn btn-default" onclick=self.history.back()>



                                    <button  type="submit" class="btn btn-primary">Simpan</button>



                                </div>



                            </div>

                                

                        </form>

                    </div>

                    <div class="col-md-6">

                        <form class="form-horizontal" id="scan" method="post" action="{{ url('warehouse_udit/check_serial') }}">

                        {{ csrf_field() }}

                            <br>

                            <br>

                            <br>

                            <br>

                            <br>

                            <br>

                            <br>

                            <br>

                            <br>

                            <br>

                            <br>

                            <br>

                            <br>

                            <br>

                            <br>

                            <br>

                            <br>

                            <br>

                            <br>

                            <br>

                            <br>

                            <div class="form-group">

                                    

                                    <div class="col-lg-8">

                                        <input type="text"  class="form-control" name="sn" id="sn" placeholder="Serial Number Barang" required>

                                    </div>



                                    <div class="col-lg-3">

                                        <button type="button" class="btn btn-primary" data-toggle="modal" id="qrcode_btn" data-target="#qrmodal">QrCode</button>

                                    </div>

                                </div>

                        </form>

                    </div>

                        





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

                })

                .done(function() {

                    console.log("success");

                })

                .fail(function() {

                    console.log("error");

                })

                .always(function() {

                    console.log("complete");

                });

            }

        },3000);

        //check sesi app







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

                })

                .done(function() {

                    console.log("success");

                })

                .fail(function() {

                    console.log("error");

                })

                .always(function() {

                    console.log("complete");

                });

            }

                

        },2000);



         $.ajaxSetup({

            headers: {

                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

            }

        });

        $('#scan').on('submit', function(e) {

            $('#loading-list-menu').show();

            e.preventDefault();

            $.ajax({

                url : $(this).attr('action') || window.location.pathname,

                type: "POST",

                cache:false,

            async: true,

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



        $('#tampilkan').on('click', function(e) {

            $('#loading-list-menu').show();

            

            // e.preventDefault();

            $.ajax({

                url : $("#myform").attr('action') || window.location.pathname,

                type: "POST",

                cache:false,

            async: true,

                data: {unit:$("#unit_barang").val() , barang_nama:$("#barang_nama").val()},

                success: function (data) {

                    $("#sn").val('');

                    $('#barang_id').html(data);

                },

                error: function (jXHR, textStatus, errorThrown) {

                    alert(errorThrown);

                }

            }).always(function() {

                $('#loading-list-menu').hide();

            });

        });



       

    });



    function get_barang_camp(id){

        $('#loading-list-menu').show();

        $.ajax({

            url: '<?php echo url('ajax/get_barang_camp/') ?>/'+id,

            type: 'GET',

            cache:false,

            async: true,

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

@endsection



