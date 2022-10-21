@extends('layouts.app')



@section('content')







<div class="container">

    <div class="row">

        <div class="col-md-12">

            <div class="panel panel-default">

                <div class="panel-heading">Laporan Supplier Barang<br><br> <a class="btn btn-default" href="{{ url('report') }}">Kembali</a></div>



                <div class="panel-body">

                    <form class="form-inline" action="<?php echo url("report/supplier/print_laporan") ?>" target="_blank">

                        <input type="text"  class="form-control date-picker" name="tanggal" id="tanggal" placeholder="Pilih Bulan" required>

                        

                        

                        <div class="row">

                        	<div class="col-md-3">

                        	<span style="color: red">Supplier</span>

                                <br>

                                <select class="selectpicker" name="supplier" id="supplier" data-live-search="true" required>

                                    <option value="">Supplier</option>

                                    <?php foreach ($supplier as $s): ?>

                                    <?php if($s->id != '-1'){ ?>

                                        <option value="<?php echo $s->id ?>" ><?php echo $s->nama ?></option>

                                    <?php } ?>

                                    <?php endforeach ?>

                                </select>

                            </div>

                        </div>



                        <div class="row ">



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

                                    <option value="">Disetujui Oleh I</option>

                                    <?php foreach ($user as $u): ?>

                                        <option value="<?php echo $u->id ?>" ><?php echo $u->nama ?></option>

                                    <?php endforeach ?>

                                </select>

                            </div>

                    

                                

                        </div>

                        <div class="row ">

                            <div class="col-md-3">

                                <span style="color: red">Disetujui II (pilih 2 orang)</span>

                                <br>

                                <select class="selectpicker" name="disetujui_2[]" multiple id="disetujui_2" data-live-search="true" required>

                                    

                                    <?php foreach ($user as $u): ?>

                                        <option value="<?php echo $u->id ?>" ><?php echo $u->nama ?></option>

                                    <?php endforeach ?>

                                </select>

                            </div>

                            <div class="col-md-3">

                                <span style="color: red">Dibuat Oleh</span>

                                <br>

                                <select class="selectpicker" name="dibuat" id="dibuat" data-live-search="true" required>

                                    <option value="">Dibuat Oleh</option>

                                    <?php foreach ($user as $u): ?>

                                        <option value="<?php echo $u->id ?>" ><?php echo $u->nama ?></option>

                                    <?php endforeach ?>

                                </select>

                            </div> 

                        

                                

                        </div>

                            

                 

                            

                        <br>



                        <div class="row col-md-3">

                            <button type="submit" name="format" value="print" class="btn btn-success"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</button>

                        <button type="submit" name="format" value="doc" class="btn btn-success"><span class="glyphicon glyphicon-file" aria-hidden="true"></span> Doc</button>

                        </div>

                    </form> 



                    



                </div>

            </div>

        </div>

    </div>



    

</div>











@endsection