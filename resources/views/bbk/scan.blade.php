@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Tambah BBK</div>

                <div class="panel-body">
                  
                    <form class="form-horizontal"  method="POST" action="{{ url('item_out/scan') }}">
                       
                        {{ csrf_field() }}
                        <div id="dd">
                            <div class="form-group">
                                <label for="nomor" class="col-lg-2 control-label">Nomor BBK</label>
                                <div class="col-lg-3">
                                    <input type="text"  class="form-control" name="nomor" id="nomor" placeholder="Nomor BBK" required>
                                </div>
                            </div>
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
                            </div>
                        </div>
                            

                        
                        
                       
                       <div class="form-group">

                            <div class="col-lg-10 col-lg-offset-2">

                                <a href="{{ url('item_out') }}" class="btn btn-success">Selesai</a>

                                <button type="submit" class="btn btn-primary">Simpan</button>

                            </div>

                        </div>
                        

                        <div class="form-group" >
                            <div class="col-lg-10 col-lg-offset-2">
                                <table style="width: 100%;">
                                    <thead>
                                        <tr>
                                           
                                            <th>Kode Barang</th>
                                            <th>Nama Barang</th>
                                            
                                            <th>Kode Unit</th>
                                            
                                            <th>Keterangan</th>
                                            <th>Jumlah</th>
                                            
                                            <th>Harga</th>
                                            <th>Hapus</th>
                                           
                                        </tr>
                                    </thead>
                                    <tbody  id="list_barang">
                                        
                                    </tbody>
                                   
                                </table>
                            </div>
                        </div>
                        
                    </form>


                    <form class="form-horizontal" id="myform" method="POST" action="{{ url('item_out/scan_barang') }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="sn" class="col-lg-2 control-label">Serial Number Barang</label>
                            <div class="col-lg-3">
                                <input type="text"  class="form-control" name="sn" id="sn" placeholder="Serial Number Barang" required>
                            </div>
                        </div>
                    </form>

                    

                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function () {
        var list_barang = [];
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
                    
                    if(list_barang.indexOf(data) > -1){
                        alert('barang sudah ditambahkan');
                    } else {
                        // $("#dd input").attr('disabled', 'disabled');
                        // $("#dd select").attr('disabled', 'disabled');
                        $("#list_barang").append(data);
                        $("#sn").val('');
                        list_barang.push(data.replace(/\s/g,''));
                    }
                    
                },
                error: function (jXHR, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            }).always(function() {
                $('#loading-list-menu').hide();
            });;
        });

        $(document).on('click', '.hapus_list_barang', function(event) {

            removeFav(list_barang.indexOf($("#"+$(this).attr('id_target')).prop('outerHTML').toString().replace(/\s/g,'')));
            $("#"+$(this).attr('id_target')).remove();

        });


    });

    function removeFav(key) { 
      for (var i = 0; i < list_barang.length; i ++) {
        // if the current array item has a property
        // that matches the specified one, remove that item
        if (list_barang[i].hasOwnProperty(key)){
          list_barang.splice(i, 1);
          return;
        }  
      }
    }
</script>
@endsection
