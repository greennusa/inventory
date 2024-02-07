@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Pengguna/User</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ url('user/'.$r->id) }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="PUT">
                        <div class="form-group">

                            <label for="username" class="col-lg-2 control-label">Username</label>

                            <div class="col-lg-3">

                                <input type="text" minlength="4" value="<?php echo @$r->username ?>" class="form-control" name="username" id="username" placeholder="Username" required>

                            </div>

                        </div>

                        <div class="form-group">

                            <label for="username" class="col-lg-2 control-label"></label>

                            <div class="col-lg-3">

                                <button type="button" class="btn btn-primary " data-toggle="modal" data-target="#myModal">Ubah Password</button>

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

                                <input type="email" value="<?php echo @$r->email ?>" class="form-control" name="email" id="email" placeholder="Email">

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

                                        <option value="<?php echo $k->id ?>" <?php if ($k->id == @$r->group_id) {echo "selected";} ?>><?php echo $k->nama ?></option>

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
                                <br>
                                <img src="{{ url('images/images/ttd/'.$r->ttd) }}">
                            </div>

                        </div>

                        <div class="form-group">

                            <div class="col-lg-10 col-lg-offset-2">

                                <a class="btn btn-default" href="<?php echo url('user?page='.$_GET['page']) ?>">Kembali</a>

                                <button type="submit" class="btn btn-primary">Simpan</button>

                            </div>

                        </div>
                        <input type="hidden" name="page" value="{{ $_GET['page'] }}">
                    </form>

                    <div id="myModal" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Ubah Password</h4>
                            </div>
                            <div class="modal-body" style="padding:0;">
                                <form class="form-horizontal" method="POST" action="{{ url('user/'.$r->id.'/ubah_password') }}" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    
                                    <div class="form-group">
                                        <label  class="col-lg-2 control-label">Password Lama</label>

                                        <div class="col-lg-3">

                                            <input type="password" name="password_lama" class="form-control" required  minlength="6">

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-2 control-label">Password Baru</label>

                                        <div class="col-lg-3">

                                            <input type="password" name="password_baru" class="form-control" required  minlength="6">

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label  class="col-lg-2 control-label"></label>

                                        <div class="col-lg-3">

                                            <input type="submit" name="submit" value="Ubah">

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
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
