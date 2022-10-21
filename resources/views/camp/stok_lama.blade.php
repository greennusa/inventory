@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Tambah Barang Lama</div>

                <div class="panel-body">
                    <form class="form-horizontal" enctype="multipart/form-data" method="post" accept-charset="utf-8" action="{{ url('/warehouse_udit_lama') }}">
                        {{ csrf_field() }}
                        

                        <div class="form-group">
                            <label for="barang_id" class="col-lg-2 control-label">Barang</label>
                            <div class="col-lg-3">
                                <select class="form-control selectpicker" onchange="get_data(this.value)" name="barang_id" id="barang_id" data-live-search="true">
                                    <option>Pilih Barang</option>
                                    <?php foreach ($barang as $b): ?>
                                        <option value="<?php echo $b->id ?>"><?php echo $b->kode." - ".$b->nama." - Rp.".number_format($b->harga) ?></option>
                                    <?php endforeach ?>             
                                </select>
                            </div>
                        </div>

                        

                        <div class="form-group">

                            <label for="kode" class="col-lg-2 control-label">Kode Barang</label>

                            <div class="col-lg-3">

                                <input type="text"  class="form-control" name="kode" id="kode" placeholder="Kode Barang" required>

                            </div>

                        </div>

                        <div class="form-group">

                            <label for="nama" class="col-lg-2 control-label">Nama Barang</label>

                            <div class="col-lg-3">

                                <input type="text"  class="form-control" name="nama" id="nama" placeholder="Nama Barang" required>

                            </div>

                        </div>

                        
                        

                        <div class="form-group">

                            <label for="harga" class="col-lg-2 control-label">Harga Barang</label>

                            <div class="col-lg-3">

                                <input type="text"  class="form-control" name="harga" id="harga" placeholder="Harga Barang" required>

                            </div>

                        </div>

                        
                        <div class="form-group">

                            <label for="satuan_id" class="col-lg-2 control-label">Satuan</label>

                            <div class="col-lg-3">

                                <select class="form-control "  name="satuan_id" id="satuan_id" >

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
                            <label for="tanggal" class="col-lg-2 control-label">Tanggal</label>
                            <div class="col-lg-3">
                                <input type="date"  class="form-control" name="tanggal" id="tanggal" placeholder="Pilih Tanggal" required >
                            </div>
                        </div>
						
						<div class="form-group">

                            <label for="keterangan" class="col-lg-2 control-label">Keterangan</label>

                            <div class="col-lg-3">

                                <input type="text"  class="form-control" name="keterangan" id="keterangan" placeholder="keterangan Barang" required>

                            </div>

                        </div>	
						
                        <div class="form-group">

                            <label for="jumlah" class="col-lg-2 control-label">Jumlah Barang</label>

                            <div class="col-lg-3">

                                <input type="number" value="1"  min="1" class="form-control" onchange="add_sn(this.value)" name="jumlah" id="jumlah" placeholder="Jumlah Barang" required>

                            </div>

                        </div>

                        <div class="form-group">
                            <div class="col-lg-2">
                                
                            </div>
                            <div class="col-lg-6">
                                <table class="table">
                                    
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>SN</th>
                                        </tr>
                                    </thead>
                                    <tbody id="sn">

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="form-group">

                            <div class="col-lg-10 col-lg-offset-2">

                                <input  type=button value=Batal class="btn btn-default" onclick=self.history.back()>

                                <button type="submit" class="btn btn-primary">Simpan</button>

                            </div>

                        </div>

 

                    </form>


                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" charset="utf-8" async defer>
    var useSN = false;
    
    function add_sn(jumlah) {
        
        if(!useSN){
            $("#sn").html('');
            return;
        }

        
        for (var i = 1; i <= jumlah; i++) {
            if($("#sn"+i).length == 1 ){
                for (var x = 1; x <= $(".sn").length; x++) {
                    if(x > jumlah)
                    $("#sn"+x).remove();
                }
          
            } else {
                $("#sn").append('<tr class="sn" id="sn'+i+'"><td>'+i+'</td><td><input  type="text" name="sn[]"></td></tr>');
            }
            
        }
       
            
    }
    function get_data(id) {
        $('#loading-list-menu').show();
        $.ajax({
            url: '<?php echo url('barang/get_data/') ?>/'+id,
            type: 'GET',
            success:function(data){
                $("#kode").val(data.kode);
                $("#nama").val(data.nama);
                $("#harga").val(data.harga);
                $("#satuan_id").val(data.satuan_id);
                if(data.pakai_sn == 1){
                    useSN = true;

                }
                $("#sn").html('');
                $("#jumlah").val(0);
            }
        })
        
        .always(function() {
            $('#loading-list-menu').hide();
        });
        
    }
</script>

@endsection
