@extends('layouts.appLogin')
@section('content')
@php
											$currency = SiteHelpers::getCurrencyPrice();
											@endphp
<div class="breadcrumb-section"
        style="background-image: linear-gradient(270deg, rgba(0, 0, 0, .3), rgba(0, 0, 0, 0.3) 101.02%), url({{asset('front/assets/img/innerpage/inner-banner-bg.png')}});">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 d-flex justify-content-center">
                    <div class="banner-content">
                        <h1>Activities & Tours</h1>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>


    @include('inc.errors-and-messages')
    <!-- Start Room Details section -->
    <div class="room-suits-page pt-50 pb-120">
        <div class="container">
		
            <div class="row g-lg-4 gy-5">
              <div class="col-md-12">
			           <div class="package-inner-title-section box-shadow">
                    <p style="padding-left: 10px;"><span id="tcount">{{$totalCount}}</span> Things to do in UAE</p>
                      <div class="selector-and-grid">
                          <div class="selector">
                              <select  class="tagsinput" onchange="searchActivity()" id="porder" >
                                  <option value="">Sorting</option>
								  <option value="1">Popular</option>
                                  <option value="ASC">Price Low to High</option>
                                  <option value="DESC">Price High to Low</option>
                                </select>
                          </div>
                    </div>
                  </div>
                </div>
                <div class="col-xl-3 order-lg-1 order-2">
				<form id="filterForm" class="form-inline"  >
                    <div class="sidebar-area  box-shadow">
                        <div class="single-widget mb-30">
                            <h5 class="widget-title">Search Here</h5>
							
							<div class="search-box">
							<input type="text" name="name" value="{{ request('name') }}" class="form-control tagsinput" style="border-radius: 5px 0px 0px 5px;" placeholder="Search by Tour Name" />
							
							</div>
							
                        <hr class=" mt-30 mb-20"/>
						
                            <h5 class="widget-title ">Price </h5>
                                <div class="range-wrap">
                                <form>
                                    
                                        <div class=" row">
                                       
                                            <input type="text" name="min-value" id="min-value" class="col-sm-6" style="color:#fff;height: 3px;font-size: 1px;" value="">
                                            <input type="text" name="max-value" id="max-value"  class="col-sm-6" style="text-align: right;color:#fff;height: 3px;font-size: 1px;" value="">
                                       
                                        </div>
                                    
                                    </form>
                                    <div class="row">
                                        <div class="col-sm-12">
                                        <div id="slider-range"></div>
                                        </div>
                                    </div>
                                    <div class="slider-labels">
                                        <div class="caption">
                                            <span id="slider-range-value1"></span>
                                        </div>
                                        <!--<a href="javascript:;" onclick="searchActivity()">Apply</a>-->
                                        <div class="caption">
                                            <span id="slider-range-value2"></span>
                                        </div>
                                    </div>
                                </div>
                                <hr class=" mt-30 mb-20"/>
                            <h5 class="widget-title">Fliter By Category</h5>
                            <div class="checkbox-container">
                                <ul>
								@foreach($tags as $tag)
                                    <li>
                                        <label class="containerss">
                                            <input type="checkbox" class="tagsinput" name="tags[]" value="{{$tag}}">
                                            <span class="checkmark"></span>
                                            <span class="text">{{$tag}}</span>
                                        </label>
                                    </li>
                                  @endforeach
                                   
                                </ul>
                            </div>
                        </div> 
						
                      
                    </div>
					</form>
                        
                </div>
				
				 <div class="col-xl-9 order-lg-2 order-1" id="listdata_ajax">
				 
                    @include('agent-vouchers.activities-list-ajax')
                   </div>  
				  <div id="pagination_ajax" class="pagination-area"></div>
                </div>
            </div>
        </div>
    </div>

<!-- CART VIEW -->

@include("inc.sidebar_cart")



<div class="modal fade" id="timeSlotModal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Select Time Slot</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
           
                <div class="form-group" id="radioSlotGroup">
                    <!-- Radio buttons will be dynamically added here -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="primary-btn1-sm btn-sm" id="selectTimeSlotBtn"><i class="fa fa-cart-plus"></i></button>
                <!-- You can add a button here for further actions if needed -->
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="PriceModal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Price Breakup</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <p id="mpvn" style="font-weight:bold"></p>
			 <table class="table rounded-corners">
                  <thead>
				  <tr>
					<th valign="middle">Tour Option</th>
                    <th valign="middle">Adult Price</th>
					<th valign="middle" >Child Price</th>
                  </tr>
				  </thead>
				   <tbody>
				   <tr>
					<td valign="middle" id="to"></td>
                    <td valign="middle" id="pad"></td>
					<td valign="middle" id="pchd" ></td>
                  </tr>
               </tbody>
			    </table>
            </div>
            <div class="modal-footer">
<p>Total Price : <span id="tpbv"></span></p>
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
			
$(document).on('click', '.loadvari', function(evt) {
  var actid = $(this).data('act');
   var inputnumber = $(this).data('inputnumber');
  $("body #loader-overlay").show();
		$.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
           
		$.ajax({
            url: "{{route('get-agent-vouchers.activity.variant')}}",
            type: 'POST',
            dataType: "json",
            data: {
              act: $(this).data('act'),
              vid: $(this).data('vid'),
            },
            success: function( data ) {
               //console.log( data.html );
               //alert("#var_data_div");
               
             $("body .var_data_div_cc").html('');
             $("body .pdivvarc").css('display','none');
			 $("body #var_data_div"+actid).html(data.html);
            $("body #pdivvar"+actid).css('display','block');
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
      var actType = $("body #activity_type").val();
if((actType == 'Bundle_Diff') || (actType == 'Bundle_Same')  || (actType == 'Package'))
			 $('.actcsk').prop('checked', true).trigger("change");
else	
$('.actcsk:first').prop('checked', true).trigger("change");		
			// $('.actcsk:first').prop('checked', true).trigger("change");
       var disabledDates = data.dates.disabledDates;
				var availableDates = data.dates.availableDates;
				var disabledDay = data.disabledDay;
        var today = new Date(); // Get today's date
		var tomorrow = new Date(today);
		tomorrow.setDate(today.getDate() + 1); // Set tomorrow's date
    
        $('.tour_datepicker').daterangepicker({
		singleDatePicker: true,
		showDropdowns: false,
		minDate: today,
		minYear: today.getFullYear(),
			locale: {
		format: 'DD-MM-YYYY'
		},autoApply: true
		}, function (start, end, label) {
		var years = moment().diff(start, 'years');
		});

				// $(".tour_datepicker").datepicker({
        //                 beforeShowDay: function(date) {
        //                     var dateString = $.datepicker.formatDate('yy-mm-dd', date);
							
				// 			if(disabledDay.length > 0){
				// 				if (disabledDay.indexOf(date.getDay()) != -1) {
				// 					return [false, "disabled-day", "This day is disabled"];
				// 				}
				// 			}
        //                     if (availableDates.indexOf(dateString) != -1) {
        //                         return [true, "available-date", "This date is available"];
        //                     }else{
				// 				return [false, "disabled-date", "This date is disabled"];
				// 			}
        //                     return [true];
        //                 },
				// 			minDate: new Date(),
				// 			weekStart: 1,
				// 			daysOfWeekHighlighted: "6,0",
				// 			autoclose: true,
				// 			todayHighlight: true,
				// 			dateFormat: 'dd-mm-yy'
        //             });
            }
          });
});

/* const popover = new bootstrap.Popover('.popover-dismiss', {
  trigger: 'focus'
}) */
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
  const activityType = $("body #activity_type").val();

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

   var actType = $("body #activity_type").val();
  if(actType == 'Bundle_Diff')
  {
    zonevalue = getTotalZoneValueByClass('trfzone');
    zoneValueChild = getTotalChildZoneValueByClass('trfzone');

    console.log('Total Zone Value:', zonevalue);
    console.log('Total Child Zone Value:', zoneValueChild);



  }
  else
  {
    zonevalue = parseFloat(transferZone.find(':selected').data("zonevalue"));
	    zoneValueChild = parseFloat(transferZone.find(':selected').data("zonevaluechild"));
  }
  } else if (transferOption == 3) {
    colTd.css("display", "block");
  }

  //  zonevalue = parseFloat(transferZone.find(':selected').data("zonevalue"));
  //  zoneValueChild = parseFloat(transferZone.find(':selected').data("zonevaluechild"));
  // } else if (transferOption == 3) {
  //   colTd.css("display", "block");
  // }

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

      var code = "{{$currency['code']}}";
      var c_val = "{{$currency['value']}}";
      if(actType == 'Bundle_Diff')
  {
    $("body #price0").html(parseFloat(price.variantData.totalprice*c_val).toFixed(2));
	  $("body #totalprice0").val(parseFloat(price.variantData.totalprice).toFixed(2));
  }
  else
  {
    $("body #price" + inputnumber).html(parseFloat(price.variantData.totalprice*c_val).toFixed(2));
	  $("body #totalprice" + inputnumber).val(parseFloat(price.variantData.totalprice*c_val).toFixed(2));
  }
    })
    .catch(function(error) {
      console.error('Error:', error);
    })
    .finally(function() {
      loaderOverlay.hide();
    });

    // Select all elements with the class "common-css"
    const elements = document.querySelectorAll('.priceChangeBDA');

// Loop through each element and add an event listener
elements.forEach((element) => {
  element.addEventListener('input', function() {
    const newValue = this.value; // Get the new value from the changed element

    // Update all elements with the same class with the new value
    elements.forEach((el) => {
      if (el !== this) {
        el.value = newValue; // Update the value of other elements
      }
    });
  });
});

    // Select all elements with the class "common-css"
    const elementC = document.querySelectorAll('.priceChangeBDC');

// Loop through each element and add an event listener
elementC.forEach((element) => {
  element.addEventListener('input', function() {
    const newValue = this.value; // Get the new value from the changed element

    // Update all elements with the same class with the new value
    elementC.forEach((el) => {
      if (el !== this) {
        el.value = newValue; // Update the value of other elements
      }
    });
  });
});


    // Select all elements with the class "common-css"
    const elementsI = document.querySelectorAll('.priceChangeBDI');

// Loop through each element and add an event listener
elementsI.forEach((element) => {
  element.addEventListener('input', function() {
    const newValue = this.value; // Get the new value from the changed element

    // Update all elements with the same class with the new value
    elementsI.forEach((el) => {
      if (el !== this) {
        el.value = newValue; // Update the value of other elements
      }
    });
  });

  
});


   // Select all elements with the class "common-css"
   const elementsTT = document.querySelectorAll('.priceChangeTT');

// Loop through each element and add an event listener
elementsTT.forEach((element) => {
  element.addEventListener('input', function() {
    const newValue = this.value; // Get the new value from the changed element

    // Update all elements with the same class with the new value
    elementsTT.forEach((el) => {
      if (el !== this) {
        el.value = newValue; // Update the value of other elements
      }
    });
  });

  
});
    

});


function getTotalZoneValueByClass(className) {
    let zoneValue = 0;

    $('.'+className).each(function() {
        // 'this' refers to the current dropdown in the loop
       
        // You can also get any attribute of the selected option, like 'data-zonevalue'
        zoneValue += parseFloat($(this).find(':selected').data("zonevalue")); // Get the data-zonevalue
        console.log('Zone Value:', zoneValue);
    });
    return zoneValue;
}
function getTotalChildZoneValueByClass(className) {

  let zoneChildValue = 0;

$('.'+className).each(function() {
    // 'this' refers to the current dropdown in the loop
   
    // You can also get any attribute of the selected option, like 'data-zonevalue'
    zoneChildValue += parseFloat($(this).find(':selected').data("zonevaluechild")); // Get the data-zonevalue
    console.log('Zone Value:', zoneChildValue);
});
return zoneChildValue;

  
}

$(document).on('click', '.priceModalBtn', function(evt) {
  const inputnumber = $(this).data('inputnumber');
  const activityVariantId = $("body #activity_variant_id" + inputnumber).val();
  const activityVariantName = $("body #activity_variant_name" + inputnumber).val();
  const adult = parseInt($("body #adult" + inputnumber).val());
  const child = parseInt($("body #child" + inputnumber).val());
  const infant = parseInt($("body #infant" + inputnumber).val());
  const discount = parseFloat($("body #discount" + inputnumber).val());
  const tourDate = $("body #tour_date" + inputnumber).val();
  const activityType = $("body #activity_type").val();

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

   var actType = $("body #activity_type").val();
  if(actType == 'Bundle_Diff')
  {
    zonevalue = getTotalZoneValueByClass('trfzone');
    zoneValueChild = getTotalChildZoneValueByClass('trfzone');

    console.log('Total Zone Value:', zonevalue);
    console.log('Total Child Zone Value:', zoneValueChild);



  }
  else
  {
    zonevalue = parseFloat(transferZone.find(':selected').data("zonevalue"));
	    zoneValueChild = parseFloat(transferZone.find(':selected').data("zonevaluechild"));
  }
  } else if (transferOption == 3) {
    colTd.css("display", "block");
  }
var to = $("body #transfer_option" + inputnumber).find(':selected').val();

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
		
      var code = "{{$currency['code']}}";
      var c_val = "{{$currency['value']}}";
		var adp = parseFloat(price.variantData.adultTotalPrice*c_val/adult).toFixed(2);
    var chp = 0;
    if(child > 0)
		chp = parseFloat(price.variantData.childTotalPrice*c_val/child).toFixed(2);
    var grandTotal = parseFloat((parseFloat(adp)*adult)+(parseFloat(chp)*child)).toFixed(2);
		$("body #pad").html(code+' '+parseFloat(adp).toFixed(2)+" X "+adult);
		$("body #pchd").html(code+' '+parseFloat(chp).toFixed(2)+" X "+child);
    $("body #tpbv").html(code+' '+grandTotal);
    $("body #mpvn").html(activityVariantName);
		$("body #to").html(to);
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
	//$("body .priceChange").prop('disabled',true);
	//$("body .addToCart").prop('disabled',true);
  $("body .note").addClass('d-none');

	$("body #ucode").val('');
	$('#timeslot').val('');
	//$("body .priceclass").text(0);
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
      url: "{{ route('agent.get.activity.variant.price') }}",
      type: 'POST',
      dataType: "json",
      data: argsArray,
      success: function(data) {
        resolve(data,argsArray);
     
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
		$("body #cartForm").removeClass('error-rq');
        $('#timeSlotModal').modal('show');

        var radioGroup = $('#radioSlotGroup');
        radioGroup.empty();
        var tk = 0;
//         <input type="radio" class="btn-check" name="options-outlined" id="success-outlined" autocomplete="off">
// <label class="btn btn-outline-success" for="success-outlined">Time</label>
        $.each(slots, function(index, slot) {
            // var radio = $('<input type="radio" class="btn-check" autocomplete="off" name="timeSlotRadio">')
            //     .attr('value', slot)
            //     .prop('checked', slot === selectedSlot);
            // var label = $('<label>').text(slot).prepend(radio);
            // radioGroup.append(label);
var radio = '<input type="radio" class="btn-check" autocomplete="off" id="input_'+tk+'" name="timeSlotRadio" value ="'+slot+'"><label class="btn btn-outline-success"  style="margin:10px;" for="input_'+tk+'">'+slot+'</label>';
                // .attr('value', slot)
                // .prop('checked', slot === selectedSlot);
            //var label = $('<label>').text(slot).prepend(radio);
            radioGroup.append(radio);
            tk++;
        });

        $('#selectTimeSlotBtn').on('click', function() {
            var selectedValue = $('input[name="timeSlotRadio"]:checked').val();
            if (selectedValue) {
                $('#timeslot').val(selectedValue);
                $("body #cartForm").submit();
            } else {
                $("body #cartForm").addClass('error-rq');
            }
        });

        $('#timeSlotModal .close').on('click', function() {
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
 $('#PriceModal .close').on('click', function() {
            $('#PriceModal').modal('hide');
        });
$(document).on('keypress', '.tagsinput', function(evt) {
  searchActivity()
 });

 
$(document).on('change', '.tagsinput', function(evt) {
  searchActivity()
 });
 
$(document).ready(function() {
  
	var min = "{{$minPrice}}";
	var max = "{{$maxPrice}}";
  var currencyValue = parseInt("{{$currency['value']}}");
  console.log(currencyValue)

    $('.noUi-handle').on('click', function() {
      $(this).width(50);
    });
    var rangeSlider = document.getElementById('slider-range');
	
    var moneyFormat = wNumb({
      decimals: 0,
      thousand: ',',
      prefix: "{{$currency['code']}} "
    });
    noUiSlider.create(rangeSlider, {
      start: [parseInt(min),parseInt(max)],
      step: 1,
      range: {
        'min': [parseInt(min)],
        'max': [parseInt(max)]
      },
      format: moneyFormat,
      connect: true
    });
    
    // Set visual min and max values and also update value hidden form inputs
    rangeSlider.noUiSlider.on('update', function(values, handle) {
      var valueMax = values[1].toString().replace(/[^0-9.]/g, '');
      var sliderRangeMax = parseInt(valueMax) * parseInt(currencyValue);
      document.getElementById('slider-range-value1').innerHTML = ""+values[0];
      document.getElementById('slider-range-value2').innerHTML =new Intl.NumberFormat().format(sliderRangeMax);
      document.getElementById('min-value').value = moneyFormat.from(
        values[0]);
      document.getElementById('max-value').value = moneyFormat.from(
        values[1]);
		
		debounceSearchActivity();
    });
	
   
  });
  const debounceSearchActivity = debounce(searchActivity, 500);
  function debounce(func, delay) {
        let timeout;
        return function() {
            const context = this;
            const args = arguments;
            clearTimeout(timeout);
            timeout = setTimeout(function() {
                func.apply(context, args);
            }, delay);
        };
    }
	
function searchActivity(page = 1) {
	$("body #loader-overlay").show();
    var vid = "{{$vid}}"; 
    var name = $("input[name='name']").val(); 
	var porder = $("#porder").val();
	
	var minPrice = document.getElementById('min-value').value;
	var maxPrice = document.getElementById('max-value').value;
	 var selectedTags = $('input[name="tags[]"]:checked').map(function () {
        return this.value;
    }).get();
	//console.log(selectedTags);
    $("body #loader-overlay").show();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: "{{ route('agent-vouchers.add.activity.search') }}",
        type: 'GET',
        dataType: "json",
        data: {
            name: name,
            vid: vid,
			selectedTags: selectedTags,
			minPrice: minPrice,
			maxPrice: maxPrice,
			porder:porder,
			page: page
        },
        success: function(data) {
            $("#listdata_ajax").html(data.html); // Replace the content of the div
			$("#tcount").html(data.totalCount); 
            $("#pagination_ajax").html(data.pagination);
			$("body #loader-overlay").hide();
        },
        error: function(error) {
            //console.error('Error:', error);
        },
        complete: function() {
            $("body #loader-overlay").hide();
        }
    });
}
$(document).on('click', '#pagination_ajax a', function(e) {
    e.preventDefault();
    var page = $(this).attr('href').split('page=')[1];
    searchActivity(page);
});
 </script> 

@endsection