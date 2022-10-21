@extends('layouts.app')



@section('content')





<div class="container">

	<div class="row">

		 <div class="col-md-12">

            <div class="panel panel-default">

                <div class="panel-heading">Tambah Monitoring Unit<br><br> <a class="btn btn-default" href="{{ url('monitoring') }}">Kembali</a></div> 

          	<div class="panel-body">

                      		  

              <form class="form-horizontal" method="POST" action="{{ url("monitoring") }}">

                {{ csrf_field() }}

                <div class="form-group">

                  <label for="unit" class="col-lg-2 control-label">No. Unit</label>

                  <div class="col-lg-3">

                    <select name="unit[]" class="form-control selectpicker show-tick select-all" data-live-search = "true" multiple>

                      <option value="[all]" class="select-all">All Items</option>

                      <option value="" data-divider="true"></option>

                      <?php

                        use App\MonitoringUnit;

                        foreach ($unit as $u) { 
                          if(strpos($u->kode, '-') !== false && $u->kode != "Oprt. Chainsaw-01" && $u->kode != "Oprt. Chainsaw-02" && $u->kode != "ATK-26") {
                          $q = MonitoringUnit::where('unit_id', $u->id)->where('tanggal', date("Y-m-d"))->count();







                          ?>



                          <option value="<?php echo $u->id ?>" @if( $q != 0 ) class = "bg-success" @endif>{{ $u->kode }} @if( $q != 0 ) (Sudah di Monitor) @endif</option>

                      <?php 

                        }
                      }

                      ?>

                    </select>

                  </div>

                </div>



                <div class="form-group">

                  <label for="tanggal" class="col-lg-2 control-label">Tanggal</label>

                  <div class="col-lg-3">

                    <input type="date" class="form-control" name="tanggal" required>

                  </div>

                </div>



                <div class="form-group">

                  <label for="status" class="col-lg-2 control-label">Status</label>

                  <div class="col-lg-3">

                    <select name="status" class="form-control selectpicker">

                      <option value="operasional">Operasional</option>

                      <option value="standby">Standby</option>

                      <option value="rusak">Rusak</option>

                    </select>

                  </div>

                </div>
                
                <div class="form-group">
                  <label for="keterangan" class="col-lg-2 control-label">Keterangan</label>
                  <div class="col-lg-3">
                    <input type="text" class="form-control" name="keterangan">
                  </div>
                </div>


                <div class="form-group">

                  <label for="libur" class="col-lg-2 control-label">Libur</label>

                  <div class="col-lg-3">

                    <select name="libur" class="form-control selectpicker">

                      <option value="0">Tidak</option>

                      <option value="1">Ya</option>

                      

                    </select>

                  </div>

                </div>





                <div class="form-group">

                  <div class="col-lg-10 col-lg-offset-2">

                    <input type=button value=Batal class="btn btn-default" onclick=self.history.back()>

                      <button type="submit" class="btn btn-primary">Simpan</button>

                  </div>

                </div>





              </form>



          	</div>  



            </div>

        </div>

    </div>

	</div>

</div>



<script type="text/javascript">

      $('.selectpicker.select-all').on('change', function () {

        var selectPicker = $(this);

        var selectAllOption = selectPicker.find('option.select-all');

        var checkedAll = selectAllOption.prop('selected');

        var optionValues = selectPicker.find('option[value!="[all]"][data-divider!="true"]');



        if (checkedAll) {

            // Process 'all/none' checking

            var allChecked = selectAllOption.data("all") || false;



            if (!allChecked) {

                optionValues.prop('selected', true).parent().selectpicker('refresh');

                selectAllOption.data("all", true);

            }

            else {

                optionValues.prop('selected', false).parent().selectpicker('refresh');

                selectAllOption.data("all", false);

            }



            selectAllOption.prop('selected', false).parent().selectpicker('refresh');

        }

        else {

            // Clicked another item, determine if all selected

            var allSelected = optionValues.filter(":selected").length == optionValues.length;

            selectAllOption.data("all", allSelected);

        }

    }).trigger('change');





</script>



@endsection