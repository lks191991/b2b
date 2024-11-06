<!-- Sidebar Menu -->

<div class="right-sidebar-menu">
        <div class="sidebar-logo-area d-flex justify-content-between align-items-center">
            <div class="right-sidebar-close-btn">
                <i class="bi bi-x"></i>
            </div>
            <h4>My Cart</h4>
        </div>
        <div class="sidebar-content-wrap">
            <div class="category-wrapper">
                @php
					$total = 0;
                    $caid  = 0;
					$currency = SiteHelpers::getCurrencyPrice();
					@endphp
				
			  
					@if(!empty($voucherActivity))
					  @foreach($voucherActivity as $ap)
				  @php
		  $activityImg = SiteHelpers::getActivityImageName($ap->activity_id);
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
                                        <a class="btn btn-info cart-delete" title="delete" href="javascript:void(0)" onclick="
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
                                        <a class="btn btn-info cart-delete" title="delete" href="javascript:void(0)" onclick="
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
                    <img src="{{asset('uploads/activities/'.$activityImg)}}" class="img-fluid" style="border-radius: 5px;" />
                    </div>
                    <div class="col-9 " style="padding-left:0px;padding-top:0px;margin-bottom:5px;">
                    <p class="cart-title font-size-21 text-dark" style="font-size:11pt;line-height: 14pt;padding-bottom: 0px;margin-bottom: 0px;">
                        {{$ap->activity_title}} : {{$ap->variant_name}}
                        </p>
                                 
                    </div>
              </div>
             
                                  <div class="col-12 "  >
                                   
			
              <ul class="list-unstyled" style="">
             
               
				
                <li>
                <i class="fas fa-calendar-alt color-grey" style="font-size:16px;color:grey" title=""></i> {{ $ap->tour_date ? date(config('app.date_format_full'),strtotime($ap->tour_date)) : null }}.  {{$ap->time_slot}}
                </li>
                @if(($entry_type == 'Yacht') || ($entry_type == 'Limo'))
                <li><i class="fas fa-clock color-grey" style="font-size:16px;color:grey" title="Adult"></i> <span class="color-black">{{$ap->adult}} Hour(s)</span> 
                </li>
                
               
                @else
                
                <li>  <i class="fas fa-male color-grey" style="font-size:16px;color:grey" title="Adult"></i> <span class="color-black">{{$ap->adult}}</span> 
                
                 @if($ap->child > 0)
                 <i class="fas fa-child color-grey" style="font-size:14px;color:grey" title="Child"></i>  <span class="color-black">{{$ap->child}}</span>
                @endif
                <li>
                <li>
                <i class="fas fa-car color-grey" style="font-size:16px;color:grey" title="Adult"></i> {{$ap->transfer_option}}
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
                                                              <li><i class="fas fa-clock color-grey" style="font-size:16px;color:grey" title="Adult"></i> Pickup Time:  {{$pickup_time}} Approx</li>
                                                            @endif
                                                            @if(($ap->transfer_option == 'Pvt Transfer') && ($ap->variant_pick_up_required == '1')  && ($ap->variant_pvt_TFRS == '1'))
                                                              @php
                                                              $pickup_time = SiteHelpers::getPickupTimeByZone($ap->variant_zones,$ap->transfer_zone);
                                                              $var_display++;
                                                              @endphp
                                                              <li> <i class="fas fa-clock color-grey" style="font-size:16px;color:grey" title="Adult"></i> Pickup Time: {{$ap->variant_pvt_TFRS_text}} Approx</li>
                                                            @endif
                                                    </ul>
                                                </div>
                                             </div>
                    </div>
                    <div class="col-6">
                    @if($var_display > 0)
                    <div class="accordion-cart" id="cartBlock_{{$ap->id}}" style="background-color:none!important;">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingOne">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#cartIBlock_{{$ap->id}}" aria-expanded="false" aria-controls="cartIBlock_{{$ap->id}}">
                                               More Details
                                                </button>
                                            </h2>
                                             
                                        </div>
                        
                                    </div>
                                    @endif
                    </div>
                    <div class="col-6">
                    <p class="float-right" style="text-align: right;">
                        
                   
                    @if(($ap->activity_product_type != 'Bundle_Same') && ($ap->activity_product_type != 'Bundle_Diff'))        
                    <strong> {{$currency['code']}}  {{$ap->totalprice*$currency['value']}}
                    </strong> <small style="font-size:11px;color:grey"><br/>including Taxes</small>
                     @elseif($caid != $ap->activity_id)
                     <strong> {{$currency['code']}}  {{$total_sp*$currency['value']}}
                     </strong> <small style="font-size:11px;color:grey"><br/>including Taxes</small>
                      @endif
                
                      </p>
                    </div>
                   </div>
               
                
               
                </li>
                
              </ul>
			   
           
			
                </div>
                </div>
                @endif
                @php
                $total += $ap->totalprice;

                $caid = $ap->activity_id;
                @endphp
              
				 @endforeach
                 @endif
             
            </div>
            
        </div>
        
        <div class="sidebar-bottom">
            <div class="row">
           
                <div class="col-md-12">
                @if($voucherActivityCount > 0)
                               <h5 class="col-md-12" style="width:100%; text-align: right;">Total Amount : {{$currency['code']}} {{$total*$currency['value']}}</h5>
                            @endif
                </div>
                
            </div>
            
        
            <div class="row cart-checkout-block">
               
                <div class="col-md-12 mt-3" style="text-align: center;">
                @if($voucherActivityCount > 0)
                                  <a href="{{ route('agent-vouchers.show',$voucher->id) }}" class="secondary-btn2" >
                                <i class="fas fa-shopping-cart"></i>
                                Checkout({{$voucherActivityCount}})
                            </a>
                            @endif
                </div>
            </div>
            
        </div>
    </div>

<!-- END CART VIEW -->


