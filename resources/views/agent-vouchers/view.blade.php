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
                        <h1>Checkout</h1>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Start Checkout section -->
    <div class="checkout-page pt-120 pb-120">
        <div class="container">
            <div class="row g-lg-4 gy-5">
                <div class="col-lg-8">
                @include('inc.errors-and-messages')
                <div class="title">
                            <h4>Guest Details</h4>
                        </div>
                    <div class="inquiry-form box-shadow">
                        
                        <form id="cusDetails" method="post"  action="{{route('agent.vouchers.status.change',$voucher->id)}}" >
			                      {{ csrf_field() }}
                            <div class="row">
                              <div class="col-md-6">
                                    <div class="form-inner mb-30">
                                        <label>First Name*</label>
                                        <input type="text" name="fname" value="{{$fname}}" class="form-control"  placeholder="First Name*" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-inner mb-30">
                                        <label>Last Name*</label>
                                        <input type="text" name="lname" value="{{$lname}}" class="form-control" placeholder="Last Name*"  required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-inner mb-30">
                                        <label>Email</label>
                                        <input type="text" name="customer_email" value="{{(!empty($voucher->guest_email))?$voucher->guest_email:$voucher->agent->email}}" placeholder="Email ID" class="form-control" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-inner mb-30">
                                        <label>Mobile No.*</label>
                                        <input type="text" name="customer_mobile" value="{{(!empty($voucher->guest_phone))?$voucher->guest_phone:$voucher->agent->mobile}}" class="form-control" placeholder="Mobile No." required >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-inner mb-30">
                                        <label>Agent Reference No.</label>
                                        <input type="text" name="agent_ref_no" value="{{$voucher->agent_ref_no}}" class="form-control" >

                                        <input type="hidden" name="remark" value="{{$voucher->remark}}" class="form-control" >
                                    </div>
                                </div>
                                
                            </div>
                        
                    </div>
 @php
					$ii = 0;
					@endphp
			@if(!empty($voucherActivity) && $voucher->is_activity == 1)
				@foreach($voucherActivity as $ap)
				  @if(($ap->transfer_option == 'Shared Transfer') || ($ap->transfer_option == 'Pvt Transfer') || ($ap->activity_entry_type=='Limo') || ($ap->activity_entry_type=='Yacht'))
				  @php
					$ii = 1;
					@endphp
				@endif
					@endforeach
                    @if($ii == '1')
                    
                    <div class="title">
                            <h4>Additional Information</h4>
                        </div>
                    <div class="inquiry-form box-shadow  ">
                       
                            <div class="row">
                            @if(!empty($voucherActivity))
                                  @php
                                $c=0;
                                $tkt=0;
                                @endphp
                                @foreach($voucherActivity as $ap)
                                  @if(($ap->transfer_option != 'Ticket Only'))
                                    @php $tkt++; @endphp
                                  @endif
                                  @endforeach
                                  @if($tkt > 1)

                                  <div class="col-md-6 @if($tkt == 0) d-none @endif">
                                  <div class="form-inner mb-30">
                                  <label class="">Default Pickup Location</label>
                                  <input type="text" class="form-control" id="defaut_pickup_location" />
                                 
                                  </div>
                                </div>
                                <div class="col-md-6 @if($tkt == 0) d-none @endif">
                                  <div class="form-inner mb-30">
                                  <label class="">Default Dropoff Location</label>
                                  <input type="text" class="form-control" id="defaut_dropoff_location" />
                                
                                  </div>
                                </div>
                                @endif
                               
                                
                            </div>
                            @foreach($voucherActivity as $ap)
				   @if(($ap->transfer_option == 'Shared Transfer') || ($ap->transfer_option == 'Pvt Transfer') || ($ap->activity_entry_type=='Limo') || ($ap->activity_entry_type=='Yacht'))
				  @php
					$c++;
					$activity = SiteHelpers::getActivity($ap->activity_id);
          
					@endphp
					
                  <div class="row" style="margin-bottom: 15px;">
                    <div class="col-12">
					<p><strong>{{$c}}. {{$ap->variant_name}} : {{$ap->transfer_option}}
					@if($ap->transfer_option == 'Shared Transfer')
					@php
					$zone = SiteHelpers::getZoneName($ap->transfer_zone);
					$zoneName = @$zone->name;
					@endphp
					@if(!empty($zoneName))
					- Zone :{{$zoneName}}
					@endif
					@endif
					</strong></p></div>
                   
					@if($activity->entry_type=='Arrival')
						
						<div class="col-md-6 form-inner mb-30">
						 
						<input type="text" class="form-control inputsave autodropoff_location required" id="dropoff_location{{$ap->id}}" data-name="dropoff_location"  data-id="{{$ap->id}}" value="{{$ap->dropoff_location}}" required data-zone="{{$ap->transfer_zone}}"  placeholder="Dropoff Location*" name="temp_14{{$ap->id}}" />
						
						
            

            <div class="form-inner">
                                        <label class="containerss">
                                        <input type="checkbox" data-idinput="dropoff_location{{$ap->id}}" class="chk_other " data-name="dropoff_other"  data-id="{{$ap->id}}" value="1"   /> 
                                            <span class="checkmark"></span>
                                            <span class="text">Other</span>
                                        </label>
                                    </div>

            
       
						</div>
					
					
					<div class="col-md-6 form-inner mb-30 ">
				<input type="text" class="form-control inputsave required" id="passenger_name{{$ap->id}}" data-name="passenger_name"  data-id="{{$ap->id}}" required value="{{$ap->passenger_name}}" name="temp_11{{$ap->id}}" placeholder="Passenger Name*" />
				
              </div>
			 
			   <div class="col-md-6 form-inner mb-30 ">
                 <input type="text" id="actual_pickup_time{{$ap->id}}" value="{{$ap->actual_pickup_time}}" class="form-control inputsave required timepicker" required placeholder="Arrival Time*" name="temp_10{{$ap->id}}" data-id="{{$ap->id}}" data-name="actual_pickup_time" />
				 
              </div>
			 
			  
			  <div class="col-md-6 form-inner mb-30 ">
                 <input type="text" id="flight_no{{$ap->id}}" value="{{$ap->flight_no}}" class="form-control inputsave required"  placeholder="Arrival Flight Details*" name="temp_5{{$ap->id}}" required data-id="{{$ap->id}}" data-name="flight_no" />
				
              </div>
                    
					<div class="col-md-12 form-inner mb-30 ">
					<input type="text" class="form-control inputsave" id="remark{{$ap->id}}" data-name="remark"  data-id="{{$ap->id}}" value="{{$ap->remark}}"  placeholder="Remark" />
                    </div>
					
					@elseif(($ap->activity_entry_type=='Interhotel') || ($ap->activity_entry_type=='Limo'))
		  
                    <div class="col-md-6 form-inner mb-30">
						
					<input type="text" class="form-control inputsave autocom required" id="pickup_location{{$ap->id}}" name="temp_2{{$ap->id}}" data-name="pickup_location"  data-id="{{$ap->id}}" value="{{$ap->pickup_location}}" data-zone="{{$ap->transfer_zone}}"  placeholder="Pickup Location*" required />
										
          
          
          <div class="form-inner">
                                        <label class="containerss">
                                        <input type="checkbox" data-idinput="pickup_location{{$ap->id}}" class="chk_other " data-name="pickup_other"  data-id="{{$ap->id}}" value="1"   /> 
                                            <span class="checkmark"></span>
                                            <span class="text">Other</span>
                                        </label>
                                    </div>

         

                     
                    </div>
					 <div class="col-md-6 form-inner mb-30">
					
					 
					
					<input type="text" class="form-control inputsave autodropoff_location required" name="temp_2{{$ap->id}}" id="dropoff_location{{$ap->id}}" data-name="dropoff_location"  data-id="{{$ap->id}}" value="{{$ap->dropoff_location}}" data-zone="{{$ap->transfer_zone}}"  required placeholder="Dropoff Location*" />
					
                        <div class="form-inner">
                                        <label class="containerss">
                                        <input type="checkbox" data-idinput="dropoff_location{{$ap->id}}" class="chk_other " data-name="dropoff_other"  data-id="{{$ap->id}}" value="1"   /> 
                                            <span class="checkmark"></span>
                                            <span class="text">Other</span>
                                        </label>
                                    </div>
          
          
      
                    </div>
                    @if(($ap->activity_entry_type=='Interhotel'))
					 <div class="col-md-6 form-inner mb-30 ">
               
                 <input type="text" id="actual_pickup_time{{$ap->id}}" value="{{$ap->actual_pickup_time}}" name="temp_1{{$ap->id}}" required class="form-control inputsave required timepicker"  placeholder="Pickup Time*" required data-id="{{$ap->id}}" data-name="actual_pickup_time" />
				 
              </div>
              @endif
                    <div class="col-md-6 form-inner mb-30">
					
					<input type="text" class="form-control inputsave required" id="remark{{$ap->id}}" data-name="remark"  data-id="{{$ap->id}}" value="{{$ap->remark}}" required placeholder="Remark" />
                    </div>
					@elseif($activity->entry_type=='Departure')
		  
                    <div class="col-md-6 form-inner mb-30">
					
					
					<input type="text" class="form-control inputsave autocom required" id="pickup_location{{$ap->id}}" name="pickup_location{{$ap->id}}"  data-name="pickup_location"  data-id="{{$ap->id}}" value="{{$ap->pickup_location}}" data-zone="{{$ap->transfer_zone}}" placeholder="Pickup Location*" required />
					
          
          
          <div class="form-inner">
                                        <label class="containerss">
                                        <input type="checkbox" data-idinput="pickup_location{{$ap->id}}" class="chk_other " data-name="pickup_other"  data-id="{{$ap->id}}" value="1"   /> 
                                            <span class="checkmark"></span>
                                            <span class="text">Other</span>
                                        </label>
                                    </div>

        
                     
                    </div>
					
					 <div class="col-md-6 form-inner mb-30 ">
                
                 <input type="text" id="actual_pickup_time{{$ap->id}}" value="{{$ap->actual_pickup_time}}" class="form-control inputsave required timepicker"  placeholder="Pickup Time*" required data-id="{{$ap->id}}" data-name="actual_pickup_time" />
				 
              </div>
			  <div class="col-md-6 form-inner mb-30 ">
               
                 <input type="text" id="flight_no{{$ap->id}}" value="{{$ap->flight_no}}" class="form-control inputsave required"  placeholder="Departure Flight Details*" required data-id="{{$ap->id}}" data-name="flight_no" />
				
              </div>
                    <div class="col-md-6 form-inner mb-30">
					
					<input type="text" class="form-control inputsave" id="remark{{$ap->id}}" data-name="remark"  data-id="{{$ap->id}}" value="{{$ap->remark}}"  placeholder="Remark" />
                    </div>
					@elseif($activity->entry_type=='Yacht')
                    <div class="col-md-6 form-inner mb-30">
					
					<input type="text" class="form-control inputsave" id="remark{{$ap->id}}" data-name="remark"  data-id="{{$ap->id}}" value="{{$ap->remark}}"  placeholder="Remark" />
                    </div>
                    @else
						<div class="col-md-6 form-inner mb-30">
					
					 
						
					<input type="text" class="form-control inputsave autocom required" id="pickup_location{{$ap->id}}"  data-name="pickup_location"  data-id="{{$ap->id}}" value="{{$ap->pickup_location}}" data-zone="{{$ap->transfer_zone}}" placeholder="Pickup Location*" required />
					 
          
                                <div class="form-inner">
                                        <label class="containerss">
                                        <input type="checkbox" data-idinput="pickup_location{{$ap->id}}" class="chk_other " data-name="pickup_other"  data-id="{{$ap->id}}" value="1"   /> 
                                            <span class="checkmark"></span>
                                            <span class="text">Other</span>
                                        </label>
                                    </div>

          
					  </div>
					
                     @if(($activity->pvt_TFRS=='1') && ($activity->pick_up_required=='1'))
					<div class="col-md-6 form-inner mb-30 ">
                <label for="inputName"></label>
                 <input type="text" id="actual_pickup_time{{$ap->id}}" value="{{$ap->actual_pickup_time}}" class="form-control inputsave required timepicker" required placeholder="Pickup Time*" data-id="{{$ap->id}}" data-name="actual_pickup_time" />
				 
              </div>
                    @endif
                    <div class="col-md-6 form-inner mb-30">
					
					<input type="text" class="form-control inputsave" id="remark{{$ap->id}}" data-name="remark"  data-id="{{$ap->id}}" value="{{$ap->remark}}"  placeholder="Remark" />
                    </div>
					
					@endif
                   
					
                  </div>
				   @endif
				  @endforeach
                 @endif
                 </div>
                 @endif
               
				@endif
                <div class="title">
                            <h4>Select Payment Method</h4>
                        </div>
            
        <div class="inquiry-form box-shadow" >

        <div class="choose-payment-method">
                                       
                                        <div class="">
                                        @php
					$balance  = $voucher->agent->agent_amount_balance - $voucher->agent->agent_credit_limit;
					@endphp

       
                                            <ul>
                                                <li class="paypal active " style="margin-bottom: 15px;">
                                                <input type="radio" checked name="payment" value="creditLimit" /> Credit Limit (AED {{$voucher->agent->agent_credit_limit}}) (Wallet Balance AED {{($balance > 0)?$balance:0}})
                                                </li>
                                                <li class="stripe"  style="margin-bottom: 15px;">
												@if($voucher->agent->flyremit_reg=='1' && $currency['code']=='INR' && $voucher->agent->country_id=='94')
                                                <input type="radio"  name="payment" value="creditCard" />
												@else 
													<input type="radio"  disabled  name="payment" value="creditCard"  />
												@endif
                                               Pay in INR (Net Banking / Credit Card / Debit Card)
                                                </li>
                                                
                                            </ul>
                                        </div>
                                        
                                    </div>

        <div class="col-md-12">
                                      <div class="form-inner">
                                          <label class="containerss">
                                              <input type="checkbox" required placeholder="Terms and Conditions required" name="tearmcsk" id="tearmcsk">
                                              <span class="checkmark"></span>
                                              <span class="text">By clicking Pay Now you agree that you have read ad understood our Terms and Conditions</span>
                                          </label>
                                      </div>
                                  </div>
                                    <div class="form-inner">
                                        <div class="row m-3">
                                            <div class="col-6 text-right" style="display:none">
                                              @if($voucher->status_main < 4 && $voucher->is_refundable==1)
                                              <button type="submit"  name="btn_hold" class="secondary-btn2">Hold</button>
                                              @endif
                                            </div>
                                            <div class="col-6 text-right">
                                              @if($voucher->status_main < 5 )
                                              <button type="submit" name="btn_paynow" class="primary-btn3" id="btn_paynow">Pay Now</button>
											<button type="submit" name="btn_paynow_flyremit" class="primary-btn3 d-none" id="flyremitUrlButton">Pay Now</button>
											  @endif
                                            </div>
											
											
                                        </div>
                                    </div>
        </div>
        

        </form>

                </div>
                <div class="col-lg-4">
                 
                        <div class="title">
                            <h4>Booking Details</h4>
                        </div>
                        
                            <div class="cart-menu">
                                <div class="cart-body">
                                  
                                    @php
				$totalGrand =0; 
                $caid = 0;
$ty=0;
$aid = 0;
			  @endphp
			  @if(!empty($voucherActivity) && $voucher->is_activity == 1)
					@if(!empty($voucherActivity))
					  @foreach($voucherActivity as $ap)
				  @php
					$activity = SiteHelpers::getActivity($ap->activity_id);
                    $entry_type = SiteHelpers::getActivityEntryType($ap->activity_id);
					@endphp
                    @php
            $delKey = $ap->id;
            $totalDiscount = 0;
					@endphp
          @if(($ap->activity_product_type == 'Bundle_Same') || ($ap->activity_product_type == 'Bundle_Diff'))
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
                    <div class="cart-outer-block box-shadow">
                    
                        @if(($ap->activity_product_type != 'Bundle_Same') && ($ap->activity_product_type != 'Bundle_Diff'))
           
                    <form id="delete-form-{{$ap->id}}" method="post" action="{{route('agent.voucher.activity.delete',$delKey.'/0')}}" style="display:none;">
                                {{csrf_field()}}
                                {{method_field('DELETE')}}
                            </form>
                            <span class="cart-close">
                                        <a class="btn btn-info cart-delete" style="font-size: 8pt;
    padding: 1px 4px;" href="javascript:void(0)" onclick="
                                if(confirm('Are you sure, You want to delete this?'))
                                {
                                    event.preventDefault();
                                    document.getElementById('delete-form-{{$ap->id}}').submit();
                                }
                                else
                                {
                                    event.preventDefault();
                                }
                            
                            "><i class="fa fa-trash-alt"></i></a></span>

@elseif($caid != $ap->activity_id)
                            <form id="delete-form-{{$ap->id}}" method="post" action="{{route('agent.voucher.activity.delete',$delKey.'/'.$ap->activity_id)}}" style="display:none;">
                                {{csrf_field()}}
                                {{method_field('DELETE')}}
                            </form>
                            <span class="cart-close">
                                        <a class="btn btn-info cart-delete" style="font-size: 8pt;
    padding: 1px 4px;" href="javascript:void(0)" onclick="
                                if(confirm('Are you sure, You want to delete this?'))
                                {
                                    event.preventDefault();
                                    document.getElementById('delete-form-{{$ap->id}}').submit();
                                }
                                else
                                {
                                    event.preventDefault();
                                }
                            
                            "><i class="fa fa-trash-alt"></i></a></span>

                            @endif
                            <div class="row">
                                          
                                                <div class="col-3" style="margin-bottom:5px;">
                                                    <img src="{{asset('uploads/activities/thumb/'.$activity->image)}}" style="width:50px" alt="image">
                                                    </div>
                                                   
                                                        <div class="col-9 " style="padding-left:0px;padding-top:0px;margin-bottom:5px;">
                                                             <p class="cart-title font-size-21 text-dark" style="font-size:11pt;line-height: 14pt;padding-bottom: 3px;margin-bottom: 0px;font-weight:bold;">
                                                                {{$ap->activity_title}}
                                                                 </p>
                                                                <p class="cart-title font-size-21 text-dark" style="font-size:11pt;line-height: 14pt;padding-bottom: 3px;margin-bottom: 0px;">
                                                               
                                                                {{$ap->variant_name}} {{ $ap->activity_product_type}}  </p>
                                 
                                                       
                                                
                                               <div class="col-12 "  >
                                                
                         
                           <ul class="list-unstyled" style="">
             
                          
                <li  style="font-size:10pt;line-height: 14pt;padding-bottom: 0px;margin-bottom: 0px;">Date: {{ $ap->tour_date ? date(config('app.date_format'),strtotime($ap->tour_date)) : null }} </li>

                <li  style="font-size:10pt;line-height: 14pt;padding-bottom: 0px;margin-bottom: 0px;">{{ $ap->time_slot ? 'Slot: '.$ap->time_slot: null }}</li>
                <li style="font-size:10pt;line-height: 14pt;padding-bottom: 0px;margin-bottom: 0px;"><strong> </strong>Transfer: {{$ap->transfer_option}}</li>
              
                @if(($entry_type == 'Yacht') || ($entry_type == 'Limo'))
                <li style="font-size:10pt;line-height: 14pt;padding-bottom: 0px;margin-bottom: 0px;"> <span class="color-black">{{$ap->adult}} Hour(s)</span> 
                @else
                
                <li style="font-size:10pt;line-height: 14pt;padding-bottom: 0px;margin-bottom: 0px;"> ADT: <span class="color-black">{{$ap->adult}}</span> 
                
                 @if($ap->child > 0)
                  <span class="color-black">CHD: {{$ap->child}}</span>
                @endif
                </li>
               
                @endif
           
                                                          
                                                            <li>
                                                            <div class="row">
                    <div class="col-md-12">
                        <div id="cartIBlock_{{$ap->id}}" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#tourPlan" style="">
                                                <div class="accordion-body">
                                                    <ul>
                                                    @php
                                                    $var_display = 0;
                                                    @endphp
                                                    @if($ap->transfer_option == 'Shared Transfer')
                                                              @php
                                                              $pickup_time = SiteHelpers::getPickupTimeByZone($ap->variant_zones,$ap->transfer_zone);
                                                              $var_display++;
                                                              @endphp
                                                              <li style="font-size:10pt;line-height: 14pt;padding-bottom: 0px;margin-bottom: 0px;"> Pickup Time: {{$pickup_time}}  Approx</li>
                                                            @endif
                                                            @if(($ap->transfer_option == 'Pvt Transfer') && ($ap->variant_pick_up_required == '1')  && ($ap->variant_pvt_TFRS == '1'))
                                                              @php
                                                              $pickup_time = SiteHelpers::getPickupTimeByZone($ap->variant_zones,$ap->transfer_zone);
                                                              $var_display++;
                                                              @endphp
                                                              <li style="font-size:10pt;line-height: 14pt;padding-bottom: 0px;margin-bottom: 0px;"> Pickup Time: {{$ap->variant_pvt_TFRS_text}}  Approx</li>
                                                            @endif
                                                    </ul>
                                                    </div>
                                                    </div>
                                                </div>
                                             </div>
</li>
</ul>
                    </div>
                  
                                                   
                                                </div>
                                               
                    @if($var_display > 0)
                    <div class="col-6 ">
                    <div class="accordion-cart" id="cartBlock_{{$ap->id}}" style="background-color:none!important;">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingOne">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#cartIBlock_{{$ap->id}}" aria-expanded="false" style="font-size: 9pt;" aria-controls="cartIBlock_{{$ap->id}}">
                                               More Details
                                                </button>
                                            </h2>
                                             
                                        </div>
                        
                                        </div>
                                        </div>
                                    @endif    
                                  
                                              
                    </div>
                   
                    <div class=" row" >
                   <hr style="border-top: dotted 1px #000;margin:0px 7px 7px 7px;width: 95%;text-align:center;"/>
                    <div class="col-6" style="><p style="text-align: left;font-weight:bold;margin-top:0px;">Amount</p>  </div>    
                    <div class="col-6" style="text-align: right;margin-top:0px;"><strong>
                        <p style="font-size:10pt;line-height: 14pt;padding-bottom: 0px;margin-bottom: 0px;text-align: right;">
                    @if(($ap->activity_product_type != 'Bundle_Same') && ($ap->activity_product_type != 'Bundle_Diff'))    
                        {{$currency['code']}} {{$ap->totalprice*$currency['value']}}
                    @elseif($caid != $ap->activity_id)
                    {{$currency['code']}} {{$total_sp*$currency['value']}}
                    @endif
                    </strong> </p>    <p style="font-size:10pt;line-height: 14pt;padding-bottom: 0px;margin-bottom: 0px;"><small style="font-size:11px;color:grey;clear:both;">including VAT</small></p>             
                    </div>       
                                                   
                                                    </div>  
                                                    </div>  
                                                    
                                        @php
					$totalGrand += $ap->totalprice; 
                    $caid = $ap->activity_id;
				  @endphp
                  @endif    
				 @endforeach
                 @endif
				  @endif
                
                                </div>
                                </div>
                                <div class="card card-default  box-shadow" style="margin-top: 20px;">
              
              <div class="card-body">
                <div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-6 text-left">
                    <h5 style="padding-bottom: 0px;">Grand Total</h5>
                  </div>
                  <div class="col-md-6 text-right">
                  <h5 style="padding-bottom: 0px;">{{$currency['code']}} {{$totalGrand*$currency['value']}}
                  <small style="font-size:11px;color:grey;font-weight:normal"><br/>including VAT</small>

                  </h5>
                 
                  </div>
                </div>
</div>
</div>
                           
                    @php
						$gtotal = $totalGrand*$currency['value'];
					@endphp
                   
                </div>
            </div>
        </div>
    </div>
    <!-- End Checkout section -->



@endsection



@section('scripts')
<script  src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js
"></script>



<script type="text/javascript">
 
  $(function(){
	 $('.chk_other').each(function() {
        var inputid = $(this).data('idinput');
        var isChecked = $(this).is(':checked');

        // Handle checkbox change
        $(this).on('change', function() {
            if ($(this).is(':checked')) {
                $("body #" + inputid).autocomplete("option", "disabled", true);
            } else {
                $("body #" + inputid).autocomplete("option", "disabled", false);
            }
        });
    });
	 

/* $('#cusDetails').validate({
        errorPlacement: function (error, element) {
            // Customize error placement logic here
            if (element.attr("name") === "fname") {
                error.insertAfter(element.parent());
            } else if (element.attr("name") === "lname") {
                error.insertAfter(element.parent());
            } else {
                // Default behavior
                error.insertAfter(element);
            }
        },
        // Other validation options...
    }); */

	 $(document).on('blur', '.inputsave', function(evt) {
		
		$("#loader-overlay").show();
		$.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
		$.ajax({
            url: "{{route('voucherReportSave')}}",
            type: 'POST',
            dataType: "json",
            data: {
               id: $(this).data('id'),
			   inputname: $(this).data('name'),
			   val: $(this).val()
            },
            success: function( data ) {
               //console.log( data );
			  $("#loader-overlay").hide();
            }
          });
	 }); 

   $(document).on('change', '.inputsavehotel', function(evt) {
		
		$("#loader-overlay").show();
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
               id: $(this).data('id'),
			   inputname: $(this).data('name'),
			   val: $(this).val()
            },
            success: function( data ) {
               //console.log( data );
			  $("#loader-overlay").hide();
            }
          });
	 }); 

	 var path = "{{ route('auto.hotel') }}";
	 var inputElement = $(this); // Store reference to the input element

	 $(".autocom").each(function() {
    var inputElement = $(this);
    inputElement.autocomplete({
        source: function(request, response) {
            $.ajax({
                url: path,
                type: 'GET',
                dataType: "json",
                data: {
                    search: request.term,
                    //zone: inputElement.attr('data-zone')
                },
                success: function(data) {
                    response(data);
                }
            });
        },
        select: function(event, ui) {
			
            $(this).val(ui.item.label);
            return false;
        },
        change: function(event, ui) {
            if (ui.item == null) {
                $(this).val('');
            }
        }
    });
});

 $(".autodropoff_location").each(function() {
    var inputElement = $(this);
    inputElement.autocomplete({
        source: function(request, response) {
            $.ajax({
                url: path,
                type: 'GET',
                dataType: "json",
                data: {
                    search: request.term,
                    //zone: inputElement.attr('data-zone')
                },
                success: function(data) {
                    response(data);
                }
            });
        },
        select: function(event, ui) {
            $(this).val(ui.item.label);
            return false;
        },
        change: function(event, ui) {
            if (ui.item == null) {
               $(this).val('');
            }
        }
    });
});


	
    $("#defaut_dropoff_location").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: path,
                type: 'GET',
                dataType: "json",
                data: {
                    search: request.term,
                },
                success: function(data) {
                    response(data);
                }
            });
        },
        select: function(event, ui) {
            $(this).val(ui.item.label);
			var selectBox = $('.autodropoff_location'); // Adjust selector as per your HTML structure
			selectBox.val(ui.item.label);
			savedropoff_location(ui.item.label);
            return false;
        },
        change: function(event, ui) {
            if (ui.item == null) {
               $(this).val('');
            }
        }
    });

 $("#defaut_pickup_location").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: path,
                type: 'GET',
                dataType: "json",
                data: {
                    search: request.term,
                },
                success: function(data) {
                    response(data);
                }
            });
        },
        select: function(event, ui) {
            $(this).val(ui.item.label);
			var selectBox = $('.autocom'); // Adjust selector as per your HTML structure
			selectBox.val(ui.item.label);
			savepickup_location(ui.item.label);
            return false;
        },
        change: function(event, ui) {
            if (ui.item == null) {
               $(this).val('');
            }
        }
    });


	});
	
	function savepickup_location(v){
		
		if(v!=''){
		$(".autocom.inputsave").each(function() {
			$("#loader-overlay").show();
		$.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
		$.ajax({
            url: "{{route('voucherReportSave')}}",
            type: 'POST',
            dataType: "json",
            data: {
               id: $(this).data('id'),
			   inputname: $(this).data('name'),
			   val: $(this).val()
            },
            success: function( data ) {
               //console.log( data );
			  $("#loader-overlay").hide();
            }
          });
    });
		}
	}
	
	function savedropoff_location(v){
		
		if(v!=''){
		$(".autodropoff_location.inputsave").each(function() {
			$("#loader-overlay").show();
		$.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
		$.ajax({
            url: "{{route('voucherReportSave')}}",
            type: 'POST',
            dataType: "json",
            data: {
               id: $(this).data('id'),
			   inputname: $(this).data('name'),
			   val: $(this).val()
            },
            success: function( data ) {
               //console.log( data );
			  $("#loader-overlay").hide();
            }
          });
    });
		}
	}

 $('input[name="payment"]').change(function() {
        var selectedValue = $('input[name="payment"]:checked').val();
        if(selectedValue=='creditLimit'){
			$('#btn_paynow').removeClass("d-none");
			$('#flyremitUrlButton').addClass("d-none");
		}else if(selectedValue=='creditCard'){
			$('#btn_paynow').addClass("d-none");
			$('#flyremitUrlButton').removeClass("d-none");
		}
    });
    function dosomething()
    {
        var c = 0;
        $(".required").each(function() {
        val = $(this).val();
		if(val == '')
        {
            c++;
            alert("Kindly Enter Required Fields");
            return false;
           
        }
    });
   
   if(c == 0)
       document.getElementById('cusDetails').submit();
      
    }
  $('#btn_paynow').on('click', function(event) {
    event.preventDefault();

    const loaderOverlay = $("body #loader-overlay");
    const form = $('#cusDetails');
    const buttonName = $(this).attr('name');
    const buttonValue = $(this).val();
    // Append button info
    form.append(`<input type="hidden" name="${buttonName}" value="${buttonValue}" />`);

    let firstInvalid = null;
    let name = '';

    let requiredValid = true;
   

   

    if (!form.valid()) {
        form.find(':input').each(function() {
            if (!$(this).valid()) {
                name = $(this).attr('placeholder') || 'a required field';
                firstInvalid = this;
                return false; 
            }
        });

        alert("Please fill " + name);
        if (firstInvalid) $(firstInvalid).focus();
        return false;
    }

 $('.required').each(function() {
        if ($(this).val().trim() === '') {
            requiredValid = false;
            firstInvalid = this;
            name = $(this).attr('placeholder') || 'Required field';
            return false; 
        }
    });

    if (!requiredValid) {
        alert("Please fill " + name);
        $(firstInvalid).focus();
        return false; 
    }

    const selectedtandc = $('input[name="tearmcsk"]:checked').val();
    if (!selectedtandc) {
        alert("You must accept the Terms and Conditions.");
        loaderOverlay.hide();
        return false;
    }
    loaderOverlay.show();
    setTimeout(() => {
        form.submit();
    }, 500);
});


    </script>
@endsection