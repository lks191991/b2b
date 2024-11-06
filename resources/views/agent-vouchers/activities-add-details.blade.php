@extends('layouts.appLogin')
@section('content')




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
              Starting From : AED {{$minPrice}} </h3><span>per person</span>
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
                   
    <div class="modal login-modal " id="timeSlotModal" data-bs-keyboard="false" tabindex="-1"  aria-modal="true" role="dialog" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-clode-btn" data-bs-dismiss="modal"></div>
                <div class="modal-header">
                  <!-- Select Time Slot -->
                </div>
                <div class="modal-body">
                    <div class="login-registration-form">
                        <div class="form-title">
                           <p>Select Time Slot</p>
                             <!-- <p>Enter your email address for Login.</p> -->
                        </div>
                        <form>
                            <div class="form-inner mb-20">
                              <select class="form-control" required id="timeSlotDropdown">
                       
                              </select>
                            </div>
                            
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="secondary-btn1 btn-sm" id="selectTimeSlotBtn">Add To Cart</button>
              
            </div>
            </div>
        </div>
    </div> 
                    
                    <!-- <h4>Tour Options</h4>
                    <div class="accordion tour-plan" id="tourPlan">
                        <div class="accordion-item">
                          <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                <span>Varaint 01 :</span>  Preparation and Departure
                            </button>
                          </h2>
                          <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#tourPlan">
                            <div class="accordion-body">
                              <h4>Included and Excluded</h4>
                                <div class="includ-and-exclud-area mb-20">
                                    <ul>
                                        <li><i class="bi bi-check-lg"></i> Meal as per hotel Plan and drinks free too.</li>
                                        <li><i class="bi bi-check-lg"></i> Return airport and round trip transfers.</li>
                                        <li><i class="bi bi-check-lg"></i> Accommodation on twin sharing basis.</li>
                                        <li><i class="bi bi-check-lg"></i> The above rates are on per day disposal basi</li>
                                        <li><i class="bi bi-check-lg"></i> Enjoy Brussels day tours. Overnight Brussels</li>
                                    </ul>
                                    <ul class="exclud">
                                        <li><i class="bi bi-x-lg"></i> AC will not be functional on Hills or Slopes.</li>
                                        <li><i class="bi bi-x-lg"></i> Any other service not mentioned</li>
                                        <li><i class="bi bi-x-lg"></i> Additional entry fees other than specified</li>
                                        <li><i class="bi bi-x-lg"></i> Amsterdam canal cruise not included for basic</li>
                                    </ul>
                                </div>
                                <div class="highlight-tour mb-20">
                                    <h4>Highlights of the Tour</h4>
                                    <ul>
                                        <li><span><i class="bi bi-check"></i></span> Our team of knowledgeable guides and travel experts are dedicated to making your journey memorable and worry-free</li>
                                        <li><span><i class="bi bi-check"></i></span> Dive into rich cultures and traditions. Explore historic sites, savor authentic cuisine, and connect with locals.</li>
                                        <li><span><i class="bi bi-check"></i></span> We take care of all the details, so you can focus on creating memories. Rest assured that your journey is in capable hands</li>
                                        <li><span><i class="bi bi-check"></i></span> Sip cocktails on the beach as you watch the sun dip below the horizon.</li>
                                        <li><span><i class="bi bi-check"></i></span> From accommodations to dining experiences, we select the best partners to ensure your comfort and enjoyment throughout your journey.</li>
                                    </ul>
                                </div>
                            </div>
                          </div>
                        </div>
                       
                        
                      </div> -->
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
	$("body .priceChange").prop('disabled',true);
	$("body .addToCart").prop('disabled',true);
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
      url: "{{ route('agent.get.activity.variant.price') }}",
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
