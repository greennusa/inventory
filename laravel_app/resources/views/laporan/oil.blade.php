@extends('layouts.app')

@section('content')

<div class="container">
    

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Rekapitulasi Bahan Bakar Minyak<br><br> <a class="btn btn-default" href="{{ url('report') }}">Kembali</a></div>

                <div class="panel-body">
                    <form class="form-inline" action="<?php echo url("report/oil/print_bbm") ?>" target="_blank">
                        <input type="text"  class="form-control date-picker" name="tanggal" id="tanggal" placeholder="Pilih Bulan" required>
                        <input type="text"  class="form-control date-picker" name="tanggal2" id="tanggal2" placeholder="Pilih Bulan" required>
                        
                        <br>
                        <br>
                        <select class="selectpicker" name="diketahui" id="diketahui" data-live-search="true" required>
                            <option value="">Diketahui Oleh</option>
                            <?php foreach ($user as $u): ?>
                                <option value="<?php echo $u->id ?>" ><?php echo $u->nama ?></option>
                            <?php endforeach ?>
                        </select>
                 
                        <select class="selectpicker" name="disetujui" id="disetujui" data-live-search="true" required>
                            <option value="">Disetujui Oleh</option>
                            <?php foreach ($user as $u): ?>
                                <option value="<?php echo $u->id ?>" ><?php echo $u->nama ?></option>
                            <?php endforeach ?>
                        </select>
                        
                        <br>
                        <br>

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
