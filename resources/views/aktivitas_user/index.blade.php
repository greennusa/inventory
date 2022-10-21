@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Aktivitas User<br><br> <a class="btn btn-default" href="{{ url('/') }}">Kembali</a></div>

                <div class="panel-body">
                    <form class="form-inline">
                        <div class="form-group">
                            <input type="text" class="form-control" name="q" placeholder="Pencarian" value="@if(isset($_GET['q'])){{$_GET['q']}}@endif">
                        </div>
                        <button type="submit" class="btn btn-default">Cari</button>
                        
                    </form>
                    <p></p>
                    
                    <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>User</th>
                            <th>Grup</th>
                            <th>Aktivitas</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $page = 0;
                            if(isset($_GET['page']) && $_GET['page'] > 1){
                                $page = $_GET['page']*10-10;
                            }
                            $no = 1*$page+1; 
                        ?>
                        @foreach ($tables as $data)
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $data->created_at; ?></td>
                                <td><?php echo $data->user->nama; ?></td>
                                <td><?php echo $data->user->group->nama; ?></td>
                                <td><?php echo $data->aktivitas; ?></td>
                                
                            </tr>
                            <?php $no++; ?>
                        @endforeach
                    </table>
                    <center>
                        {{$tables->appends(request()->input())->render()}}
                    </center>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
