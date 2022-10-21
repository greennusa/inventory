<?php 
    header("Content-type:application/vhd.ms-excel");
    header("Content-disposition:attachment;filename=pemesanan_barang-".$r->nomor."-".$r->tanggal.".xls"); 
    ?>

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{$r->nomor."-".$r->tanggal}}</title>

    <!-- Styles -->
    
    <link rel="stylesheet" type="text/css" href="{{ asset('bootstrap/theme/16/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('selectbox/css/bootstrap-select.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('jquery-ui/jquery-ui.min.css') }}">




    <script src="{{ asset('jquery/jquery-1.11.3.min.js') }}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('selectbox/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-notify.min.js') }}" ></script>

    <style type="text/css">
        th,td {
            padding: 5px;
        }
    </style>
    <style type="text/css">
        body {
            margin:8px;
           
            
        }

    </style>

    <style type="text/css" media="print">
        @page {
            
            margin-right: 0;  /* this affects the margin in the printer settings */
            margin-left: 0;
            margin-top: 0;
        }

        
    </style>



</head>
<body onload="window.print()">
<div class="container" >
    <div class="row" style="margin:0;padding: 0;">
        <div class="col-md-12"  style="margin:0;padding: 0;">
            <div class="panel panel-default"  style="border: none;margin:0;padding: 0;">
               

                <div class="panel-body" style="border: none;margin:0;padding: 0;">
                    

                    <table>
                        <tr>
                            <td colspan="4"></td>
                            <td><label for="nama" class="col-lg-12 control-label" style="text-align: left;font-size: 16px;"><strong>Purchase Order</strong></label></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="4"></td>
                            <td><label for="nama" class="col-lg-12 control-label" style="text-align: left;font-size: 16px;">Nomor Pemesanan : {{ $r->nomor }}</label></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="4"></td>
                            <td><label for="nama" class="col-lg-12 control-label" style="text-align: left;font-size: 16px;">Tanggal Pemesanan : {{ $r->tanggal }}</label></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="4"></td>
                            <td><label for="supplier_id" class="col-lg-12 control-label" style="text-align: left;font-size: 16px;">Supplier Barang : {{ $r->pemasok->nama }}</label></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="4"></td>
                            <td><label for="supplier_id" class="col-lg-12 control-label" style="text-align: left;font-size: 16px;">Dikirim Ke : {{ $r->dikirim }}</label></td>
                            <td></td>
                        </tr>
                    </table>
                    
            
                    
                    
                        
                        <table style="width: 100%;text-align: center;" border="1">
                            <thead>
                                <tr>
                                   
                                    <th>#</th>
                                   
                                    <th>Nama Barang</th>
                                    <th>Kode Barang</th>
                                   
                                    
                                   
                                    <th >Qty</th>
                                    
                                    <th >Harga Satuan</th>
                                    <th>Total</th>
                                    
                                   
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                use App\DetailPemesananBarang;
                                $no=1;
                                $jml_total = 0;
                                      $total = 0;
                                      $jumlahItem = 0;
                                      $jumlahPengeluaran = 0;
                                      $opb = 0;
                                 ?>

                                <?php foreach ($r->detail as $d): ?>
                                    @if($d->gabungan == '' || $d->gabungan == null)
                                    <?php $total_row = $d->jumlah*$d->harga; ?>
                                    <?php if($opb != $d->detail_permintaan->permintaan->id) { ?>
                                    <tr>
                                        <td colspan="6">Keperluan : <?php if($d->pemesanan->keperluan == null): echo $d->detail_permintaan->permintaan->keperluan; else: echo $d->pemesanan->keperluan; endif;?></td>
                                    </tr>
                                    <?php $opb = $d->detail_permintaan->permintaan->id; } ?>
                                    <tr>
                                        
                                            
                                           
                                           
                                            <td><?php echo $no ?></td>
                                           
                                            <?php $db = DetailPemesananBarang::where('gabungan','like','%'.$d->detail_gabungan.'%')->get();?>
                                            <td>@if($d->nama_barang == null){{ $d->barang->nama }}@else{{ $d->nama_barang }}<?php endif; ?>@if($d->detail_gabungan != null || $d->detail_gabungan != '')@foreach($db as $aa)/<?php echo $aa->barang->nama ?>@endforeach @endif</td>
                                            <td>@if($d->kode_barang == null){{ $d->barang->kode }}@else{{ $d->kode_barang }}<?php endif; ?>@if($d->detail_gabungan != null || $d->detail_gabungan != '')@foreach($db as $aa)/<?php echo $aa->barang->kode ?>@endforeach @endif</td>
                                            
                                     
                                            
                                            <td>
                                               <?php echo $d->jumlah ?> <?php echo $d->barang->satuan->nama ?>
                                                
                                                
                                            </td>
                                      
                                            <td>
                                                Rp. <?=number_format($d->harga) ?>
                                            </td>
                                            <td>Rp. <?=number_format($total_row) ?></td>
                                            
                                            
                                        
                                    </tr>
                                    <?php $no++ ?>
                                    <?php $jumlahItem += $d->jumlah; ?>
                                    <?php $jumlahPengeluaran += ($d->jumlah * $d->harga); ?>
                                    @endif
                                <?php endforeach ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" align="right"><b>Total : </b></td>
                                    <td><b><center><?php echo $jumlahItem ?></center></b></td>
                                    <td colspan="2"><b>Rp. <?=number_format($jumlahPengeluaran)?></b></td>
                                </tr>
                            </tfoot>
                        </table>
                        <br>
                        <table border="1">
                            <tr>
                                <td >Keterangan : <br> {{ $r->keterangan }} </td>
                            </tr>
                        </table>
                        <br>
                        <br>
                        <table  border="0" cellpadding="5" cellspacing="0" width="100%" style="text-align: center;">
                           
                            <tr style="border: none;margin-top: 50px;">
                                <td colspan="2">Yang Menyetujui</td>
                                <td colspan="2">Yang Mengetahui</td>
                                <td colspan="2">Yang Memesan</td>
                            </tr>
                            <tr>
                                <td colspan="6"><br><br><br></td>
                            </tr>
                            <tr style="border: none;">
                                <td colspan="2"><br><br><br>{{ $r->menyetujui_user->nama }}</td>
                                <td colspan="2"><br><br><br>{{ $r->mengetahui_user->nama }}</td>
                                <td colspan="2"><br><br><br>{{ $r->memesan_user->nama }}</td>
                            </tr>
                        </table>
                        
                    

                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>