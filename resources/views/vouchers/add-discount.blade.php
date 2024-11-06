@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Discount Details</h1>
          </div>
          
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->

  

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
  
<div class="row multistep">
        <div class="col-md-3 multistep-step complete">
            <div class="text-center multistep-stepname" style="font-size: 16px;">Add to Cart</div>
            <div class="progress"><div class="progress-bar"></div></div>
            <a href="#" class="multistep-dot"></a>
        </div>

        <div class="col-md-3 multistep-step current">
            <div class="text-center multistep-stepname" style="font-size: 16px;">Discount</div>
            <div class="progress"><div class="progress-bar"></div></div>
            <a href="#" class="multistep-dot"></a>
        </div>

        <div class="col-md-3 multistep-step next">
            <div class="text-center multistep-stepname" style="font-size: 16px;">Voucher</div>
            <div class="progress"><div class="progress-bar"></div></div>
            <a href="#" class="multistep-dot"></a>
        </div>
		 <div class="col-md-3">
				@if($voucher->is_activity == 1)
				@if($voucher->status_main < 5)
				<a class="btn btn-info btn-sm float-left" style=" margin-top: 20px;margin-left: 120px;" href="{{route('voucher.add.activity',$voucher->id)}}" >Add More</a>

				@endif
				@endif
				</div>
        
        
    </div>
	
        <div class="row" style="margin-top: 30px;">
		
          <!-- left column -->
          <div class="offset-md-1 col-md-6">
		  
			
            <div class="card card-default">
              <div class="card-header">
                <h3 class="card-title"><i class="nav-icon fas fa-book" style="color:black"></i> Discount Information</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
            
                <div class="card-body">
				
					@if(!empty($voucherActivity))
						 @php
					$c=0;
					$tkt=0;
					@endphp
					
					
					 @foreach($voucherActivity as $ap)
					 @php
					$c++;
					@endphp
				  
          
                  <div class="row" style="margin-bottom: 15px;">
                   <div class="col-12"><p><strong>{{$c}}. {{$ap->variant_name}} : {{$ap->transfer_option}}@if($ap->transfer_option == 'Shared Transfer')
					@php
					$zone = SiteHelpers::getZoneName($ap->transfer_zone);
					@endphp
					- Zone :{{(isset($zone->name))?$zone->name:''}}
					@endif</strong></p></div>
					
				
			  <div class="form-group col-md-6 ">
              <label>Sequence</label>
              <input type="text" id="serial_no{{$ap->id}}" value="{{$ap->serial_no}}"  required="required" class="form-control inputsave"  placeholder="Tour Sequence" required data-id="{{$ap->id}}" data-name="serial_no" />
				
				
              </div>
			 
                  </div>
				  
				  @endforeach
                 @endif
				  
                </div>
                </div>
				
                <!-- /.card-body -->

               
           
			
          
            
            <!-- /.card -->
 <!-- general form elements -->
 <div class="card card-default">
  
   

    
</div>
<!-- /.card -->

            <!-- Horizontal Form -->
            

          </div>
          <!--/.col (left) -->
          <!-- right column -->
          <div class="col-md-4" >
		 
            <!-- Form Element sizes -->
			@php
      $totalGrand =0; 
				$totalGrandDiscount =0; 
        $caid = 0;
$ty=0;
$aid = 0;
			  @endphp
			  @if(!empty($voucherActivity) && $voucher->is_activity == 1)
					@if(!empty($voucherActivity))
          <div class="card card-default">
             
             <div class="card-body">
              
        
              <div class="row" id="markup_block" style="margin-bottom: 15px;">
                 <div class="col-md-6 text-left">
                   <strong>Markup (%)</strong>
                 </div>
                 <div class="col-md-6 text-right">
                  <select id="markup_per" class="form-control">
                   @for($i=0;$i<=70;$i++)
                   <option value="{{$i}}">{{$i}}</option>
                   @endfor
                   </select> 
                 </div>
               </div>
               
             </div>
             <!-- /.card-body -->
           </div>
           <!-- /.card -->
          
			
					  @foreach($voucherActivity as $ap)
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
           
            <div class="card card-default">
			
              <div class="card-header">
                <div class="row">
				<div class="col-md-8 text-left">
                    <h3 class="card-title">
                      <strong> {{$ap->activity_title}}</strong></h3>
                  </div>
				<div class="col-md-4 text-right">
                    <form id="delete-form-{{$ap->id}}" method="post" action="{{route('agent.voucher.activity.delete',$ap->id)}}" style="display:none;">
                                {{csrf_field()}}
                                {{method_field('DELETE')}}
                            </form>
                            <a class="btn-danger btn-sm" href="javascript:void(0)" onclick="
                                if(confirm('Are you sure, You want to delete this?'))
                                {
                                    event.preventDefault();
                                    document.getElementById('delete-form-{{$ap->id}}').submit();
                                }
                                else
                                {
                                    event.preventDefault();
                                }
                            
                            "><i class="fas fa-trash"></i></a>
                            <a class="btn-info btn-sm" href="{{route('voucher.activity.view',[$ap->activity_id,$voucher->id,$ap->tour_date,$ap->adult,$ap->child,$ap->infant,$ap->transfer_option])}}"><i class="fas fa-edit"></i></a>
                    
                  </div>
				   </div>
              </div>
              <div class="card-body">
			  
			  <div class="">
        @if(($ap->activity_product_type != 'Bundle_Same'))
                <div class="row" style="margin-bottom: 5px;">
                    <div class="col-md-5 text-left">
                      <strong>Tour Option</strong>
                    </div>
                    <div class="col-md-7 text-right">
                      {{$ap->variant_name}}
                    </div>
                </div>
                @endif
                <div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-5 text-left">
                    <strong>Date</strong>
                  </div>
                  <div class="col-md-7 text-right">
                   {{ $ap->tour_date ? date(config('app.date_format'),strtotime($ap->tour_date)) : null }}

                   {{ $ap->time_slot ? ' : '.$ap->time_slot: null }}
                  </div>
                </div>
                <div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-5 text-left">
                    <strong>Transfer Type</strong>
                  </div>
                  <div class="col-md-7 text-right">
                   {{$ap->transfer_option}}
                  </div>
                </div>
				@if($ap->transfer_option == 'Shared Transfer')
					@php
					$pickup_time = SiteHelpers::getPickupTimeByZone($ap->variant_zones,$ap->transfer_zone);
					@endphp
                <div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-5 text-left">
                    <strong>Pickup Timing</strong>
                  </div>
                  <div class="col-md-7 text-right">
                   {{$pickup_time}}
                  </div>
                </div>
				@endif
        @php
          $priceAr = PriceHelper::getVariantPrice($ap->variant_price_id);
          $total_min_rate = 0;
          
          //$total_min_rate = ($priceAr->adult_mini_selling_price*$ap->adult)+((float)$priceAr->child_mini_selling_price*$ap->child);
					@endphp
				@if(($ap->transfer_option == 'Pvt Transfer') && ($ap->variant_pick_up_required == '1')  && ($ap->variant_pvt_TFRS == '1'))
					@php
					$pickup_time = SiteHelpers::getPickupTimeByZone($ap->variant_zones,$ap->transfer_zone);
					@endphp
                <div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-5 text-left">
                    <strong>Pickup Timing</strong>
                  </div>
                  <div class="col-md-7 text-right">
                   {{$ap->variant_pvt_TFRS_text}}
                  </div>
                </div>
				@endif
                <div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-5 text-left">
                    <strong>Pax</strong>
                  </div>
                  <div class="col-md-7 text-right">
                  @if(($ap->activity_entry_type == 'Yacht') || ($ap->activity_entry_type == 'Limo'))
							        {{$ap->adult}}  Hour(s)
						    	@else
                   {{$ap->adult}} Adult {{$ap->child}} Child
                   @endif
                  </div>
                </div>
                <div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-5 text-left">
                    <strong>Amount</strong> 
                  </div>
                  <div class="col-md-7 text-right">
                  @if(($ap->activity_product_type == 'Bundle_Same'))
                  AED {{$total_sp}} 
                  @else
                   AED {{$ap->totalprice}} 
                   @endif
                  </div>
                </div>
                @if($ap->original_tkt_rate > 0)
                <div class="row" style="margin-bottom: 5px;">

            
                  <div class="col-md-5 text-left">
                    <strong>Net Ticket Amount (Total)</strong>
                  </div>
                  <div class="col-md-7 text-right">
                  @if(($ap->activity_product_type == 'Bundle_Same'))
                  <input type="hidden" id="net_amount_tkt{{$ap->id}}" 	@if(($ap->activity_product_type == 'Bundle_Same') || ($ap->activity_product_type == 'Bundle_Diff')) readonly @endif value="{{($ap->original_tkt_rate>0)?$ap->original_tkt_rate-$ap->discount_tkt:0}}"   class="form-control inputsaveDisTktTrans text-right"  placeholder="Ticket Discount"  data-id="{{$ap->id}}" data-maxdis="{{$ap->original_tkt_rate}}"  data-min="{{$total_min_rate}}" data-name="tkt" />

                 
                  <input type="hidden" id="discount_tkt{{$ap->id}}" value="{{($ap->discount_tkt>0)?$ap->discount_tkt:0}}"   class="form-control dis_price"  placeholder="Ticket Discount"  data-id="{{$ap->id}}" data-name="discount_tkt" />

                  <input type="hidden" id="org_tkt{{$ap->id}}" value="{{($ap->original_tkt_rate>0)?$ap->original_tkt_rate:0}}"   class="form-control"   data-id="{{$ap->id}}" data-name="org_tkt" />
  @else

  <input type="text" id="net_amount_tkt{{$ap->id}}" 	@if(($ap->activity_product_type == 'Bundle_Same') || ($ap->activity_product_type == 'Bundle_Diff')) readonly @endif value="{{($ap->original_tkt_rate>0)?$ap->original_tkt_rate-$ap->discount_tkt:0}}"   class="form-control inputsaveDisTktTrans text-right"  placeholder="Ticket Discount"  data-id="{{$ap->id}}" data-maxdis="{{$ap->original_tkt_rate}}"  data-min="{{$total_min_rate}}" data-name="tkt" />

                 
                  <input type="hidden" id="discount_tkt{{$ap->id}}" value="{{($ap->discount_tkt>0)?$ap->discount_tkt:0}}"   class="form-control dis_price"  placeholder="Ticket Discount"  data-id="{{$ap->id}}" data-name="discount_tkt" />

                  <input type="hidden" id="org_tkt{{$ap->id}}" value="{{($ap->original_tkt_rate>0)?$ap->original_tkt_rate:0}}"   class="form-control"   data-id="{{$ap->id}}" data-name="org_tkt" />
  @endif
                    
                  </div>
                </div>
                @else
                <input type="hidden" id="discount_tkt{{$ap->id}}" value="0"   class="form-control "  placeholder="Ticket Discount"   />
                @endif
               
                @if($ap->original_trans_rate > 0)
				<div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-5 text-left">
                    <strong>Net Transfer Amount (Total)</strong>
                  </div>
                  <div class="col-md-7 text-right">
                  @if(($ap->activity_product_type == 'Bundle_Same'))

                  <input type="hidden" id="net_sic_pvt_price{{$ap->id}}" @if(($ap->activity_product_type == 'Bundle_Same') || ($ap->activity_product_type == 'Bundle_Diff')) readonly @endif value="{{($ap->original_trans_rate>0)?($ap->original_trans_rate-$ap->discount_sic_pvt_price):0}}"   class="form-control inputsaveDisTktTrans  text-right"  placeholder="Transfer Discount" data-maxdis="{{$ap->original_trans_rate}}" data-min="{{$ap->original_trans_rate}}"  data-id="{{$ap->id}}" data-name="sic_pvt_price" />

                  <input type="hidden" id="discount_sic_pvt_price{{$ap->id}}" value="{{($ap->discount_sic_pvt_price>0)?$ap->discount_sic_pvt_price:0}}"   class="form-control dis_price"  placeholder="Transfer Discount"  data-id="{{$ap->id}}" data-name="discount_sic_pvt_price" />

                 
                  <input type="hidden" id="org_sic_pvt_price{{$ap->id}}" value="{{($ap->original_trans_rate>0)?$ap->original_trans_rate:0}}"   class="form-control"  placeholder="Transfer"  data-id="{{$ap->id}}" data-name="org_sic_pvt_price" />
                  @else
                  <input type="text" id="net_sic_pvt_price{{$ap->id}}" @if(($ap->activity_product_type == 'Bundle_Same') || ($ap->activity_product_type == 'Bundle_Diff')) readonly @endif value="{{($ap->original_trans_rate>0)?($ap->original_trans_rate-$ap->discount_sic_pvt_price):0}}"   class="form-control inputsaveDisTktTrans  text-right"  placeholder="Transfer Discount" data-maxdis="{{$ap->original_trans_rate}}" data-min="{{$ap->original_trans_rate}}"  data-id="{{$ap->id}}" data-name="sic_pvt_price" />

<input type="hidden" id="discount_sic_pvt_price{{$ap->id}}" value="{{($ap->discount_sic_pvt_price>0)?$ap->discount_sic_pvt_price:0}}"   class="form-control dis_price"  placeholder="Transfer Discount"  data-id="{{$ap->id}}" data-name="discount_sic_pvt_price" />


<input type="hidden" id="org_sic_pvt_price{{$ap->id}}" value="{{($ap->original_trans_rate>0)?$ap->original_trans_rate:0}}"   class="form-control"  placeholder="Transfer"  data-id="{{$ap->id}}" data-name="org_sic_pvt_price" />

                  @endif
                  </div>
                </div>
                @else
               
                <input type="hidden" id="discount_sic_pvt_price{{$ap->id}}" value="0"   class="form-control "  />
                @endif
				<div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-5 text-left">
                    <strong>Net Total</strong>
                  </div>
                  <div class="col-md-7 text-right">
				  @php
				  $totalDiscount = $ap->discount_tkt+ $ap->discount_sic_pvt_price;
				  @endphp
          @if(($ap->activity_product_type == 'Bundle_Same'))
          <input type="hidden" id="org_total_price{{$ap->id}}" value="{{$total_sp}}"   class="form-control "   data-id="{{$ap->id}}"  />
                   AED <span id="total_price_{{$ap->id}}">{{$total_sp}}<span>
              @else 
              <input type="hidden" id="org_total_price{{$ap->id}}" value="{{$ap->totalprice}}"   class="form-control "   data-id="{{$ap->id}}"  />
              AED <span id="total_price_{{$ap->id}}">{{$ap->totalprice - $totalDiscount}}<span>

              @endif
                  </div>
                </div>
				</div>
				
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
            @endif
            
            <!-- /.card -->
@php
					$totalGrand += $ap->totalprice; 
					$totalGrandDiscount += $totalDiscount; 
				 
      $caid = $ap->activity_id;
      @endphp
				 @endforeach
                 @endif
				  @endif
         <!-- /.startteldiv-->
          @if(!empty($voucherHotel) && $voucher->is_hotel == 1)
					@if(!empty($voucherHotel))
					  @foreach($voucherHotel as $vh)
            @php
            $room = SiteHelpers::hotelRoomsDetails($vh->hotel_other_details)
            @endphp
            <div class="card card-default">
              <div class="card-header">
                <div class="row">
				<div class="col-md-8 text-left">
                    <h3 class="card-title">
                      <strong> {{$vh->hotel->name}}</strong></h3>
                  </div>
				<div class="col-md-4 text-right">
                    <form id="delete-form-hotel-{{$vh->id}}" method="post" action="{{route('voucher.hotel.delete',$vh->id)}}" style="display:none;">
                                {{csrf_field()}}
                                {{method_field('DELETE')}}
                            </form>
                            <a class="btn-danger btn-sm" href="javascript:void(0)" onclick="
                                if(confirm('Are you sure, You want to delete this?'))
                                {
                                    event.preventDefault();
                                    document.getElementById('delete-form-hotel-{{$vh->id}}').submit();
                                }
                                else
                                {
                                    event.preventDefault();
                                }
                            
                            "><i class="fas fa-trash"></i></a>
                    
                  </div>
				   </div>
              </div>
              <div class="card-body">
			  
			  <div class="">
          <div class="row" style="margin-bottom: 5px;">
            <div class="col-md-5 text-left">
              <strong>Hotel Category</strong>
            </div>
            <div class="col-md-7 text-right">
              {{$vh->hotel->hotelcategory->name}}
            </div>
        </div>
                <div class="row" style="margin-bottom: 5px;">
                    <div class="col-md-5 text-left">
                      <strong>Check In</strong>
                    </div>
                    <div class="col-md-7 text-right">
                      {{$vh->check_in_date}}
                    </div>
                </div>
                <div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-5 text-left">
                    <strong>Check Out</strong>
                  </div>
                  <div class="col-md-7 text-right">
                   {{$vh->check_out_date}}
                  </div>
                </div>
                <div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-5 text-left">
                    <strong>Room Type</strong>
                  </div>
                  <div class="col-md-7 text-right">
                    {{$room['room_type']}}
                  </div>
                </div>
                <div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-5 text-left">
                    <strong>Number of Rooms</strong>
                  </div>
                  <div class="col-md-7 text-right">
                    {{$room['number_of_rooms']}}
                  </div>
                </div>
                <div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-5 text-left">
                    <strong>Occupancy</strong>
                  </div>
                  <div class="col-md-7 text-right">
                    {{$room['occupancy']}}
                  </div>
                </div>
                <div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-5 text-left">
                    <strong>Meal Plan</strong>
                  </div>
                  <div class="col-md-7 text-right">
                    {{$room['mealplan']}}
                  </div>
                </div>
                <div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-5 text-left">
                    <strong>Amount Incl. VAT</strong>
                  </div>
                  <div class="col-md-7 text-right">
                   AED {{$room['price']}}
                  </div>
                </div>
                <div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-5 text-left">
                    <strong>Total</strong>
                  </div>
                  <div class="col-md-7 text-right">
                   AED {{$room['price']}}
                  </div>
                </div>
				</div>
				
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
@php
					$totalGrand += $room['price']; 
				  @endphp
				 @endforeach
                 @endif
				  @endif
           <!-- /.endhoteldiv-->
            <div class="card card-default">
              <div class="card-header">
                <h3 class="card-title"><strong>Total Payment</strong></h3>
              </div>
              <div class="card-body">
                <div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-6 text-left">
                    <strong>Amount Incl. VAT</strong>
                  </div>
                  <div class="col-md-6 text-right">
                   AED {{$totalGrand}}
                   <input type="hidden" id="total_amount" value="{{$totalGrand}}"   class="form-control "     />
                  </div>
                </div>
				 <div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-6 text-left">
                    <strong>Discount</strong>
                  </div>
                  <div class="col-md-6 text-right">
                   AED <span id="total_discount">{{$totalGrandDiscount}}</span>
                  </div>
                </div>
               
                <div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-6 text-left">
                    <h5>Final Amount</h5>
                  </div>
                  <div class="col-md-6 text-right">
                   <h5>AED <span id="grand_total">{{$totalGrand - $totalGrandDiscount}}</span></h5>
                  </div>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <div class="card-footer">
      <div class="row" style="margin-bottom: 5px;">
        
        <div class="col-12 text-right">
			@if(!empty($voucherActivity))

     
			<a href="{{ route('vouchers.show',$voucher->id) }}" id="checkout-btn" class="btn btn-lg btn-primary pull-right" style="width:100%">
			<i class="fas fa-shopping-cart"></i>
			Checkout
			</a>
			@endif
        </div>
      </div>
    </div>
          </div>
          <!--/.col (right) -->
          
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
  
    <!-- /.content -->
@endsection



@section('scripts')

<script type="text/javascript">
 
  $(function(){


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

$(document).on('change', '.inputsaveDisTktTrans', function(evt) {
		$("#loader-overlay").show();
		var id = $(this).data('id');

    var markup_per = parseFloat($("body #markup_per").val());
   
    var org_tkt = parseFloat($("body #org_tkt" + id).val());
        var org_tff = parseFloat($("body #org_sic_pvt_price" + id).val());
        var enet_tkt = parseFloat($("body #net_amount_tkt" + id).val());
        var enet_tff = parseFloat($("body #net_sic_pvt_price" + id).val());
        var net_tkt = parseFloat($("body #net_amount_tkt" + id).val());
        var net_tff =  parseFloat($("body #net_sic_pvt_price" + id).val()); //parseFloat($("body #net_sic_pvt_price" + id).val());
        var name = $(this).data('name');
        if(name == 'tkt')
        {
          var cval = enet_tkt;
          var val = parseFloat(org_tkt-net_tkt).toFixed(2);
         $("body #discount_tkt" + id).val(val);
         $("body #net_amount_tkt" + id).val(net_tkt);
        }
        else
        {
         
        
          var val = parseFloat(org_tff-net_tff).toFixed(2);
          $("body #discount_sic_pvt_price" + id).val(val);
          $("body #net_sic_pvt_price" + id).val(net_tff);
        }
      
		var inputname = "discount_"+$(this).data('name');
		
    var minval = $(this).data('min');
		if((cval < minval) && (name == 'tkt'))
    {
      var maxdis = $(this).data('maxdis');
			alert("Invalid selling price: Ticket Selling Price can't be less than "+minval);
			$("#loader-overlay").hide();
			$(this).val(maxdis)
			return false;
		}
		//alert(id);
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
               id: id,
			   inputname: inputname,
			   val: val,
            },
            success: function( data ) {
               // 
      
        
         var trf = parseFloat($("body #discount_sic_pvt_price" + id).val());
         var tkt = parseFloat($("body #discount_tkt" + id).val());
         var total_price = parseFloat($("body #org_total_price" + id).val());
        
         var net_price = parseFloat(total_price-(tkt+trf)).toFixed(2);
      
         $("body #total_price_" + id).html(net_price);

         var dis_sum = 0;
    $("input[class *= 'dis_price']").each(function(){
      dis_sum += +$(this).val();
    });
    var total_amount = parseFloat($("body #total_amount").val());
   var payable_amt = parseFloat(total_amount-(dis_sum)).toFixed(2);
    $("body #total_discount").html(dis_sum);
    $("body #grand_total").html(payable_amt);
			     $("#loader-overlay").hide();
            }
          });
	 });
	 
	});
	


</script>
@endsection
