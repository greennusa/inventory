@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Tambah Arsip<br><br> <a class="btn btn-default" href="{{ url('/arsip') }}">Kembali</a></div>

                <div class="panel-body">
                    <form class="form-horizontal" enctype="multipart/form-data" method="post" accept-charset="utf-8" action="{{ url('arsip') }}">
                        {{ csrf_field() }}
                       

                        

                        <div class="form-group">
                            <label for="tanggal" class="col-lg-2 control-label">Tanggal</label>
                            <div class="col-lg-3">
                                <input type="date" class="form-control datepickers" name="tanggal" id="tanggal" placeholder="Tanggal" required >
                            </div>
                        </div> 

                        <div class="form-group">

                            <label for="gambar" class="col-lg-2 control-label">Keterangan</label>

                            <div class="col-lg-3">

                                <input type="text" name="keterangan" id="keterangan" class="form-control">

                            </div>

                        </div>

                        <div class="form-group">

                            <label for="gambar" class="col-lg-2 control-label">File</label>

                            <div class="col-lg-3">

                                <input type="file" name="userfile" id="userfile" class="form-control">

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


</script>
@endsection
