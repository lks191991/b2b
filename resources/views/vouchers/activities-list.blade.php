@extends('layouts.app')
@section('content')
<style>
/* Hide the radio button */
.btn-check:checked + .btn-outline-success {
    background-color: #28a745; /* Green background when selected */
    border-color: #28a745; /* Same green border */
    color: white; /* White text when selected */
}

/* Optional: You can add a border or other styling to the label when it's selected */
.btn-check:checked + .btn-outline-success {
    box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.5); /* Optional glow effect */
}

</style>
    <!-- Content Header (Page header) -->
    <section class="content-header" >
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1>Activities & Tours (Agency : {{$voucher->agent->company_name}}) (<i class="fa fa-wallet" aria-hidden="true"></i> : AED {{number_format($voucher->agent->agent_amount_balance,"2",".",",")}})</h1>
          </div>
          
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content" id="activities-list-blade">
        
    <div class="container-fluid">
       
              <!-- /.card-header -->
             
             
          <div class="col-md-12 ">
             
               
               

       <div class="row">
       <div class="col-md-12 card card-default d-none">
              <!-- form start -->
              <form id="filterForm" class="form-inline" method="get" action="{{ route('voucher.add.activity',$vid) }}" >
                <div class="card-body">
                  <div class="row">
                      <div class="col-md-4">
                        <div class="input-group">
                          <input type="text" name="name" value="{{ request('name') }}" class="form-control"  placeholder="Filter with Name" />
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="input-group ">
                            <button class="btn btn-info" type="submit">   <i class="fas fa-search"></i> Search</button>
                            <a class="btn btn-default  mx-sm-2" href="{{ route('voucher.add.activity',$vid) }}">Clear</a>
                        </div>
                      </div>
                      <div class="col-md-2 text-right">
                          <div class="input-group  text-right float-right">
                          @if($voucher->is_hotel == '1')
                                <a href="{{ route('voucher.add.hotels',$voucher->id) }}" class="btn btn-md btn-secondary pull-right">
                                  <i class="fas fa-hotel"></i>
                                  Add Hotels
                              </a>
                              @endif
                        </div>
                        </div>
                      <div class="col-md-2 text-right">
                        <div class="input-group  text-right float-right">
                            @if($voucherActivityCount > 0)
                                  <a href="{{ route('vouchers.show',$voucher->id) }}" class="btn btn-md btn-primary pull-right">
                                <i class="fas fa-shopping-cart"></i>
                                Checkout({{$voucherActivityCount}})
                            </a>
                            @endif
                        </div>
                      </div>
                  </div>
                </div>
                <!-- /.card-body -->
                </form>
                </div>
             <div class="card-body @if($voucherActivityCount > 0) col-md-9 @else offset-1 col-md-10 @endif">
             <table id="tbl-activites" class="dataTable" style="width:100%" cellpadding="0px;" cellspaccing="0px" aria-describedby="example2_info">
              <thead>
                <tr>
                <th class=" " tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="" aria-sort=""></th>
                </tr>
              </thead>
                  @foreach ($records as $record)
				  @php
            $minPrice = $record->min_price;
			$cutoffTime = SiteHelpers::getActivityVarByCutoffCancellation($record->id);
          @endphp
          <tr><td>
                   <!-- Default box -->
      <div class="card collapsed-card ">
        <div class="card-header">
          <div class="row">
            <div class="col-md-3">
              <img src="{{asset('uploads/activities/'.$record->image)}}" class="img-fluid" style="width: 278px;height:173px" />
            </div>
            <div class="col-md-6">
              <h2 class="card-title" >
			  <strong> <a class="" href="{{route('voucher.activity.view',[$record->id,$vid])}}" target="_blank">
                            {{$record->title}}
                          </a></strong>
			 </h2>
              <br/> <br/>
              <ul class="list-unstyled" style="margin-top: 70px;">
				@if($record->entry_type == 'Tour')
                <li class="text-color">
                 <i class="far fa-fw  fa-check-circle"></i> Instant Confirmation
                </li>
				@endif
                <li  class="text-color">
                 <i class="far fa-fw  fa-check-circle "></i> {!!$cutoffTime!!}
                </li>
               
                
              </ul>
            </div>
            <div class="col-md-3 text-right text-dark" style="padding-top: 60px;">
              
              <span >
              From 
              <br/>
              AED {{$minPrice}}
              <br/>
              </span>
              <br/>
              <button type="button" data-act="{{ $record->id }}"  data-vid="{{ $vid }}" class="btn btn-sm btn-primary-flip loadvari" data-card-widget="collapse" title="Collapse">
                SELECT
              </button>
            </div>
          </div>
        
        </div>
        <div class="card-body pdivvarc" id="pdivvar{{ $record->id }}" style="display: none;">
          <div class="row p-2">
			 
            <div class="col-md-12 var_data_div_cc" id="var_data_div{{ $record->id }}">
                    
                  </div>
              
           </div>
        </div>
        <!-- /.card-body -->
        
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->
				 
      </td></tr>
                  @endforeach
</table> 
                 
				<div class="pagination pull-right mt-3"> {!! $records->appends(request()->query())->links() !!} </div> 
</div>
@php
$caid = 0;
$ty=0;
$aid = 0;
					$total = 0;
					@endphp
 @if(!empty($voucherActivity) && $voucher->is_activity == 1)
 <div class="col-md-3  mt-2 " id="div-cart-list" >
				
			  
					@if(!empty($voucherActivity))
					  @foreach($voucherActivity as $ap)
				  @php
          $total += $ap->totalprice;
		  $activityImg = SiteHelpers::getActivityImageName($ap->activity_id);
$delKey = $ap->id;

					@endphp
          @if(($ap->activity_product_type == 'Bundle_Same') || ($ap->activity_product_type == 'Bundle_Diff') || ($ap->activity_product_type == 'Package'))
          @php
          $aid = $ap->activity_id;
          $delKey = $ap->voucher_id;
          $total_sp  = 0;
          
		  $total_sp = PriceHelper::getTotalActivitySP($ap->voucher_id,$ap->activity_id);


					@endphp
          @endif
          @if(($ap->activity_product_type == 'Bundle_Same') && ($caid != $ap->activity_id))
          @php
          $dis = 1;
          @endphp
          @elseif(($ap->activity_product_type != 'Bundle_Same'))
          @php
          $dis = 1;
          @endphp
          @else
          @php
          $dis = 0;
          @endphp
          @endif
          
          @if( $dis == 1)

            <div class="card">
			
              
              <div class="card-body card-body-hover" >
             
              <div class="row">
              <div class="col-10">
              <span class="cart-title font-size-21 text-dark">
              {{$ap->activity_title}}
              </span>
              </div>
              <div class="col-2  text-right">
              @if(($ap->activity_product_type != 'Bundle_Same') && ($ap->activity_product_type != 'Bundle_Diff') && ($ap->activity_product_type != 'Package'))
           
         
              <form id="delete-form-{{$delKey}}" method="post" action="{{route('voucher.activity.delete',$delKey.'/0')}}" style="display:none;">
                                {{csrf_field()}}
                                {{method_field('DELETE')}}
                            </form>
                            <small>
                            <a class="btn btn-xs btn-danger border-round" title="delete" href="javascript:void(0)" onclick="
                                if(confirm('Are you sure, You want to delete this?'))
                                {
                                    event.preventDefault();
                                    document.getElementById('delete-form-{{$delKey}}').submit();
                                }
                                else
                                {
                                    event.preventDefault();
                                }
                            
                            ">
                            
                            <small><i class="fas fa-trash-alt "></i></small></a></small>
                 @elseif($caid != $ap->activity_id)
                
                 <form id="delete-form-{{$delKey}}-{{$ap->activity_id}}" method="post" action="{{route('voucher.activity.delete',$delKey.'/'.$ap->activity_id)}}" style="display:none;">
                                {{csrf_field()}}
                                {{method_field('DELETE')}}
                            </form>
                            <small>
                            <a class="btn btn-xs btn-danger border-round" title="delete" href="javascript:void(0)" onclick="
                                if(confirm('Are you sure, You want to delete this?'))
                                {
                                    event.preventDefault();
                                    document.getElementById('delete-form-{{$delKey}}-{{$ap->activity_id}}').submit();
                                }
                                else
                                {
                                    event.preventDefault();
                                }
                            
                            ">
                            
                            <small><i class="fas fa-trash-alt "></i></small></a></small>
                  @endif
             
              </div>
              </div>
             
                                  <div class="row" >
				  <div class="col-md-3" style="padding: 5px 0px 5px 5px; ">
              <img src="{{asset('uploads/activities/'.$activityImg)}}" class="img-fluid" style="border-radius: 5px;" />
            </div>
			<div class="col-md-9">
              <ul class="list-unstyled" style="">
              @if(($ap->activity_product_type != 'Bundle_Same'))
                <li>
             
                 {{$ap->variant_name}}

                </li>
                @endif
				<li>
                  {{$ap->transfer_option}}
                </li>
                <li>
                   {{ $ap->tour_date ? date(config('app.date_format'),strtotime($ap->tour_date)) : null }}   {{ $ap->time_slot ? ' : '.$ap->time_slot: null }}
               
                </li>
                <li>

                 <i class="fas fa-male color-grey" style="font-size:16px;" title="Adult"></i> <span class="color-black">{{$ap->adult}}</span> <i class="fas fa-child color-grey" title="Child"></i>  <span class="color-black">{{$ap->child}}</span>
                 @if(($ap->activity_product_type != 'Bundle_Same') && ($ap->activity_product_type != 'Bundle_Diff') && ($ap->activity_product_type != 'Package'))
                  <span class="float-right " ><h2 class="card-title text-right color-black"><strong>AED {{$ap->totalprice}}</strong></h2></span>
                 @elseif($caid != $ap->activity_id)
                 <span class="float-right " ><h2 class="card-title text-right color-black"><strong>AED {{$total_sp}}</strong></h2></span>
                  @endif
                </li>
                
              </ul>
			   
            </div>
			
                </div>
              
              </div>
              <!-- /.card-body -->
            </div>
            @endif
			@php
      $caid = $ap->activity_id;
      @endphp
				 @endforeach
                 @endif
                 <div class="input-group  text-right float-right mb-3">
                            @if($voucherActivityCount > 0)
                               <h2 class="card-title color-black " style="width:100%"><strong>Total Amount : AED {{$total}}</strong></h2>
                            @endif
                        </div>
						
                 <div class="input-group  text-right float-right">
                            @if($voucherActivityCount > 0)
                                  <a href="{{ route('voucher.add.discount',$voucher->id) }}" class="btn btn-lg btn-primary pull-right" style="width:100%">
                                <i class="fas fa-shopping-cart"></i>
                                Checkout({{$voucherActivityCount}})
                            </a>
                            @endif
                        </div>
				
</div>
  @endif
</div>
</div>
           
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
         
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
	
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
                <button type="button" class="btn btn-sm btn-primary-flip btn-sm" id="selectTimeSlotBtn"><i class="fa fa-cart-plus"></i></button>
                <!-- You can add a button here for further actions if needed -->
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


@endsection

@section('scripts')
<script  src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js
"></script>
	
<script type="text/javascript">
  $(document).ready(function() {
	  var table = $('#tbl-activites').DataTable();
			
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
            url: "{{route('get-vouchers.activity.variant')}}",
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
            }
          });
});
});
</script>  
 
<script type="text/javascript">
  $(document).ready(function() {
    const loaderOverlay = $("body #loader-overlay");
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
	//transferZone.prop('disabled', true);	
  if (transferOption == 2) {
    transferZoneTd.css("display", "block");
    colTd.css("display", "block");
    transferZone.prop('required', true);
	transferZone.prop('disabled', false);

  //
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
  activityType: activityType
  };

  getPrice(argsArray)
    .then(function(price) {
      if(actType == 'Bundle_Diff')
  {
    $("body #price0").html(price.variantData.totalprice);
	  $("body #totalprice0").val(price.variantData.totalprice);
  }
  else
  {
    $("body #price" + inputnumber).html(price.variantData.totalprice);
	  $("body #totalprice" + inputnumber).val(price.variantData.totalprice);
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
 
 
 $(document).on('change', '.actcsk', function(evt) {
   let inputnumber = $(this).data('inputnumber');
    const adult = parseInt($("body #adult" + inputnumber).val());
  const child = parseInt($("body #child" + inputnumber).val());
   adultChildReq(adult,child,inputnumber);
    $("body .priceChange").prop('required',false);
	// $("body .priceChange").prop('disabled',true);
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
    loaderOverlay.show();
	 if($('body #cartForm').validate({})){
		 variant_id = $(this).data('variantid');
		 inputnumber = $(this).data('inputnumber');
		 const transferOptionName = $("body #transfer_option" + inputnumber).find(':selected').val();
     const tour_date = $("body #tour_date" + inputnumber).val();
     const adult = $("body #adult" + inputnumber).val();
     const child = $("body #child" + inputnumber).val();
     const infant = $("body #infant" + inputnumber).val();
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
							openTimeSlotModal(data.slots,data.is_rayna);
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

  function openTimeSlotModal(slots, isRayna) {
	  
    var isValid = $('body #cartForm').valid();
    if (isValid) {
		$("body #cartForm").removeClass('error-rq');
        $('#timeSlotModal').modal('show');

        var radioGroup = $('#radioSlotGroup');
        radioGroup.empty();
        var tk = 0;
       
		$.each(slots, function(index, slot) {
    var radio = '<input type="radio" class="btn-check" autocomplete="off" id="input_' + tk + '" data-id="' + slot.id + '" name="timeSlotRadio" value="' + slot.time + '" style="display:none;">';
    radio += '<label class="btn btn-outline-success" style="margin:10px;" for="input_' + tk + '">' + slot.time + ' <span class="badge bg-secondary">Avail: ' + slot.available + '</span></label>';
    radioGroup.append(radio);
    tk++;
});



        $('#selectTimeSlotBtn').on('click', function() {
            var selectedRadio = $('input[name="timeSlotRadio"]:checked');
			var selectedValue = selectedRadio.val();
			var timeSlotId = selectedRadio.data('id');
            if (selectedValue) {
                $('#timeslot').val(selectedValue);
				$('#isRayna').val(isRayna);
				$('#timeSlotId').val(timeSlotId);
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


 </script> 
@endsection
