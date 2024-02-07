@extends('layouts.app')

@section('content')
<div class="container" style="margin: 0;padding: 0;width: 100%;">
    <div class="row" style="margin: 0;padding: 0;">
        <div class="col-md-12" style="margin: 0;padding: 0;width: 100%;">
            <div class="panel panel-default">
                <div class="panel-heading">Tambah Group</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ url('group') }}">
                    	{{ csrf_field() }}
						<div class="form-group">
							<label for="nama" class="col-lg-2 control-label">Nama Group</label>
							<div class="col-lg-3">
								<input type="text" value="" class="form-control" name="nama" id="nama" placeholder="Nama Group" required>
							</div>
						</div>
						
						<div class="form-group">
							<div class="col-lg-10 col-lg-offset-2">
								<input type=button value=Batal class="btn btn-default" onclick=self.history.back()>
								<button type="submit" class="btn btn-primary">Simpan</button>
							</div>
						</div>
						<table width="100%" class="table table-responsive table-bordered">

                            <thead>

                                <tr>

                                    <th colspan="6">Nama Aksi</th>

                                    <th>Pilih Semua</th>

                                </tr>

                            </thead>

                            <tbody>
                                <?php $no_plh=1; ?>
                            <tr>
                                <td colspan="7" align="right"><input type="checkbox" id="{{ $no_plh }}"></td>
                            </tr>
                            <tr>

                                <?php 
                                    $nama = "";
                                   
                                    
                                    foreach ($modul as $m): 
                                        $no_plh++;
                                        
                                        if($nama != $m->nama):
                                        ?>
                                        <tr>
                                            
                                        <?php
                                        $col = 7;

                                        foreach ($modul as $d): 
                                            if($m->nama == $d->nama  ){
                                                
                                                $col--;
                                                ?>
                                                <td  width="16%"><input  class="sel s{{ $no_plh }}"  type="checkbox" name="akses[]" value="{{ $d->id }}"> {{ $d->nama }} {{ $d->aksi }}</td>

                                                <?php

                                            }

                                        endforeach;
                                        ?>
                                            <td colspan="{{ $col }}" align="right"><input class="sel pilih" nomornya="{{ $no_plh }}" type="checkbox" ></td>
                                        </tr>
                                        <?php
                                        
                                        endif;
                                        $nama = $m->nama;
                                    endforeach; 
                                ?>

                                    

                                </tr>

                            </tbody>

                        </table>

					</form>


                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    jQuery("#1").click(function () {

     jQuery('.sel').not(this).prop('checked', this.checked);

    });

    jQuery(".pilih").click(function () {

        jQuery(".s"+$(this).attr('nomornya')).not(this).prop('checked', this.checked);

    });
</script>
@endsection

