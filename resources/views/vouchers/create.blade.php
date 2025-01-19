@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Voucher Add</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('vouchers.index') }}">Vouchers</a></li>
              <li class="breadcrumb-item active">Voucher Add</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
    <form action="{{ route('vouchers.store') }}" method="post" class="form">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Add Voucher</h3>
            </div>
            <div class="card-body row">
              <div class="form-group col-md-12">
                <label for="inputName">Agency Name: <span class="red">*</span></label>
				@if($pid > 0)
					 <input type="text" readonly id="agent_id" name="agent_id" value="{{ old('agent_id') ?: $voucher->agent->company_name }}" class="form-control"  placeholder="Agency Name" />
              <input type="hidden" id="agent_id_select" value="{{$voucher->agent_id}}" name="agent_id_select"  />
			  
			@else
				  <input type="text" id="agent_id" name="agent_id" value="{{ old('agent_id') }}" class="form-control"  placeholder="Agency Name" />
			  <input type="hidden" id="agent_id_select" name="agent_id_select"  />
				@endif 
                @if ($errors->has('agent_id'))
                    <span class="text-danger">{{ $errors->first('agent_id') }}</span>
                @endif
				
				
				
              </div>
			   <div class="form-group col-md-12" id="agent_details">
			   @if($pid > 0)
			   <b>Code:</b>{{$voucher->agent->code}}<br/><b> Email:</b>{{$voucher->agent->email}}<br/><b>Mobile No:</b>{{$voucher->agent->mobile}}<br/><b>Address:</b>{{$voucher->agent->address. " ".$voucher->agent->postcode;}}
		   @endif 
			   </div>
				<input type="hidden" id="parent_id" name="parent_id" value="{{$pid}}"  />
			    <div class="form-group col-md-6">
                <label for="inputName">Country: <span class="red">*</span></label>
                <select name="country_id" id="country_id" class="form-control">
				<option value="">--select--</option>
				@foreach($countries as $country)
				@if(!empty(old('country_id')) && old('country_id') == $country->id)
                    <option value="{{$country->id}}"  selected="selected"  >{{$country->name}}</option>
				@endif
				@if(empty(old('country_id')))
					<option value="{{$country->id}}" @if($country->id == 1) {{'selected="selected"'}} @endif  >{{$country->name}}</option>
					@endif
				@endforeach
                 </select>
				 @if ($errors->has('country_id'))
                    <span class="text-danger">{{ $errors->first('country_id') }}</span>
                @endif
              </div>
			 
			   <div class="form-group col-md-3">
                <label for="inputName">Activity: <span class="red">*</span></label>
                <select name="is_activity" id="is_activity" class="form-control">
				@if(!old('is_activity'))
				<option value="1" selected="selected">Yes</option>
				<option value="0" >No</option>
				@else
				<option value="1" @if(old('is_activity') ==1) {{'selected="selected"'}} @else selected @endif>Yes</option>
				 <option value="0" @if(old('is_activity') ==0) {{'selected="selected"'}} @endif >No</option>
                     @endif
                 </select>
              </div>
			  <div class="form-group col-md-3">
                <label for="inputName">Hotel: <span class="red">*</span></label>
                <select name="is_hotel" id="is_hotel" class="form-control">
				@if(!old('is_hotel'))
				<option value="1" >Yes</option>
				<option value="0" selected="selected">No</option>
				@else
				<option value="1" @if(old('is_hotel') ==1) {{'selected="selected"'}} @endif >Yes</option>	
				 <option value="0" @if(old('is_hotel') ==0) {{'selected="selected"'}} @endif >No</option>
                   @endif
					 
                 </select>
              </div>
			   <div class="form-group col-md-4">
                <label for="inputName">Default Adults: <span class="red">*</span></label>
                <input type="text" id="adults" name="adults" value="{{ old('adult')?:1 }}" class="form-control"  placeholder="Adults" />
				  @if ($errors->has('adults'))
                    <span class="text-danger">{{ $errors->first('adults') }}</span>
                @endif
              </div>
			   <div class="form-group col-md-4">
                <label for="inputName">Default Childs:</label>
                <input type="text" id="childs" name="childs" value="{{ old('childs')?:0 }}" class="form-control"  placeholder="Childs" />
				  @if ($errors->has('childs'))
                    <span class="text-danger">{{ $errors->first('childs') }}</span>
                @endif
              </div>
			   <div class="form-group col-md-4">
                <label for="inputName">Default Infants:</label>
                <input type="text" id="infants" name="infants" value="{{ old('infants')?:0 }}" class="form-control"  placeholder="Infants" />
				  @if ($errors->has('infants'))
                    <span class="text-danger">{{ $errors->first('infants') }}</span>
                @endif
              </div>
			  <div class="form-group col-md-3">
                <label for="inputName">Travel Date From: <span class="red">*</span></label>
               <input type="text" id="travel_from_date" name="travel_from_date" value="{{ old('travel_from_date', date('Y-m-d', strtotime('+1 day'))) }}" class="form-control datepickerdiscurdate"  placeholder="Travel Date From" />
				  @if ($errors->has('travel_from_date'))
                    <span class="text-danger">{{ $errors->first('travel_from_date') }}</span>
                @endif
              </div>
			  <div class="form-group col-md-3">
                <label for="inputName">Number Of Night: <span class="red">*</span></label>
               <select name="nof_night" id="nof_night" class="form-control">
			   <option value="">--select--</option>
					@for($i =1; $i<30; $i++)
						@if(!empty(old('nof_night')))
					  <option value="{{$i}}" @if(old('nof_night') == $i) {{'selected="selected"'}} @endif >{{$i}}</option>
						@else
						 <option value="{{$i}}" @if($i == 7) {{'selected="selected"'}} @endif >{{$i}}</option>	
						@endif
					@endfor
                 </select>
				  @if ($errors->has('nof_night'))
                    <span class="text-danger">{{ $errors->first('nof_night') }}</span>
                @endif
              </div>
			   <div class="form-group col-md-3">
                <label for="inputName">Travel Date To: <span class="red">*</span></label>
               <input type="text" id="travel_to_date" name="travel_to_date" value="{{ old('travel_to_date') }}" class="form-control" readonly placeholder="Travel Date To" />
				  @if ($errors->has('travel_to_date'))
                    <span class="text-danger">{{ $errors->first('travel_to_date') }}</span>
                @endif
              </div>
			   <div class="form-group col-md-1">
                <label for="inputName">Vat Invoice:</label>
               <select name="vat_invoice" id="vat_invoice" class="form-control">
               @if(!old('vat_invoice'))
				<option value="1" selected="selected">Yes</option>
				<option value="0" >No</option>
				@else
				<option value="1" @if(old('vat_invoice') ==1) {{'selected="selected"'}} @endif >Yes</option>	
				 <option value="0" @if(old('vat_invoice') ==0) {{'selected="selected"'}} @endif >No</option>
                   @endif
                 
                 </select>
				  @if ($errors->has('vat_invoice'))
                    <span class="text-danger">{{ $errors->first('vat_invoice') }}</span>
                @endif
              </div>
              <div class="form-group col-md-2">
                <label for="inputName">Summary Invoice:</label>
               <select name="summary_invoice" id="summary_invoice" class="form-control">
               @if(!old('summary_invoice'))
				<option value="1" selected="selected">Yes</option>
				<option value="0" >No</option>
				@else
				<option value="1" @if(old('summary_invoice') ==1) {{'selected="selected"'}} @endif >Yes</option>	
				 <option value="0" @if(old('summary_invoice') ==0) {{'selected="selected"'}} @endif >No</option>
                   @endif
                 
                 </select>
				  @if ($errors->has('summary_invoice'))
                    <span class="text-danger">{{ $errors->first('summary_invoice') }}</span>
                @endif
              </div>
			  <div class="form-group col-md-12 hide">
                <label for="inputName">Flight: <span class="red">*</span></label>
                <select name="is_flight" id="is_flight" class="form-control">
                    <option value="1" @if(old('is_flight') ==1) {{'selected="selected"'}} @endif>Yes</option>
					<option value="0" @if(old('is_flight') ==0) {{'selected="selected"'}} @endif >No</option>
                 </select>
              </div>
			  
			   <div class="form-group col-md-3 flight_is_div">
                <label for="inputName">Arrival Airline: <span class="red">*</span></label>
                <select name="arrival_airlines_id" id="arrival_airlines_id" class="form-control">
				<option value="">--select--</option>
                   @foreach($airlines as $airline)
                    <option value="{{$airline->id}}" @if(old('arrival_airlines_id') == $airline->id) {{'selected="selected"'}} @endif>{{$airline->name}}</option>
				@endforeach
                 </select>
				  @if ($errors->has('arrival_airlines_id'))
                    <span class="text-danger">{{ $errors->first('arrival_airlines_id') }}</span>
                @endif
              </div>
			   <div class="form-group col-md-2 flight_is_div">
                <label for="inputName">Arrival Date: <span class="red">*</span></label>
                 <input type="text" id="arrival_date" name="arrival_date" value="{{ old('arrival_date') }}" class="form-control datepicker"  placeholder="Arrival Date" />
				  @if ($errors->has('arrival_date'))
                    <span class="text-danger">{{ $errors->first('arrival_date') }}</span>
                @endif
              </div>
			  <div class="form-group col-md-3 flight_is_div">
                <label for="inputName">Arrival Airport: <span class="red">*</span></label>
                 <input type="text" id="arrival_airport" name="arrival_airport" value="{{ old('arrival_airport') }}" class="form-control"  placeholder="Arrival Airport" />
				  @if ($errors->has('arrival_airport'))
                    <span class="text-danger">{{ $errors->first('arrival_airport') }}</span>
                @endif
              </div>
			  <div class="form-group col-md-2 flight_is_div">
                <label for="inputName">Arrival Terminal: <span class="red">*</span></label>
                 <input type="text" id="arrival_terminal" name="arrival_terminal" value="{{ old('arrival_terminal') }}" class="form-control "  placeholder="Arrival Terminal" />
				  @if ($errors->has('arrival_terminal'))
                    <span class="text-danger">{{ $errors->first('arrival_terminal') }}</span>
                @endif
              </div>
			  <div class="form-group col-md-2 flight_is_div">
                <label for="inputName">Arrival Flight No: <span class="red">*</span></label>
                 <input type="text" id="arrival_flight_no" name="arrival_flight_no" value="{{ old('arrival_flight_no') }}" class="form-control "  placeholder="Arrival Flight No" />
				  @if ($errors->has('arrival_flight_no'))
                    <span class="text-danger">{{ $errors->first('arrival_flight_no') }}</span>
                @endif
              </div>
			  <div class="form-group col-md-3 flight_is_div">
                <label for="inputName">Depature Airline: <span class="red">*</span></label>
                <select name="depature_airlines_id" id="depature_airlines_id" class="form-control">
				<option value="">--select--</option>
                   @foreach($airlines as $airline)
                    <option value="{{$airline->id}}" @if(old('depature_airlines_id') == $airline->id) {{'selected="selected"'}} @endif>{{$airline->name}}</option>
				@endforeach
                 </select>
				  @if ($errors->has('depature_airlines_id'))
                    <span class="text-danger">{{ $errors->first('depature_airlines_id') }}</span>
                @endif
              </div>
			   <div class="form-group col-md-2 flight_is_div">
                <label for="inputName">Depature Date: <span class="red">*</span></label>
                <input type="text" id="depature_date" name="depature_date" value="{{ old('depature_date') }}" class="form-control datepicker"  placeholder="Depature Date" />
				 @if ($errors->has('depature_date'))
                    <span class="text-danger">{{ $errors->first('depature_date') }}</span>
                @endif
              </div>
			    <div class="form-group col-md-3 flight_is_div">
                <label for="inputName">Depature Airport: <span class="red">*</span></label>
                 <input type="text" id="depature_airport" name="depature_airport" value="{{ old('depature_airport') }}" class="form-control"  placeholder="Depature Airport" />
				  @if ($errors->has('depature_airport'))
                    <span class="text-danger">{{ $errors->first('depature_airport') }}</span>
                @endif
              </div>
			  <div class="form-group col-md-2 flight_is_div">
                <label for="inputName">Depature Terminal: <span class="red">*</span></label>
                 <input type="text" id="depature_terminal" name="depature_terminal" value="{{ old('depature_terminal') }}" class="form-control "  placeholder="Depature Terminal" />
				  @if ($errors->has('depature_terminal'))
                    <span class="text-danger">{{ $errors->first('depature_terminal') }}</span>
                @endif
              </div>
				<div class="form-group col-md-2 flight_is_div">
                <label for="inputName">Depature Flight No: <span class="red">*</span></label>
                 <input type="text" id="depature_flight_no" name="depature_flight_no" value="{{ old('depature_flight_no') }}" class="form-control "  placeholder="Depature Flight No" />
				  @if ($errors->has('depature_flight_no'))
                    <span class="text-danger">{{ $errors->first('depature_flight_no') }}</span>
                @endif
              </div>
			 </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
      <div class="row">
        <div class="col-12 mb-3">
          <a href="{{ route('vouchers.index') }}" class="btn btn-secondary">Cancel</a>
         
		   <button type="submit" name="save_and_view" class="btn btn-success float-right">Save</button>
        </div>
      </div>
    </form>
	
	<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog" data-backdrop="static">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header"> Add New Customer
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
       <form action="{{ route('customers.store') }}" id="newCustomerForm" method="post" class="form">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-12">
          <div class="card-primary">
          <div id="message"></div>
		  <div id="errors"></div>
            <div class="card-body row">
                <div class="form-group col-md-6">
                <label for="inputName">Name: <span class="red">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control"  placeholder="Name" />
                    <span class="text-danger" id="err_name"></span>
              </div>
			  <div class="form-group col-md-6">
                <label for="inputName">Code: <span class="red">*</span></label>
                <input type="text" id="code" name="code" value="{{ old('code') }}" class="form-control"  placeholder="Name" />
                    <span class="text-danger" id="err_code"></span>
              </div>
                <div class="form-group col-md-6">
                <label for="inputName">Mobile: <span class="red">*</span></label>
                <input type="text" id="mobile" name="mobile" value="{{ old('mobile') }}" class="form-control"  placeholder="Mobile" />
                  <span class="text-danger" id="err_mobile"></span>
              </div>
			   <div class="form-group col-md-6">
                <label for="inputName">Email:</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-control"  placeholder="Email" />
                    <span class="text-danger" id="err_email"></span>
              </div>
                <div class="form-group col-md-6">
                <label for="inputName">Address: <span class="red">*</span></label>
                <input type="text" id="address" name="address" value="{{ old('address') }}" class="form-control"  placeholder="Address" />
                    <span class="text-danger" id="err_address"></span>
              </div>
               
			  <div class="form-group col-md-6">
                <label for="inputName">Country: <span class="red">*</span></label>
                <select name="country_id" id="country_id" class="form-control">
				<option value="">--select--</option>
				@foreach($countries as $country)
                    <option value="{{$country->id}}" @if(old('country_id') == $country->id) {{'selected="selected"'}} @endif>{{$country->name}}</option>
				@endforeach
                 </select>
				 <span class="text-danger" id="err_country_id"></span>
              </div>
			  <div class="form-group col-md-6">
                <label for="inputName">State: <span class="red">*</span></label>
                <select name="state_id" id="state_id" class="form-control">
				<option value="">--select--</option>
				</select>
				 <span class="text-danger" id="err_state_id"></span>
              </div>
              <div class="form-group col-md-6">
                <label for="inputName">City: <span class="red">*</span></label>
                <select name="city_id" id="city_id" class="form-control">
				<option value="">--select--</option>
				</select>
				 <span class="text-danger" id="err_city_id"></span>
              </div>
               <div class="form-group col-md-6">
                <label for="inputName">Zip Code: <span class="red">*</span></label>
                <input type="text" id="zip_code" name="zip_code" value="{{ old('zip_code') }}" class="form-control"   />
                  <span class="text-danger" id="err_zip_code"></span>
				  
				  <input type="hidden" id="status" name="status" value="1"  />
              </div>
			  
            </div>
			
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <button type="submit" class="btn btn-success float-right">Create</button>
        </div>
      </div>
    </form>
      </div>
     
    </div>

  </div>
</div>

    </section>
    <!-- /.content -->
@endsection
@section('scripts')
@include('inc.citystatecountryjs')
<script type="text/javascript">
    var path = "{{ route('auto.agent') }}";
  
    $( "#agent_id" ).autocomplete({
        source: function( request, response ) {
          $.ajax({
            url: path,
            type: 'GET',
            dataType: "json",
            data: {
               search: request.term
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
  
  var pathcustomer = "{{ route('auto.customer') }}";
  
    /* $( "#customer_id" ).autocomplete({
        source: function( request, response ) {
          $.ajax({
            url: pathcustomer,
            type: 'GET',
            dataType: "json",
            data: {
               search: request.term
            },
            success: function( data ) {
               response( data );
            }
          });
        },
        select: function (event, ui) {
           $('#customer_id').val(ui.item.label);
           //console.log(ui.item); 
		   $('#customer_id_select').val(ui.item.value);
		    $('#cus_details').html(ui.item.cusDetails);
           return false;
        },
        change: function(event, ui){
            // Clear the input field if the user doesn't select an option
            if (ui.item == null){
                $('#customer_id').val('');
				 $('#customer_id_select').val('');
				 $('#cus_details').html('');
            }
        }
      }); */
	  
	$(document).ready(function() {
		if($('#is_flight').find(":selected").val() == 1)
		{
		$('.flight_is_div').css('display','block');
		}else{
			$('.flight_is_div').css('display','none');
		}
  
		$('#is_flight').change(function() {
			var selectedOption = $(this).val(); // Get the selected option value
			if(selectedOption==1){
				 $('.flight_is_div').css('display','block');
			}else{
				 $('.flight_is_div').css('display','none');
			}
		});
	});
	
	$(document).ready(function() {
  $('body #newCustomerForm').on('submit', function(e) {
    e.preventDefault(); // Prevent the form from submitting normally
    
    var formData = $(this).serialize(); // Serialize the form data
    
    // Send an Ajax request to the controller method
    $.ajax({
      url: $(this).attr('action'),
      type: 'POST',
      data: formData,
      dataType: 'json',
      success: function(response) {
        if (response.success) {
          // Display a success message
          $('#message').html(response.message);
          $('#message').removeClass('text-danger').addClass('text-success');
		  $('.text-danger').html('');
		  $('#newCustomerForm')[0].reset();
		  //$('#myModal').modal('hide');
        }
      },
      error: function(response) {
        if (response.status === 422) {
          // Display validation errors
          var errors = response.responseJSON.errors;
          var errorHtml = '';
          $.each(errors, function(field, messages) {
			  $('#err_'+field).html(messages[0]);
          });
          
          $('#message').html('Please correct the errors below.');
          $('#message').removeClass('text-success').addClass('text-danger');
        } else {
          // Display a general error message
          $('#message').html('Error: ' + response.responseText);
          $('#message').removeClass('text-success').addClass('text-danger');
        }
      }
    });
  });
  
  $('#travel_from_date, #nof_night').on('change', function() {
    var fromDate = new Date($('#travel_from_date').val());
    var numberOfNights = parseInt($('#nof_night').val());

    if (!isNaN(fromDate) && !isNaN(numberOfNights)) {
      var toDate = new Date(fromDate);
      toDate.setDate(fromDate.getDate() + numberOfNights);
		
      var formattedDate = toDate.toISOString().split('T')[0];
	 
      $('#travel_to_date').val(formattedDate);
    }
  });
  
  $("#nof_night").trigger("change");
  
});



</script>


@endsection
