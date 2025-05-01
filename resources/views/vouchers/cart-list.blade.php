@php
$caid = 0;
$ty=0;
$aid = 0;
					$total = 0;
					@endphp
 @if(!empty($voucherActivity) && $voucher->is_activity == 1)
 <div class="mt-2 " id="div-cart-list" >
				
			  
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