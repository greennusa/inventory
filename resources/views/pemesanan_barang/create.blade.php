@extends('layouts.app')



@section('content')

<div class="container">

    <div class="row">

        <div class="col-md-12">

            <div class="panel panel-default">

                <div class="panel-heading">Tambah Pemesanan Barang</div>



                <div class="panel-body">

                    <form class="form-horizontal" action="<?php echo url('order') ?>" method="POST">

                        {{ csrf_field() }}

                        <input type="hidden" name="pemesanan_baru" id="pemesanan_baru" value="tidak">

                        



                            <div class="form-group">

                                <label for="permintaan_id" class="col-lg-2 control-label">Permintaan Barang</label>

                                <div class="col-lg-3">

                                    <select onchange="get_supplier(this.value)" class="form-control selectpicker" name="permintaan_id" id="permintaan_id" data-live-search="true">

                                        <option></option>

                                        <?php foreach ($permintaan as $p): ?>

                                            <option value="<?php echo $p->id ?>" ><?php echo $p->nomor ?> - <?php echo $p->tanggal ?></option>

                                        <?php endforeach ?>             

                                    </select>

                                </div>

                                <a href="{{ url('purchase_request/create') }}" target="_blank" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> Permintaan Baru</a>

                                <!-- <button type="button" data-toggle="modal" data-target="#new-item" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> Permintaan Baru</button> -->

                            </div>

                            

                            <div class="form-group">

                                <label for="supplier_id" class="col-lg-2 control-label">Supplier Barang</label>

                                <div class="col-lg-3">

                                    <select  class="form-control" onchange="cek_pemesanan(this.value)" name="pemasok_id" id="supplier_id" data-live-search="true" required>

                                        <option value="-1"></option>

                                                  

                                    </select>

                                </div>

                            </div>



                            <div class="form-group">



                                <label for="nama" class="col-lg-2 control-label" >Buat Pemesanan Baru</label>



                                <div class="col-lg-3">



                                    <input type="checkbox" checked="true" name="data_baru" id="data_baru" value="baru">

                                    <span style="color:red; font-size:13px" class="help-block">Jika Ingin Membuat Pemesanan baru centang ini / biarkan saja bila ingin memasukan data ke pemesanan yang sudah ada</span>

                                </div>



                            </div>



                            <div class="form-group">



                                <label for="nama" class="col-lg-2 control-label" >Pilih Pemesanan Lama</label>



                                <div class="col-lg-3">



                                    <input type="checkbox"  name="data_lama" id="data_lama" value="baru">

                                    <span style="color:red; font-size:13px" class="help-block">Jika Ingin Memasukan Data Ini Ke Pemesanan Yang Lain Dengan Supplier Yang Sama Silakan Centang Ini</span>

                                </div>



                                <div class="col-lg-3" id="list_pemesanan_lama">

                                    <select style="border: 1px blue solid;" class="form-control" onchange="get_pemesanan(this.value)" name="pemesanan_lama" id="pemesanan_lama" data-live-search="true">

                                    <option></option>

                                    </select>

                                </div>



                            </div>

                            

                             <div class="form-group">



                                <label for="keperluan" class="col-lg-2 control-label" >Keperluan</label>



                                <div class="col-lg-3">



                                    <input type="text"  class="form-control" name="keperluan"  id="keperluan"  placeholder="Keperluan" >



                                </div>



                            </div>



                            <div class="form-group">



                                <label for="nama" class="col-lg-2 control-label" >Nomor Pemesanan</label>



                                <div class="col-lg-3">



                                    <input type="text"  class="form-control" name="nomor"  id="nomor"  placeholder="Nomor Pemesanan" required>



                                </div>



                            </div>





                            

                            



                            <div class="form-group">



                                <label for="nama" class="col-lg-2 control-label" >Tanggal Pemesanan</label>



                                <div class="col-lg-3">



                                    <input type="date" class="form-control datepickers" id="tanggal" name="tanggal" placeholder="Tanggal Pemesanan" required >



                                </div>



                            </div>



                            <div class="form-group">



                                <label for="nama" class="col-lg-2 control-label" >Dikirim Ke : </label>



                                <div class="col-lg-3">



                                    <input type="text" class="form-control"  name="dikirim" id="dikirim" placeholder="Dikirim Ke" required >



                                </div>



                            </div>



                            

                        <div class="form-group">

                            <label for="tanggal" class="col-lg-2 control-label">Keterangan</label>

                            <div class="col-lg-3">

                                <textarea class="form-control" name="keterangan" id="keterangan" placeholder="keterangan" maxlength="255" ></textarea>

                            </div>

                        </div>







                        <div class="form-group">

                            <label for="menyetujui" class="col-lg-2 control-label">Disetujui oleh</label>

                            <div class="col-lg-3">

                                <select class="form-control" name="menyetujui" id="menyetujui" data-live-search="true" required>

                                    <option></option>

                                    <?php foreach ($user as $u): ?>

                                        <option value="<?php echo $u->id ?>" ><?php echo $u->nama ?></option>

                                    <?php endforeach ?>             

                                </select>

                                <span style="color:red; font-size:13px" class="help-block">Wajib diisi</span>

                            </div>

                        </div>

                        <div class="form-group">

                            <label for="mengetahui" class="col-lg-2 control-label">Mengetahui oleh</label>

                            <div class="col-lg-3">

                                <select class="form-control" name="mengetahui" id="mengetahui" data-live-search="true" required>

                                    <option></option>

                                    <?php foreach ($user as $u): ?>

                                        <option value="<?php echo $u->id ?>" ><?php echo $u->nama ?></option>

                                    <?php endforeach ?>             

                                </select>

                                <span style="color:red; font-size:13px" class="help-block">Wajib diisi</span>

                            </div>

                        </div>





                        <div class="form-group">

                            <label for="memesan" class="col-lg-2 control-label">Yang Memesan</label>

                            <div class="col-lg-3">

                                <select class="form-control" name="memesan" id="memesan" data-live-search="true" required>

                                    <option></option>

                                    <?php foreach ($user as $u): ?>

                                        <option value="<?php echo $u->id ?>" ><?php echo $u->nama ?></option>

                                    <?php endforeach ?>             

                                </select>

                                <span style="color:red; font-size:13px" class="help-block">Wajib diisi</span>

                            </div>

                        </div>



                        <div class="form-group">



                            <div class="col-lg-10 col-lg-offset-2">



                                <input type=button value=Batal class="btn btn-default" onclick=self.history.back()>



                                <button  type="submit" class="btn btn-primary">Simpan</button>



                            </div>



                        </div>

                        <div id="list-barang">

                            

                        </div>  

                    </form>





                </div>

            </div>

        </div>

    </div>

</div>





<!-- Modal -->

<div id="new-item" class="modal fade" role="dialog">

  <div class="modal-dialog">



    <!-- Modal content-->

    <div class="modal-content">

      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal">&times;</button>

        <h4 class="modal-title">Barang Baru</h4>

      </div>

      <div class="modal-body" style="max-height: 70vh;overflow-y: scroll;">

        <form class="form-horizontal" enctype="multipart/form-data" method="post" accept-charset="utf-8" action="{{ url('order/detail_baru') }}">

            {{ csrf_field() }}

                        <input type="hidden" name="_method" value="PUT">

            <div class="row">

                <div class="col-lg-6">

                    <div class="form-group">

                            <label for="nomor" class="col-lg-4 control-label">Nomor Permintaan</label>

                            <div class="col-lg-6">

                                <input type="text" class="form-control" name="nomor" id="nomor" placeholder="Nomor Permintaan" required >

                            </div>

                        </div>

                        <div class="form-group">

                            <label for="tanggal" class="col-lg-4 control-label">Tanggal</label>

                            <div class="col-lg-6">

                                <input type="date" class="form-control datepickers" name="tanggal" id="tanggal" placeholder="Tanggal" required>

                            </div>

                        </div>

                        

                       

                        <div class="form-group">

                            <label for="sifat" class="col-lg-4 control-label">Sifat</label>

                            <div class="col-lg-6">

                                <select class="form-control selectpicker" name="sifat" id="sifat" data-live-search="true">

                                    

                                    <option value="0" >Biasa</option>

                                    <option value="1" >Urgent</option>          

                                </select>

                            </div>

                        </div>

                        <div class="form-group">

                            <label for="destination" class="col-lg-4 control-label">Pilih Tujuan</label>

                            <div class="col-lg-6">

                                <select class="form-control selectpicker" name="destination" id="destination" data-live-search="true">

                                    <option value="Camp">Camp</option>

                                    <option value="Kantor">Kantor</option>  

                                </select>

                            </div>

                        </div>



                        <div class="form-group">

                            <label for="tanggal" class="col-lg-4 control-label">Keterangan</label>

                            <div class="col-lg-6">

                                <textarea class="form-control" name="keperluan" id="Keperluan" placeholder="Keperluan" maxlength="255" ></textarea>

                            </div>

                        </div>

                        

                </div>



                <div class="col-lg-6">

                    

                        <div class="form-group">

                            <label for="pembuat_id" class="col-lg-4 control-label">Dibuat oleh</label>

                            <div class="col-lg-6">

                                <select class="form-control selectpicker" name="pembuat_id" id="pembuat_id" data-live-search="true" required>

                                    <option></option>

                                    <?php foreach ($user as $u): ?>

                                        <option value="<?php echo $u->id ?>" ><?php echo $u->nama ?></option>

                                    <?php endforeach ?>             

                                </select>

                                <span style="color:red; font-size:13px" class="help-block">Wajib diisi</span>

                            </div>

                        </div>



                        <div class="form-group">

                            <label for="diperiksa_id" class="col-lg-4 control-label">Diperiksa oleh</label>

                            <div class="col-lg-6">

                                <select class="form-control selectpicker" name="diperiksa_id" id="diperiksa_id" data-live-search="true" required>

                                    <option></option>

                                    <?php foreach ($user as $u): ?>

                                        <option value="<?php echo $u->id ?>" ><?php echo $u->nama ?></option>

                                    <?php endforeach ?>             

                                </select>

                                <span style="color:red; font-size:13px" class="help-block">Wajib diisi</span>

                            </div>

                        </div>



                        <div class="form-group">

                            <label for="diketahui_id" class="col-lg-4 control-label">Diketahui oleh</label>

                            <div class="col-lg-6">

                                <select class="form-control selectpicker" name="diketahui_id" id="diketahui_id" data-live-search="true" >

                                    <option></option>

                                    <?php foreach ($user as $u): ?>

                                        <option value="<?php echo $u->id ?>" ><?php echo $u->nama ?></option>

                                    <?php endforeach ?>             

                                </select>

                                

                            </div>

                        </div>

                        

                        <div class="form-group">

                            <label for="disetujui_id" class="col-lg-4 control-label">Disetujui oleh</label>

                            <div class="col-lg-6">

                                <select class="form-control selectpicker" name="disetujui_id" id="disetujui_id" data-live-search="true" >

                                    <option></option>

                                    <?php foreach ($user as $u): ?>

                                        <option value="<?php echo $u->id ?>" ><?php echo $u->nama ?></option>

                                    <?php endforeach ?>

                                </select>

                                

                            </div>

                        </div>

                </div>

                </div>

            <div class="row">

                <hr class="col-md-12 ">

                <h5 class="text-center">Detail Barang</h5>

                <div class="col-md-6">

                     

                    <div class="form-group">



                        <label for="nama" class="col-lg-4 control-label">Nama Barang</label>



                        <div class="col-lg-6">



                            <input type="text"  class="form-control" name="nama" id="nama" placeholder="Nama Barang" required>



                        </div>



                    </div>



                    <div class="form-group">



                        <label for="kode" class="col-lg-4 control-label">No. Part / Kode</label>



                        <div class="col-lg-6">



                            <input type="text"  class="form-control" name="kode" id="kode" placeholder="No. Part / Kode Pabrikan" required>



                        </div>



                    </div>



                    <div class="form-group">



                        <label for="kategori_id" class="col-lg-4 control-label">Kategori</label>



                        <div class="col-lg-6">



                            <select class="form-control selectpicker"  name="kategori_id" id="kategori_id" data-live-search="true">



                                <option></option>   



                                @foreach ($kategori as $k)



                                    <option value="<?php echo $k->id ?>"><?php echo $k->nama ?></option>



                                @endforeach            



                            </select>

                            @if ($errors->has('kategori_id'))

                                <span class="help-block">

                                    <strong>{{ $errors->first('kategori_id') }}</strong>

                                </span>

                            @endif



                        </div>



                    </div>



                    <div class="form-group">



                        <label for="unit_id" class="col-lg-4 control-label">Unit</label>



                        <div class="col-lg-6">



                            <select class="form-control selectpicker"  name="unit_id" id="unit_id" data-live-search="true">



                                    <option></option>



                                    @foreach ($unit as $j)



                                        <option value="<?php echo $j->id ?>"><?php echo $j->kode ?></option>



                                    @endforeach             



                                </select>



                            @if ($errors->has('unit_id'))

                                <span class="help-block">

                                    <strong>{{ $errors->first('unit_id') }}</strong>

                                </span>

                            @endif



                        </div>



                    </div>





                    



                    <div class="form-group">



                        <label for="harga" class="col-lg-4 control-label">Harga Barang</label>



                        <div class="col-lg-6">



                            <input type="text"  class="form-control" name="harga" id="harga" placeholder="Harga Barang" required>



                        </div>



                    </div>





                    <div class="form-group">



                        <label for="jumlah" class="col-lg-4 control-label">Jumlah Barang</label>



                        <div class="col-lg-6">



                            <input type="text"  class="form-control" name="jumlah" id="jumlah" placeholder="Harga Barang" required>



                        </div>



                    </div>



                   



                    <div class="form-group">



                        <div class="col-lg-10 col-lg-offset-2">



                            <input  type=button value=Batal class="btn btn-default" data-dismiss="modal">



                            <button type="submit" class="btn btn-primary">Simpan</button>



                        </div>



                    </div>



                </div>



                <div class="col-md-6">

                    <div class="form-group">



                        <label for="halaman" class="col-lg-4 control-label">Halaman</label>



                        <div class="col-lg-6">



                            <input type="text"  class="form-control" name="halaman" id="halaman" placeholder="Halaman" >



                        </div>



                    </div>



                    <div class="form-group">



                        <label for="indeks" class="col-lg-4 control-label">Indeks</label>



                        <div class="col-lg-6">



                            <input type="text"  class="form-control" name="indeks" id="indeks" placeholder="Indeks" >



                        </div>



                    </div>



                    <div class="form-group">



                        <label for="satuan_id" class="col-lg-4 control-label">Satuan</label>



                        <div class="col-lg-6">



                            <select class="form-control selectpicker"  name="satuan_id" id="satuan_id" data-live-search="true">



                                <option></option>



                                @foreach ($satuan as $s)



                                    <option value="<?php echo $s->id ?>" ><?php echo $s->nama ?></option>



                                @endforeach          



                            </select>

                            @if ($errors->has('satuan_id'))

                                <span class="help-block">

                                    <strong>{{ $errors->first('satuan_id') }}</strong>

                                </span>

                            @endif



                        </div>



                    </div>



                    <div class="form-group">



                        <label for="keterangan" class="col-lg-4 control-label">Keterangan</label>



                        <div class="col-lg-6">



                            <input type="text"  class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan">



                        </div>



                    </div>



                        



                    <div class="form-group">



                        <label for="gambar" class="col-lg-4 control-label">Gambar Barang</label>



                        <div class="col-lg-6">



                            <input type="file" name="userfile" id="userfile" class="form-control">



                        </div>



                    </div>



                    <div class="form-group">



                        <label for="pakai_sn" class="col-lg-4 control-label">Menggunakan Serial Number?</label>



                        <div class="col-lg-6">



                            <select class="form-control" name="pakai_sn" id="pakai_sn">



                                

                                    <option value="1" > Iya</option>   



                                

                                    <option value="0" > Tidak</option>  



                                

                            </select>

                            <span style="color:red; font-size:13px" class="help-block">Disarankan pilih "Tidak" untuk barang yang pada saat di pesan berjumlah banyak</span>

                        </div>



                    </div>   



                    

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



<script type="text/javascript">

    var a = 0;

    var b = 0;

    var data_pem;

    $("#list_pemesanan_lama").hide();



    function get_pemesanan(id){

            $.ajax({

                url: '<?php echo url('ajax/get_pemesanan/') ?>/'+id,

                type: 'GET',

                cache:false,

            async: true,

                success: function(data) {

                    $("#nomor").val(data.nomor);

                    $("#dikirim").val(data.dikirim);

                    $("#nomor").attr('readonly', 'readonly');

                    $("#dikirim").attr('readonly', 'readonly');

                    $("#pemesanan_baru").attr('disabled', 'disabled');

                    

                    $("#pemesanan_baru").val("iya");

                    $('#data_baru').prop('checked', false);

                    $("#tanggal").val(data.tanggal);

                    $("#tanggal").attr('readonly', 'readonly'); 

                    $("#keterangan").val(data.keterangan);

                    $("#keterangan").attr('readonly', 'readonly'); 

                    $("#menyetujui").val(data.menyetujui);

                    $("#menyetujui").attr('readonly', 'readonly');

                    $("#mengetahui").val(data.mengetahui);

                    $("#mengetahui").attr('readonly', 'readonly');

                    $("#memesan").val(data.memesan);

                    $("#memesan").attr('readonly', 'readonly');

                }

            });

    }

    



    $(document).on('click', '#data_baru', function(event) {

        if(a == 0){

            $("#list_pemesanan_lama").hide();

            $("#pemesanan_lama").html('');

            b = 0;

            $('#data_lama').prop('checked', false);

            $("#nomor").val('');

            $("#dikirim").val('');

            $("#keperluan").val('');

            $("#keperluan").removeAttr('readonly');

            $("#dikirim").removeAttr('readonly');

            $("#nomor").removeAttr('readonly');

            $("#pemesanan_baru").val("tidak");

            $('#data_baru').prop('checked', true);

            $("#pemesanan_baru").removeAttr('disabled');

            $("#tanggal").val('');

            $("#tanggal").removeAttr('readonly'); 

            $("#keterangan").val('');

            $("#keterangan").removeAttr('readonly'); 

            $("#menyetujui").val('');

            $("#menyetujui").removeAttr('readonly'); 

            $("#mengetahui").val('');

            $("#mengetahui").removeAttr('readonly');

            $("#memesan").val('');

            $("#memesan").removeAttr('readonly');

            a = 1;

        }

        else { 

            if(data_pem != null){

                $("#nomor").val(data_pem[0].nomor);

                $("#dikirim").val(data_pem[0].dikirim);

                $("#nomor").attr('readonly', 'readonly');

                $("#dikirim").attr('readonly', 'readonly');

                $("#pemesanan_baru").attr('disabled', 'disabled');

                $("#keperluan").val(data_pem[0].keperluan);

                // $("#keperluan").attr('readonly', 'readonly');

                $("#pemesanan_baru").val("iya");

                $('#data_baru').prop('checked', false);

                $("#tanggal").val(data_pem[0].tanggal);

                $("#tanggal").attr('readonly', 'readonly'); 

                $("#keterangan").val(data_pem[0].keterangan);

                $("#keterangan").attr('readonly', 'readonly'); 

                $("#menyetujui").val(data_pem[0].menyetujui);

                $("#menyetujui").attr('readonly', 'readonly');

                $("#mengetahui").val(data_pem[0].mengetahui);

                $("#mengetahui").attr('readonly', 'readonly');

                $("#memesan").val(data_pem[0].memesan);

                $("#memesan").attr('readonly', 'readonly');

            }

                

            a = 0;

        }

    });



    $(document).on('click', '#data_lama', function(event) {

        if(b == 0){

            $("#list_pemesanan_lama").show();

            $('#data_baru').prop('checked', false);

            $.ajax({

                url: '<?php echo url('ajax/get_pemesanan_lama/') ?>/'+$("#supplier_id").val(),

                type: 'GET',

                cache:false,

            async: true,

                success: function(data) {

                    if(data == 'false'){

                        alert('pemesanan dengan supplier yang sama tidak ada');

                    }

                    else {

                        $("#pemesanan_lama").html(data);

                    }

                }

            });

            a = 0;

            b = 1;

        }

        else { 

            $("#list_pemesanan_lama").hide();

            $("#pemesanan_lama").html('');

            if(data_pem != null){

                $("#nomor").val(data_pem[0].nomor);

                $("#dikirim").val(data_pem[0].dikirim);

                $("#nomor").attr('readonly', 'readonly');

                $("#dikirim").attr('readonly', 'readonly');

                $("#pemesanan_baru").attr('disabled', 'disabled');

                $("#keperluan").val(data_pem[0].keperluan);

                // $("#keperluan").attr('readonly', 'readonly');

                $("#pemesanan_baru").val("iya");

                $('#data_baru').prop('checked', false);

                $("#tanggal").val(data_pem[0].tanggal);

                $("#tanggal").attr('readonly', 'readonly'); 

                $("#keterangan").val(data_pem[0].keterangan);

                $("#keterangan").attr('readonly', 'readonly'); 

                $("#menyetujui").val(data_pem[0].menyetujui);

                $("#menyetujui").attr('readonly', 'readonly');

                $("#mengetahui").val(data_pem[0].mengetahui);

                $("#mengetahui").attr('readonly', 'readonly');

                $("#memesan").val(data_pem[0].memesan);

                $("#memesan").attr('readonly', 'readonly');

            }

            b = 0;

        }

    });



    function get_supplier(id){

        $('#loading-list-menu').show();

        $.ajax({

            url: '<?php echo url('ajax/get_supplier/') ?>/'+id,

            type: 'GET',

            cache:false,

            async: true,

            success: function(data) {



                if(data == 'false'){

                    alert("Supplier Tidak Ditemukan");

                    $("#nomor").val('');

                    $("#nomor").removeAttr('readonly');

                    $("#pemesanan_baru").val("tidak");

                    

                    $("#pemesanan_baru").removeAttr('disabled');

                    $("#tanggal").val('');

                    $("#tanggal").removeAttr('readonly'); 

                    $("#supplier_id").html('');

                }

                else {

                    $("#supplier_id").html(data);

                    $('.selectpicker').selectpicker();

                    $('#loading-list-menu').hide();

                }

                $.ajax({

            url: '<?php echo url('ajax/get_permintaan/') ?>/'+id,

            type: 'GET',

            success: function(data) {

               $("#keperluan").val(data.keperluan);

            

            }

           

        });

                

            }

           

        }).fail(function() {

            $("#supplier_id").html('');

        }).always(function() {

            $('#loading-list-menu').hide();

        });

        

        

    }



    function get_list_barang_permintaan_barang(id,permintaan_id){

        $.ajax({

            url: '<?php echo url('ajax/get_list_barang_permintaan_barang/') ?>/'+id+'/'+permintaan_id,

            type: 'GET',

            cache:false,

            async: true,

            success: function(data) {

                if(data == 'false'){

                    alert("Barang Sudah Di Pesan Semua");

                } else {

                    $("#list-barang").html(data);

                    $('#loading-list-menu').hide();

                }

                    

            }

           

        }).fail(function() {

            $("#list-barang").html('');

        }).always(function() {

            $('#loading-list-menu').hide();

        });

        

    }





    function cek_pemesanan(id){

        $('#loading-list-menu').show();

        $.ajax({

            url: '<?php echo url('ajax/cek_pemesanan/') ?>/'+id,

            type: 'GET',

            cache:false,

            async: true,

            success: function(data) {

                data_pem = null;

                get_list_barang_permintaan_barang(id,$("#permintaan_id").val());

                if(data != 'false'){



                    alert("karena pemesanan dengan supllier yang sama sudah ada \nmaka data ini akan di masukan di detail pemesanan yang bernomor "+data[0].nomor);

                    a = 0;

                    data_pem = data;

                    $("#nomor").val(data[0].nomor);

                    $("#dikirim").val(data[0].dikirim);

                    $("#nomor").attr('readonly', 'readonly');

                    $("#dikirim").attr('readonly', 'readonly');

                    $("#pemesanan_baru").attr('disabled', 'disabled');

                     $("#keperluan").val(data_pem[0].keperluan);

                    // $("#keperluan").attr('readonly', 'readonly');

                    $("#pemesanan_baru").val("iya");

                    $('#data_baru').prop('checked', false);

                    $("#tanggal").val(data[0].tanggal);

                    $("#tanggal").attr('readonly', 'readonly'); 

                    $("#keterangan").val(data[0].keterangan);

                    $("#keterangan").attr('readonly', 'readonly'); 

                    $("#menyetujui").val(data[0].menyetujui);

                    $("#menyetujui").attr('readonly', 'readonly');

                    $("#mengetahui").val(data[0].mengetahui);

                    $("#mengetahui").attr('readonly', 'readonly');

                    $("#memesan").val(data[0].memesan);

                    $("#memesan").attr('readonly', 'readonly');

                    

                }



                else {

                    $("#nomor").val('');

                    $("#dikirim").val('');

                     $("#keperluan").val('');

                    $("#keperluan").removeAttr('readonly');

                    $("#dikirim").removeAttr('readonly');

                    $("#nomor").removeAttr('readonly');

                    $("#pemesanan_baru").val("tidak");

                    $('#data_baru').prop('checked', true);

                    $("#pemesanan_baru").removeAttr('disabled');

                    $("#tanggal").val('');

                    $("#tanggal").removeAttr('readonly'); 

                }

                



                

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



