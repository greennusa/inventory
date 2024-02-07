@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Tambah Barang Lama</div>

                <div class="panel-body">
                    <form class="form-horizontal" enctype="multipart/form-data" method="post" accept-charset="utf-8" action="{{ url('/warehouse_udit/stok_lama') }}">
                        {{ csrf_field() }}
                        

                        <div class="form-group">
                            <label for="nama" class="col-lg-2 control-label">Barang</label>
                            <div class="col-lg-3">
                                <select class="form-control selectpicker" name="barang_id" id="barang_id" data-live-search="true">
                                    <option>Pilih Barang</option>
                                    <?php foreach ($barang as $b): ?>
                                        <option value="<?php echo $b->id ?>"><?php echo $b->kode." - ".$b->nama." - Rp.".number_format($b->harga) ?></option>
                                    <?php endforeach ?>             
                                </select>
                            </div>
                        </div>

                        <div class="form-group">

                            <label for="jumlah" class="col-lg-2 control-label">Jumlah Barang</label>

                            <div class="col-lg-3">

                                <input type="text"  class="form-control" name="jumlah" id="jumlah" placeholder="Jumlah Barang" required>

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
                            <label for="tanggal" class="col-lg-2 control-label">Tanggal</label>
                            <div class="col-lg-3">
                                <input type="date"  class="form-control" name="tanggal" id="tanggal" placeholder="Pilih Tanggal" required>
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

<script type="text/javascript">
    function list_sn(nama_barang,barang_id,jumlah){

        var inputan = $(".inputan_sn"+barang_id);
        
        for (var x = 0 ; x < inputan.length; x++) {
                    
            if(x > jumlah-1){
                inputan[x].remove();
            }
        }

        for (var i = 0 ; i < parseInt(jumlah); i++) {
            if(i > inputan.length-1 ){
                $("#isi_modal_"+barang_id).append('<tr class="inputan_sn'+barang_id+'"><td>'+(i+1)+'</td><td><input  type="text" name="sn_'+barang_id+'[]" class=" form-control input-submit-query" placeholder="Serial number '+nama_barang+'"></td></tr>');
            }

            
            
        }

        

        
    }
</script>
@endsection
