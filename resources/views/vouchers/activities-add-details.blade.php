@extends('layouts.app')
@section('content')
<style>
  /* Hide the radio button */
  .btn-check {
      position: absolute;
      opacity: 0;
      pointer-events: none;
  }
  .btn-check:checked + .btn-outline-success {
      background-color: #28a745;
      border-color: #28a745; 
      color: white;
      /* box-shadow removed */
  }
  
  /* Optional: You can add a border or other styling to the label when it's selected */
  .btn-check:checked + .btn-outline-success {
      box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.5); 
  }
  
   /* Modal Container */
   #timeSlotModal {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0;
        bottom: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.4);
      }
  
      /* Modal Content */
      #timeSlotModal .modal-content {
        position: absolute;
        bottom: 0;
        background-color: #fff;
        width: 100%;
        max-width: 100%;
        padding: 20px;
        border-radius: 16px 16px 0 0;
        animation: slideUp 0.3s ease-out;
        overflow-y: auto;
      }
  
      .modal-header .close {
        float: right !important;
        font-size: 24px !important;
        font-weight: bold !important;
        color: #888 !important;
        cursor: pointer !important;
      padding:15px 25px !important;
      }
  
      .modal-header .close:hover {
        color: #000 !important;
      }
  
      @keyframes slideUp {
        from {
          bottom: -100%;
          opacity: 0;
        }
        to {
          bottom: 0;
          opacity: 1;
        }
      }
  
      @media screen and (max-height: 500px) {
        #timeSlotModal .modal-content {
          max-height: 80%;
        }
      }
  
  </style>
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
	
    <div class="modal fade" id="timeSlotModal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 100%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabelHeading"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                
        <div class="row">
      <div class="col-sm-3">
              Tour Date
              <input type="text" id="dateTS" value=""  placeholder="Tour Date" class="form-control  timeS"      />
          <input type="hidden" id="s_variant_id" value=""  />
          <input type="hidden" id="s_transferOptionName" value=""  />
          <input type="hidden" id="s_inputnumber" value=""  />
            </div>
            <div class="col-sm-3">
              Adult
               <input type="number" id="adultsTS" min="1"  class="form-control timeS onlynumbr" value="" placeholder="Adults" >
            </div>
            <div class="col-sm-3">
              Child
            <input type="number" id="childrenTS" min="0" class="form-control timeS onlynumbr" value="0" placeholder="Children" >
            </div>
            <div class="col-sm-3">
              Infant
            <input type="number" id="infantTS" min="0" class="form-control timeS onlynumbr" value="0" placeholder="Infant" >
            </div>
          
      </div>
      <div class="row">
      <div class="col-md-12">
          <h6 class="pt-3">Select Time Slot</h6>
    
          <div class="form-group m-1">
          <div id="slotLoader" style="display:none; text-align:left; padding: 2px;">
          <div class="spinner-border text-primary" role="status">
          <span class="sr-only">Loading...</span>
          </div>
          <div>Loading available time slots...</div>
          </div>
    
        <!-- Radio Slot Buttons -->
        <div id="radioSlotGroup">
            <!-- Radio buttons will be dynamically added here -->
        </div>
                    </div>
      </div>
      </div>
                  
                    <div class="col-md-4">
                    <div id="total-price">Total Price: ₹0</div>
      </div>
               
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="selectTimeSlotBtn">Add to Cart</button>
                   
                </div>
            </div>
        </div>
    </div></div>

  <div class="modal fade" id="Noslot" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Slot Unavailable</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               <span id="messageSlot" class="row p-2"></span>
            </div>
            
        </div>
    </div>
</div>
<div class="modal fade" id="PriceModal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Price</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
             <span id="pad" class="row"></span>
       <span id="pchd" class="row"></span>
          </div>
          
      </div>
  </div>
</div>

<div class="modal fade" id="Noslot" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Slot Unavailable</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
             <span id="messageSlot" class="row p-2"></span>
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
    $("body #total-price").html("Total Price: " + price.variantData.totalprice);
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
  $("body .note").addClass('d-none');
	$('#timeslot').val('');
	$("body .priceclass").text(0);
   if ($(this).is(':checked')) {
       $("body #transfer_option"+inputnumber).prop('required',true);
		$("body #tour_date"+inputnumber).prop('required',true);
    $("body #note_"+inputnumber).removeClass('d-none');
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
    const loaderOverlay = $("body #loader-overlay");
	  evt.preventDefault();
    loaderOverlay.show();
	 if($('body #cartForm').validate({})){
		 variant_id = $(this).data('variantid');
		 inputnumber = $(this).data('inputnumber');
		 const transferOptionName = $("body #transfer_option" + inputnumber).find(':selected').val();
     const tour_date = $("body #tour_date" + inputnumber).val();
     const adult = $("body #adult" + inputnumber).val();
     const child = $("body #child" + inputnumber).val();
     const infant = $("body #infant" + inputnumber).val();
     const title = $("body #activity_variant_title" + inputnumber).val();
	  const disabledDates = $("body #disabledDates" + inputnumber).val();
	   const disabledDay = $("body #disabledDay" + inputnumber).val();
     const vdata = {
					variant_id:variant_id,
					title : title,
					key : inputnumber,
					transferOptionName:transferOptionName,
					tour_date:tour_date,
					adult:adult,
					child:child,
					infant:infant,
					disabledDates:disabledDates,
					disabledDay:disabledDay
				  };

		$.ajax({
			  url: "{{ route('get.variant.slots') }}",
			  type: 'POST',
			  dataType: "json",
			  data: {
				  variant_id:variant_id,
				  transferOptionName:transferOptionName,
          tour_date:tour_date,
          adult:adult,
          child:child,
          infant:infant
				  },
          success: function(data) {
				  if(data.status == 1) {
						
						var timeslot = $('#timeslot').val();
						$('#isRayna').val(data.is_rayna);
						if(timeslot==''){
							openTimeSlotModal(data.slots,data.is_rayna,vdata);
              loaderOverlay.hide();
						} 
					} else if(data.status == 4) {
						 $('#Noslot .modal-body #messageSlot').text(data.message).css("color", "red");
						 $('#Noslot').modal('show');
					} else if (data.status == 2) {
						$("body #cartForm").submit();
					}

          loaderOverlay.hide();
				//console.log(data);
			  },
			  error: function(error) {
				console.log(error);
			  }
		});
		  
	 }
	
 });
 
 $(document).on('click', '.priceModalBtn', function(evt) {
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
  if (transferOption == 2) {
    transferZoneTd.css("display", "block");
    colTd.css("display", "block");
    transferZone.prop('required', true);
	transferZone.prop('disabled', false);
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
		$("body #pad").html("AED "+price.variantData.adultTotalPrice+" /Adult");
		$("body #pchd").html("AED "+price.variantData.childTotalPrice+" /Child");
     $('#PriceModal').modal('show');
    })
    .catch(function(error) {
      console.error('Error:', error);
    })
    .finally(function() {
      loaderOverlay.hide();
    });
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

function openTimeSlotModal(slots, isRayna, vdata) {
    var isValid = $('body #cartForm').valid();
    if (!isValid) return;

    // Fill modal fields
    $('#dateTS').val(vdata.tour_date);
    $('#adultsTS').val(vdata.adult);
    $('#childrenTS').val(vdata.child);
    $('#infantTS').val(vdata.infant);
    $('#s_variant_id').val(vdata.variant_id);
    $('#s_transferOptionName').val(vdata.transferOptionName);
	$('#s_inputnumber').val(vdata.key);

    var disabledDates = vdata.disabledDates || [];
    var disabledWeekdays = vdata.disabledDay || [];

    $('#timeSlotModal').modal({
        backdrop: 'static',
        keyboard: false
    }).modal('show');

    $("#exampleModalLabelHeading").html(vdata.title);
    var radioGroup = $('#radioSlotGroup');
    radioGroup.empty();
 var tk = 0;
    
		
		$.each(slots, function(index, slot) {
    var radio = '<input type="radio" class="btn-check" autocomplete="off" id="input_' + tk + '" data-id="' + slot.id + '" name="timeSlotRadio" value="' + slot.time + '" data-available="' + slot.available + '">';
    radio += '<label class="btn btn-outline-success" style="margin:10px;" for="input_' + tk + '">' + slot.time + ' <span class="badge bg-secondary">Avail: ' + slot.available + '</span></label>';
    radioGroup.append(radio);
    tk++;
});


    var inputnumber = vdata.key;
    var priceText = $("#price" + inputnumber).text();
    $("#total-price").html("Total Price: ₹" + priceText);
	const valMapPre = {
        adult: $('#adultsTS').val(),
        child: $('#childrenTS').val(),
        infant: $('#infantTS').val()
    };
	
  $('.timeS').off('change').on('change', function () {
    const valMap = {
        adult: $('#adultsTS').val(),
        child: $('#childrenTS').val(),
        infant: $('#infantTS').val()
    };

    for (let key in valMap) {
        const val = valMap[key];
        const $target = $('#' + key + inputnumber);

        if ($target.is('select')) {
            if ($target.find('option[value="' + val + '"]').length === 0) {
               alert(`Max limit reached for ${key.charAt(0).toUpperCase() + key.slice(1)}!`);
			   
			   if(key=='adult'){
				 $('#adultsTS').val(valMapPre[key]);
				  $target.val(valMapPre[key]);
			   }
			   if(key=='child'){
				 $('#childrenTS').val(valMapPre[key]);
				  $target.val(valMapPre[key]);
			   }
			   if(key=='infant'){
				 $('#infantTS').val(valMapPre[key]);
				  $target.val(valMapPre[key]);
			   }
                continue; 
            }
            $target.val(val);
        } else {
            $target.val(val); 
        }
    }
    $('.priceChange').first().trigger('change');
});


	$('#dateTS').off('change').on('change', function () {
		
		refressTimeSlotModal();
	});
    
    $('body #selectTimeSlotBtn').off('click').on('click', function () {
    const $btn = $(this).prop('disabled', true)
        .html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...')
        .css({ color: '', backgroundColor: '', border: '' });

    var selectedRadio = $('input[name="timeSlotRadio"]:checked');
    var selectedValue = selectedRadio.val();
    var timeSlotId = selectedRadio.data('id');
    var availableSlot = parseInt(selectedRadio.data('available'), 10);

    var adults = parseInt($('#adultsTS').val());
    var children = parseInt($('#childrenTS').val());
    var infants = parseInt($('#infantTS').val());
    var totalpats = adults + children + infants;

    if (totalpats > availableSlot) {
        alert("Please enter pax count based on availability.");
		$('#selectTimeSlotBtn')
        .prop('disabled', false)
        .html('Add to Cart')
        .attr('id', 'selectTimeSlotBtn')
        .attr('class', 'btn btn-success').removeAttr('style');
        return false;
    }

    if (selectedValue) {
        $('#timeslot').val(selectedValue);
         $('#isRayna').val(isRayna); 
        $('#timeSlotId').val($.isNumeric(timeSlotId) ? timeSlotId : 0);
        $('#cartForm').submit();
    } else {
        $('#cartForm').addClass('error-rq');
        $btn.prop('disabled', false).html('Please Select Time Slot').css({
            color: '#000',
            border: '2px solid red'
        });
    }
});


    // Setup Datepicker
    var formattedDisabledDates = disabledDates.map(function(date) {
        return $.datepicker.parseDate('yy-mm-dd', date);
    });

    $('#dateTS').datepicker('destroy').datepicker({
        beforeShowDay: function(date) {
            var day = date.getDay();
            var isDisabledDate = formattedDisabledDates.some(function(d) {
                return d.getTime() === date.getTime();
            });
            return [!(isDisabledDate || disabledWeekdays.includes(day))];
        },
        minDate: new Date(),
        dateFormat: 'dd-mm-yy'
    });

    if (vdata.tour_date) {
        $('#dateTS').datepicker('setDate', vdata.tour_date);
    }

    // Close button handler
    $('#timeSlotModal .close').off('click').on('click', function() {
        $('#timeSlotModal').modal('hide');
    });
}

$(document).on('keypress', '.onlynumbr', function(evt) {
   var charCode = (evt.which) ? evt.which : evt.keyCode
   if ((charCode < 48 || charCode > 57))
     return false;
   return true;
 
 });
 
function refressTimeSlotModal() {
	  
		var tour_date = $('body #dateTS').val();
		var adult = $('body #adultsTS').val();
		var child = $('body #childrenTS').val();
		var infant = $('body #infantTS').val();
		var variant_id = $('body #s_variant_id').val();
		var transferOptionName =  $('body #s_transferOptionName').val();
		
		
        var radioGroup = $('#radioSlotGroup');
        radioGroup.empty();
        var tk = 0;
	 $.ajax({
			  url: "{{ route('get.variant.slots') }}",
			  type: 'POST',
			  dataType: "json",
			data: {
				variant_id:variant_id,
				transferOptionName:transferOptionName,
				tour_date:tour_date,
				adult:adult,
				child:child,
				infant:infant
				  },
        beforeSend: function () {
            $('#slotLoader').show(); 
        },
			  success: function(data) {
				  
				   if(data.status == 1) {
					
					$.each(data.slots, function(index, slot) {
   				var radio = '<input type="radio" class="btn-check" autocomplete="off" id="input_' + tk + '" data-id="' + slot.id + '" name="timeSlotRadio" value="' + slot.time + '" data-available="' + slot.available + '">';
				radio += '<label class="btn btn-outline-success" style="margin:10px;" for="input_' + tk + '">' + slot.time + ' <span class="badge bg-secondary">Avail: ' + slot.available + '</span></label>';
				radioGroup.append(radio);
				tk++;

});

					} else if(data.status == 4) {
						radioGroup.text(data.message).css("color", "red");
					} 

			  },
        complete: function () {
            $('#slotLoader').hide(); // Hide loader
        },
			  error: function(error) {
				console.log(error);
			  }
		});
        
       
}

$(document).on('click', 'input[name="timeSlotRadio"]', function () {
    $('#selectTimeSlotBtn')
        .prop('disabled', false)
        .html('Add to Cart')
        .attr('id', 'selectTimeSlotBtn')
        .attr('class', 'btn btn-success').removeAttr('style');
});

$(document).on('click', '#timeSlotModal .close', function () {
    $('#timeSlotModal').modal('hide');
});
$(document).on('click', '#Noslot .close', function () {
    $('#Noslot').modal('hide');
});

 $(document).on('keypress', '.onlynumbrf', function(evt) {
   var charCode = (evt.which) ? evt.which : evt.keyCode
   if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
     return false;
   return true;
 
 });
 
 </script> 
@endsection
