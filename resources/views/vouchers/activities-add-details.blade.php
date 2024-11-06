@extends('layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header d-done" >
      <div class="container-fluid">
        <div class="row mb-2">
          <!-- <div class="col-sm-6">
            <h1>Voucher Code :{{$voucher->code}}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
			 <li class="breadcrumb-item"><a href="{{ route('vouchers.index') }}">Vouchers</a></li>
              <li class="breadcrumb-item"><a href="{{ route('voucher.add.activity',[$voucher->id]) }}">Activities</a></li>
              <li class="breadcrumb-item active">Activity Details</li>
            </ol>
          </div> -->
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content" id="activities-list-blade">
    <div class="row">
        <div class="col-md-12">
		
          <div class="card">
           
			
			<div class="card-body">
			<div class="row">
			
				 <div class="col-md-7">
				 @if(!empty($activity->image))
               
			   <img src="{{asset('uploads/activities/'.$activity->image)}}"  class="img-fluid" style="border-radius: 5px;" />
			 
			 @endif
				 </div>
					<div class="col-md-5">
						<div class="row">
								
							@if($activity->images->count() > 0)
								
										
								@foreach($activity->images as $k => $image)
								@if($k < 6)
								<div class="col-md-6" style="margin-bottom: 16px;">
								<img src="{{asset('uploads/activities/'.$image->filename)}}"  class="img-fluid"  style="border-radius: 5px;">
								</div>
								@endif 
								@endforeach
							
							@endif 
							</div>
					
					</div>
			   
	
				
			 </div>
			 <hr class="col-md-12">
			  <div class="row">
			   <div class="col-md-6" >
				 <h3><i class="far fa-fw  fa-check-circle"></i> {{$activity->title}}</h3>
              </div>
			   <div class="col-md-6 text-right">
			   @php
            $minPrice = $activity->min_price;
          @endphp
		  <small>Starting From </small><br/>
				 <h3>AED {{$minPrice}}</h3>
              </div>
			  
			  </div>
			 
			    <div class="row">
					<div class="col-md-12">
						<ul class="list-inline list-group list-group-horizontal">
							<li style="padding-right: 10px;">
							<i class="fas fa-fw fa-clock"></i> 2 Hours Approx
							</li>
							<li style="padding-right: 10px;">
							<i class="far fa-fw  fa-check-circle "></i> Mobile Voucher Accepted
							</li>
							<li style="padding-right: 10px;">
							<i class="far fa-fw  fa-check-circle"></i> Instant Confirmation 
							</li>
							<li style="padding-right: 10px;">
							<i class="fas fa-exchange-alt"></i> Transfer Available 
							</li>
						</ul>
					</div>
			  </div>

			 
			    <div class="row fixme">
					<div class="col-md-12">
						<ul class="list-inline list-group list-group-horizontal">
							<li style="padding-right: 10px;">
								<a href="#description">Short Description</a>
							</li>
							<li style="padding-right: 10px;">
								|
							</li>
							<li style="padding-right: 10px;">
								<a href="#tour_options">Bundle Product Cancellation</a>
							</li>
							<li style="padding-right: 10px;">
								|
							</li>
							<li style="padding-right: 10px;">
								<a href="#inclusion">Description</a>
							</li>
							<li style="padding-right: 10px;">
								|
							</li>
							<li style="padding-right: 10px;">
								<a href="#booking">Notes</a>
							</li>
							
						</ul>
					</div>
			  </div>
			 
				  <div class="form-group col-md-12" id="description"  >
				 
                <h4>Short Description</h4>
				{!! $activity->sort_description !!}
              </div>
			  <div class="form-group col-md-12" id="tour_options"  >
				 <div class="form-group col-md-12" id="inclusion"  >
				 
                <h4>Bundle Product Cancellation</h4>
				{!! $activity->bundle_product_cancellation !!}
              </div>
                <h4>Description</h4>
				{!! $activity->description !!}
              </div>
			  
			  <div class="form-group col-md-12" id="booking"  >
				 
                <h4>Notes</h4>
				{!! $activity->notes !!}
              </div>
			  <hr class="col-md-12 p-30" id="tour_options">
		
			 <div class="card-body pdivvarc" id="pdivvar" style="display: none;">
					  <div class="row p-2">
						 
						<div class="col-md-12 var_data_div_cc" id="var_data_div">
								
							  </div>
						  
					   </div>
					</div>
          <!-- /.card -->
        </div>
      </div>
  
    </section>
	
	<div class="modal fade" id="timeSlotModal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Select Time Slot</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="timeSlotDropdown">Choose a time slot:</label>
                    <select class="form-control" required id="timeSlotDropdown">
                        <!-- Time slots will be dynamically added here -->
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-primary-flip btn-sm" id="selectTimeSlotBtn"><i class="fa fa-cart-plus"></i></button>
                <!-- You can add a button here for further actions if needed -->
            </div>
        </div>
    </div>
</div>

    <!-- /.content -->
@endsection



@section('scripts')
<script  src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js
"></script>
 <script type="text/javascript">
 
  $(document).ready(function() {
	  
			$.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
			
			

  var actid = "{{$activity->id}}";
  var vid = "{{$vid}}";
  
   var inputnumber = $(this).data('inputnumber');
  $("body #loader-overlay").show();
		
           
		$.ajax({
            url: "{{route('get-vouchers.activity.variant')}}",
            type: 'POST',
            dataType: "json",
            data: {
              act: actid,
              vid: vid,
            },
            success: function( data ) {
               //console.log( data.html );
               //alert("#var_data_div");
               
             //$("body .var_data_div_cc").html('');
             //$("body .pdivvarc").css('display','none');
			      $("body #var_data_div").html(data.html);
            $("body #pdivvar").css('display','block');
            $("body #loader-overlay").hide();
			$(".tour_datepicker").datepicker({
							minDate: new Date(),
							weekStart: 1,
							daysOfWeekHighlighted: "6,0",
							autoclose: true,
							todayHighlight: true,
							dateFormat: 'dd-mm-yy'
                    });
			// Onload change price 
			var pvttr =  $("body #transfer_option0").find(':selected').val();
			$("body #adult0").trigger("change");
			if(pvttr == 'Pvt Transfer'){
				setTimeout(function() {
				$("body .t_option#transfer_option0").trigger("change");
				}, 1000);
			}
			
			if(pvttr == 'Shared Transfer'){
				$("body .t_option#transfer_option0").trigger("change");
			}
			 $('.actcsk:first').prop('checked', true).trigger("change");
            }
          });

});
</script>  

<script type="text/javascript">
  $(document).ready(function() {
	  $('body #cartForm').validate({});
   adultChildReq(0,0,0);
 
 $(document).on('change', '.priceChange', function(evt) {
  const inputnumber = $(this).data('inputnumber');
  const activityVariantId = $("body #activity_variant_id" + inputnumber).val();
  const adult = parseInt($("body #adult" + inputnumber).val());
  const child = parseInt($("body #child" + inputnumber).val());
  const infant = parseInt($("body #infant" + inputnumber).val());
  const discount = parseFloat($("body #discount" + inputnumber).val());
  const tourDate = $("body #tour_date" + inputnumber).val();
  const transferOption = $("body #transfer_option" + inputnumber).find(':selected').data("id");
  const transferOptionName = $("body #transfer_option" + inputnumber).find(':selected').val();
  const variantId = $("body #transfer_option" + inputnumber).find(':selected').data("variant");
  let zonevalue = 0;
  let zoneValueChild = 0;
  const agentId = "{{$voucher->agent_id}}";
  const voucherId = "{{$voucher->id}}";
  let grandTotal = 0;

  const transferZoneTd = $("body #transfer_zone_td" + inputnumber);
  const colTd = $("body .coltd");
  const transferZone = $("body #transfer_zone" + inputnumber);
  const loaderOverlay = $("body #loader-overlay");

  transferZoneTd.css("display", "none");
  colTd.css("display", "none");
  transferZone.prop('required', false);
  //transferZone.prop('disabled', true);
  if (transferOption == 2) {
    transferZoneTd.css("display", "block");
    colTd.css("display", "block");
    transferZone.prop('required', true);
	//transferZone.prop('disabled', false);
    zonevalue = parseFloat(transferZone.find(':selected').data("zonevalue"));
	zoneValueChild = parseFloat(transferZone.find(':selected').data("zonevaluechild"));
  } else if (transferOption == 3) {
    colTd.css("display", "block");
  }

  loaderOverlay.show();
	adultChildReq(adult,child,inputnumber);
  const argsArray = {
    transfer_option: transferOptionName,
    activity_variant_id: activityVariantId,
    agent_id: agentId,
    voucherId: voucherId,
    adult: adult,
    infant: infant,
    child: child,
    discount: discount,
    tourDate: tourDate,
    zonevalue: zonevalue,
	 zoneValueChild: zoneValueChild
  };

  getPrice(argsArray)
    .then(function(price) {
      $("body #price" + inputnumber).html(price.variantData.totalprice);
	  $("body #totalprice" + inputnumber).val(price.variantData.totalprice);
    })
    .catch(function(error) {
      console.error('Error:', error);
    })
    .finally(function() {
      loaderOverlay.hide();
    });
});
 
 
 $(document).on('change', '.actcsk', function(evt) {
   let inputnumber = $(this).data('inputnumber');
    const adult = parseInt($("body #adult" + inputnumber).val());
  const child = parseInt($("body #child" + inputnumber).val());
   adultChildReq(adult,child,inputnumber);
    $("body .priceChange").prop('required',false);
	// $("body .priceChange").prop('disabled',true);
	// $("body .addToCart").prop('disabled',true);
	$("body #ucode").val('');
	$('#timeslot').val('');
	$("body .priceclass").text(0);
   if ($(this).is(':checked')) {
       $("body #transfer_option"+inputnumber).prop('required',true);
		$("body #tour_date"+inputnumber).prop('required',true);
     
     $("body #transfer_option"+inputnumber).prop('disabled',false);
     $("body #tour_date"+inputnumber).prop('disabled',false);
	 $("body #addToCart"+inputnumber).prop('disabled',false);
     $("body #adult"+inputnumber).prop('disabled',false);
     $("body #child"+inputnumber).prop('disabled',false);
     $("body #infant"+inputnumber).prop('disabled',false);
     $("body #discount"+inputnumber).prop('disabled',false);
	 $("body #adult"+inputnumber).trigger("change");
	 var ucode = $("body #activity_select"+inputnumber).val();
	 $("body #ucode").val(ucode);
     }
 });

  $(document).on('click', '.addToCart', function(evt) {
	  evt.preventDefault();
	 if($('body #cartForm').validate({})){
		 variant_id = $(this).data('variantid');
		 inputnumber = $(this).data('inputnumber');
		 const transferOptionName = $("body #transfer_option" + inputnumber).find(':selected').val();
		 $.ajax({
			  url: "{{ route('get.variant.slots') }}",
			  type: 'POST',
			  dataType: "json",
			  data: {
				  variant_id:variant_id,
				  transferOptionName:transferOptionName
				  },
			  success: function(data) {
				  if(data.status == 1) {
						
						var timeslot = $('#timeslot').val();
						if(timeslot==''){
							openTimeSlotModal(data.slots);
						} 
					} else if (data.status == 2) {
						$("body #cartForm").submit();
					}
				//console.log(data);
			  },
			  error: function(error) {
				console.log(error);
			  }
		});
		  
	 }
	
 });
 });
 


 
 function getPrice(argsArray) {
	argsArray.adult = (isNaN(argsArray.adult))?0:argsArray.adult;
	argsArray.child = (isNaN(argsArray.child))?0:argsArray.child;
  return new Promise(function(resolve, reject) {
    $.ajax({
      url: "{{ route('get-activity.variant.price') }}",
      type: 'POST',
      dataType: "json",
      data: argsArray,
      success: function(data) {
        resolve(data);
      },
      error: function(error) {
        reject(error);
      }
    });
  });
}

function adultChildReq(a,c,inputnumber) {
	a = (isNaN(a))?0:a;
	c = (isNaN(c))?0:c;
  var total = a+c;
  if(total == 0){
	  $("body #adult"+inputnumber).prop('required',true); 
  } else {
	  $("body #adult"+inputnumber).prop('required',false); 
  }
}

  function openTimeSlotModal(slots, selectedSlot) {
    var isValid = $('body #cartForm').valid();
    if (isValid) {
        $('#timeSlotModal').modal('show');

        var dropdown = $('#timeSlotDropdown');
        dropdown.empty();

        $.each(slots, function(index, slot) {
            var option = $('<option></option>').attr('value', slot).text(slot);
            if (slot === selectedSlot) {
                option.attr('selected', 'selected');
            }
            dropdown.append(option);
        });

        dropdown.on('change', function() {
            var selectedValue = dropdown.val();
			$('body #timeslot').val('');
            if (selectedValue !== 'select') {
                $('#timeslot').val(selectedValue);
				$("body #timeSlotDropdown").removeClass('error-rq');
            }
        });

        $('#selectTimeSlotBtn').on('click', function() {
				var timeslot = $('body #timeslot').val();
				$("body #timeSlotDropdown").removeClass('error-rq');
				//if(timeslot==''){
				//$("body #timeSlotDropdown").addClass('error-rq');
				//} else { 
					$("body #cartForm").submit();
				//}
						
            
        });

        $('#timeSlotModal .close').on('click', function() {
            $('body #timeslot').val('');
            $('#timeSlotModal').modal('hide');
        });
    }
}

 $(document).on('keypress', '.onlynumbrf', function(evt) {
   var charCode = (evt.which) ? evt.which : evt.keyCode
   if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
     return false;
   return true;
 
 });
 
 </script> 
@endsection
