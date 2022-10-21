@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Tambah Barang Di Camp<br><br> <a class="btn btn-default" href="{{ url('/warehouse_udit') }}">Kembali</a></div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ url('warehouse_udit') }}">
                        {{ csrf_field() }}
                        
                        <div class="form-group">
                            <label for="bbk_id" class="col-lg-2 control-label">Tanggal Masuk Camp</label>
                            <div class="col-lg-3">
                                <input type="date" class="form-control datepickers" id="tanggal" name="tanggal" placeholder="Tanggal Masuk" required >
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="bbk_id" class="col-lg-2 control-label">Camp</label>
                            <div class="col-lg-3">
                                <select class="form-control" name="camp" id="camp">
                                    @foreach($d as $dapur)
                                        <option value="{{ $dapur->id }}">{{ $dapur->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        
                        <div class="form-group">
                            <label for="bbk_id" class="col-lg-2 control-label">Bukti Barang Keluar</label>
                            <div class="col-lg-3">
                                <select onchange="get_detail_bbk(this.value)" class="form-control selectpicker" name="bbk_id" id="bbk_id" data-live-search="true">
                                    <option></option>
                                    <?php foreach ($bbk as $p): ?>
                                        <option @if($p->status == 1) class="bg-danger" @endif value="<?php echo $p->id ?>" ><?php echo $p->nomor ?> - <?php echo $p->tanggal ?> @if($p->status == 1) Sudah Dikirim Semua @endif</option>
                                    <?php endforeach ?>             
                                </select>
                            </div>
                        </div>
                            
                            
                        

                        <div class="form-group">

                            <div class="col-lg-10 col-lg-offset-2">

                                <input type=button value=Batal class="btn btn-default" onclick=self.history.back()>

                                <button type="submit" class="btn btn-primary">Simpan</button>

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
