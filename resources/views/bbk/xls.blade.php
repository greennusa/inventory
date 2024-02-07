<?php 
	$date = date('d/m/Y');
	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=bbk-".$r->nomor."- ".$date.".xls");
	header("Pragma: no-cache");
	header("Expires: 0");
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

    
                  
                    <br>
                    <br>
                    <br>
                    <br>
                    <center>
                        <h4>Nomor : <?php echo @$r->nomor ?></h4>
                        
                        <h6>Tanggal : <?php echo @$r->created_at->format('d-m-Y'); ?></h6>
                    </center>
                    <div style="clear: both;"></div>
                    <br>
                    <table  style="width: 100%;font-size: 10px;text-align: center;" border="1">
                                <thead>
                                    <tr>
                                        <th>NO</th>
                                        <th>NO PO</th>
                                        <th>NO OPB</th>
                                        <th>Kode Barang</th>
                                        <th>Nama Barang</th>
                                        
                                        <th>Kode Unit</th>
                                        <th>Supplier</th>
                                        <th>Halaman</th>
                                        <th>Indeks</th>
                                        <th>Keterangan</th>
                                        <th>Jumlah</th>
                                        <th>Satuan</th>
                                        <th>Harga</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no=1;
                                    $jml_total = 0;
                                      $total = 0;
                                      $jumlahItem = 0;
                                      $jumlahPengeluaran = 0; 
                                      $po = '';
                                      use App\DetailPemesananBarang;
                                      ?>
                                    <?php foreach ($r->detail as $d): ?>
                                        @if($d->gabungan == '' || $d->gabungan == null)
                                        <?php 

                                        //$db = DetailPemesananBarang::where('gabungan','like','%'.$d->gabungan_id.'%')->get();?>
                                        @if($po != $d->detail_bbm->detail_pemesanan->pemesanan->nomor)
                                        <tr>
                                            <input type="hidden" name="id[]" value="<?php echo $d->id ?>">
                                            <input type="hidden" name="barang_id[]" value="<?php echo $d->barang_id ?>">
                                            <td><?php echo $no++ ?></td>
                                            <td><?php echo $d->detail_bbm->detail_pemesanan->pemesanan->nomor ?></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                       
                                            <td> </td>
                                          
                                            <td>
                                               
                                            </td>
                                         
                                            
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>

                                        </tr>
                                        @endif
                                        <?php $po = $d->detail_bbm->detail_pemesanan->pemesanan->nomor; ?>
                                        <?php 

                                                
                                                    $jumlah_row = $d->jumlah*$d->harga;
                                                    ?>  
                                                       @if($d->gabungan == '' || $d->gabungan == null)
                                                        <tr>
                                                            
                                                            <td></td>
                                                            <td></td>
                                                            <td>{{ $d->detail_bbm->detail_pemesanan->detail_permintaan->permintaan->nomor }}</td>
                                                            <?php $db = \App\DetailPemesananBarang::where('gabungan','like','%'.$d->gabungan_id.'%')->get();?>
                                                            <td><?php if($d->detail_bbm->detail_pemesanan->kode_barang != null || $d->detail_bbm->detail_pemesanan->kode_barang != ''){ echo $d->detail_bbm->detail_pemesanan->kode_barang; }else { echo $d->barang->kode; }?>@foreach($db as $aa)
                                                                 / <?php echo $aa->barang->kode ?>
                                                                @endforeach</td>
                                                            <td><?php if($d->detail_bbm->detail_pemesanan->nama_barang != null || $d->detail_bbm->detail_pemesanan->nama_barang != ''){ echo $d->detail_bbm->detail_pemesanan->nama_barang; }else { echo $d->barang->nama; }?>@foreach($db as $aa)
                                                                 / <?php echo $aa->barang->nama ?>
                                                                @endforeach</td>
                                                           
                                                            <td><?php echo $d->barang->unit->kode ?></td>
                                                            <td>{{ $d->detail_bbm->detail_pemesanan->pemesanan->pemasok->nama }}</td>
                                                            <td><?php echo $d->barang->halaman ?></td>
                                                            <td><?php echo $d->barang->indeks ?></td>

                                                            <td><?php echo $d->keterangan ?></td>
                                                            <td>
                                                                <?php echo $d->jumlah ?>
                                                            </td>
                                                            
                                                            <td><?php echo $d->detail_bbm->detail_pemesanan->detail_permintaan->satuan->nama ?></td>
                                                            <td>
                                                                Rp.<?php echo number_format($d->harga) ?>
                                                            </td>
                                                            <td>Rp.{{ number_format($jumlah_row) }}</td>
                                                        </tr>
                                                        
                                                    <?php $jumlahItem += $d->jumlah; ?>
                                                    <?php $jumlahPengeluaran += ($d->jumlah * $d->harga); ?>
                                                    @endif
                                               

                                        @endif
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="10" align="right"><b>Total : </b></td>
                                    <td><b><center><?php echo $jumlahItem ?></center></b></td>
                                    <td colspan="6"><b>Rp. <?=number_format($jumlahPengeluaran)?></b></td>
                                </tr>
                            </tfoot>
                            </table>
                        <table width="100%" style="text-align: center;">
                            <tr style="height: 60px;">
                                    <td style="text-align: left;">
                                        Dikirim Melalui : 
                                        <?php echo $r->dikirim ?> 
                                        <br>
                                        Catatan : 
                                        <?php echo $r->keterangan ?>                           
                                    </td>
                                    
                                </tr>
                                <tr>
                                    
                                    
                                    <td colspan="4" center>Mengetahui</td>
                                    <td colspan="4" center>Pengantar</td>
                                    <td colspan="4" center>Penerima</td>
                                    <td colspan="4" center>Pengirim</td>
                                </tr>
                                <tr style="height: 100px">
                                    
                                    <td colspan="4" center>&nbsp;</td>
                                    <td colspan="4" center>&nbsp;</td>
                                    <td colspan="4" center>&nbsp;</td>
                                    <td colspan="4" center>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="4" center>{{ $r->mengetahui_user->nama }}
                                        
                                    </td>
                                    <td colspan="4" center>{{ $r->pengantar }}
                                        
                                    </td>
                                    <td colspan="4" center>{{ $r->penerima_user->nama }}
                                        
                                    </td>
                                    <td colspan="4" center>{{ $r->pengirim_user->nama }}
                                        
                                    </td>
                                </tr>
                        </table>
                        
                    

         

</body>
</html>

