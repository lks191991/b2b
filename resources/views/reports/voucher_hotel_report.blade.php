@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Hotel Report</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Hotel Report</li>
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
				 <div class="row">
				 @permission('list.hotelreport.download') 
				<a href="{{ route('voucherHotelReportExport', request()->input()) }}" class="btn btn-info btn-sm mb-2 mr-4">Export to CSV</a>
				@endpermission	   
				   </div>
				   </div></div>
				   
              </div>
			  <div class="card-body">
			  
			  <div class="row">
			  
            <form id="filterForm" class="form-inline" method="get" action="{{ route('voucherHotelReport') }}" >
              <div class="form-row align-items-center">
			   <div class="col-auto col-md-4">
                <div class="input-group mb-2">
                  <div class="input-group-prepend">
                    <div class="input-group-text">Search Result</div>
                  </div>
                 <select name="booking_type" id="booking_type" class="form-control">
                    <option value = "1" @if(request('booking_type')==1) selected="selected" @endif>Booking Date</option>
					<option value = "2" @if(request('booking_type')==2) selected="selected" @endif>CheckIn Date</option>
					<!--<option value = "3">Deadline Date</option>-->
                 </select>
                </div>
              </div>
			  <div class="col-auto col-md-4">
                  <div class="input-group mb-2">
                    <div class="input-group-prepend"><div class="input-group-text">From Date</div></div>
                    <input type="text" name="from_date" value="{{ request('from_date') }}" autocomplete ="off" class="form-control datepicker"  placeholder="From Date" />
                  </div>
                </div>
				<div class="col-auto col-md-4">
                  <div class="input-group mb-2">
                    <div class="input-group-prepend"><div class="input-group-text">To Date</div></div>
                    <input type="text" name="to_date" value="{{ request('to_date') }}" class="form-control datepicker" autocomplete ="off"  placeholder="To Date" />
                  </div>
                </div>
                <div class="col-auto col-md-4">
                  <div class="input-group mb-2">
                    <div class="input-group-prepend"><div class="input-group-text">Booking No</div></div>
                    <input type="text" name="vouchercode" value="{{ request('vouchercode') }}" class="form-control"  placeholder="Booking No" />
                  </div>
                </div>
                <div class="col-auto col-md-4">
                  <div class="input-group mb-2">
                    <div class="input-group-prepend"><div class="input-group-text">Invoice No</div></div>
                    <input type="text" name="invoicecode" value="{{ request('invoicecode') }}" class="form-control"  placeholder="Invoice No" />
                  </div>
                </div>
             
             
			  <div class="col-auto col-md-3">
                <div class="input-group mb-2">
                  <div class="input-group-prepend">
                    <div class="input-group-text">Agency/Supplier</div>
                  </div>
                <input type="text" id="agent_id" name="agent_id" value="{{ request('agent_id')}}" class="form-control"  placeholder="Agency/Supplier Name" />
					<input type="hidden" id="agent_id_select" name="agent_id_select" value="{{ request('agent_id_select')}}"  />
                </div>
              </div>
			  
               
              <div class="col-auto col-md-2">
                <button class="btn btn-info mb-2" type="submit">Filter</button>
                <a class="btn btn-default mb-2  mx-sm-2" href="{{ route('voucherActivityReport') }}">Clear</a>
              </div>
            </form>
          </div>
        </div>
              <!-- /.card-header -->
              <div class="card-body" style="overflow-x:auto">
			 
                <table id="example3" class="table table-bordered table-striped">
                  <thead>
                 			  
				   <tr>
					
                    <th>Booking Date</th>
					<th>Payment Date</th>
					<th>Booking #</th>
					<th>Check In</th>
					<th>Check Out</th>
					<th>Hotel Name</th>
					<th>NO. Of Nights</th>
					<th>NO. Of Rooms</th>
					<th>Total Selling Price</th>
					<th>Mark up</th>
					<th>Payment Due Date</th>
					<th>Confirmation No</th>
					<th>Supplier</th>
					<th>Payment Status</th>
					<th>Payment Status Updated by</th>
					<th>Mode Of Payment</th>
					<th>Amount Paid</th>
					<th>UTR Number</th>
					<th>Remark</th>
                  </tr>
				  
                  </thead>
                  <tbody>
				 
				  @foreach ($records as $record)
				  @php
            $room = SiteHelpers::hotelRoomsDetails($record->hotel_other_details);
			 $night = SiteHelpers::numberOfNight($record->check_in_date,$record->check_out_date);
			 $markUp = @$room['markup_v_s']+@$room['markup_v_d']+@$room['markup_v_eb']+@$room['markup_v_cwb']+@$room['markup_v_cnb'];
            @endphp
                  <tr>
				  
				 
				 
                    <td>{{($record->voucher)?$record->voucher->booking_date:''}}</td>
					<td>{{($record->voucher)?$record->voucher->payment_date:''}}</td>
					<td>{{($record->voucher)?$record->voucher->code:''}}</td>
					
					<td>{{$record->check_in_date}}</td>
					<td>{{$record->check_out_date}}</td>
					<td>{{($record->hotel)?$record->hotel->name:''}}</td>
					<td>{{$night }}</td>
					<td>{{$room['number_of_rooms']}}</td>

					<td>{{$room['price']}}</td>
					<td>{{$room['markup']}}</td>
					<td>{{$record->payment_due_date}}</td>
					<td>{{$record->confirmation_number}}</td>
					<td>
				  <select name="supplier_hotel{{$record->id}}" id="supplier_hotel{{$record->id}}" class="form-control inputsaveSp">
								<option data-name="supplier_hotel"  data-id="{{$record->id}}" value="">All</option>
								@foreach($supplier_hotel as  $stv)
								
								<option data-name="supplier_hotel"  data-id="{{$record->id}}" value = "{{$stv->id}}" @if($record->supplier_hotel==$stv->id) selected="selected" @endif >{{$stv->company_name}}</option>
								@endforeach
						 </select>
				  </td>
					 <td>{!! SiteHelpers::voucherStatus($record->voucher->status_main) !!}</td>
					<td>{{($record->voucher)?@$record->voucher->updatedBy->name:''}}</td>
					 <td>
					 <select name="mode_of_payment{{$record->id}}" id="mode_of_payment{{$record->id}}" class="form-control inputsaveSp">
					 <option value="" @if($record->mode_of_payment =='') {{'selected="selected"'}} @endif data-id="{{$record->id}}" data-name="mode_of_payment">Select</option>
					<option value="1" @if($record->mode_of_payment =='1') {{'selected="selected"'}} @endif data-id="{{$record->id}}" data-name="mode_of_payment">WIO BANK A/C No - 962 222 3261</option>
					<option value="2" @if($record->mode_of_payment =='2') {{'selected="selected"'}} @endif data-id="{{$record->id}}" data-name="mode_of_payment">RAK BANK A/C No -0033488116001</option>
					<option value="3" @if($record->mode_of_payment =='3'){{'selected="selected"'}} @endif data-id="{{$record->id}}" data-name="mode_of_payment">CBD BANK A/C No -1001303922</option>
					<option value="4" @if($record->mode_of_payment =='4'){{'selected="selected"'}} @endif data-id="{{$record->id}}" data-name="mode_of_payment">Cash</option>
					<option value="5" @if($record->mode_of_payment =='5'){{'selected="selected"'}} @endif data-id="{{$record->id}}" data-name="mode_of_payment">Cheque</option>
                 </select></td>
				 <td> <input type="text" name="amount_paid{{$record->id}}" data-name="amount_paid" id="amount_paid{{$record->id}}" value="{{ $record->amount_paid }}" data-id="{{$record->id}}" autocomplete ="off" class="form-control inputsave"  /></td>
				 <td> <input type="text" name="utr_number{{$record->id}}" data-name="utr_number" id="utr_number{{$record->id}}" value="{{ $record->utr_number }}" data-id="{{$record->id}}" autocomplete ="off" class="form-control inputsave"  /></td>
				 <td><input type="text" name="remark{{$record->id}}"  data-name="remark"id="remark{{$record->id}}" value="{{ $record->remark }}"  data-id="{{$record->id}}" autocomplete ="off" class="form-control inputsave"  /></td>
				 
					</tr>
                 
                  @endforeach
				 </tbody>
					
                </table>
				
				
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
@endsection
@section('scripts')
	<script type="text/javascript">
 $(document).ready(function(){
	var activity_id = "{{request('activity_id')}}";
	var oldactivity_variant = "{{request('activity_variant')}}";
	
	$("body #activity_id").on("change", function () {
            var activity_id = $(this).val();
			$("#activity_variant").prop("disabled",true);
            $.ajax({
                type: "POST",
                url: '{{ route("variantByActivity") }}',
                data: {'activity_id': activity_id, '_token': '{{ csrf_token() }}'},
                success: function (data) {
					 $('#activity_variant').html('<option value="">--select--</option>');
					$.each(data, function (key, value) {
                            $("#activity_variant").append('<option value="' + value
                                .u_code + '">' + value.variant_name + '</option>');
                        });
					$('#activity_variant').val(oldactivity_variant).prop('selected', true);
					$("#activity_variant").prop("disabled",false);
					
					
                }
            });
        });

$(document).on('change', '.inputsave', function(evt) {
		$("#loader-overlay").show();
	var id= $(this).data('id');
    var inputname =  $(this).data('name');
    var txt_var =  $(this).val();
   
		$.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
		$.ajax({
            url: "{{route('voucherHotelInputSave')}}",
            type: 'POST',
            dataType: "json",
            data: {
               id: id,
			   inputname: inputname,
			   val: $(this).val(),
			   type: "Report",
			   report_type: "Hotel"
            },
            success: function( data ) {
	
			  $("#loader-overlay").hide();
            }
          });
	 });
	 
        $(document).on('change', '.inputsaveSp', function(evt) {
		$("#loader-overlay").show();
		var id = $(this).find(':selected').data('id');
		var inputname = $(this).find(':selected').data('name');
		//alert(inputname);
		$.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
		$.ajax({
            url: "{{route('voucherHotelInputSave')}}",
            type: 'POST',
            dataType: "json",
            data: {
               id: id,
			   inputname: inputname,
			   val: $(this).val(),
			   type: "Report",
			   report_type: "Hotel"
            },
            success: function( data ) {
	
			  $("#loader-overlay").hide();
            }
          });
	 });

		if(activity_id){
					$("body #activity_id").trigger("change");
					}
					
		if(oldactivity_variant){
					$("body #activity_id").trigger("change");
					}
		});

var path = "{{ route('auto.agent.supp') }}";
  
  $( "#agent_id" ).autocomplete({
	  source: function( request, response ) {
		$.ajax({
		  url: path,
		  type: 'GET',
		  dataType: "json",
		  data: {
			 search: request.term,
		  },
		  success: function( data ) {
			 response( data );
		  }
		});
	  },
	  
	  select: function (event, ui) {
		 $('#agent_id').val(ui.item.label);
		 //console.log(ui.item); 
		 $('#agent_id_select').val(ui.item.value);
		  $('#agent_details').html(ui.item.agentDetails);
		 return false;
	  },
	  change: function(event, ui){
		  // Clear the input field if the user doesn't select an option
		  if (ui.item == null){
			  $('#agent_id').val('');
			   $('#agent_id_select').val('');
			   $('#agent_details').html('');
		  }
	  }
	});
			</script>  
@endsection