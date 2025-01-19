@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Logistic Report</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Logistic Report</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        
    <div class="container-fluid">
        <div class="row">
          <div class="col-12">

            <div class="card">
              <div class="card-header">
				<div class="card-tools">
				 <div class="row">
				 @permission('list.logisticreport.download') 
				<a href="{{ route('voucherReportExport', request()->input()) }}" class="btn btn-info btn-sm mb-2 mr-4">Export to CSV</a>
        <a href="{{ route('logistic.record.csv.upload', request()->input()) }}" class="btn btn-info btn-sm mb-2 mr-4">Upload Record From CSV</a>
        @endpermission
				   </div></div>
				   
              </div>
              <!-- /.card-header -->
              <div class="card-body">
			  <div class="row">
            <form id="filterForm" class="form-inline" method="get" action="{{ route('voucherReport') }}" >
              <div class="form-row align-items-center">
			   <div class="col-auto col-md-3">
                <div class="input-group mb-2">
                  <div class="input-group-prepend">
                    <div class="input-group-text">Search Result</div>
                  </div>
                 <select name="booking_type" id="booking_type" class="form-control">
                    <option value = "1" @if(request('booking_type')==1) selected="selected" @endif>Booking Date</option>
					<option value = "2" @if(request('booking_type')==2) selected="selected" @endif>Travel Date</option>
					<!--<option value = "3">Deadline Date</option>-->
                 </select>
                </div>
              </div>
			  <div class="col-auto col-md-2">
                  <div class="input-group mb-2">
                    <div class="input-group-prepend"><div class="input-group-text">From Date</div></div>
                    <input type="text" name="from_date" value="{{ request('from_date') }}" autocomplete ="off" class="form-control datepicker"  placeholder="From Date" />
                  </div>
                </div>
				<div class="col-auto col-md-2">
                  <div class="input-group mb-2">
                    <div class="input-group-prepend"><div class="input-group-text">To Date</div></div>
                    <input type="text" name="to_date" value="{{ request('to_date') }}" class="form-control datepicker" autocomplete ="off"  placeholder="To Date" />
                  </div>
                </div>
                <div class="col-auto col-md-3">
                  <div class="input-group mb-2">
                    <div class="input-group-prepend"><div class="input-group-text">Voucher Code</div></div>
                    <input type="text" name="vouchercode" value="{{ request('vouchercode') }}" class="form-control"  placeholder="Voucher Code" />
                  </div>
                </div>
                <div class="col-auto col-md-3" style="display:none">
                <div class="input-group mb-2">
                  <div class="input-group-prepend">
                    <div class="input-group-text">Booking Status</div>
                  </div>
                 <select name="booking_status" id="booking_status" class="form-control">
						<option value = "">All</option>
						@foreach($voucherStatus as $vsk => $vs)
						<option value = "{{$vsk}}" @if(request('booking_status')==$vsk) selected="selected" @endif>{{$vs}}</option>
						@endforeach
                 </select>
                </div>
              </div>
               
              <div class="col-auto col-md-2">
                <button class="btn btn-info mb-2" type="submit">Filter</button>
                <a class="btn btn-default mb-2  mx-sm-2" href="{{ route('voucherReport') }}">Clear</a>
              </div>
            </form>
          </div>
        </div><div class="col-md-12" style="overflow-x:auto">
                <table id="example3" class="table rounded-corners">
                  <thead>
                  <tr>
				  <th>Booking Date</th>
					<th>Booking #</th>
          <th width="7%">Service Date</th>
          <th width="7%">Slot</th>
					<th>Guest Name</th>
          <th>Guest Country Code</th>
					<th>Guest Contact No</th>
					<th>Entry Type</th>
					<th>Pickup/Flight</th>
					<th>Service</th>
          <th>Varaint</th>
          <th>Dropoff/Flight</th>
          <th>A</th>
          <th>C</th>
          <th>I</th>
					<th>SIC/PVT</th>
          <th>Vehicle Type</th>
					<th>Pickup Time</th>
					<th>Dropoff Time</th>
					<th>Driver name</th>
					<th>TKT Supplier</th>
					<th>TKT Supplier Ref #</th>
					<th>Agency</th>
          <th>Booking Remark</th>
					<th>Remark</th>
					
					<th>TFR Supplier</th>
					<th>TFR SP</th>
					<th>TFR Net Cost</th>
					<th>TFR Supplier 2</th>
					<th>TFR Net Cost 2</th>
					
					<th>Status</th>
          <th>Guest WA Group Name</th>
          <th>Vouchered By</th>
                  </tr>
				  
                  </thead>
                  <tbody>
				  @foreach ($records as $record)
				  @php
				  $class = SiteHelpers::voucherActivityStatus($record->status);
          $vouchered_by  = "";
          if(!empty($record->voucher->vouchered_by))
          $vouchered_by = SiteHelpers::getUserName($record->voucher->vouchered_by);
				  @endphp
                  <tr class="{{$class}}">
				 
          <td>
          {{ $record->booking_date ? date("d-m-Y, H:i:s",strtotime($record->booking_date)) : null }}
				
					</td>          
          
					<td>{{($record->voucher)?$record->voucher->code:''}}</td>
          <td>
          {{ $record->tour_date ? date("d-m-Y",strtotime($record->tour_date)) : null }}
					
					</td>
          <td>
          {{ $record->time_slot ? $record->time_slot : null }}
					
					</td>
					<td>{{($record->voucher)?$record->voucher->guest_name:''}}</td>
          <td>{{$record->voucher->guest_country_code}}</td>
					<td>
					<input type="text"  class="form-control inputsaveV" id="guest_phone{{$record->id}}" data-name="guest_phone"  data-id="{{$record->voucher_id}}" value="{{($record->voucher)?$record->voucher->guest_phone:''}}" /></td>
         
					<td>{{$record->activity_entry_type}}</td>
					<td>
          @if($record->activity_entry_type == 'Arrival') 
          {{$record->flight_no}} : {{$record->passenger_name}} 
          @else
          <input type="hidden" class="form-control inputsave" id="pickup_location{{$record->id}}" data-name="pickup_location" data-id="{{$record->id}}" value="{{$record->pickup_location}}"  />{{$record->pickup_location}}
          @endif
          </td>
					<td>{{$record->activity_title}}</td>
					<td>{{($record->variant_name)?$record->variant_name:''}}</td>
					<td>
          @if($record->activity_entry_type == 'Departure') 
          {{$record->flight_no}} 
          @else  
          <input type="text" class="form-control inputsave" id="dropoff_location{{$record->id}}" data-name="dropoff_location"  data-id="{{$record->id}}" value="{{$record->dropoff_location}}" />
          @endif</td>
					 <td>
           @if(($record->activity_entry_type == 'Yacht') || ($record->activity_entry_type == 'Limo'))
           {{$record->adult}}  Hour(s)
						    	@else
                  {{$record->adult}}
                  @endif 
           </td>
                    <td>{{$record->child}}</td>
                    <td>{{$record->infant}}</td>
					<td>
					@if($record->transfer_option == "Shared Transfer")
					SIC
					@php
					$zone = SiteHelpers::getZoneName($record->transfer_zone);
					@endphp
						- <b>{{@$zone->name}} </b>
					
					@endif
					@if($record->transfer_option == 'Pvt Transfer')
					PVT
					@endif
					
				</td>
        <td>
      {{@$record->vehicle_type}}
        
        </td>
				<td><input type="text" class="form-control inputsave" id="actual_pickup_time{{$record->id}}"  style="text-transform:uppercase;" data-name="actual_pickup_time"  data-id="{{$record->id}}" value="{{$record->actual_pickup_time}}" /></td>
				
				<td><input type="text" class="form-control inputsave" id="dropoff_time{{$record->id}}" data-name="dropoff_time"  data-id="{{$record->id}}" value="{{$record->dropoff_time}}" /></td>	
					<td><input type="text" class="form-control inputsave" id="driver_name{{$record->id}}" data-name="driver_name"  data-id="{{$record->id}}" value="{{$record->driver_name}}" /></td>
					
					
					
					<td>
					 <select name="supplier_ticket{{$record->id}}" id="supplier_ticket{{$record->id}}" class="form-control inputsaveSp">
						<option data-name="supplier_ticket"  data-id="{{$record->id}}" value="">All</option>
						@foreach($supplier_ticket as  $stv)
						
						<option data-name="supplier_ticket"  data-id="{{$record->id}}" value = "{{$stv->id}}" @if($record->supplier_ticket==$stv->id) selected="selected" @endif >{{$stv->company_name}}</option>
						@endforeach
                 </select>
					</td>
					<td>
         
          <input type="text" class="form-control inputsave" id="ticket_supp_ref_no{{$record->id}}" data-name="ticket_supp_ref_no"  data-id="{{$record->id}}" value="{{$record->ticket_supp_ref_no}}" /></td>
					<td>{{($record->voucher->agent)?$record->voucher->agent->company_name:''}}</td>
          <td>
          {!!$record->remark!!}
</td>
					<td>
        
          {!!$record->internal_remark!!}
          <input type="hidden" class="form-control inputsave" id="remark_old{{$record->id}}" data-name="remark_old"  data-id="{{$record->id}}" value="{{$record->internal_remark}}" />
            <textarea  class="form-control inputsave" id="internal_remark{{$record->id}}" style="resize:none;" data-name="internal_remark"  data-id="{{$record->id}}"></textarea></td>
					
					
					
					
					
					
					
				
				
				<td>
					 <select name="supplier_transfer{{$record->id}}" id="supplier_transfer{{$record->id}}" class="form-control inputsaveSp">
						<option data-name="supplier_transfer"  data-id="{{$record->id}}" value="">All</option>
						@foreach($supplier_transfer as  $stt)
						<option data-name="supplier_transfer"  data-id="{{$record->id}}" value = "{{$stt->id}}" @if($record->supplier_transfer==$stt->id) selected="selected" @endif >{{$stt->company_name}}</option>
						@endforeach
                 </select>
					</td>
				
				
					<td>
					{{$record->original_trans_rate-$record->discount_sic_pvt_price}}
					</td>
					
					<td>
          @if($record->status == '3')
          <input type="text" class="form-control inputsave" id="actual_transfer_cost{{$record->id}}" data-name="actual_transfer_cost"  data-id="{{$record->id}}" value="{{$record->actual_transfer_cost}}" />
            @else
          @permission('list.report.costing') 
            <input type="text" class="form-control inputsave" id="actual_transfer_cost{{$record->id}}" data-name="actual_transfer_cost"  data-id="{{$record->id}}" value="{{$record->actual_transfer_cost}}" />
            @else
            {{ $record->actual_transfer_cost }}
          @endpermission
          @endif
          </td>
					
					<td><select name="supplier_transfer2{{$record->id}}" id="supplier_transfer2{{$record->id}}" class="form-control inputsaveSp">
						<option data-name="supplier_transfer2"  data-id="{{$record->id}}" value="">All</option>
						@foreach($supplier_transfer as  $stt)
						<option data-name="supplier_transfer2"  data-id="{{$record->id}}" value = "{{$stt->id}}" @if($record->supplier_transfer==$stt->id) selected="selected" @endif >{{$stt->company_name}}</option>
						@endforeach
                 </select></td>
					<td>
            @if($record->status == '3')
            <input type="text" class="form-control inputsave" id="actual_transfer_cost2{{$record->id}}" data-name="actual_transfer_cost2"  data-id="{{$record->id}}" value="{{$record->actual_transfer_cost2}}" />
            @else
          @permission('list.report.costing') 
          <input type="text" class="form-control inputsave" id="actual_transfer_cost2{{$record->id}}" data-name="actual_transfer_cost2"  data-id="{{$record->id}}" value="{{$record->actual_transfer_cost2}}" />
            @else
            {{ $record->actual_transfer_cost2 }}
          @endpermission  
          @endif
          </td>
					<td>
          @if($record->status == '4')
              Confirmed
            @else
					@php
					$actStatus = config('constants.voucherActivityStatus');
					@endphp
					<select name="status{{$record->id}}" id="status{{$record->id}}" class="form-control inputsaveSp">
						@foreach($actStatus as $k => $status)
						@if($k > 2)
						<option data-name="status"  data-id="{{$record->id}}" value = "{{$k}}" @if($record->status==$k) selected="selected" @endif >{{$status}}</option>
						@endif
						@endforeach
            @endif
                 </select>
					</td>
          <td>
					<input type="text"  class="form-control inputsaveV" id="whatsapp_group{{$record->id}}" data-name="whatsapp_group"  data-id="{{$record->voucher_id}}" value="{{($record->voucher)?$record->voucher->whatsapp_group:''}}" /></td>
          <td> {{ $vouchered_by }}</td>
                  </tr>
                
                  @endforeach
                  </tbody>
                </table></div>
				<div class="pagination pull-right mt-3"> 
				</div> 
				
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
	
	<div class="modal fade" id="sendEmailModal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Send Email</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Test
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-primary-flip btn-sm" >Send</button>
                <!-- You can add a button here for further actions if needed -->
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
 <!-- Script -->
 <script type="text/javascript">
$(document).ready(function() {
	
	$(document).on('change', '.inputsave', function(evt) {
		$("#loader-overlay").show();
var id= $(this).data('id');
    var txt_name =  $(this).data('name');
    var txt_var =  $(this).val();
    if(txt_name == 'internal_remark')
    {
      txt_var =  $("body #remark_old"+id).val()+"<br/>"+txt_var;
    }
		$.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
		$.ajax({
            url: "{{route('voucherReportSave')}}",
            type: 'POST',
            dataType: "json",
            data: {
               id: $(this).data('id'),
			   inputname: $(this).data('name'),
			   val: txt_var,
			   type: "Report",
			   report_type: "Logistic Report"
            },
            success: function( data ) {
               //console.log( data );
			  $("#loader-overlay").hide();
            }
          });
	 });	
	 
	 $(document).on('change', '.inputsaveSp', function(evt) {
		$("#loader-overlay").show();
		var id =$(this).find(':selected').data('id');
		var spInput = $(this).attr('id');
		
		if(spInput == 'supplier_transfer'+id){
			 var cost = parseFloat($('#actual_transfer_cost' + id).val());
			var cost = $('#actual_transfer_cost' + id).val().trim(); // Get and trim the input value

					if (cost === '' || isNaN(parseFloat(cost)) || parseFloat(cost) <= 0 ) {
						alert("Please enter a valid TFR Net Cost greater than or equal to 0");
						$('#' + spInput).val('');  // Reset the value to an empty string or a default value
						$("#loader-overlay").hide();
						return false;
					}
		}
    if((spInput == 'status'+id) && ($(this).val() =='4')){
			 var cost = parseFloat($('#actual_transfer_cost' + id).val());
			var cost = $('#actual_transfer_cost' + id).val().trim(); // Get and trim the input value
      var sp = $('#supplier_transfer' + id).val().trim(); // Get and trim the input value
					if (cost === '' || isNaN(parseFloat(cost)) || parseFloat(cost) <= 0 || sp == '')  {
						alert("Please enter a valid TFR Net Cost greater than or equal to 0 or select supplier");
						$('#' + spInput).val('3');  // Reset the value to an empty string or a default value
						$("#loader-overlay").hide();
						return false;
					}
		}
		$.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
		$.ajax({
            url: "{{route('voucherReportSave')}}",
            type: 'POST',
            dataType: "json",
            data: {
               id: $(this).find(':selected').data('id'),
			   inputname: $(this).find(':selected').data('name'),
			   val: $(this).val(),
			   type: "Report",
			   report_type: "Logistic Report"
            },
            success: function( data ) {
               //console.log( data );
			  $("#loader-overlay").hide();
            }
          });
	 });
	 
	  $(document).on('change', '.inputsaveV', function(evt) {
		$("#loader-overlay").show();
		$.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
		$.ajax({
            url: "{{route('voucherReportSaveInVoucher')}}",
            type: 'POST',
            dataType: "json",
            data: {
               id: $(this).data('id'),
			   inputname: $(this).data('name'),
			   val: $(this).val()
            },
            success: function( data ) {
               //console.log( data );
			  $("#loader-overlay").hide();
            }
          });
	 });	
	 
		$(document).on('click', '.emailPopup', function(evt) {
		var id = $(this).data('id'); 
		$('#sendEmailModal').modal('show'); 
		});
});

  </script> 
  @endsection
