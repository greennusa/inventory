@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Pengguna/User</div>

                <div class="panel-body"> 
                    <form class="form-horizontal" method="POST" action="{{ url('user') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                       
                        <div class="form-group">

                            <label for="username" class="col-lg-2 control-label">Username</label>

                            <div class="col-lg-3">

                                <input type="text" minlength="4" value="<?php echo @$r->username ?>" class="form-control" name="username" id="username" placeholder="Username" required>

                            </div>

                        </div>

                        <div class="form-group">

                            <label for="password" class="col-lg-2 control-label">Password</label>

                            <div class="col-lg-3">

                                <input type="password" minlength="6" class="form-control" name="password" id="password" placeholder="Password"  >


                            </div>

                        </div>

                        <div class="form-group">

                            <label for="nama" class="col-lg-2 control-label">Nama Lengkap</label>

                            <div class="col-lg-3">

                                <input type="text" value="<?php echo @$r->nama ?>" class="form-control" name="nama" id="nama" placeholder="Nama Lengkap" required>

                            </div>

                        </div>  

                        <div class="form-group">

                            <label for="email" class="col-lg-2 control-label">Email</label>

                            <div class="col-lg-3">

                                <input type="email"  class="form-control" name="email" id="email" placeholder="Email">

                            </div>

                        </div> 
                     

                            

                        

                        <div class="form-group">

                            <label for="lokasi_id" class="col-lg-2 control-label">Lokasi</label>

                            <div class="col-lg-3">

                                <select class="form-control selectpicker" name="lokasi_id" id="lokasi_id" data-live-search="true">

                                    <option value="0"></option> 

                                    <?php foreach ($lokasi as $k): ?>

                                        <option value="<?php echo $k->id ?>" <?php if ($k->id == @$r->lokasi_id) {echo "selected";} ?>><?php echo $k->nama ?></option>

                                    <?php endforeach ?>             

                                </select>

                            </div>

                        </div>

                        <div class="form-group">

                            <label for="jabatan_id" class="col-lg-2 control-label">Jabatan</label>

                            <div class="col-lg-3">

                                <select class="form-control selectpicker" name="jabatan_id" id="jabatan_id" data-live-search="true">

                                    <option></option>   

                                    <?php foreach ($jabatan as $k): ?>

                                        <option value="<?php echo $k->id ?>" <?php if ($k->id == @$r->jabatan_id) {echo "selected";} ?>><?php echo $k->nama ?></option>

                                    <?php endforeach ?>             

                                </select>

                            </div>

                        </div>

                        <div class="form-group">

                            <label for="group_id" class="col-lg-2 control-label">Grup</label>

                            <div class="col-lg-3">

                                <select class="form-control selectpicker" name="group_id" id="group_id" data-live-search="true">

                                    <option></option>   

                                    <?php foreach ($grup as $k): ?>

                                        <option value="<?php echo $k->id ?>" <?php if ($k->id == @$r->grup_id) {echo "selected";} ?>><?php echo $k->nama ?></option>

                                    <?php endforeach ?>             

                                </select>

                            </div>

                        </div>

                        <div class="form-group">

                            <label for="active" class="col-lg-2 control-label">Status</label>

                            <div class="col-lg-3">

                                <select class="form-control selectpicker" name="active" id="active" data-live-search="true">

                                    <option value="1">Aktif</option>            

                                    <option value="0">Tidak Aktif</option>

                                </select>

                            </div>

                        </div>

                        <div class="form-group">

                            <label for="gambar" class="col-lg-2 control-label">Tanda Tangan</label>

                            <div class="col-lg-3">

                                <input type="file" name="userfile" id="userfile" class="form-control">

                            </div>

                        </div>

                        <div class="form-group">

                            <div class="col-lg-10 col-lg-offset-2">

                                <input type=button value=Batal class="btn btn-default" onclick=self.history.back()>

                                <button type="submit" class="btn btn-primary">Simpan</button>

                            </div>

                        </div>

                    </form>

                    
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
