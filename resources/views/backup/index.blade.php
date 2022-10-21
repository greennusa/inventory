@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Database Backups<br><br> <a class="btn btn-default" href="{{ url('/') }}">Kembali</a></div>

                <div class="panel-body">
                   
 
                    <div class="row">
                        <div class="col-xs-12 clearfix">
                            <a id="create-new-backup-button" href="{{ url('backup/create') }}" class="btn btn-primary pull-right"
                               style="margin-bottom:2em;"><i
                                    class="fa fa-plus"></i> Create New Backup
                            </a>
                        </div>
                        <!-- <div class="row col-xs-12" style="color: red;">
                            <marquee>Jika Ingin Meng-import / Merestore data silahkan hubungi ADMIN</marquee>
                        </div> -->
                        <?php 
                        use Spatie\Backup\Helpers\Format;
                        function humanFilesize($size, $precision = 2) {

                            $units = array('B','kB','MB','GB','TB','PB','EB','ZB','YB');
                            $step = 1024;
                            $i = 0;

                            while (($size / $step) > 0.9) {
                                $size = $size / $step;
                                $i++;
                            }
                            
                            return round($size, $precision).$units[$i];
                        } ?>
                        <div class="col-xs-12">
                            @if (count($backups))

                                <table class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th>File</th>
                                        <th>Size</th>
                                        <th>Waktu Di Buat</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($backups as $backup)
                                        <tr>
                                            <td>{{ $backup['file_name'] }}</td>
                                            <td>{{ Format::humanReadableSize($backup['file_size']) }}</td>
                                            <td>{{ $backup['time']->format('Y-m-d H:i:s') }}</td>
                                            <td class="text-right">
                                                <a class="btn btn-xs btn-default"
                                                   href="{{ url('backup/download/'.$backup['file_name']) }}"><i
                                                        class="fa fa-cloud-download"></i> Download</a>
                                                <!-- <a class="btn btn-xs btn-info"
                                                   href="{{ url('backup/restore/'.$backup['file_name']) }}"><i
                                                        class="fa fa-cloud-download"></i> Restore</a> -->
                                                <!-- <a class="btn btn-xs btn-danger" data-button-type="delete"
                                                   href="{{ url('backup/delete/'.$backup['file_name']) }}"><i class="fa fa-trash-o"></i>
                                                    Delete</a> -->
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="well">
                                    <h4>There are no backups</h4>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection