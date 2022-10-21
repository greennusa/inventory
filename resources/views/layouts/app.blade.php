<?php 
    use App\Notifikasi;
    use App\BuktiBarangKeluar;
    use App\PermintaanBarang;
    date_default_timezone_set("Asia/Kuala_Lumpur");
    use Illuminate\Support\Collection;
   
 ?>
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Aplikasi Inventory</title>

    <!-- Styles -->
    
    <link rel="stylesheet" type="text/css" href="{{ asset('bootstrap/theme/16/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('selectbox/css/bootstrap-select.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('jquery-ui/jquery-ui.min.css') }}">




    <script src="{{ asset('jquery/jquery-1.11.3.min.js') }}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('selectbox/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-notify.min.js') }}" ></script>
    <script src="{{ asset('node_modules/chart.js/dist/Chart.js') }}"></script>
    <script type="text/javascript">
        $('.selectpicker').selectpicker();

        $('.selectpicker').on('changed', function (e) {
            var options = $('.selectpicker option:selected');
            var selected = [];

            $(options).each(function(){
                selected.push( $(this).text() ); 
                // or $(this).val() for 'id'
            });
            console.log(selected);

            // write value to some field, etc
        });
    </script>
    <script>
        $(function() {
            $( ".datepicker" ).datepicker({ altFormat: 'yy-mm-dd' });
            $( "#format" ).change(function() {
                $( "#datepicker" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
            });
        });
    </script>
    <script type="text/javascript">
        $(function() {
            $('.date-picker').datepicker( {
                changeMonth: true,
                changeYear: true,
                showButtonPanel: true,
                dateFormat: 'yy-mm-dd',
                onClose: function(dateText, inst) { 
                    var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                    var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                    $(this).datepicker('setDate', new Date(year, month, 1));
                }
            });
        });
    </script>
    <style>
        .ui-datepicker-calendar {
            display: none;
        }
    </style>
    <style type="text/css">
    
        .modal-dialog {
            width: 80%;
        }
        .zoom {
            width: 100px;
            transition: transform .2s; /* Animation */
            background-color: white;
            display: inline-block;

          }

          .zoom:hover {
            transform: scale(2);
            z-index: 9999;
          }

        .help-block {
            color: red;
        }

        #gambar{

            float: right; margin-top: -40%; margin-right: auto;

            max-width: 40%;

            max-height: 30%;

        }

        @media screen and (max-width: 1199px) {

          #gambar {

            float: none;

            margin-top: 5px;

            margin-bottom: 5px;

          }

        }

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

    <style type="text/css" media="print">
    @page {
        size: auto;   /* auto is the initial value */
        margin-bottom: 0;  /* this affects the margin in the printer settings */
    }
    </style>


</head>
<body onload="$('#loading-list-menu').hide();">
    <div style="width: 100vw;height: 100vh;background-color: rgba(160,160,160,0.7);padding-top: 40VH; position: fixed; z-index: 99999999;" id="loading-list-menu">
        <center>
            <div class="lds-ring" ><div></div><div></div><div></div><div></div>
            </div>
        </center>
        
    </div>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        Aplikasi Inventory
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                                
                        @else
                        <?php 
                            $data1 = new Collection(PermintaanBarang::select('id','nomor')->where('setuju',0)->get());
                            $data1 = $data1->map(function ($item) {
                                $item['menu'] = 'Permintaan';
                                $item['jenis'] = 1;
                                return $item;
                            });



                            $data2 = new Collection(BuktiBarangKeluar::select('id','nomor')->where('status',0)->get());
                            $data2 = $data2->map(function ($item) {
                                $item['menu'] = 'Bukti Barang Keluar';
                                $item['jenis'] = 2;
                                return $item;
                            });


                                $cc = BuktiBarangKeluar::select('id','nomor')->where('status',0)->orderBy('created_at','DESC')->count() + PermintaanBarang::where('setuju',0)->orderBy('created_at','DESC')->count();
                               
                                $data1 = $data1->merge($data2);

                                $notif = $data1->sortByDesc('created_at');
                            
                         ?>
                            <li class="dropdown" >
                                <a href="#" class="dropdown-toggle" title="Notifikasi BBM yang belum lengkap" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ $cc }}  &nbsp;<span class="glyphicon glyphicon-bullhorn" aria-hidden="true"></span></a>
                                
                                <ul class="listitems dropdown-menu " style="max-height: 200px;overflow-y: scroll;">
                                    <?php if($cc == 0){
                                        ?>
                                            <li><a href="#">Tidak ada notifikasi</a></li>
                                        <?php
                                    } else {
                                        $x = 0;
                                         foreach ($notif as $d) {
                                                if($d->jenis == 1){
                                                ?>
                                                    <li data-position="{{ $d->created_at }}"><a href="{{ url('approval/'.$d->id.'?page=1') }}">Permintaan {{ $d->nomor }} Belum Diproses</a></li>
                                                    <?php
                                                } elseif($d->jeni == 2){
                                                    
                                                    ?>
                                                    <li data-position="{{ $d->created_at }}"><a href="{{ url('warehouse_udit/create') }}">Bukti Barang Keluar {{ $d->nomor }} Belum Diproses</a></li>
                                                    <?php
                                                }
                                                
                                                $x++;
                                            } 
                                        
                                    }?>
                                           
                                </ul>
                                
                            </li>
                            <li><a href="{{ url('/home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> Home</a></li>
                            <li><a href="{{ url('/report') }}"><span class="glyphicon glyphicon-file" aria-hidden="true"></span> Laporan</a></li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    <span class="glyphicon glyphicon-cog" aria-hidden="true"></span> {{ Auth::user()->nama }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="{{ url('user/'.Auth::user()->id.'/edit'.'?page=1') }}"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Pengaturan Akun</a></li>
                                    <li><a href="{{ url('log_user/'.Auth::user()->id) }}"><span class="glyphicon glyphicon-globe" aria-hidden="true"></span> Aktivitas Saya</a></li>
                                    <li class="divider"></li>

                                    <li><a href="{{ url('user') }}"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Pengguna</a></li>
                                    
                                    <li><a href="{{ url('group') }}"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Group</a></li>

                                    <li><a href="{{ url('job') }}"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Jabatan</a></li>
                                    <li class="divider"></li>

                                    <li><a href="{{ url('lokasi') }}"><span class="glyphicon glyphicon-move" aria-hidden="true"></span> Lokasi</a></li>

                                    <li><a href="{{ url('backup') }}"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> Backup Database</a></li>
                                    <li class="divider"></li>

                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                           <span class="glyphicon glyphicon-off" aria-hidden="true"></span> Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
        @if (session()->has('flash_notif.massage'))
                <div class="alert alert-{{ session()->get('flash_notif.level') }}">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <p>{!! session()->get('flash_notif.massage') !!}</p>
                </div>
        @endif

        @if ($errors->any())
                <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
        @endif
        
        @yield('content')
    </div>

    <!-- Scripts -->
    
    <script type="text/javascript" src="{{ asset('js/underscore-min.js') }}"></script>



<script type="text/javascript">
    
$(".listitems li").sort(sort_li) // sort elements
                  .appendTo('.listitems'); // append again to the list
// sort function callback
function sort_li(a, b){
    return ($(b).data('position')) > ($(a).data('position')) ? 1 : -1;    
}
    
    
// $(function() {
//   $("ul.listitems").each(function() {
//     $("li:gt(9)", this).hide(); /* :gt() is zero-indexed */
//     //$("li:nth-child(5)", this).after("<li class='listitems'><a href='#'>More...</a></li>"); /* :nth-child() is one-indexed */
//   });
  
// });

    function get_detail_pemesanan(id){
        $('#loading-list-menu').show();
        $.ajax({
            url: '<?php echo url('ajax/get_detail_pemesanan/') ?>/'+id,
            type: 'GET',
            cache:false,
            async: true,
            success: function(data) {
                $("#list-barang").html(data);
                
                $('#loading-list-menu').hide();
            }
           
        }).fail(function() {
            $("#list-barang").html('');
        }).always(function() {
            $('#loading-list-menu').hide();
        });
        
        
    }



    function get_detail_bbm(id){
        $('#loading-list-menu').show();
        $.ajax({
            url: '<?php echo url('ajax/get_detail_bbm/') ?>/'+id,
            type: 'GET',
            cache:false,
            async: true,
            success: function(data) {
                $("#list-barang").html(data);
                
                $('#loading-list-menu').hide();
            }
           
        }).fail(function() {
            $("#list-barang").html('');
        }).always(function() {
            $('#loading-list-menu').hide();
        });
        
        
    }


    function get_detail_bbk(id){
        $('#loading-list-menu').show();
        $.ajax({
            url: '<?php echo url('ajax/get_detail_bbk/') ?>/'+id,
            type: 'GET',
            cache:false,
            async: true,
            success: function(data) {
                $("#list-barang").html(data);
                
                $('#loading-list-menu').hide();
            }
           
        }).fail(function() {
            $("#list-barang").html('');
        }).always(function() {
            $('#loading-list-menu').hide();
        });
        
        
    }

    
    
</script>

</body>
</html>
