@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header" >
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1>Activities & Tours (Ageny : {{$voucher->agent->company_name}}) (<i class="fa fa-wallet" aria-hidden="true"></i> : AED {{$voucher->agent->agent_amount_balance}})</h1>
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
       <div class="col-md-12 card card-default">
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
             
                  @foreach ($records as $record)
				  @php
            $minPrice = SiteHelpers::getActivityLowPrice($record->id,$voucher->agent_id,$voucher);
			$cutoffTime = SiteHelpers::getActivityVarByCutoffCancellation($record->id);
          @endphp
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
				 
                  @endforeach
                 
				<div class="pagination pull-right mt-3"> {!! $records->appends(request()->query())->links() !!} </div> 
</div>
 @if(!empty($voucherActivity) && $voucher->is_activity == 1)
 <div class="col-md-3  mt-2 " id="div-cart-list" >
				
			  
					@if(!empty($voucherActivity))
					  @foreach($voucherActivity as $ap)
				  @php
					$activity = SiteHelpers::getActivity($ap->activity_id);
					@endphp
            <div class="card">
			
              
              <div class="card-body card-body-hover" >
             
              <div class="row">
              <div class="col-10">
              <span class="cart-title font-size-21 text-dark">
              {{$activity->title}}
              </span>
              </div>
              <div class="col-2  text-right">
              <form id="delete-form-{{$ap->id}}" method="post" action="{{route('voucher.activity.delete',$ap->id)}}" style="display:none;">
                                {{csrf_field()}}
                                {{method_field('DELETE')}}
                            </form>
                            <small>
                            <a class="btn btn-xs btn-danger border-round" title="delete" href="javascript:void(0)" onclick="
                                if(confirm('Are you sure, You want to delete this?'))
                                {
                                    event.preventDefault();
                                    document.getElementById('delete-form-{{$ap->id}}').submit();
                                }
                                else
                                {
                                    event.preventDefault();
                                }
                            
                            "><small><i class="fas fa-trash-alt "></i></small></a></small>
              </div>
              </div>
             
                                  <div class="row" >
				  <div class="col-md-3" style="padding: 5px 0px 5px 5px; ">
              <img src="{{asset('uploads/activities/'.$activity->image)}}" class="img-fluid" style="border-radius: 5px;" />
            </div>
			<div class="col-md-9">
              <ul class="list-unstyled" style="">
             
                <li>
                 {{$ap->variant_name}}
                </li>
				<li>
                  {{$ap->transfer_option}}
                </li>
                <li>
                   {{ $ap->tour_date ? date(config('app.date_format'),strtotime($ap->tour_date)) : null }}
                </li>
                <li>

                 <i class="fas fa-male color-grey" style="font-size:16px;" title="Adult"></i> <span class="color-black">{{$ap->adult}}</span> <i class="fas fa-child color-grey" title="Child"></i>  <span class="color-black">{{$ap->child}}</span>

                  <span class="float-right " ><h2 class="card-title text-right color-black"><strong>AED {{$ap->totalprice}}</strong></h2></span>
                </li>
                
              </ul>
			   
            </div>
			
                </div>
              
              </div>
              <!-- /.card-body -->
            </div>
				 @endforeach
                 @endif

                 <div class="input-group  text-right float-right">
                            @if($voucherActivityCount > 0)
                                  <a href="{{ route('vouchers.show',$voucher->id) }}" class="btn btn-lg btn-primary pull-right" style="width:100%">
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
@endsection

@section('scripts')

	
<script type="text/javascript">
  $(document).ready(function() {
	  $('body #activity_select0').prop('checked', false); // Checks it
			
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
			
				//var response = JSON.parse(data.dates);
				var disabledDates = data.dates.disabledDates;
				var availableDates = data.dates.availableDates;
				 var disabledDay = data.disabledDay;
				 console.log(disabledDay);
				$(".tour_datepicker").datepicker({
                        beforeShowDay: function(date) {
                            var dateString = $.datepicker.formatDate('yy-mm-dd', date);
							if(disabledDay.length > 0){
								if (disabledDay.indexOf(date.getDay()) != -1) {
									return [false, "disabled-day", "This day is disabled"];
								}
							}
                            if (availableDates.indexOf(dateString) != -1) {
                                return [true, "available-date", "This date is available"];
                            }else{
								return [false, "disabled-date", "This date is disabled"];
							}
                            return [true];
                        },
							minDate: new Date(),
							weekStart: 1,
							daysOfWeekHighlighted: "6,0",
							autoclose: true,
							todayHighlight: true,
							dateFormat: 'dd-mm-yy'
                    });
			
			
            }
          });
});
});
</script>  
<script type="text/javascript">
  $(document).ready(function() {
   
 
 $(document).on('change', '.priceChange', function(evt) {
  
   let inputnumber = $(this).data('inputnumber');
   var activity_id = $("body  #activity_id").val();
   var is_vat_invoice = $("body  #vat_invoice").val();
	if(is_vat_invoice == 1){
		var activity_vat = $("#activity_vat").val();
	} else {
		var activity_vat = 0;
	}
  
   let adult = parseInt($("body #adult"+inputnumber).val());
   let child = parseInt($("body #child"+inputnumber).val());
   let infant = parseInt($("body #infant"+inputnumber).val());
   let discount = parseFloat($("body #discount"+inputnumber).val());
   //alert(discount);
   let mpt = parseFloat($("body #mpt"+inputnumber).val());
   let mpst = parseFloat($("body #mpst"+inputnumber).val());
   let mppt = parseFloat($("body #mppt"+inputnumber).val());
   
   let adultPrice = $("body #adultPrice"+inputnumber).val();
   let childPrice = $("body #childPrice"+inputnumber).val();
   let infPrice = $("body #infPrice"+inputnumber).val();
   var ad_price = (adult*adultPrice) ;
   var chd_price = (child*childPrice) ;
   var ad_ch_TotalPrice = ad_price + chd_price;
   var ticket_only_markupamt = ((ad_ch_TotalPrice*mpt)/100);
   
   
   let t_option_val = $("body #transfer_option"+inputnumber).find(':selected').data("id");
   //$("body #pickup_location"+inputnumber).val('');
   let grandTotal = 0;
   let grandTotalAfterDis = 0;
   if(t_option_val == 3)
   {
     var totaladult = parseInt(adult + child);
   getPVTtransfer(activity_id,totaladult,mppt,inputnumber);
   $("body #loader-overlay").show();	
   waitForInputValue(inputnumber, function(pvt_transfer_markupamt_total) {
     var totalPrice = parseFloat(ad_ch_TotalPrice + (infant * infPrice) + ticket_only_markupamt  + pvt_transfer_markupamt_total);
     
     grandTotal = ( (totalPrice));
     let vatPrice = parseFloat(((activity_vat/100) * grandTotal));
     grandTotalAfterDis = parseFloat(grandTotal+vatPrice-discount);
        
     if(isNaN(grandTotalAfterDis))
     {
     $("body #totalprice"+inputnumber).val(0);
     $("body #price"+inputnumber).text(0);
     }
     else
     {
       if(grandTotalAfterDis > 0)
       {
       $("body #totalprice"+inputnumber).val(grandTotalAfterDis.toFixed(2));
       $("body #price"+inputnumber).text("AED "+grandTotalAfterDis.toFixed(2));
       }
       else
       {
         $("body #totalprice"+inputnumber).val(0);
         $("body #price"+inputnumber).text(0);
       }
     }
     $("body #loader-overlay").hide();
     });
   }
   else
   {
     if(t_option_val == 2)
     {
       let zonevalue = parseFloat($("body #transfer_zone"+inputnumber).find(':selected').data("zonevalue"));
       let zoneptime = $("body #transfer_zone"+inputnumber).find(':selected').data("zoneptime");
       
      // $("body #pickup_location"+inputnumber).val(zoneptime);
       var totaladult = parseInt(adult + child);
       let zonevalueTotal = (totaladult * zonevalue);
       $("body #zonevalprice"+inputnumber).val(zonevalueTotal);
       var sic_transfer_markupamt = ((zonevalueTotal *  mpst)/100);
       var totalPrice = parseFloat(ad_ch_TotalPrice + (infant * infPrice) + ticket_only_markupamt + sic_transfer_markupamt + zonevalueTotal);
       
       grandTotal = ( (totalPrice));
        let vatPrice = parseFloat(((activity_vat/100) * grandTotal));
        grandTotalAfterDis = parseFloat(vatPrice + grandTotal-discount);
     }
     else
     {
       var totalPrice = parseFloat(ad_ch_TotalPrice + (infant * infPrice) + ticket_only_markupamt);
       
        grandTotal = ( (totalPrice));
       let vatPrice = parseFloat(((activity_vat/100) * grandTotal));
        grandTotalAfterDis = parseFloat(vatPrice + grandTotal-discount);
       
     }
     
     if(isNaN(grandTotalAfterDis))
     {
     $("body #totalprice"+inputnumber).val(0);
     $("body #price"+inputnumber).text(0);
     }
     else
     {
     if(grandTotalAfterDis > 0)
       {
       $("body #totalprice"+inputnumber).val(grandTotalAfterDis.toFixed(2));
       $("body #price"+inputnumber).text("AED "+grandTotalAfterDis.toFixed(2));
       }
       else
       {
         $("body #totalprice"+inputnumber).val(0);
         $("body #price"+inputnumber).text(0);
       }
     }
   }
   
   
   
 });
 $(document).on('blur','.priceChangedis',function(){
   let inputnumber = $(this).data('inputnumber');
   let inputvale = parseFloat($(this).val());
   if(inputvale == null || isNaN(inputvale))
   {
     inputvale = 0;
     $(this).val(0);
   }
   $("body #adult"+inputnumber).trigger("change");
 });
 $(document).on('change', '.actcsk', function(evt) {
   let inputnumber = $(this).data('inputnumber');
   if ($(this).is(':checked')) {
       $("body #transfer_option"+inputnumber).prop('required',true);
     $("body #tour_date"+inputnumber).prop('required',true);
     
     $("body #transfer_option"+inputnumber).prop('disabled',false);
     $("body #tour_date"+inputnumber).prop('disabled',false);
     $("body #adult"+inputnumber).prop('disabled',false);
     $("body #child"+inputnumber).prop('disabled',false);
     $("body #infant"+inputnumber).prop('disabled',false);
     $("body #discount"+inputnumber).prop('disabled',false);
	 $("body #adult"+inputnumber).trigger("change");
     } else {
       $("body #transfer_option"+inputnumber).prop('required',false);
     $("body #tour_date"+inputnumber).prop('required',false);
     
     $("body #transfer_option"+inputnumber).prop('disabled',true);
     $("body #tour_date"+inputnumber).prop('disabled',true);
     $("body #adult"+inputnumber).prop('disabled',true);
     $("body #child"+inputnumber).prop('disabled',true);
     $("body #infant"+inputnumber).prop('disabled',true);
     $("body #discount"+inputnumber).prop('disabled',true);
	 $("body #totalprice"+inputnumber).val(0);
     $("body #price"+inputnumber).text(0);
     }
 });
 
 $(document).on('change', '.t_option', function(evt) {
   //alert("Asas");
   //alert("Asas");
   let inputnumber = $(this).data('inputnumber');
   let t_option_val = $(this).find(':selected').data("id");
   //$("body #top").removeAttr("colspan");
   $("body #transfer_zone_td"+inputnumber).css("display","none");
   $("body .coltd").css("display","none");
   //$("#pickup_location_td"+inputnumber).css("display","none");
   $("body #transfer_zone"+inputnumber).prop('required',false);
   $("body #zonevalprice"+inputnumber).val(0);
   $('body #transfer_zone'+inputnumber).prop('selectedIndex',0);
   $("body #pvt_traf_val"+inputnumber).val(0);
   $("body #adult"+inputnumber).trigger("change");
   if(t_option_val == 2){
     //$("body #top").attr("colspan",2);
     $("body #transfer_zone_td"+inputnumber).css("display","block");
     $("body .coltd").css("display","block");
    //$("#pickup_location_td"+inputnumber).css("display","block");
     $("body #transfer_zone"+inputnumber).prop('required',true);
   } else if(t_option_val == 3){
    // $("body #top").attr("colspan",2);
	 $("body .coltd").css("display","block")
     //$("#pickup_location_td"+inputnumber).css("display","block");
     var activity_id = $("body #activity_id").val();
     let adult = parseInt($("body #adult"+inputnumber).find(':selected').val());
     let child = parseInt($("body #child"+inputnumber).find(':selected').val());
     var totaladult = parseInt(adult + child);
     //alert(totaladult);
     let mppt = parseFloat($("body #mppt"+inputnumber).val());
     getPVTtransfer(activity_id,totaladult,mppt,inputnumber);
     $("body #adult"+inputnumber).trigger("change");
   }
 });
 
 $(document).on('change', '.zoneselect', function(evt) {
   let inputnumber = $(this).data('inputnumber');
   let zonevalue = parseFloat($(this).find(':selected').data("zonevalue"));
  // $("body #top").attr("colspan",2);
   let adult = parseInt($("body #adult"+inputnumber).find(':selected').val());
     let child = parseInt($("body #child"+inputnumber).find(':selected').val());
     var totaladult = parseInt(adult + child);
     let zonevalueTotal = totaladult * zonevalue;
     $("body #zonevalprice"+inputnumber).val(zonevalueTotal);
     $("body #adult"+inputnumber).trigger("change");
 });
 
 function getPVTtransfer(acvt_id,adult,markupPer,inputnumber)
 {
     $.ajaxSetup({
                 headers: {
                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                 }
             });
     $.ajax({
             url: "{{route('voucher.getPVTtransferAmount')}}",
             type: 'POST',
             dataType: "json",
             data: {
                acvt_id: acvt_id,
          adult: adult,
          markupPer: markupPer
             },
             success: function( data ) {
                //console.log( data );
          $("body #pvt_traf_val"+inputnumber).val(data);
             }
           });
 }
 
 function waitForInputValue(inputnumber, callback) {
   var $input = $("body #pvt_traf_val" + inputnumber);
   
   var interval = setInterval(function() {
     var pvt_transfer_markupamt_total = parseFloat($input.val());
     
     if (!isNaN(pvt_transfer_markupamt_total)) {
       // Value is available, execute the callback function
       clearInterval(interval); // Stop the interval
       callback(pvt_transfer_markupamt_total);
     }
   }, 2000); // Check every 100 milliseconds
 }
 });
 
 $(document).on('keypress', '.onlynumbrf', function(evt) {
   var charCode = (evt.which) ? evt.which : evt.keyCode
   if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
     return false;
   return true;
 
 });
 
   </script> 
@endsection
