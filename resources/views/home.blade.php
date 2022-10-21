@extends('layouts.app')

@section('content')
<div class="table-responsive" style="margin:10px;">
        <table border="0">
            <tr>
                <td></td>
                <td></td>
                <td><a href="<?php echo url('monitoring') ?>" class="btn btn-default btn-block">
                        <img src="<?php echo url("images/icon/clipboard_full.png") ?>"> 
                        Monitoring Unit
                    </a></td>
            </tr>

            <tr>
                <td></td>
                <td></td>
                <td>
                   <img src="<?php echo url("images/arrow/16.png") ?>">  
                </td>
            </tr>


            <tr>
                <td>
                    <a href="<?php echo url("type_unit") ?>" class="btn btn-default btn-block">
                        <img src="<?php echo url("images/icon/bookmark.png") ?>"> 
                        Jenis Unit
                    </a>
                </td>
                <td><img src="<?php echo url("images/arrow/4.png") ?>"></td>
                <td>
                    <a href="<?php echo url("unit") ?>" class="btn btn-default btn-block">
                        <img src="<?php echo url("images/icon/bookmark.png") ?>"> 
                        Kode Unit
                    </a>
                </td>
                <td>
                    <img src="<?php echo url("images/arrow/14.png") ?>">
                </td>
                <td>
                    <a href="<?php echo url("purchase_request") ?>" class="btn btn-default btn-block">
                        <img src="<?php echo url("images/icon/folder_add.png") ?>"> 
                        Permintaan Barang
                    </a>
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td>
                    
                </td>
                
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td>
                    <img src="<?php echo url("images/arrow/15.png") ?>">
                </td>
                <td>
                    <img src="<?php echo url("images/arrow/3.png") ?>">
                </td>
                <td>
                    <img src="<?php echo url("images/arrow/15.png") ?>">
                </td>
                <td>
                    
                </td>
                <td></td>
                <td></td>
                <td>
                    
                </td>
               
            </tr>
            <tr>
                <td>
                    <a href="<?php echo url("category") ?>" class="btn btn-default btn-block">
                        <img src="<?php echo url("images/icon/bookmark.png") ?>"> 
                        Kategori
                    </a>
                </td>
                <td><img src="<?php echo url("images/arrow/4.png") ?>"></td>
                <td>
                    <a href="<?php echo url("item") ?>" class="btn btn-default btn-block">
                        <img src="<?php echo url("images/icon/bookmark.png") ?>"> 
                        Barang
                    </a>
                </td>
                <td>
                    <img src="<?php echo url("images/arrow/7.png") ?>">
                </td>
                <td>
                    <a href="<?php echo url("set_supplier") ?>" class="btn btn-default btn-block">
                        <img src="<?php echo url("images/icon/bookmark.png") ?>"> 
                        Atur Supplier
                    </a>
                </td>
                <td>
                    <img src="<?php echo url("images/arrow/17.png") ?>">
                </td>
                <td>
                    <a href="<?php echo url("supplier") ?>" class="btn btn-default btn-block">
                        <img src="<?php echo url("images/icon/user.png") ?>"> 
                        Supplier
                    </a>
                </td>
                <td></td>
                <td>
                    
                </td>
                  
            </tr>
            <tr>
                <td></td>
                <td>
                    
                </td>
                <td>
                    <img src="<?php echo url("images/arrow/16.png") ?>">
                </td>
                <td></td>
                <td>
                    <img src="<?php echo url("images/arrow/15.png") ?>">
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td>
                    
                </td>
                
            </tr>


            <tr>
                <td>
                    
                </td>
                <td>
                   
                </td>
                <td>
                    <a href="<?php echo url("satuan") ?>" class="btn btn-default btn-block">
                        <img src="<?php echo url("images/icon/bookmark.png") ?>"> 
                        Satuan
                    </a>
                </td>
                <td></td>
                <td>
                    <a href="<?php echo url("approval") ?>" class="btn btn-default btn-block">
                        <img src="<?php echo url("images/icon/bookmark.png") ?>"> 
                        Persetujuan
                    </a>
                </td>
                <td>
                    <img src="<?php echo url("images/arrow/4.png") ?>">
                </td>
                <td>
                    <a href="<?php echo url("order") ?>" class="btn btn-default btn-block">
                        <img src="<?php echo url("images/icon/bookmark.png") ?>"> 
                        Pesanan Pembelian
                    </a>
                </td>
                <td>
                    <img src="<?php echo url("images/arrow/4.png") ?>">
                </td>
                <td>
                    <a href="<?php echo url("item_in") ?>" class="btn btn-default btn-block">
                        <img src="<?php echo url("images/icon/folder_add.png") ?>"> 
                        Bukti Barang Masuk
                    </a>
                </td>
                
            </tr>

            <tr>
                <td></td>
                <td></td>
                <td>
                    
                </td>
                <td></td>
                <td>
                    
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td>
                    <img src="<?php echo url("images/arrow/15.png") ?>">
                </td>
               
            </tr>

            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>
                    <a href="<?php echo url('retur_item') ?>" class="btn btn-default btn-block">
                        <img src="<?php echo url("images/icon/clipboard_full.png") ?>"> 
                        Retur Pemakaian
                    </a>
                </td>
                <td></td>
                <td>
                    <a href="<?php echo url('retur_camp') ?>" class="btn btn-default btn-block">
                        <img src="<?php echo url("images/icon/clipboard_full.png") ?>"> 
                        Retur Camp
                    </a>
                </td>
                <td></td>
                <td>
                    <a href="<?php echo url('warehouse') ?>" class="btn btn-default btn-block">
                        <img src="<?php echo url("images/icon/bookmark.png") ?>"> 
                        Gudang
                    </a>
                </td>
                <td>
                    <img src="<?php echo url("images/arrow/4.png") ?>">
                </td>
                <td>
                    <a href="<?php echo url('warehouse_use') ?>" class="btn btn-default btn-block">
                        <img src="<?php echo url("images/icon/bookmark.png") ?>"> 
                        Pemakaian Gudang
                    </a>
                </td>
               
            </tr>

            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>
                   <img src="<?php echo url("images/arrow/16.png") ?>"> 
                </td>
                
                <td></td>
                <td>
                    <img src="<?php echo url("images/arrow/16.png") ?>"> 
                </td>
                <td></td>
                <td>
                    <img src="<?php echo url("images/arrow/15.png") ?>">
                </td>
               
            </tr>
            
            <tr>
                <td></td>
                <td></td>
                <td>
                    <a href="<?php echo url('report') ?>" class="btn btn-default btn-block">
                        <img src="<?php echo url("images/icon/folder_add.png") ?>"> 
                        Laporan
                    </a>
                </td>
                <td><img src="<?php echo url("images/arrow/17.png") ?>"></td>
                <td>
                    <a href="<?php echo url('item_use') ?>" class="btn btn-default btn-block">
                        <img src="<?php echo url("images/icon/bookmark.png") ?>"> 
                        Pemakaian
                    </a>
                </td>
                <td>
                    <img src="<?php echo url("images/arrow/17.png") ?>">
                </td>
                <td>
                    <a href="<?php echo url('warehouse_udit') ?>" class="btn btn-default btn-block">
                        <img src="<?php echo url("images/icon/bookmark.png") ?>"> 
                        Camp
                    </a>
                </td>
                <td>
                    <img src="<?php echo url("images/arrow/17.png") ?>">
                </td>
                <td>
                    <a href="<?php echo url("item_out") ?>" class="btn btn-default btn-block">
                        <img src="<?php echo url("images/icon/folder_add.png") ?>"> 
                        Bukti Barang Keluar
                    </a>
                </td>
                
            </tr>

            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td><img src="<?php echo url("images/arrow/16.png") ?>"> </td>
            </tr>

            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td><a href="<?php echo url('camp_list') ?>" class="btn btn-default btn-block">
                        <img src="<?php echo url("images/icon/bookmark.png") ?>"> 
                        Dapur
                    </a> 
                </td>
            </tr>
        </table>
    </div>
@endsection
