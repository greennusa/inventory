<?php 
        
        $tahun = $_GET['tahun'];
        $bulannya = ['array_bulan','JANUARI','FEBRUARI','MARET','APRIL','MEI','JUNI','JULI','AGUSTUS','SEPTEMBER','NOVEMBER','OKTOBER','DESEMBER'];  
        ?>

        <?php 


        $date = date('d/m/Y');
    header("Content-type: application/vhd.ms-word");
    header("Content-Disposition: attachment; filename=Rekap-Pemakaian-Grafik-".$tahun.".doc");
    header("Pragma: no-cache");
    header("Expires: 0");
 ?>

<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Monitoring Periode Tahun <?php echo $_GET['tahun'] ?></title>

        <!-- Fonts -->
        <link rel="stylesheet" type="text/css" href="{{ asset('bootstrap/theme/16/bootstrap.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('selectbox/css/bootstrap-select.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('jquery-ui/jquery-ui.min.css') }}">




        <script src="{{ asset('jquery/jquery-1.11.3.min.js') }}"></script>
        <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('selectbox/js/bootstrap-select.min.js') }}"></script>
        <script src="{{ asset('jquery-ui/jquery-ui.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap-notify.min.js') }}" ></script>
        <script src="{{ asset('node_modules/chart.js/dist/Chart.js') }}"></script>
    </head>
    <style type="text/css">
      .lds-ring {
          display: inline-block;
          position: relative;
          width: 64px;
          height: 64px;
        }
        .lds-ring div {
          box-sizing: border-box;
          display: block;
          position: absolute;
          width: 51px;
          height: 51px;
          margin: 6px;
          border: 6px solid blue;
          border-radius: 50%;
          animation: lds-ring 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
          border-color: #147CA8 transparent transparent transparent;
        }
        .lds-ring div:nth-child(1) {
          animation-delay: -0.45s;
        }
        .lds-ring div:nth-child(2) {
          animation-delay: -0.3s;
        }
        .lds-ring div:nth-child(3) {
          animation-delay: -0.15s;
        }
        @keyframes lds-ring {
          0% {
            transform: rotate(0deg);
          }
          100% {
            transform: rotate(360deg);
          }
        }
    </style>
    <body>
      <div style="width: 100vw;height: 100vh;background-color: rgba(160,160,160,0.7);padding-top: 40VH; position: fixed; z-index: 99999999;" id="loading-list-menu">
        <center>
            <div class="lds-ring" ><div></div><div></div><div></div><div></div>
            </div>
        </center>
        
    </div>
      <div class="row">
       <div class="col-md-10 col-md-offset-1">
           <div class="panel panel-default">
               <div class="panel-heading"><center><b>Monitoring Penerimaan & Pemakaian Spare Part / Material Bangunan,BBM Pelumas<br>PT.UTAMA DAMAI INDAH TIMBER - BC BUNUT PANA'AN <br> <u>TAHUN {{ $_GET['tahun'] }}</u></b>  </center></div>
               <div class="panel-body">
                   <canvas id="canvas" height="150" width="600"></canvas>
                   <table class="table table-bordered table-hover">
                     <tr>
                       <th rowspan="2">SPARE PART</th>
                       <th  colspan="12"></th>

                     </tr>
                     <tr>
                       <th>January</th>
                        <th>Februari</th>
                        <th>Maret</th>
                        <th>April</th>
                        <th>Mei</th>
                        <th>Juni</th>
                        <th>Juli</th>
                        <th>Agustus</th>
                        <th>September</th>
                        <th>Oktober</th>
                        <th>November</th>
                        <th>Desember</th>
                     </tr>

                     <tr>
                       <td>
                         PENERIMAAN
                       </td>

                       <?php 
                       @$tahun = $_GET['tahun'];
                       use App\User;
                        @$diketahui = User::findOrFail($_GET['diketahui']);
                        @$dibuat = User::findOrFail($_GET['dibuat']);
                         @$result = \App\DetailBuktiBarangKeluar::whereHas('bbk',function ($q) use ($tahun) {
                                $q->whereYear('tanggal',$tahun);
                            })->get();
                          @$total_col = [0,0,0,0,0,0,0,0,0,0,0,0];
                          foreach ($result as $value) {
                               @$d = \App\DetailBuktiBarangKeluar::whereHas('bbk',function ($q) use ($tahun) {
                                $q->whereYear('tanggal',$tahun);
                            })->get();
                               $total = 0;   
                                  for ($i=0; $i < count($total_col) ; $i++) { 
                                      @$total = 0;

                                      foreach($d as $dd){
                                          if( date('m',strtotime($dd->bbk->tanggal)) == $i){
                                              @$total+=(int)$dd->harga*$dd->jumlah;
                                              @$total_col[$i-1] += $total;
                                          }
                                      }

                                  }  
                                ?>
                               

                                <?php
                                              
                          }

                        ?>
                        <td>{{$total_col[0]}}</td>
                        <td>{{$total_col[1]}}</td>
                        <td>{{$total_col[2]}}</td>
                        <td>{{$total_col[3]}}</td>
                        <td>{{$total_col[4]}}</td>
                        <td>{{$total_col[5]}}</td>
                        <td>{{$total_col[6]}}</td>
                        <td>{{$total_col[7]}}</td>
                        <td>{{$total_col[8]}}</td>
                        <td>{{$total_col[9]}}</td>
                        <td>{{$total_col[10]}}</td>
                        <td>{{$total_col[11]}}</td>
                       
                     </tr>

                     <tr>
                       <td>PEMAKAIAN</td>
                       <?php 
                        use App\DetailPemakaianBarang;
                        use App\DetailPemakaianBarangLama;
                        $total_col = [0,0,0,0,0,0,0,0,0,0,0,0];

                         $result = DetailPemakaianBarang::whereHas('pemakaian',function ($q) use ($tahun) {
                                $q->whereYear('tanggal',$tahun);
                            })->get()->toBase()->merge(DetailPemakaianBarangLama::whereHas('pemakaian',function ($q) use ($tahun) {
                                $q->whereYear('tanggal',$tahun);
                            })->get());

                          foreach ($result as $value) {
                               $d = DetailPemakaianBarang::whereHas('pemakaian',function ($q) use ($tahun) {
                                                  $q->whereYear('tanggal',$tahun);
                                              })->where('barang_id',$value->barang->id)->get()->toBase()->merge(DetailPemakaianBarangLama::whereHas('pemakaian',function ($q) use ($tahun) {
                                                  $q->whereYear('tanggal',$tahun);
                                              })->where('barang_id',$value->barang->id)->get());$total = 0;   
                                  for ($i=0; $i < count($total_col) ; $i++) { 
                                      $total = 0;

                                      foreach($d as $dd){
                                          if(date('m',strtotime($dd->pemakaian->tanggal)) == $i){
                                              $total+=(int)(@$dd->detail_bbk->harga+@$dd->camp_lama->harga)*$dd->jumlah;
                                              $total_col[$i-1] += $total;
                                          }
                                      }

                                  }
                                              
                          }
                        ?>
                        <td>{{$total_col[0]}}</td>
                        <td>{{$total_col[1]}}</td>
                        <td>{{$total_col[2]}}</td>
                        <td>{{$total_col[3]}}</td>
                        <td>{{$total_col[4]}}</td>
                        <td>{{$total_col[5]}}</td>
                        <td>{{$total_col[6]}}</td>
                        <td>{{$total_col[7]}}</td>
                        <td>{{$total_col[8]}}</td>
                        <td>{{$total_col[9]}}</td>
                        <td>{{$total_col[10]}}</td>
                        <td>{{$total_col[11]}}</td>
                     </tr>
                   </table>

                   <br>
                    <br>

                    <table style="width: 100%;text-align: center;" >
                      <tr>
                        <td colspan="2" style="text-align: right;">{{ date('d F Y') }}</td>
                      </tr>
                      <tr><td colspan="2"><br><br><br><br></td></tr>
                        <tr>
                            <td>Diketahui Oleh</td>

                            <td>Dibuat Oleh</td>
                        </tr>
                        <tr>
                            <td colspan="2"><br><br><br><br></td>
                        </tr>
                        <tr>
                            <td>{{ $diketahui->nama }}<br>{{ $diketahui->jabatan->nama }}</td>
                            
                            <td>{{ $dibuat->nama }}<br>{{ $dibuat->jabatan->nama }}</td>
                        </tr>
                    </table>
               </div>
           </div>
       </div>
     </div>
        
        <script>
        var url = "{{url('stock/get_penerimaan_per_bulan/?tahun='.$_GET['tahun'])}}";
        var url2 = "{{url('stock/get_total_per_bulan/?tahun='.$_GET['tahun'])}}";
        var tanggal = new Array();
        var nama = new Array();
        var jumlah = new Array();
        var total_per_bulan = new Array();
        var penerimaan_per_bulan = new Array();
        $(document).ready(function(){
          
          $.get(url, function(response){
            response.forEach(function(data){
                penerimaan_per_bulan.push(data);
            });
            
          });

          $.get(url2, function(response){
            response.forEach(function(data){
                total_per_bulan.push(data);

            });
          });

          
          


          var ctx = document.getElementById("canvas").getContext('2d');
              
          window.setTimeout(function (){
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels:['JANUARI','FEBRUARI','MARET','APRIL','MEI','JUNI','JULI','AGUSTUS','SEPTEMBER','OKTOBER','NOVEMBER','DESEMBER'],
                    datasets: [{
                        label: 'PEMAKAIAN',
                        backgroundColor: "red",
                        data: total_per_bulan,
                        borderWidth: 1
                    },{
                        label: 'PENERIMAAN',
                        backgroundColor: "blue",
                        data: penerimaan_per_bulan,
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero:true
                            }
                        }]
                    }
                }
            });
            $('#loading-list-menu').hide();
           
          },3000);

          window.setTimeout(function (){
           
            window.print();
           
          },4000);


              
        });


        </script>
    </body>
</html>