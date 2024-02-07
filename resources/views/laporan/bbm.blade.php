@extends('layouts.app')



@section('content')
    <div class="container">

        <div class="row">

            <div class="col-md-12">

                <div class="panel panel-default">

                    <div class="panel-heading">Laporan Pemakaian BBM dan Pelumas<br><br> <a class="btn btn-default"
                            href="{{ url('report') }}">Kembali</a></div>



                    <div class="panel-body">

                        <form class="form-inline" action="<?php echo url('report/bbm/print_laporan'); ?>" target="_blank">

                            <div class="row">

                                <div class="col-md-3">

                                    <span style="color: red">Bulan :</span>

                                    <br>

                                    <input type="text" name="tanggal" class="form-control date-picker">

                                </div>

                            </div>



                            <div class="row ">



                                <div class="col-md-3">

                                    <span style="color: red">Diketahui Oleh</span>

                                    <br>

                                    <select class="selectpicker" name="diketahui" id="diketahui" data-live-search="true"
                                        required>

                                        <option value="">Diketahui Oleh</option>

                                        <?php foreach ($user as $u): ?>

                                        <option value="<?php echo $u->id; ?>"><?php echo $u->nama; ?></option>

                                        <?php endforeach ?>

                                    </select>

                                </div>

                                <div class="col-md-3">

                                    <span style="color: red">Disetujui I</span>

                                    <br>

                                    <select class="selectpicker" name="disetujui_1" id="disetujui_1" data-live-search="true"
                                        required>

                                        <option value="">Disetujui Oleh I</option>

                                        <?php foreach ($user as $u): ?>

                                        <option value="<?php echo $u->id; ?>"><?php echo $u->nama; ?></option>

                                        <?php endforeach ?>

                                    </select>

                                </div>





                            </div>

                            <div class="row ">

                                <div class="col-md-3">

                                    <span style="color: red">Disetujui II (pilih 2 orang)</span>

                                    <br>

                                    <select class="selectpicker" name="disetujui_2[]" multiple id="disetujui_2"
                                        data-live-search="true" required>



                                        <?php foreach ($user as $u): ?>

                                        <option value="<?php echo $u->id; ?>"><?php echo $u->nama; ?></option>

                                        <?php endforeach ?>

                                    </select>

                                </div>

                                <div class="col-md-3">

                                    <span style="color: red" value="">Dibuat Oleh</span>

                                    <br>

                                    <select class="selectpicker" name="dibuat" id="dibuat" data-live-search="true"
                                        required>

                                        <option value="">Dibuat Oleh</option>

                                        <?php foreach ($user as $u): ?>

                                        <option value="<?php echo $u->id; ?>"><?php echo $u->nama; ?></option>

                                        <?php endforeach ?>

                                    </select>

                                </div>





                            </div>







                            <br>



                            <div class="row col-md-3">

                                <button type="submit" name="format" value="print" class="btn btn-success"><span
                                        class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</button>

                                {{-- <button type="submit" name="format" value="doc" class="btn btn-success"><span class="glyphicon glyphicon-file" aria-hidden="true"></span> Doc</button> --}}

                            </div>

                        </form>







                    </div>

                </div>

            </div>

        </div>



        <div class="row">

            <div class="col-md-12">

                <div class="panel panel-default">

                    <div class="panel-heading">Laporan Pemakaian BBM dan Pelumas, Skidding, Road Construction, Produksi,
                        DLL<br><br> <a class="btn btn-default" href="{{ url('report') }}">Kembali</a></div>



                    <div class="panel-body">

                        <form class="form-inline" action="<?php echo url('report/bbm/print_laporan_2'); ?>" target="_blank">







                            <div class="row">

                                <div class="col-md-3">

                                    <span style="color: red">Bulan :</span>

                                    <br>

                                    <input type="text" name="tanggal" class="form-control date-picker">

                                </div>

                            </div>



                            <div class="row ">



                                <div class="col-md-3">

                                    <span style="color: red">Diketahui Oleh</span>

                                    <br>

                                    <select class="selectpicker" name="diketahui" id="diketahui" data-live-search="true"
                                        required>

                                        <option value="">Diketahui Oleh</option>

                                        <?php foreach ($user as $u): ?>

                                        <option value="<?php echo $u->id; ?>"><?php echo $u->nama; ?></option>

                                        <?php endforeach ?>

                                    </select>

                                </div>

                                <div class="col-md-3">

                                    <span style="color: red">Disetujui I</span>

                                    <br>

                                    <select class="selectpicker" name="disetujui_1" id="disetujui_1" data-live-search="true"
                                        required>

                                        <option value="">Disetujui Oleh I</option>

                                        <?php foreach ($user as $u): ?>

                                        <option value="<?php echo $u->id; ?>"><?php echo $u->nama; ?></option>

                                        <?php endforeach ?>

                                    </select>

                                </div>





                            </div>

                            <div class="row ">

                                <div class="col-md-3">

                                    <span style="color: red">Disetujui II (pilih 2 orang)</span>

                                    <br>

                                    <select class="selectpicker" name="disetujui_2[]" multiple id="disetujui_2"
                                        data-live-search="true" required>



                                        <?php foreach ($user as $u): ?>

                                        <option value="<?php echo $u->id; ?>"><?php echo $u->nama; ?></option>

                                        <?php endforeach ?>

                                    </select>

                                </div>

                                <div class="col-md-3">

                                    <span style="color: red">Dibuat Oleh</span>

                                    <br>

                                    <select class="selectpicker" name="dibuat" id="dibuat" data-live-search="true"
                                        required>

                                        <option value="">Dibuat Oleh</option>

                                        <?php foreach ($user as $u): ?>

                                        <option value="<?php echo $u->id; ?>"><?php echo $u->nama; ?></option>

                                        <?php endforeach ?>

                                    </select>

                                </div>





                            </div>







                            <br>



                            <div class="row col-md-3">

                                <button type="submit" name="format" value="print" class="btn btn-success"><span
                                        class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</button>

                                {{-- <button type="submit" name="format" value="doc" class="btn btn-success"><span class="glyphicon glyphicon-file" aria-hidden="true"></span> Doc</button> --}}

                            </div>

                        </form>







                    </div>

                </div>

            </div>

        </div>







        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Rekapitulasi Bahan Bakar Minyak<br><br> <a class="btn btn-default"
                            href="{{ url('report') }}">Kembali</a></div>

                    <div class="panel-body">
                        <form class="form-inline" action="<?php echo url('report/oil/print_bbm'); ?>" target="_blank">
                            <input type="text" class="form-control date-picker" name="tanggal" id="tanggal"
                                placeholder="Pilih Bulan" required>
                            <input type="text" class="form-control date-picker" name="tanggal2" id="tanggal2"
                                placeholder="Pilih Bulan" required>
                            <input type="text" class="form-control" name="keterangan" id="keterangan"
                                placeholder="Keterangan">
                            <br>
                            <br>
                            <select class="selectpicker" name="diketahui" id="diketahui" data-live-search="true"
                                required>
                                <option value="">Diketahui Oleh</option>
                                <?php foreach ($user as $u): ?>
                                <option value="<?php echo $u->id; ?>"><?php echo $u->nama; ?></option>
                                <?php endforeach ?>
                            </select>

                            <select class="selectpicker" name="disetujui" id="disetujui" data-live-search="true"
                                required>
                                <option value="">Disetujui Oleh</option>
                                <?php foreach ($user as $u): ?>
                                <option value="<?php echo $u->id; ?>"><?php echo $u->nama; ?></option>
                                <?php endforeach ?>
                            </select>

                            <br>
                            <br>

                            <select class="selectpicker" name="dibuat" id="dibuat" data-live-search="true" required>
                                <option value="">Dibuat Oleh</option>
                                <?php foreach ($user as $u): ?>
                                <option value="<?php echo $u->id; ?>"><?php echo $u->nama; ?></option>
                                <?php endforeach ?>
                            </select>



                            <br>
                            <br>
                            <button type="submit" name="format" value="print" class="btn btn-success"><span
                                    class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</button>
                            <button type="submit" name="format" value="doc" class="btn btn-success"><span
                                    class="glyphicon glyphicon-file" aria-hidden="true"></span> Doc</button>
                        </form>



                    </div>
                </div>
            </div>
        </div>








    </div>
@endsection
