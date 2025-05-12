@extends('layouts.appLogin')
@section('content')

@php
											$currency = SiteHelpers::getCurrencyPrice();
											@endphp
                      <style>
   

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
     border-radius: 16px 16px 0 0;
     animation: slideUp 0.3s ease-out;
     overflow-y: auto;
   }

    .modal-header .close {
      float: right !important;
font-size: 14px !important;
font-weight: bold !important;
color: #888 !important;
cursor: pointer !important;
padding: -1px 6px !important;
right: 0px;
top: 0px;
    
    }

   .modal-header .close:hover {
     color: #000;
   }
   .modal-footer {

border-bottom: var(--bs-modal-footer-border-width) solid var(--bs-modal-footer-border-color);

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

   .modal-header {
   
    border-bottom: dotted;
}

.quantity-group {
  display: inline-flex;
  align-items: center;
  border: 1px solid #ccc;
  border-radius: 5px;
  overflow: hidden;
  width: 45%;
  height: 38px;
}

.qty-btn {
  background-color: #808080;
  border: none;
  padding: 8px 12px;
  font-size: 20px;
  cursor: pointer;
  user-select: none;
}

.qty-input {
  width: 50px;
  text-align: center;
  border: none;
  font-size: 16px;
  outline: none;
}
 </style>

<div class="breadcrumb-section"
        style="background-image: linear-gradient(270deg, rgba(0, 0, 0, .3), rgba(0, 0, 0, 0.3) 101.02%), url({{asset('front/assets/img/innerpage/inner-banner-bg.png')}});">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 d-flex justify-content-center">
                    <div class="banner-content">
                        <h1> {{$activity->title}}</h1>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('inc.errors-and-messages')
    <!-- Start Room Details section -->
    <div class="package-details-area pt-120 mb-120 position-relative">
        <div class="container">
            <div class="row">
                <div class="co-lg-12">
                    <div class="package-img-group mb-50">
                        <div class="row align-items-center g-3">
                            <div class="col-lg-6">
                                <div class="gallery-img-wrap">
                                @if(!empty($activity->image))
                                  <img src="{{asset('uploads/activities/'.$activity->image)}}"  class="img-fluid" style="border-radius: 5px;" />
                                  @endif
                                  
                                </div>
                            </div>
                            <div class="col-lg-6 h-100">
                                <div class="row g-3 h-100">
                                
                                  @if($activity->images->count() > 0)
                                  @foreach($activity->images as $k => $image)
                                  @if($k<=3)
                                  <div class="col-6">
                                        <div class="gallery-img-wrap">
                                        <img src="{{asset('uploads/activities/'.$image->filename)}}" alt="image">
                                        </div>
                                    </div>
                                  @endif
                                  @endforeach
                                  @endif 
                                    <div class="col-6">
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
           
            <div class="row g-xl-4 gy-5">
                <div class="col-xl-12">
                    <h2>{{$activity->title}}</h2>
                    <div class="tour-price">
                        <h3> @php
            $minPrice = $activity->min_price;
          @endphp
              Starting From : {{$currency['code']}} {{$minPrice*$currency['value']}} </h3><span>per person</span>
                    </div>
                    <ul class="tour-info-metalist">
                        <li>
                            <svg width="14" height="14" viewBox="0 0 14 14" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M14 7C14 8.85652 13.2625 10.637 11.9497 11.9497C10.637 13.2625 8.85652 14 7 14C5.14348 14 3.36301 13.2625 2.05025 11.9497C0.737498 10.637 0 8.85652 0 7C0 5.14348 0.737498 3.36301 2.05025 2.05025C3.36301 0.737498 5.14348 0 7 0C8.85652 0 10.637 0.737498 11.9497 2.05025C13.2625 3.36301 14 5.14348 14 7ZM7 3.0625C7 2.94647 6.95391 2.83519 6.87186 2.75314C6.78981 2.67109 6.67853 2.625 6.5625 2.625C6.44647 2.625 6.33519 2.67109 6.25314 2.75314C6.17109 2.83519 6.125 2.94647 6.125 3.0625V7.875C6.12502 7.95212 6.14543 8.02785 6.18415 8.09454C6.22288 8.16123 6.27854 8.2165 6.3455 8.25475L9.408 10.0048C9.5085 10.0591 9.62626 10.0719 9.73611 10.0406C9.84596 10.0092 9.93919 9.93611 9.99587 9.83692C10.0525 9.73774 10.0682 9.62031 10.0394 9.50975C10.0107 9.39919 9.93982 9.30426 9.842 9.24525L7 7.62125V3.0625Z">
                                </path>
                            </svg>
                            30 Mins
                        </li>
                        <li>
                            <svg width="14" height="14" viewBox="0 0 14 14" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M7 7C7.92826 7 8.8185 6.63125 9.47487 5.97487C10.1313 5.3185 10.5 4.42826 10.5 3.5C10.5 2.57174 10.1313 1.6815 9.47487 1.02513C8.8185 0.368749 7.92826 0 7 0C6.07174 0 5.1815 0.368749 4.52513 1.02513C3.86875 1.6815 3.5 2.57174 3.5 3.5C3.5 4.42826 3.86875 5.3185 4.52513 5.97487C5.1815 6.63125 6.07174 7 7 7ZM14 12.8333C14 14 12.8333 14 12.8333 14H1.16667C1.16667 14 0 14 0 12.8333C0 11.6667 1.16667 8.16667 7 8.16667C12.8333 8.16667 14 11.6667 14 12.8333Z">
                                </path>
                            </svg>
                            Max People : 40
                        </li>
                        
                    </ul>
         
<h4 class="text-30">Description</h4>
            <p class="mt-20">{!! $activity->description !!}</p>


            <div class="pdivvarc" id="pdivvar" style="display: none;">
            <h4>Tour Options</h4>
					  <div class="row p-2">
           
						<div class="col-md-12 var_data_div_cc" id="var_data_div">
								
							  </div>
						  
					   </div>
					</div>

          @include("inc.sidebar_cart")       
          

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
    <div class="row">
	<div class="col-sm-2">
          Tour Date
          <input type="text" id="dateTS" value=""  placeholder="Tour Date" class="form-control  timeS"    />
		  <input type="hidden" id="s_variant_id" value=""  />
			<input type="hidden" id="s_transferOptionName" value=""  />
			<input type="hidden" id="s_inputnumber" value=""  />
        </div>
        <div class="col-sm-3 text-center">
        <label class="col-md-12">Adult</label>
          <div class="quantity-group">
  <button class="qty-btn minus"  onclick="decrease(1)">−</button>
  <input type="number" id="adultsTS" min="1"  class=" timeS onlynumbr text-center" style="width:50%" value="" placeholder="Adults" >
  <button class="qty-btn plus" onclick="increase(1)">+</button>
</div>
          
        </div>
        <div class="col-sm-3 text-center">
        <label class="col-md-12">Child <small><span id="child-age">0-0 Yrs</span></small></label>
          <div class="quantity-group">
  <button class="qty-btn minus"  onclick="decrease(2)">−</button>
  <input type="number" id="childrenTS" min="0"  class=" timeS onlynumbr text-center" style="width:50%" value="" placeholder="Children" >
  <button class="qty-btn plus" onclick="increase(2)">+</button>
</div>
        
        </div>
        <div class="col-sm-3 text-center">
        <label class="col-md-12">Infant <small><span id="infant-age">0-0 Yrs</span></small></label>
          <div class="quantity-group">
  <button class="qty-btn minus"  onclick="decrease(3)">−</button>
  <input type="number" id="infantTS" min="0"  class=" timeS onlynumbr text-center" style="width:50%" value="" placeholder="Infant" >
  <button class="qty-btn plus" onclick="increase(3)">+</button>
</div>
      
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
              
               
            </div>
            
            <div class="modal-footer">
            <div class="col-md-9 text-right">
                <div id="total-price">Total Price: {{$currency['code']}}0</div>
  </div>
  <div class="col-md-2 text-right">
                <button type="button" class="primary-btn2 " id="selectTimeSlotBtn">Add to Cart</button>
                </div>
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
                </div>
            </div>
        </div>
    </div>
    <!-- End Room Details section -->
    </div>



    
@endsection

@section('scripts')
<script  src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js
"></script>
 <script type="text/javascript">
  var code = "{{$currency['code']}}";
  var c_val = "{{$currency['value']}}";
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
            url: "{{route('get-agent-vouchers.activity.variant')}}",
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
	transferZone.prop('disabled', true);
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
	zoneValueChild: zoneValueChild,
	inputnumber: inputnumber
  };

  getPrice(argsArray)
    .then(function(price) {
	  $("body #price" + inputnumber).html(parseFloat(price.variantData.totalprice*c_val).toFixed(2));
	  $("body #totalprice" + inputnumber).val(parseFloat(price.variantData.totalprice*c_val).toFixed(2));
	  $("body #total-price").html("Total Price: "+code+' '+ parseFloat(price.variantData.totalprice*c_val).toFixed(2));
    })
    .catch(function(error) {
      console.error('Error:', error);
    })
    .finally(function() {
      loaderOverlay.hide();
    });
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
	zoneValueChild: zoneValueChild,
	inputnumber: inputnumber
	
  };

  getPrice(argsArray)
    .then(function(price) {
		$("body #pad").html(code+' '+price.variantData.adultTotalPrice*c_val+" /Adult");
		$("body #pchd").html(code+' '+price.variantData.childTotalPrice*c_val+" /Child");
     $('#PriceModal').modal('show');
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
	$("body .priceChange").prop('disabled',true);
	$("body .addToCart").prop('disabled',true);
  $("body .note").addClass('d-none');
	$("body #ucode").val('');
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
 });
 
 function getPrice(argsArray) {
	argsArray.adult = (isNaN(argsArray.adult))?0:argsArray.adult;
	argsArray.child = (isNaN(argsArray.child))?0:argsArray.child;
  return new Promise(function(resolve, reject) {
    $.ajax({
      url: "{{ route('agent.get.activity.variant.price') }}",
      type: 'POST',
      dataType: "json",
      data: argsArray,
      success: function(data) {
		 const totalPrice = data.variantData?.totalprice ?? 0;
        const allButtons = $('.addToCart');

        if (totalPrice <= 0) {
          allButtons.prop('disabled', true).css('pointer-events', 'none');
        } else {
          allButtons.prop('disabled', false).css('pointer-events', 'auto');
        }
		
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
    if(slot.available <= 50)
    radio += '<label class="btn btn-outline-success" style="margin:10px;" for="input_' + tk + '">' + slot.time + '<br/><span class="badge bg-secondary org" style="background-color:orange!important;">Available ' + slot.available +  '</span><span class="badge bg-secondary selected  d-none" >Selected</span></label>';
           else if(slot.available > 199)
    radio += '<label class="btn btn-outline-success" style="margin:10px;" for="input_' + tk + '">' + slot.time + '<br/><span class="badge bg-secondary org">Available ' + '</span><span class="badge bg-secondary selected  d-none" >Selected</span></label>';
    else
    radio += '<label class="btn btn-outline-success" style="margin:10px;" for="input_' + tk + '">' + slot.time + '<br/><span class="badge bg-secondary org">Available: ' + slot.available + '</span><span class="badge bg-secondary selected  d-none" >Selected</span></label>';
    radioGroup.append(radio);
    tk++;
});

	var code = "{{$currency['code']}}";
    var inputnumber = vdata.key;
    var priceText = $("#price" + inputnumber).text();
    $("#total-price").html("Total Price: "+code+' '+  priceText);
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
    $("body #tour_date" + inputnumber).val($('#dateTS').val());
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
        .attr('class', 'primary-btn2').removeAttr('style');
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
            color: 'red',
            backgroundColor: '#ffcccc',
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

$('#PriceModal .close').on('click', function() {
            $('#PriceModal').modal('hide');
        });
 $(document).on('keypress', '.onlynumbrf', function(evt) {
   var charCode = (evt.which) ? evt.which : evt.keyCode
   if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
     return false;
   return true;
 
 });
 
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
    if(slot.available <= 50)
    radio += '<label class="btn btn-outline-success" style="margin:10px;" for="input_' + tk + '">' + slot.time + '<br/><span class="badge bg-secondary org" style="background-color:orange!important;">Available ' + slot.available +  '</span><span class="badge bg-secondary selected  d-none" >Selected</span></label>';
           else if(slot.available > 199)
    radio += '<label class="btn btn-outline-success" style="margin:10px;" for="input_' + tk + '">' + slot.time + '<br/><span class="badge bg-secondary org">Available ' + '</span> <span class="badge bg-secondary selected d-none" >Selected</span></label>';
    else
    radio += '<label class="btn btn-outline-success" style="margin:10px;" for="input_' + tk + '">' + slot.time + '<br/><span class="badge bg-secondary org">Available: ' + slot.available + '</span> <span class="badge bg-secondary selected  d-none" >Selected</span></label>';
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
        .attr('class', 'primary-btn2').removeAttr('style');
});

$(document).on('click', '#timeSlotModal .close', function () {
    $('#timeSlotModal').modal('hide');
});
$(document).on('click', '#Noslot .close', function () {
    $('#Noslot').modal('hide');
});




$(document).on('click', '.btn-outline-success', function () {

$('.btn-outline-success .org').removeClass('d-none');
$('.btn-outline-success .selected').addClass('d-none');


  var $org = $(this).find('.org');
  var $selected = $(this).find('.selected');

  if ($selected.hasClass('d-none')) {
      $org.addClass('d-none');
      $selected.removeClass('d-none');
  } else {
      $selected.addClass('d-none');
      $org.removeClass('d-none');
  }
});

function decrease(ty) {

if(ty == '3')
{
const input = document.getElementById('infantTS');
if (parseInt(input.value) > 0) {
  input.value = parseInt(input.value) - 1;
}
}
else if(ty == '2')
{
const input = document.getElementById('childrenTS');
if (parseInt(input.value) > 0) {
  input.value = parseInt(input.value) - 1;
}
}
else
{
const input = document.getElementById('adultsTS');
if (parseInt(input.value) > 1) {
  input.value = parseInt(input.value) - 1;
}
}

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

}


function increase(ty) {
  if(ty == '3')
{
  const input = document.getElementById('infantTS');
      input.value = parseInt(input.value) + 1;
}
else if(ty == '2')
{
  const input = document.getElementById('childrenTS');
      input.value = parseInt(input.value) + 1;
}
else
{
  const input = document.getElementById('adultsTS');
      input.value = parseInt(input.value) + 1;
}


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

    }
		
 </script> 
@endsection
