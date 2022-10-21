@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Tambah Barang Di Gudang</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ url('warehouse') }}">
                        {{ csrf_field() }}
                        
                        
                        <div class="form-group">
                            <label for="bbm_id" class="col-lg-2 control-label">Barang Masuk</label>
                            <div class="col-lg-3">
                                <select onchange="get_detail_bbm(this.value)" class="form-control selectpicker" name="bbm_id" id="bbm_id" data-live-search="true">
                                    <option></option>
                                    <?php foreach ($bbm as $p): ?>
                                        <option value="<?php echo $p->id ?>" ><?php echo $p->pemesanan->nomor ?> - <?php echo $p->nomor ?> - <?php echo $p->pemesanan->pemasok->nama ?> - <?php echo $p->tanggal ?></option>
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
                        <div id="list-barang"></div>
                        
                    </form>

                        
                    

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
