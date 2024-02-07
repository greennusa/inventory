<?php 

        $from = (int)date('m',strtotime($_GET['tanggal']));

        $to = (int)date('m',strtotime($_GET['tanggal2']));

        $tahun = date('Y',strtotime($_GET['tanggal']));

        $bulannya = ['array_bulan','JANUARI','FEBRUARI','MARET','APRIL','MEI','JUNI','JULI','AGUSTUS','SEPTEMBER','NOVEMBER','OKTOBER','DESEMBER']; 

        ?>

<!DOCTYPE html>

<html>

<head>

    <title>PERIODE BULAN <?php echo $bulannya[$from]; ?> <?php echo $tahun; ?></title>

    <link rel="stylesheet" type="text/css" href="{{ asset('bootstrap/theme/16/bootstrap.min.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('selectbox/css/bootstrap-select.min.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('jquery-ui/jquery-ui.min.css') }}">









    <script src="{{ asset('jquery/jquery-1.11.3.min.js') }}"></script>

    <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>

    <script src="{{ asset('selectbox/js/bootstrap-select.min.js') }}"></script>

    <script src="{{ asset('jquery-ui/jquery-ui.min.js') }}"></script>

    <script src="{{ asset('js/bootstrap-notify.min.js') }}" ></script>

</head>

<style type="text/css" media="print">

    @page {

        
		size:auto;
        margin-bottom: 0;  /* this affects the margin in the printer settings */
		


    }

	
    table{
		white-space:nowrap;
        font-size: 8px;
		padding:0;
		margin-left:-140px;
    }
	
	table tr td{
		height: 5px;
	}
	
	table tr th{
		height: 5px;
		white-space:nowrap;
	}

</style>

<style type="text/css">

    @page {

        size: auto;   /* auto is the initial value */

        margin-bottom: 0;  /* this affects the margin in the printer settings */



    }



    table{
		white-space:nowrap;
        font-size: 8px;
		
    }
	
	table tr{
		height: 5px;
		padding-top:-3px;
		padding-bottom:-3px;
	}
	
	table tr th{
		height: 5px;
		white-space:nowrap;
	}

</style>



<div class="col">

    <br>

        <br>

        <p class="ok">PT. UTAMA DAMAI INDAH TIMBER</p><br>  

        <center>

            <h5>LAPORAN MONITORING UNIT</h5>



            <u>PERIODE <?php echo date('d',strtotime($_GET['tanggal'])); ?> <?php echo $bulannya[$from]; ?> <?php echo date('Y',strtotime($_GET['tanggal'])); ?> - <?php echo date('d',strtotime($_GET['tanggal2'])); ?> <?php echo $bulannya[$to]; ?> <?php echo date('Y',strtotime($_GET['tanggal2'])); ?></u>

        </center>

        <br>

        <?php 

        use App\User;

        use App\Unit;

        use App\MonitoringUnit;

        $no = 1;

        $unit = Unit::orderBy('kode','ASC')->get();
        if(isset($_GET['diketahui'])){
        $diketahui = User::find($_GET['diketahui']);
        }
        if(isset($_GET['disetujui_1'])){
        $disetujui_1 = User::find($_GET['disetujui_1']);
        }
        if(isset($_GET['disetujui_2'])){
        $disetujui_2_1 = User::find($_GET['disetujui_2'][0]);
        $disetujui_2_2 = User::find($_GET['disetujui_2'][1]);
        }
        if(isset($_GET['dibuat'])){
        $dibuat = User::find($_GET['dibuat']);
        }
        $tanggal = $_GET['tanggal'];

        $tanggal2 = $_GET['tanggal2'];

        $begin = new DateTime($_GET['tanggal']);

        $end = new DateTime($_GET['tanggal2']);

        $end->add(new DateInterval('P1D'));



        $interval = DateInterval::createFromDateString('1 day');

        $period = new DatePeriod($begin, $interval, $end);

        $arraydate = iterator_to_array($period);

        // var_dump($end->format("d"));

        // echo $arraydate[0]->format("d");

        ?>







        <table class="table table-bordered table-hover">

             

            <thead>

                <tr style="height:5px;padding:1px;">

                <th>No.</th>

                <th>Jenis <br> Unit</th>

                <th>Kode <br> Unit</th>

                @foreach($period as $p)

                    <?php 

                    

                    ?>

                    <td>{{ $p->format("d") }} </td>

                @endforeach



                <th>Operasi</th>

                <th>Standby</th>

                <th>Rusak</th>



            </tr>

            </thead>

                



                @foreach($unit as $u)



                <?php


                if(strpos($u->kode, '-') !== false && $u->kode != "Oprt. Chainsaw-01" && $u->kode != "Oprt. Chainsaw-02" && $u->kode != "ATK-26") {
                  



                    $o = 0;

                    $s = 0;

                    $r = 0;

                    $i = 0;

                    $monitoring = MonitoringUnit::where('unit_id', $u->id)->whereBetween('tanggal', [$tanggal,$tanggal2])->orderBy('tanggal','asc')->get();



                    

                ?>



                <tr>

                    <td>{{$no}}</td> <?php $no++ ?>

                    <td>{{ $u->jenis_unit->nama }}</td>

                    <td>{{ $u->kode }}</td>

                    @foreach($period as $index => $p )

                    

                    <?php

                    
					
                    if(isset($monitoring[$i]) && ($p->format("d")) == date("d", strtotime($monitoring[$i]->tanggal))){ 
					
					//if(isset($monitoring[$i])){ 


                    ?>

                    

                    <td @if($monitoring[$i]->libur == 1) style="background-color: red !important;" @endif ><strong>{{ @$monitoring[$i]->status[0] }}</strong></td>

                    

                    <?php 



                    if ($monitoring[$i]->status[0] == "o") {

                        $o++;

                    } else if ($monitoring[$i]->status[0] == "s") {

                        $s++;

                    } else if ($monitoring[$i]->status[0] == "r"){

                        $r++;

                    }



                    $i++; } else 

                    {



                    ?>

                    <td></td>



                    <?php } ?>

                   

                    @endforeach



                    <td>{{ $o }}</td>

                    <td>{{ $s }}</td>

                    <td>{{ $r }}</td>

                 </tr>


                 <?php } ?>

                @endforeach





            



        </table>





        <table style="width: 100%;text-align: center;">



            <tr>

                

                <td style="text-align: left">O = Operasional <br>S = Standby <br>R = Rusak</td>

            </tr>

            <tr>

                <td colspan="4" style="text-align: right;">BC Bunut-Pana'an, {{ date('d F Y') }}</td>



            </tr>

            <tr>
                @if(isset($diketahui))
                <td>Diketahui Oleh</td>
                @endif
                @if(isset($disetujui_1))
                <td>Dibenarkan I Oleh</td>
                @endif
                @if(isset($disetujui_2_1))
                <td>Dibenarkan II Oleh</td>
                @endif
                @if(isset($dibuat))
                <td>Dibuat Oleh</td>
                @endif
            </tr>

            <tr>

                <td colspan="4"><br><br><br><br></td>

            </tr>

            <tr>
                @if(isset($diketahui))
                <td>{{ $diketahui->nama }}<br>{{ $diketahui->jabatan->nama }}</td>
                @endif
                @if(isset($disetujui_1))
                <td>{{ $disetujui_1->nama }}<br>{{ $disetujui_1->jabatan->nama }}</td>
                @endif
                @if(isset($disetujui_2_1))
                <td>{{ $disetujui_2_1->nama }} / {{ $disetujui_2_1->nama }}<br>{{ $disetujui_2_1->jabatan->nama }} / {{ $disetujui_2_1->jabatan->nama }}</td>
                @endif
                @if(isset($dibuat))
                <td>{{ $dibuat->nama }}<br>{{ $dibuat->jabatan->nama }}</td>
                @endif
            </tr>

        </table>



</div>