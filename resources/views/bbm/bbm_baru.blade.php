@extends('layouts.app')

@section('content')
<div class="container" >
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Tambah BBM</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ url('item_in/'.$pemesanan->id.'/buat_bbm') }}">
                        {{ csrf_field() }}
                       
                        <div class="form-group">
                            <label for="tanggal" class="col-lg-2 control-label">Tanggal</label>
                            <div class="col-lg-3">
                                <input type="date" class="form-control datepickers" name="tanggal" id="tanggal" placeholder="Tanggal" required >
                            </div>
                        </div>
                        
                        <input type="hidden" name="pemesanan_barang_id" value="{{ $pemesanan->id }}">
                            
                            
                        <div class="form-group">
                            <label for="keterangan" class="col-lg-2 control-label">Keterangan</label>
                            <div class="col-lg-3">
                                <input type="text"  class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan" >
                            </div>
                        </div>

                        <div class="form-group">

                            <div class="col-lg-10 col-lg-offset-2">

                                <input type=button value=Batal class="btn btn-default" onclick=self.history.back()>

                                <button type="submit" class="btn btn-primary">Simpan</button>

                            </div>

                        </div>
                        
                        <div id="list-barang">
                            
                        </div>
                        @if ($errors->has('barang_id'))
                            <span class="help-block">
                                <strong>{{ $errors->first('barang_id') }}</strong>
                            </span>
                        @endif
                    </form>

                    

                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#loading-list-menu').show();
        $.ajax({
            url: '<?php echo url('ajax/get_detail_pemesanan/') ?>/{{ $pemesanan->id }}',
            type: 'GET',
            success: function(data) {
                $("#list-barang").html(data);
                
                $('#loading-list-menu').hide();
            }
           
        }).fail(function() {
            $("#list-barang").html('');
        }).always(function() {
            $('#loading-list-menu').hide();
        });
    $('.input_sn').keypress(function(event) {
        if (event.keyCode == 13) {
            event.preventDefault();
            var index = $('.input_sn').index(this) + 1;
            $('.input_sn').eq(index).focus();
        }
    });

    function randomcode() {
        var text = "";
        var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

        for (var i = 0; i < 6; i++)
            text += possible.charAt(Math.floor(Math.random() * possible.length));

        return text;
    }
</script>
@endsection
