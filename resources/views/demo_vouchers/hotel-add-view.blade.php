@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Voucher Code :{{$voucher->code}} , Hotel : {{ $hotel->name }} </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
			 <li class="breadcrumb-item"><a href="{{ route('vouchers.index') }}">Vouchers</a></li>
              <li class="breadcrumb-item"><a href="{{ route('voucher.add.hotels',[$voucher->id]) }}">Hotels</a></li>
              <li class="breadcrumb-item active">Hotel Details</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
    <div class="row">
        <div class="col-md-12">
		@php
		$tourDateArray = SiteHelpers::getDateList($voucher->travel_from_date,$voucher->travel_to_date)
		@endphp
          <div class="card">
           
			
			<div class="card-body">
			
			
			<header class="profile-header">
          <div class="profile-image" style="border-radius:0px;height:auto;margin-bottom:258px"> @if(!empty($hotel->image))<img src="{{asset('uploads/hotels/'.$hotel->image)}}"  />@endif </div>
				<div class="profile-content">
				
					<div class="row">
              
			 
			      <div class="col-lg-4 mb-3">
                <label for="inputName">Brand Name:</label>
                {{ $hotel->brand_name }}
              </div>
			  <div class="col-lg-4 mb-3">
                <label for="inputName">Formerly Name:</label>
                {{ $hotel->formerly_name }}
              </div>
			  <div class="col-lg-4 mb-3">
                <label for="inputName">Translates Name:</label>
                {{ $hotel->translates_name }}
              </div>
			  <div class="col-lg-4 mb-3">
                <label for="inputName">Mobile:</label>
                {{ $hotel->mobile }}
              </div>
			  <div class="col-lg-4 mb-3">
                <label for="inputName">Address Line 1:</label>
                {{ $hotel->address }}
              </div>
			   <div class="col-lg-4 mb-3">
                <label for="inputName">Address Line 2:</label>
                {{ $hotel->address2 }}
              </div>
			  <div class="col-lg-4 mb-3">
                <label for="inputName">Hotel Category:</label>
				{{ ($hotel->hotelcategory)?$hotel->hotelcategory->name:''}}
              </div>
              <div class="form-group col-lg-4 mb-3">
                <label for="inputName">City:</label>
                {{($hotel->city)?$hotel->city->name:''}}
              </div>
			  <div class="form-group col-lg-4 mb-3">
                <label for="inputName">State:</label>
                {{($hotel->state)?$hotel->state->name:''}}
              </div>
              <div class="form-group col-lg-4 mb-3">
                <label for="inputName">Country:</label>
                {{($hotel->country)?$hotel->country->name:''}}
              </div>
              <div class="form-group col-lg-4 mb-3">
                <label for="inputName">Zip Code:</label>
                {{$hotel->zip_code}}
              </div>
			   <div class="form-group col-lg-4 mb-3">
                <label for="inputName">Zone:</label>
               {{($hotel->zone)?$hotel->zone->name:''}}
              </div>
			   <div class="form-group col-lg-4 mb-3">
                <label for="inputName">Location:</label>
                {{$hotel->location}}
              </div>
			  <div class="form-group col-lg-4 mb-3">
                <label for="inputName">Longitude:</label>
                {{$hotel->longitude}}
              </div>
			  <div class="form-group col-lg-4 mb-3">
                <label for="inputName">Latitude:</label>
                {{$hotel->latitude}}
              </div>
			  <div class="form-group col-lg-4 mb-3">
                <label for="inputName">Overview:</label>
                {{$hotel->overview}}
              </div>
			  <div class="form-group col-lg-4 mb-3">
                <label for="inputName">Continent Name:</label>
                {{$hotel->continent_name}}
              </div>
			  <div class="form-group col-lg-4 mb-3">
                <label for="inputName">Accommodation Type:</label>
                {{$hotel->accommodation_type}}
              </div>
             
          
			
          </div>	
		  
				</div>
          
			
				</header>
				<form action="{{route('voucher.hotel.save')}}" method="post" class="form" enctype="multipart/form-data">
				{{ csrf_field() }}
				<div class="row p-2">
				<div class="col-lg-12">
				<h3>Hotel Details</h3>
				</div>
				 <div class="col-lg-6 mb-3">
                <label for="inputName">Check In Date: <span class="red">*</span></label>
				<select name="check_in_date" id="check_in_date" class="form-control" required  >
						
						<option value="">--Select--</option>
						@foreach($tourDateArray as $dt)
						<option value="{{$dt}}" @if($dt==$voucher->travel_from_date) selected @endif>{{$dt}}</option>
						@endforeach
						
						</select>
              
			
              </div>
			   <div class="col-lg-6 mb-3">
                <label for="inputName">Check Out Date: <span class="red">*</span></label>
				<select name="check_out_date" id="check_out_date" class="form-control" required  >
						
						<option value="">--Select--</option>
						@foreach($tourDateArray as $dt2)
						<option value="{{$dt2}}" @if($dt2==$voucher->travel_to_date) selected @endif>{{$dt2}}</option>
						@endforeach
						
						</select>
              
				
              </div>
				 <div class="col-lg-12">
				 <a href="javascript:;" class="btn btn-success float-right btn-sm" id="addMoreBtn"><i class="fas fa-plus"></i> Add More</a>
				 <input type="hidden" id="hotel_id" name="hotel_id" value="{{ $hid }}"  />
				 <input type="hidden" id="v_id" name="v_id" value="{{ $vid }}"  />
				 </div>
				 
				  </div>
				<div id="hDetailsDiv">
				<div class="bg-row row p-2">
			 
			 
			  <div class="col-md-12">
                <table class="table table-bordered">
                  <thead>
				   <tr>
                    <th>Room Type</th>
					<th><input type="text" id="room_type1" required name="room_type[]"  class="form-control"    /></th>
					<th colspan="4"></th>
                  </tr>
				   <tr>
                    <th>Number of Rooms</th>
					<th ><input type="text" id="nom_of_room1" required name="nom_of_room[]"  class="form-control onlynumbr"   /></th>
					<th colspan="4"></th>
                  </tr>
				  <tr>
                    <th>Meal Plan</th>
					<th >
						<select name="mealplan[]" id="mealplan1" class="form-control" required  >
						
							<option value="">--Select--</option>
							<option value="Room Only">Room Only</option>
							<option value="Breakfast">Breakfast</option>
							<option value="Breakfast and Lunch or Dinner">Breakfast and Lunch or Dinner</option>
							<option value="MAP">MAP</option>
							<option value="All Meals">All Meals</option>
							</select>
						</th>
					<th colspan="4"></th>
                  </tr>
                  <tr>
					<th></th>
                    <th>Single</th>
					<th>Double</th>
					<th>Extra Bed</th>
                    <th>CWB</th>
                    <th>CNB</th>
                  </tr>
				   <tr>
                    <th>Number of Pax</th>
					<td><input type="text" id="nop_s1"  name="nop_s[]" tabindex="0"  class="form-control onlynumbrf psingle" data-inputnumber="1" value="0" required  /></td>
					<td><input type="text" id="nop_d1"  name="nop_d[]"  tabindex="2" class="form-control onlynumbrf pdouble" data-inputnumber="1" required  /></td>
					<td><input type="text" id="nop_eb1"  name="nop_eb[]" tabindex="4" class="form-control onlynumbrf peb" data-inputnumber="1" value="0" required  /></td>
                    <td><input type="text" id="nop_cwb1" name="nop_cwb[]" tabindex="6" class="form-control onlynumbrf pcwb" data-inputnumber="1" value="0" required /></td>
                    <td><input type="text" id="nop_cnb1"  name="nop_cnb[]"  tabindex="7" class="form-control onlynumbrf pcnb" data-inputnumber="1" value="0" required  /></td>
                  </tr>
				  <tr>
                    <th>Net Rate</th>
					<td><input type="text" id="nr_s1"  name="nr_s[]" value="0"  tabindex="1" required class="form-control onlynumbrf psingle" data-inputnumber="1" /></td>
					<td><input type="text" id="nr_d1"  name="nr_d[]"  required tabindex="3" class="form-control onlynumbrf pdouble" data-inputnumber="1" required  /></td>
					<td><input type="text" id="nr_eb1"  name="nr_eb[]" value="0"  tabindex="5" required class="form-control onlynumbrf peb "  data-inputnumber="1" /></td>
                    <td><input type="text" id="nr_cwb1" name="nr_cwb[]" value="0" tabindex="7" required class="form-control onlynumbrf pcwb" data-inputnumber="1" /></td>
                    <td><input type="text" id="nr_cnb1"  name="nr_cnb[]" value="0"  tabindex="9" required  class="form-control onlynumbrf pcnb" data-inputnumber="1" /></td>
                  </tr>
				   <tr>
                    <th>Per Pax to be autocalculated</th>
					<td><input type="text" id="ppa_s1"  name="ppa_s[]" value="0" required readonly class="form-control onlynumbrf " data-inputnumber="1" /></td>
					<td><input type="text" id="ppa_d1"  name="ppa_d[]" value="0" required readonly class="form-control onlynumbrf "  data-inputnumber="1" /></td>
					<td><input type="text" id="ppa_eb1"  name="ppa_eb[]" value="0" required readonly class="form-control onlynumbrf" data-inputnumber="1"  /></td>
                    <td><input type="text" id="ppa_cwb1" name="ppa_cwb[]" value="0" required readonly class="form-control onlynumbrf" data-inputnumber="1" /></td>
                    <td><input type="text" id="ppa_cnb1"  name="ppa_cnb[]" value="0" required readonly class="form-control onlynumbrf" data-inputnumber="1" /></td>
                  </tr>
				   <tr>
                    <th>Mark Up in % (Default Value (5%)</th>
					<td><input type="text" id="markup_p_s1"  name="markup_p_s[]" required  class="form-control onlynumbrf psingle" value="5" data-inputnumber="1" required /></td>
					<td><input type="text" id="markup_p_d1" value="5" name="markup_p_d[]" required class="form-control onlynumbrf pdouble" data-inputnumber="1"  /></td>
					<td><input type="text" id="markup_p_eb1" value="5"  name="markup_p_eb[]"  required class="form-control onlynumbrf peb" data-inputnumber="1"  /></td>
                    <td><input type="text" id="markup_p_cwb1" value="5" name="markup_p_cwb[]" required class="form-control onlynumbrf pcwb" data-inputnumber="1" /></td>
                    <td><input type="text" id="markup_p_cnb1" value="5" name="markup_p_cnb[]" required class="form-control onlynumbrf pcnb" data-inputnumber="1" /></td>
                  </tr>
				   <tr>
                    <th>Mark up Value</th>
					<td><input type="text" id="markup_v_s1"  name="markup_v_s[]" value="0"  class="form-control onlynumbrf " readonly data-inputnumber="1"  /></td>
					<td><input type="text" id="markup_v_d1"  name="markup_v_d[]" value="0"  class="form-control onlynumbrf " readonly data-inputnumber="1"   /></td>
					<td><input type="text" id="markup_v_eb1"  name="markup_v_eb[]"  class="form-control onlynumbrf" readonly data-inputnumber="1" value="0"  /></td>
                    <td><input type="text" id="markup_v_cwb1" name="markup_v_cwb[]"  class="form-control onlynumbrf" readonly data-inputnumber="1" value="0"  /></td>
                    <td><input type="text" id="markup_v_cnb1"  name="markup_v_cnb[]"  class="form-control onlynumbrf" readonly data-inputnumber="1" value="0"  /></td>
                  </tr>
				  </table>
              </div>
			 </div>	
			 </div>	
			  <div class="row">

        <div class="col-12 mt-3">
          <a href="{{ route('vouchers.index') }}" class="btn btn-secondary">Back To Vouchers</a>
		  
		   <a href="{{route('vouchers.show',$vid)}}" class="btn btn-secondary mr-2">View Vouchers</a>
          <button type="submit" class="btn btn-primary float-right" name="save">Save</button>
			<button type="submit" class="btn btn-success float-right mr-2" name="save_and_continue">Save & Add More Hotel</button>
        </div>
      </div>
			 </form>
          <!-- /.card-body --> 
        </div>
		
          
			
          </div>
		 
          <!-- /.card -->
        </div>
      </div>
  
    </section>
    <!-- /.content -->
@endsection



@section('scripts')
 <script type="text/javascript">
 $(document).ready(function() {
	var rowCount = 1;
	
	$(document).on('click', '#addMoreBtn', function() {
		rowCount++;
		var data = {
			rowCount: rowCount,
			hotel_id : $('#hotel_id').val(),
			v_id : $('#v_id').val()
		};
	$.ajax({
    url: "{{ route('voucher.hotel.new.row') }}",
	data: data,	
    type: 'GET',
    dataType: 'json',
    success: function(response) {
        // Append the content to the DOM
		
			$('#hDetailsDiv').append(response.html);
				/* $('.datepicker').datepicker({
				weekStart: 1,
				daysOfWeekHighlighted: "6,0",
				autoclose: true,
				todayHighlight: true,
				format: 'yyyy-mm-dd'
			}); */
			

    },
    error: function(xhr, status, error) {
        console.error(error);
    }
});
});

$("body").on('click','.remove-btn',function(){
			$(this).parent().parent().remove();
		});

});

$(document).on('keypress', '.onlynumbrf', function(evt) {
	var charCode = (evt.which) ? evt.which : evt.keyCode
  if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
    return false;
  return true;

  }); 
  $(document).on('keypress', '.onlynumbr', function(evt) {
	var charCode = (evt.which) ? evt.which : evt.keyCode
  if (charCode > 31 && (charCode < 48 || charCode > 57))
    return false;
  return true;

});

$(document).on('change', '.psingle', function(evt) {
	let inputnumber = $(this).data('inputnumber');
	let numberofPax = $("body #nop_s"+inputnumber).val();
	let netRate = $("body #nr_s"+inputnumber).val();
	
	let perPax = 0;
	if((numberofPax > 0) && (netRate > 0))
	{
		perPax = netRate / numberofPax;
	}
	
	$("body #ppa_s"+inputnumber).val(perPax.toFixed(2));
	
	//Markup Cal
	let markUpP = $("body #markup_p_s"+inputnumber).val() / 100;
	let taxvalu = markUpP*netRate;
	$("body #markup_v_s"+inputnumber).val(taxvalu.toFixed(2));
});

$(document).on('change', '.pdouble', function(evt) {
	let inputnumber = $(this).data('inputnumber');
	let numberofPax = $("body #nop_d"+inputnumber).val();
	let netRate = $("body #nr_d"+inputnumber).val();
	
	let perPax = 0;
	if((numberofPax > 0) && (netRate > 0))
	{
		perPax = netRate / numberofPax;
	}
	
	$("body #ppa_d"+inputnumber).val(perPax.toFixed(2));
	
	//Markup Cal
	let markUpP = $("body #markup_p_d"+inputnumber).val() / 100;
	let taxvalu = markUpP*netRate;
	$("body #markup_v_d"+inputnumber).val(taxvalu.toFixed(2));
});

$(document).on('change', '.peb', function(evt) {
	let inputnumber = $(this).data('inputnumber');
	let numberofPax = $("body #nop_eb"+inputnumber).val();
	let netRate = $("body #nr_eb"+inputnumber).val();
	
	let perPax = 0;
	if((numberofPax > 0) && (netRate > 0))
	{
		perPax = netRate / numberofPax;
	}
	
	$("body #ppa_eb"+inputnumber).val(perPax.toFixed(2));
	
	//Markup Cal
	let markUpP = $("body #markup_p_eb"+inputnumber).val() / 100;
	let taxvalu = markUpP*netRate;
	$("body #markup_v_eb"+inputnumber).val(taxvalu.toFixed(2));
});

$(document).on('change', '.pcwb', function(evt) {
	let inputnumber = $(this).data('inputnumber');
	let numberofPax = $("body #nop_cwb"+inputnumber).val();
	let netRate = $("body #nr_cwb"+inputnumber).val();
	
	let perPax = 0;
	if((numberofPax > 0) && (netRate > 0))
	{
		perPax = netRate / numberofPax;
	}
	
	$("body #ppa_cwb"+inputnumber).val(perPax.toFixed(2));
	
	//Markup Cal
	let markUpP = $("body #markup_p_cwb"+inputnumber).val() / 100;
	let taxvalu = markUpP*netRate;
	$("body #markup_v_cwb"+inputnumber).val(taxvalu.toFixed(2));
});

$(document).on('change', '.pcnb', function(evt) {
	let inputnumber = $(this).data('inputnumber');
	let numberofPax = $("body #nop_cnb"+inputnumber).val();
	let netRate = $("body #nr_cnb"+inputnumber).val();
	
	let perPax = 0;
	if((numberofPax > 0) && (netRate > 0))
	{
		perPax = netRate / numberofPax;
	}
	
	$("body #ppa_cnb"+inputnumber).val(perPax.toFixed(2));
	
	//Markup Cal
	let markUpP = $("body #markup_p_cnb"+inputnumber).val() / 100;
	let taxvalu = markUpP*netRate;
	$("body #markup_v_cnb"+inputnumber).val(taxvalu.toFixed(2));
});



  </script>   
@endsection
