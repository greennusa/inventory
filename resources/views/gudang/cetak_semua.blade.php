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
    
        body {
            margin:8px;
           
            
        }

        @media all {
        .page-break { display: none; }
        }

        @media print {
        .page-break { display: block; page-break-before: always; }
        }

    </style>

    <style type="text/css" media="print">
        @page {
            
            margin-right: 0;  /* this affects the margin in the printer settings */
            margin-left: 0;
            margin-top: 0;
        }

        
    </style>

<body onload="window.print()">
<div class="container">
	<table width="100%" >
						
						<tr>
							<td colspan="6" align="center"><h5>Gudang</h5><h5>PT.Utama Damai Indah Timber</h5></td>
						</tr>
						<tr>
							<td colspan="6"><br><br><br></td>
						</tr>
						
					</table>

 <table class="table table-bordered table-hover">
                        <tr>
                            <th>No</th>
                            <th>PO</th>
                            
                            <th>Kode Barang</th>
                            <th>Nama</th>
                            <th>Stok</th>

                            

                            <th>Satuan</th>

                            <th>Kode Unit</th>
                            
                            
                        </tr>
                        <?php 
                        $page = 0;
                        if(isset($_GET['page']) && $_GET['page'] > 1){
                            $page = $_GET['page']*10-10;
                        }
                        $no = 1*$page+1; 
                        use App\DetailPemesananBarang;
                        ?>
                        @foreach($tables as $data)
                        @if($data->gabungan == '' || $data->gabungan == null)
                            <tr>
                                <td><?php echo $no ?></td>
                                <td>{{ @$data->detail_bbm->bbm->pemesanan->nomor }}</td>
                               
                                <?php $db = DetailPemesananBarang::where('gabungan','like','%'.$data->gabungan_id.'%')->get();?>
                                <td><?php if(@$data->detail_bbm->detail_pemesanan->kode_barang != null || @$data->detail_bbm->detail_pemesanan->kode_barang != ''){ echo @$data->detail_bbm->detail_pemesanan->kode_barang; }else { echo $data->barang->kode; }?>
                                @if($data->gabungan_id != null || $data->gabungan_id != '')
                                    @foreach($db as $aa)
                                         / <?php echo $aa->barang->kode ?>
                                      @endforeach
                                @endif
                                </td>
                                <td><?php if(@$data->detail_bbm->detail_pemesanan->nama_barang != null || @$data->detail_bbm->detail_pemesanan->nama_barang != ''){ echo @$data->detail_bbm->detail_pemesanan->nama_barang; }else { echo $data->barang->nama; }?>
                                @if($data->gabungan_id != null || $data->gabungan_id != '')
                                    @foreach($db as $aa)
                                                                 / <?php echo $aa->barang->nama ?>
                                                                @endforeach
                                                                @endif
                                </td>
                                <td><?php echo $data->stok ?></td>

                                <td><?php echo @$data->detail_bbm->detail_pemesanan->detail_permintaan->satuan->nama ?></td>

                                <td><?php echo $data->barang->unit->kode ?></td>

                               
                                
                            </tr>
                            <?php $no++; ?>
                            @endif
                        @endforeach
                    </table>

                   
</div>
</body>	