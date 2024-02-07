@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Pemesanan Barang</div>

                <div class="panel-body" >
                    <form class="form-horizontal" action="{{ url('order/'.$r->id) }}"  method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="PUT">
                        <div class="form-group">

                            <label for="nama" class="col-lg-4 control-label">Nomor Pemesanan</label>

                            <div class="col-lg-6">

                                <input type="text"  class="form-control" name="nomor"  placeholder="Nomor Pemesanan" required value="{{ $r->nomor }}">

                            </div>

                        </div>

                        <div class="form-group">

                            <label for="nama" class="col-lg-4 control-label">Tanggal Pemesanan</label>

                            <div class="col-lg-6">

                                <input  type="date" class="form-control datepickers" name="tanggal" placeholder="Tanggal Pemesanan" required value="{{ $r->tanggal }}">

                            </div>

                        </div>


                        <div class="form-group">
                            <label for="supplier_id" class="col-lg-4 control-label">Supplier Barang</label>
                            <div class="col-lg-6">
                                <select  class="form-control selectpicker" name="pemasok_id" id="pemasok_id" data-live-search="true" required style="font-size: 10px;">
                                                    
                                                    <?php foreach ($pemasok as $p): ?>
                                                        <option value="<?php echo $p->id ?>" <?php if ($p->id == @$r->pemasok_id) {echo "selected";} ?>><?php echo $p->nama ?></option>
                                                    <?php endforeach ?>             
                                                </select>
                            </div>
                        </div>

                        <div class="form-group">

                            <label for="nama" class="col-lg-4 control-label">Dikirim Ke</label>

                            <div class="col-lg-6">

                                <input type="text"  class="form-control" name="dikirim"  placeholder="Dikirim Ke" required value="{{ $r->dikirim }}">

                            </div>

                        </div>

                        <div class="form-group">

                            <label for="nama" class="col-lg-4 control-label"></label>

                            <div class="col-lg-6">

                                <a class="btn btn-success" href="<?php echo url('order') ?>">Selesai</a>
                                <button class="btn btn-primary" type="submit">Update</button>
                                <button type="button" data-toggle="modal" data-target="#new-item" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> Barang Baru</button>
                            </div>

                            

                        </div>

                        </form>
                        <form class="form-horizontal" action="{{ url('detail_order/'.$r->id) }}"  method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="PUT"> 
                    
                    <p></p>
                    <p></p>
                    <p>Detail Pemesanan</p>
                   
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="PUT">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                   
                                    <th>#</th>
                                    <th>Nomor Permintaan</th>
                                    <th>Kode Barang</th>
                                    <th>Nama Barang</th>
                                    
                                    <th>Kode Unit</th>
                                    <th>Halaman</th>
                                    <th>Indeks</th>
                                    <th >Jumlah</th>
                                    <th >Harga Satuan (Rp.)</th>
                                    
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no=1;use App\DetailPemesananBarang; ?>
                                <?php foreach ($r->detail as $d):?>
                                    @if($d->gabungan == '' || $d->gabungan == null)    
                                        <tr>    
                                                <input class="form-control" type="hidden" name="detail_id[]" value="<?php echo $d->id ?>">
                                                <td><?php echo $no ?></td>
                                                <td><?php echo $d->detail_permintaan->permintaan->nomor; ?></td>
                                                <?php $db = DetailPemesananBarang::where('gabungan','like','%'.$d->detail_gabungan.'%')->where('pemesanan_barang_id',$d->pemesanan_barang_id)->get();?>
                                                <td><input class="form-control" type="text" name="kode_barang[]" value="@if($d->kode_barang == null){{ $d->barang->kode }}@else{{ $d->kode_barang }}<?php endif; ?>@if($d->detail_gabungan != null || $d->detail_gabungan != '')@foreach($db as $aa)/<?php echo $aa->barang->kode ?>@endforeach @endif"></td>
                                                <td><input class="form-control" type="text" name="nama_barang[]" value="@if($d->nama_barang == null){{ $d->barang->nama }}@else{{ $d->nama_barang }}<?php endif; ?>@if($d->detail_gabungan != null || $d->detail_gabungan != '')@foreach($db as $aa)/<?php echo $aa->barang->nama ?>@endforeach @endif"></td>
                                                
                                                <td><?php echo $d->barang->unit->kode ?></td>
                                                <td><?php echo $d->barang->halaman ?></td>
                                                <td><?php echo $d->barang->indeks ?></td>
                                                <td>
                                                    <?php echo $d->jumlah ?> <?php echo $d->detail_permintaan->satuan->nama ?>
                                                    
                                                    
                                                </td>
                                                <td>
                                                    <input type="text" name="harga[]" value="{{ $d->harga }}" class="form-control">
                                                </td>
                                                
                                                <td><?php echo $d->keterangan ?></td>
                                                <td>
                                                    
                                                    <a class="btn btn-danger" onclick="event.preventDefault();
                                                             document.getElementById('delete<?php echo $d->id;  ?>').submit();return confirm('Apakah anda yakin akan menghapus data ini?');"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Hapus</a>
                                                    
                                                </td>
                                            
                                        </tr>
                                    <?php $no++ ?>
                                    @endif
                                <?php endforeach ?>
                            </tbody>
                        </table>
                        <button name="submit" class="btn btn-primary">Ubah</button>
                    </form>
                        
                            
                        
                        <?php foreach ($r->detail as $d): ?>
                            <form action="{{ url('detail_order/'.$d->id) }}" id="delete<?php echo $d->id;  ?>" method="POST">
                                {{ csrf_field() }}
                                <input type="hidden" name="_method" value="DELETE">
                            </form>
                        <?php endforeach ?>
                    

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="new-item" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Barang Baru</h4>
      </div>
      <div class="modal-body" style="max-height: 70vh;overflow-y: scroll;">
        <form class="form-horizontal" enctype="multipart/form-data" method="post" accept-charset="utf-8" action="{{ url('order/'.$r->id.'/detail_baru') }}">
            {{ csrf_field() }}
                        <input type="hidden" name="_method" value="PUT">
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                            <label for="nomor" class="col-lg-4 control-label">Nomor Permintaan</label>
                            <div class="col-lg-6">
                                <input type="text" class="form-control" name="nomor" id="nomor" placeholder="Nomor Permintaan" required >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tanggal" class="col-lg-4 control-label">Tanggal</label>
                            <div class="col-lg-6">
                                <input type="date" class="form-control datepickers" name="tanggal" id="tanggal" placeholder="Tanggal" required>
                            </div>
                        </div>
                        
                       
                        <div class="form-group">
                            <label for="sifat" class="col-lg-4 control-label">Sifat</label>
                            <div class="col-lg-6">
                                <select class="form-control selectpicker" name="sifat" id="sifat" data-live-search="true">
                                    
                                    <option value="0" >Biasa</option>
                                    <option value="1" >Urgent</option>          
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="destination" class="col-lg-4 control-label">Pilih Tujuan</label>
                            <div class="col-lg-6">
                                <select class="form-control selectpicker" name="destination" id="destination" data-live-search="true">
                                    <option value="Camp">Camp</option>
                                    <option value="Kantor">Kantor</option>  
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="tanggal" class="col-lg-4 control-label">Keterangan</label>
                            <div class="col-lg-6">
                                <textarea class="form-control" name="keperluan" id="Keperluan" placeholder="Keperluan" maxlength="255" ></textarea>
                            </div>
                        </div>
                        
                </div>

                <div class="col-lg-6">
                    
                        <div class="form-group">
                            <label for="pembuat_id" class="col-lg-4 control-label">Dibuat oleh</label>
                            <div class="col-lg-6">
                                <select class="form-control selectpicker" name="pembuat_id" id="pembuat_id" data-live-search="true" required>
                                    <option></option>
                                    <?php foreach ($user as $u): ?>
                                        <option value="<?php echo $u->id ?>" ><?php echo $u->nama ?></option>
                                    <?php endforeach ?>             
                                </select>
                                <span style="color:red; font-size:13px" class="help-block">Wajib diisi</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="diperiksa_id" class="col-lg-4 control-label">Diperiksa oleh</label>
                            <div class="col-lg-6">
                                <select class="form-control selectpicker" name="diperiksa_id" id="diperiksa_id" data-live-search="true" required>
                                    <option></option>
                                    <?php foreach ($user as $u): ?>
                                        <option value="<?php echo $u->id ?>" ><?php echo $u->nama ?></option>
                                    <?php endforeach ?>             
                                </select>
                                <span style="color:red; font-size:13px" class="help-block">Wajib diisi</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="diketahui_id" class="col-lg-4 control-label">Diketahui oleh</label>
                            <div class="col-lg-6">
                                <select class="form-control selectpicker" name="diketahui_id" id="diketahui_id" data-live-search="true" >
                                    <option></option>
                                    <?php foreach ($user as $u): ?>
                                        <option value="<?php echo $u->id ?>" ><?php echo $u->nama ?></option>
                                    <?php endforeach ?>             
                                </select>
                                
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="disetujui_id" class="col-lg-4 control-label">Disetujui oleh</label>
                            <div class="col-lg-6">
                                <select class="form-control selectpicker" name="disetujui_id" id="disetujui_id" data-live-search="true" >
                                    <option></option>
                                    <?php foreach ($user as $u): ?>
                                        <option value="<?php echo $u->id ?>" ><?php echo $u->nama ?></option>
                                    <?php endforeach ?>
                                </select>
                                
                            </div>
                        </div>
                </div>
                </div>
            <div class="row">
                <hr class="col-md-12 ">
                <h5 class="text-center">Detail Barang</h5>
                <div class="col-md-6">
                     
                    <div class="form-group">

                        <label for="nama" class="col-lg-4 control-label">Nama Barang</label>

                        <div class="col-lg-6">

                            <input type="text"  class="form-control" name="nama" id="nama" placeholder="Nama Barang" required>

                        </div>

                    </div>

                    <div class="form-group">

                        <label for="kode" class="col-lg-4 control-label">No. Part / Kode</label>

                        <div class="col-lg-6">

                            <input type="text"  class="form-control" name="kode" id="kode" placeholder="No. Part / Kode Pabrikan" required>

                        </div>

                    </div>

                    <div class="form-group">

                        <label for="kategori_id" class="col-lg-4 control-label">Kategori</label>

                        <div class="col-lg-6">

                            <select class="form-control selectpicker"  name="kategori_id" id="kategori_id" data-live-search="true">

                                <option></option>   

                                @foreach ($kategori as $k)

                                    <option value="<?php echo $k->id ?>"><?php echo $k->nama ?></option>

                                @endforeach            

                            </select>
                            @if ($errors->has('kategori_id'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('kategori_id') }}</strong>
                                </span>
                            @endif

                        </div>

                    </div>

                    <div class="form-group">

                        <label for="unit_id" class="col-lg-4 control-label">Unit</label>

                        <div class="col-lg-6">

                            <select class="form-control selectpicker"  name="unit_id" id="unit_id" data-live-search="true">

                                    <option></option>

                                    @foreach ($unit as $j)

                                        <option value="<?php echo $j->id ?>"><?php echo $j->kode ?></option>

                                    @endforeach             

                                </select>

                            @if ($errors->has('unit_id'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('unit_id') }}</strong>
                                </span>
                            @endif

                        </div>

                    </div>


                    

                    <div class="form-group">

                        <label for="harga" class="col-lg-4 control-label">Harga Barang</label>

                        <div class="col-lg-6">

                            <input type="text"  class="form-control" name="harga" id="harga" placeholder="Harga Barang" required>

                        </div>

                    </div>


                    <div class="form-group">

                        <label for="jumlah" class="col-lg-4 control-label">Jumlah Barang</label>

                        <div class="col-lg-6">

                            <input type="text"  class="form-control" name="jumlah" id="jumlah" placeholder="Harga Barang" required>

                        </div>

                    </div>

                   

                    <div class="form-group">

                        <div class="col-lg-10 col-lg-offset-2">

                            <input  type=button value=Batal class="btn btn-default" data-dismiss="modal">

                            <button type="submit" class="btn btn-primary">Simpan</button>

                        </div>

                    </div>

                </div>

                <div class="col-md-6">
                    <div class="form-group">

                        <label for="halaman" class="col-lg-4 control-label">Halaman</label>

                        <div class="col-lg-6">

                            <input type="text"  class="form-control" name="halaman" id="halaman" placeholder="Halaman" >

                        </div>

                    </div>

                    <div class="form-group">

                        <label for="indeks" class="col-lg-4 control-label">Indeks</label>

                        <div class="col-lg-6">

                            <input type="text"  class="form-control" name="indeks" id="indeks" placeholder="Indeks" >

                        </div>

                    </div>

                    <div class="form-group">

                        <label for="satuan_id" class="col-lg-4 control-label">Satuan</label>

                        <div class="col-lg-6">

                            <select class="form-control selectpicker"  name="satuan_id" id="satuan_id" data-live-search="true">

                                <option></option>

                                @foreach ($satuan as $s)

                                    <option value="<?php echo $s->id ?>" ><?php echo $s->nama ?></option>

                                @endforeach          

                            </select>
                            @if ($errors->has('satuan_id'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('satuan_id') }}</strong>
                                </span>
                            @endif

                        </div>

                    </div>

                    <div class="form-group">

                        <label for="keterangan" class="col-lg-4 control-label">Keterangan</label>

                        <div class="col-lg-6">

                            <input type="text"  class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan">

                        </div>

                    </div>

                        

                    <div class="form-group">

                        <label for="gambar" class="col-lg-4 control-label">Gambar Barang</label>

                        <div class="col-lg-6">

                            <input type="file" name="userfile" id="userfile" class="form-control">

                        </div>

                    </div>

                    <div class="form-group">

                        <label for="pakai_sn" class="col-lg-4 control-label">Menggunakan Serial Number?</label>

                        <div class="col-lg-6">

                            <select class="form-control" name="pakai_sn" id="pakai_sn">

                                
                                    <option value="1" > Iya</option>   

                                
                                    <option value="0" > Tidak</option>  

                                
                            </select>
                            <span style="color:red; font-size:13px" class="help-block">Disarankan pilih "Tidak" untuk barang yang pada saat di pesan berjumlah banyak</span>
                        </div>

                    </div>   

                    
                </div>
            </div>
                
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
@endsection

                    