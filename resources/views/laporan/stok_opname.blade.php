@extends('layouts.app')



@section('content')



<div class="container">

    <div class="row">

        <div class="col-md-12">

            <div class="panel panel-default">

                <div class="panel-heading">Laporan Stok Opname Per-Jenis Unit<br><br> <a class="btn btn-default" href="{{ url('report') }}">Kembali</a></div>



                <div class="panel-body">

                    <form class="form-inline" action="<?php echo url("report/opname/print_unit") ?>" target="_blank">

                        <input type="text"  class="form-control date-picker" name="tanggal" id="tanggal" placeholder="Pilih Bulan" required>

                        <br>

                        <br>

                        <select class="selectpicker" name="jenis_unit_id" id="jenis_unit_id" data-live-search="true" required>

                            <option value="">Jenis Unit</option>

                            <?php foreach ($jenisunit as $u): ?>

                                <option value="<?php echo $u->id ?>" ><?php echo $u->kode ?> - <?php echo $u->nama ?></option>

                            <?php endforeach ?>

                        </select>

                        <br>

                        <br>

                        <select class="selectpicker" name="diketahui" id="diketahui" data-live-search="true" required>

                            <option value="">Diketahui Oleh</option>

                            <?php foreach ($user as $u): ?>

                                <option value="<?php echo $u->id ?>" ><?php echo $u->nama ?></option>

                            <?php endforeach ?>

                        </select>

                 

                        <select class="selectpicker" name="dibuat" id="dibuat" data-live-search="true" required>

                            <option value="">Dibuat Oleh</option>

                            <?php foreach ($user as $u): ?>

                                <option value="<?php echo $u->id ?>" ><?php echo $u->nama ?></option>

                            <?php endforeach ?>

                        </select>

                        

                        <br>

                        <br>

                        <button type="submit" name="format" value="print" class="btn btn-success"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</button>

                        <button type="submit" name="format" value="doc" class="btn btn-success"><span class="glyphicon glyphicon-file" aria-hidden="true"></span> Doc</button>

                    </form> 



                    



                </div>

            </div>

        </div>

    </div>







    <div class="row">

        <div class="col-md-12">

            <div class="panel panel-default">

                <div class="panel-heading">Laporan Stok Opname Per-Kategori</div>



                <div class="panel-body">

                    <form class="form-inline" action="<?php echo url("report/opname/print_kategori") ?>" target="_blank">

                        <input type="text"  class="form-control date-picker" name="tanggal" id="tanggal" placeholder="Pilih Bulan" required>

                        <br>

                        <br>

                        <?php $kategori = \App\Kategori::all(); ?>

                        <select class="selectpicker" name="kategori" id="kategori" data-live-search="true" required>

                            <option value="">Kategori</option>

                            <?php foreach ($kategori as $u): ?>

                                <option value="<?php echo $u->id ?>" ><?php echo $u->nama ?></option>

                            <?php endforeach ?>

                        </select>

                        <br>

                        <br>

                        <select class="selectpicker" name="diketahui" id="diketahui" data-live-search="true" required>

                            <option value="">Diketahui Oleh</option>

                            <?php foreach ($user as $u): ?>

                                <option value="<?php echo $u->id ?>" ><?php echo $u->nama ?></option>

                            <?php endforeach ?>

                        </select>

                 

                        <select class="selectpicker" name="dibuat" id="dibuat" data-live-search="true" required>

                            <option value="">Dibuat Oleh</option>

                            <?php foreach ($user as $u): ?>

                                <option value="<?php echo $u->id ?>" ><?php echo $u->nama ?></option>

                            <?php endforeach ?>

                        </select>

                        

                        <br>

                        <br>

                        <button type="submit" name="format" value="print" class="btn btn-success"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</button>

                        <button type="submit" name="format" value="doc" class="btn btn-success"><span class="glyphicon glyphicon-file" aria-hidden="true"></span> Doc</button>

                    </form> 



                    



                </div>

            </div>

        </div>

    </div>



    

</div>





@endsection

