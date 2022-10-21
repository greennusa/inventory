@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Laporan Pemakaian Barang Per Unit<br><br> <a class="btn btn-default" href="{{ url('report') }}">Kembali</a></div>

                <div class="panel-body">
                    <form class="form-inline" action="<?php echo url("report/pemakaian_per_unit/print_unit") ?>" target="_blank">
                        <input type="date"  class="form-control " name="tanggal" id="tanggal" placeholder="Pilih Tanggal 1" required>
                        <input type="date"  class="form-control " name="tanggal2" id="tanggal2" placeholder="Pilih Tanggal 2" required>
                        <br>
                        <br>

                        <select class="selectpicker show-tick" name="jenis_unit_id[]" id="jenis_unit_id" data-live-search="true" required multiple>
                            <option>Jenis Unit</option>
                            <?php foreach ($jenisunit as $u): ?>
                                <option value="<?php echo $u->id ?>" ><?php echo $u->kode ?> - <?php echo $u->nama ?></option>
                            <?php endforeach ?>
                        </select>
                        <br>
                        <br>
                        <div class="row">
                            <div class="col-md-3">
                                <span style="color: red">Diketahui Oleh</span>
                                <br>
                                <select class="selectpicker" name="diketahui" id="diketahui" data-live-search="true" required>
                                    <option>Diketahui Oleh</option>
                                    <?php foreach ($user as $u): ?>
                                        <option value="<?php echo $u->id ?>" ><?php echo $u->nama ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <span style="color: red">Disetujui I</span>
                                <br>
                                <select class="selectpicker" name="disetujui_1" id="disetujui_1" data-live-search="true" required>
                                    <option>Disetujui Oleh I</option>
                                    <?php foreach ($user as $u): ?>
                                        <option value="<?php echo $u->id ?>" ><?php echo $u->nama ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <span style="color: red">Disetujui II (pilih 2 orang)</span>
                                <br>
                                <select class="selectpicker" name="disetujui_2[]" id="disetujui_2" multiple data-live-search="true" required>
                                   
                                    <?php foreach ($user as $u): ?>
                                        <option value="<?php echo $u->id ?>" ><?php echo $u->nama ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <span style="color: red">Dibuat Oleh</span>
                                <br>
                                <select class="selectpicker" name="dibuat" id="dibuat" data-live-search="true"  required>
                                    <option>Dibuat Oleh</option>
                                    <?php foreach ($user as $u): ?>
                                        <option value="<?php echo $u->id ?>" ><?php echo $u->nama ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                                
                 
                    
                        <br>
                        <br>
                        <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</button>
                    </form> 

                    

                </div>
            </div>
        </div>
    </div>

    
</div>


@endsection
