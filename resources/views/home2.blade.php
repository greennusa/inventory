@extends('layouts.app')

@section('content')

 
<!-- <h1 class="page-header"><?php // echo lang('apps_home_welcome') ?></h1> -->
    <div class="table-responsive" style="margin:10px;">
        <table border="0">
            <tr>
                <td></td>
                <td></td>
                <td>
                    <a href="<?php echo url("brand") ?>" class="btn btn-default btn-block">
                        <img src="<?php echo url("images/icon/bookmark.png") ?>"> 
                        Merek
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
                <td>
                    <img src="<?php echo url("images/arrow/4.png") ?>">
                </td>
                <td>
                    <a href="<?php echo url('warehouse_udit') ?>" class="btn btn-default btn-block">
                        <img src="<?php echo url("images/icon/bookmark.png") ?>"> 
                        Camp
                    </a>
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
                    <img src="<?php echo url("images/arrow/16.png") ?>">
                </td>
                <td>
                    
                </td>
                <td>
                    <img src="<?php echo url("images/arrow/15.png") ?>">
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
                <td>
                    
                </td>
                <td>
                    <a href="<?php echo url('item_use') ?>" class="btn btn-default btn-block">
                        <img src="<?php echo url("images/icon/bookmark.png") ?>"> 
                        Pemakaian
                    </a>
                </td>   
            </tr>
            <tr>
                <td></td>
                <td></td>
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
                    <img src="<?php echo url("images/arrow/16.png") ?>">
                </td>
                <td>
                    
                </td>
                <td>
                    <img src="<?php echo url("images/arrow/15.png") ?>">
                </td>
            </tr>


            <tr>
                <td></td>
                <td></td>
                <td>
                    <a href="<?php echo url("unit") ?>" class="btn btn-default btn-block">
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
                <td></td>
                <td><a href="<?php echo url('report') ?>" class="btn btn-default btn-block">
                        <img src="<?php echo url("images/icon/folder_add.png") ?>"> 
                        Laporan
                    </a></td>
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
                <td>
                    
                </td>
                <td>
                    
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
                    <a href="<?php echo url('warehouse') ?>" class="btn btn-default btn-block">
                        <img src="<?php echo url("images/icon/bookmark.png") ?>"> 
                        Gudang
                    </a>
                </td>
                <td>
                    
                </td>
                <td>
                    
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
                <td>
                    
                </td>
                <td>
                    
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
                    <a href="<?php echo url("item_out") ?>" class="btn btn-default btn-block">
                        <img src="<?php echo url("images/icon/folder_add.png") ?>"> 
                        Bukti Barang Keluar
                    </a>
                </td>
                <td>
                    
                </td>
                <td>
                    
                </td>
            </tr>
        </table>
    </div>

@endsection
