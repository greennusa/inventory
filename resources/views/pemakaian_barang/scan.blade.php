@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Tambah Pemakaian Barang</div>

                <div class="panel-body">
                    <form class="form-horizontal" id="myform" action="<?php echo url('item_use/scan') ?>" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="pemesanan_baru" id="pemesanan_baru" value="tidak">
                        
                            
                            <div id="dd">
                                <div class="form-group">

                                    <label for="nama" class="col-lg-2 control-label" >Tanggal Pemakaian</label>

                                    <div class="col-lg-6">

                                        <input type="date" class="form-control datepickers" id="tanggal" name="tanggal" placeholder="Tanggal Pemakaian" required >

                                    </div>

                                </div>

                                <div class="form-group">

                                    <label for="nama" class="col-lg-2 control-label" >Keterangan Pemakaian</label>

                                    <div class="col-lg-6">

                                        <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Keterangan Pemakaian" required >

                                    </div>

                                </div>

                                <div class="form-group">
                                    <label for="diketahui_id" class="col-lg-2 control-label">Diketahui</label>
                                    <div class="col-lg-6">
                                        <select class="form-control selectpicker" name="diketahui_id" id="diketahui_id" data-live-search="true">
                                            <option></option>
                                            <?php foreach ($user as $u): ?>
                                                <option value="<?php echo $u->id ?>" ><?php echo $u->nama ?></option>
                                            <?php endforeach ?>             
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="diterima_id" class="col-lg-2 control-label">Diterima</label>
                                    <div class="col-lg-6">
                                        <input type="text" name="diterima" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="dibuat_id" class="col-lg-2 control-label">Dibuat</label>
                                    <div class="col-lg-6">
                                        <select  class="form-control selectpicker" name="dibuat_id" id="dibuat_id" data-live-search="true">
                                            <option></option>
                                            <?php foreach ($user as $u): ?>
                                                <option value="<?php echo $u->id ?>" ><?php echo $u->nama ?></option>
                                            <?php endforeach ?>             
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">

                                    <label for="unit_id" class="col-lg-2 control-label">Untuk Unit</label>

                                    <div class="col-lg-6">

                                        <select  class="form-control selectpicker" name="unit_id" id="unit_id" data-live-search="true" required>
                                            <option></option>
                                            <?php foreach ($unit as $u): ?>

                                            <option value="<?php echo $u->id ?>">{{ $u->kode }}</option>
                                        <?php endforeach ?>
                                        </select>

                                    </div>

                                </div>

                                

                                

                                <div class="form-group">

                                    <label for="nama" class="col-lg-2 control-label" >Lokasi Pemakaian</label>

                                    <div class="col-lg-6">

                                        <input type="text" class="form-control" id="lokasi" name="lokasi" placeholder="Lokasi Pemakaian" required >

                                    </div>

                                </div>
                            </div>

                                

                            <div class="form-group">
                                <label for="barang_id" class="col-lg-2 control-label">Barang Di Camp</label>
                                <div class="col-lg-6" id="barang_id">
                                    
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="sn" class="col-lg-2 control-label">Serial Number Barang</label>
                                <div class="col-lg-3">
                                    <input type="text"  class="form-control" name="sn" id="sn" placeholder="Serial Number Barang" required>
                                </div>
                            </div>

                            

                        

                        <div class="form-group">

                            <div class="col-lg-10 col-lg-offset-2">

                                <input type=button value=Batal class="btn btn-default" onclick=self.history.back()>

                                <button  type="submit" class="btn btn-primary">Simpan</button>

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
        $('#myform').on('submit', function(e) {
            $('#loading-list-menu').show();
            e.preventDefault();
            $.ajax({
                url : $(this).attr('action') || window.location.pathname,
                type: "POST",
                data: $(this).serialize(),
                success: function (data) {
                    $("#dd input").attr('disabled', 'disabled');
                    $("#dd select").attr('disabled', 'disabled');
                    $("#list_barang").html(data);
                    $("#sn").val('');
                },
                error: function (jXHR, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            }).always(function() {
                $('#loading-list-menu').hide();
            });;
        });
    });
</script>
@endsection

