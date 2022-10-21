@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Tambah Barang<br><br> <a class="btn btn-default" href="{{ url('/item') }}">Kembali</a></div>

                <div class="panel-body">
                    <form class="form-horizontal" enctype="multipart/form-data" method="post" accept-charset="utf-8" action="{{ url('item') }}">
                        {{ csrf_field() }}
                        <div class="form-group">

                            <label for="nama" class="col-lg-2 control-label">Nama Barang</label>

                            <div class="col-lg-3">

                                <input type="text"  class="form-control" name="nama" id="nama" placeholder="Nama Barang" required>

                            </div>

                        </div>

                        <div class="form-group">

                            <label for="kode" class="col-lg-2 control-label">No. Part / Kode</label>

                            <div class="col-lg-3">

                                <input type="text"  class="form-control" name="kode" id="kode" placeholder="No. Part / Kode Pabrikan" required>

                            </div>

                        </div>

                        <div class="form-group">

                            <label for="kategori_id" class="col-lg-2 control-label">Kategori</label>

                            <div class="col-lg-3">

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

                            <label for="unit_id" class="col-lg-2 control-label">Unit</label>

                            <div class="col-lg-3">

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

                            <label for="harga" class="col-lg-2 control-label">Harga Barang</label>

                            <div class="col-lg-3">

                                <input type="text"  class="form-control" name="harga" id="harga" placeholder="Harga Barang" required>

                            </div>

                        </div>

                        <div class="form-group">

                            <label for="halaman" class="col-lg-2 control-label">Halaman</label>

                            <div class="col-lg-3">

                                <input type="text"  class="form-control" name="halaman" id="halaman" placeholder="Halaman" >

                            </div>

                        </div>

                        <div class="form-group">

                            <label for="indeks" class="col-lg-2 control-label">Indeks</label>

                            <div class="col-lg-3">

                                <input type="text"  class="form-control" name="indeks" id="indeks" placeholder="Indeks" >

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

                            <label for="keterangan" class="col-lg-2 control-label">Keterangan</label>

                            <div class="col-lg-3">

                                <input type="text"  class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan">

                            </div>

                        </div>

                            

                        <div class="form-group">

                            <label for="gambar" class="col-lg-2 control-label">Gambar Barang</label>

                            <div class="col-lg-3">

                                <input type="file" name="userfile" id="userfile" class="form-control">

                            </div>

                        </div>

                        <div class="form-group">

                            <label for="pakai_sn" class="col-lg-2 control-label">Menggunakan Serial Number?</label>

                            <div class="col-lg-3">

                                <select class="form-control" name="pakai_sn" id="pakai_sn">

                                    
                                        <option value="1" > Iya</option>   

                                    
                                        <option value="0" > Tidak</option>  

                                    
                                </select>
                                <span style="color:red; font-size:13px" class="help-block">Disarankan pilih "Tidak" untuk barang yang pada saat di pesan berjumlah banyak</span>
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
    var o = true;
    $(document).on('click', '#add_brand', function(event) {
        if(o){
            $(this).html('Batal');
            $("#merek_baru").show();
            $("#merek_baru input").removeAttr('disabled');

            $("#merek_id").hide();
            $("#merek_id select").attr('disabled','disabled');
            o = false;
        }
        else {
            $("#merek_baru ").hide();
            $("#merek_baru input").attr('disabled','disabled');

            $("#merek_id").show();
            $("#merek_id select").removeAttr('disabled');
            $(this).html('Tambah Merek Baru');
            o = true;
        }
            

    });
        
</script>
@endsection
