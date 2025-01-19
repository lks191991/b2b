@extends('layouts.appLogin')
@section('content')
@php
//$currency = SiteHelpers::getCurrencyPrice();
@endphp
   



<div class="breadcrumb-section" style="background-image: linear-gradient(270deg, rgba(0, 0, 0, .3), rgba(0, 0, 0, 0.3) 101.02%), url({{asset('front/assets/img/innerpage/inner-banner-bg.png')}});">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 d-flex justify-content-center">
                    <div class="banner-content">
                        <h1>Booking Detail : {{$voucher->code}}</h1>
                       
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    
    <!-- Start Checkout section -->
    <div class="checkout-page pt-120 mb-120">
        <div class="container">
            <div class="row g-lg-4 gy-5">
                <div class="col-lg-12">
                    <div class="row">
                    <div class="col-lg-8">
                    <h2 class="text-30 md:text-24 fw-700 mt-20">Booking Confirmation Details</h2>
                          
                </div>
                            <div class="col-lg-2  text-right">
                        @if($voucher->status_main > 4)
                            <a class="btn btn-success btn-sm" href="{{route('voucherInvoicePdf',$voucher->id)}}" >
                            <i class="fas fa-download"></i> Download Invoice
                                   
                                    
                                </a>
                                @endif    
                        </div>
                        <div class="col-lg-2 text-right">
                        @if($voucher->status_main > 4)
                            <a class="btn btn-secondary btn-sm" href="{{route('voucherActivityItineraryPdf',$voucher->id)}}" >
                            <i class="fas fa-download"></i> Download Itinerary
                                   
                                    
                                </a>
                                @endif    
                        </div>
                    </div>
                  
                    <div class="booking-form-wrap mb-40">
                        <div class="row">
                        <div class="col-md-3 col-6 form-inner mb-30">
                    <div class=" mb-10"><strong>Voucher Number</strong></div>
                    <div class="text-accent-2">{{$voucher->code}}</div>
                  </div>

                  <div class="col-md-3 col-6 form-inner mb-30">
                    <div class=" mb-10"><strong>Agent Reference No.</strong></div>
                    <div class="text-accent-2">{{$voucher->agent_ref_no}}</div>
                  </div>
                  <div class="col-md-3 col-6 form-inner mb-30">
                    <div class=" mb-10"><strong>Booked On</strong></div>
                    <div class="text-accent-2">{{ $voucher->created_at ? date(config('app.date_format'),strtotime($voucher->created_at)) : null }}</div>
                  </div>
                  <div class="col-md-3 col-6 form-inner mb-30">
                    <div class=" mb-10"><strong>Paid On</strong></div>
                    <div class="text-accent-2">{{ $voucher->booking_date ? date(config('app.date_format'),strtotime($voucher->booking_date)) : null }}</div>
                  </div>
                  </div>
                  <div class="row">
				  <div class="col-md-3 col-6 form-inner mb-30">
                    <div class=" mb-10"><strong>Guest Name</strong></div>
                    <div class="text-accent-2">{{$voucher->guest_name}}</div>
                  </div>
				  <div class="col-md-3 col-6 form-inner mb-30">
                    <div class=" mb-10"><strong>Email</strong></div>
                    <div class="text-accent-2">{{$voucher->guest_email}}</div>
                  </div>
				  <div class="col-md-3 col-6 form-inner mb-30">
                    <div class=" mb-10"><strong>Mobile No.</strong></div>
                    <div class="text-accent-2">{{$voucher->guest_phone}}</div>
                  </div>
				  
				  <div class="col-md-12 form-inner mb-30">
                    <div class=" mb-10"><strong>Remark</strong></div>
                    <div class="text-accent-2">{{$voucher->remark}}</div>
                  </div>
                        </div>
                    </div>

<!-- End Block 1 -->

<h2 class="text-30 md:text-24 fw-700 mt-20">Activity Details</h2>
                   
                        

                       @php
				$totalGrand =0; 
				$totalGrandDiscount =0; 
                $caid = 0;
$ty=0;
$aid = 0;
			  @endphp
			  @if(!empty($voucherActivity) && $voucher->is_activity == 1)
					@if(!empty($voucherActivity))
					  @foreach($voucherActivity as $ak => $ap)
				  @php
					$ticketCount = SiteHelpers::getTicketCountByCode($ap->variant_code);
					@endphp
					@php
				$tourDt = date("Y-m-d",strtotime($ap->tour_date));
				$validTime = PriceHelper::checkCancellation($ap->id);
				$activity = SiteHelpers::getActivity($ap->activity_id);

            
				@endphp
                @php
            $delKey = $ap->id;
            $totalDiscount = 0;
					@endphp
          @if(($ap->activity_product_type == 'Bundle_Same') || ($ap->activity_product_type == 'Bundle_Diff'))
          @php
          $aid = $ap->activity_id;
          $delKey = $ap->voucher_id;
          $aPrice  = 0;
          
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
          
              <div class="room-suits-card mb-30">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <div class="swiper hotel-img-slider swiper-fade swiper-initialized swiper-horizontal swiper-watch-progress swiper-backface-hidden">
                                 
                                    <div class="swiper-wrapper" id="swiper-wrapper-58e7db6662f9966d" aria-live="off">
                                        <div class="swiper-slide swiper-slide-visible swiper-slide-active swiper-slide-next" role="group" aria-label="1 / 1" data-swiper-slide-index="0" style="width: 285px; opacity: 1; transform: translate3d(0px, 0px, 0px);">
                                            <div class="room-img">
                                            <img src="{{asset('uploads/activities/'.$activity->image)}}" alt="image">
                                            </div>
                                        </div>
                                    </div>
                                  
                                <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span></div>
                            </div>
                            <div class="col-md-8">
                                <div class="room-content" style="padding-bottom: 0px;">
                                    <div class="content-top">
                                        <div class="row">
                                        <div class="col-md-1 date-block" style="">
                                            <h2 style="">{{ $ap->tour_date ? date(config('app.date_format_date'),strtotime($ap->tour_date)) : null }}</h2>
                                            <p>{{ $ap->tour_date ? date(config('app.date_format_my'),strtotime($ap->tour_date)) : null }}</p>
                                        </div>
                                            <div class="col-md-9">
                                            <h5 style="">
                                            {{$ap->activity_title}}  
                     
                                        </h5>
                                        <p class="tour_title">Tour Option: {{$ap->variant_name}}  </p>
                                        @if($ap->slot_time !='')
                                        <p class="tour_title">Slot Time: {{$ap->slot_time}}  </p>
                                        @endif
                                            </div>

                                            <div class="col-md-2 text-right no-padding">
                                            <span class="btn btn-sm  btn-success booking-status"  href="javascript:void(0);">
                                            @if($ap->status == '1')
				Cancellation Requested
				@elseif($ap->status == '2')
				Cancelled
				@elseif($ap->status == '3')
				In Process
				@elseif($ap->status == '4')
				Confirm
				@elseif($ap->status == '5')
				Vouchered
				@endif 
                    </span>
                                            </div>
                                        </div>
                                        <div class="row">
                                       
                                        <div class="col-md-12 highlight-tour mb-20" style="padding-left:0px;">
                        <p>Service Type : {{$ap->transfer_option}}</p>
                    
                                        
                                        </div>
										@if(!empty($ap->time_slot))
										<div class="col-md-12 highlight-tour mb-20" style="padding-left:0px;">
                        <p>Slot : {{$ap->time_slot}}</p>
                    
                                        
                                        </div>
										@endif
                                        </div>
                                        <div class="row">
                                        <div class="col-md-1" style="padding-left:0px;padding-right:0px;text-align:center">
                                        </div>
                                            <div class="col-md-8">
                                          
                                            
                           
                            
                           
                           
                          </div>

                                        
                                            </div>

                                            <div class="col-md-12 text-right">
                                            @if($validTime['btm'] == '0')
                     Non - Refundable
          @elseif($validTime['btm'] == '2')
                       Partial Refundable
					@else
                        Cancellation upto<br/>{{$validTime['validuptoTime']}}
                    @endif 
                                            <div class="price-area text-right">
                                                @php
				  $totalDiscount = $ap->discount_tkt+ $ap->discount_sic_pvt_price;
				  $aPrice = $ap->totalprice - $totalDiscount; 
				  @endphp
                                                <span  class="clear">
                                                
                                                @if(($ap->activity_product_type != 'Bundle_Same') && ($ap->activity_product_type != 'Bundle_Diff'))   
                                               
                                                {{$voucher->currency_code}} {{$aPrice*$voucher->currency_value}}
                                                <small class="clear"><br/>Inclusive of taxes</small>

                    @elseif($caid != $ap->activity_id)
                    {{$voucher->currency_code}} {{$total_sp*$voucher->currency_value}}
                 
                                                
                                            </span>
                                                <small class="clear"><br/>Inclusive of taxes</small>

                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                                </div>
                                
                            </div>
                                <div class="content-bottom content-bottom-bg" style="">
                                      <div class="row">
                                        <div class="col-ms-12">
                                        <div class="accordion" id="accordionTravel_{{ $ak }}">
                            <div class="accordion-item">
                              <h2 class="accordion-header" id="travelheadingOne_{{$ak}}">
                                
                              </h2>
                              <div id="travelcollapseOne_{{ $ak }}" class="accordion-collapse collapse" aria-labelledby="travelheadingOne_{{$ak}}" data-bs-parent="#accordionTravel_{{ $ak }}" style="">
                                <div class="accordion-body">
                                <ul class="detail-inline">
                                                               
                                                                         
                                                                         @if($ap->transfer_option == 'Shared Transfer')
                                                                             @php
                                                                             $pickup_time = SiteHelpers::getPickupTimeByZone($ap->variant_zones,$ap->transfer_zone);
                                                                             @endphp
                                                                   <li><span>Pickup Timing:</span> {{$pickup_time}} </li>
                                                                         @endif
                                                                         @if(($ap->transfer_option == 'Pvt Transfer') && ($ap->variant_pick_up_required == '1')  && ($ap->variant_pvt_TFRS == '1'))
                                                                         <li><span>Pickup Timing:</span> {{$ap->variant_pvt_TFRS_text}} </li>
                                                                         @endif
                                                                 <li><span>Adult x {{$ap->adult}}  - Child x {{!empty($ap->child)?$ap->child:0}} </span></li>
                                                                         
                                                                         @if(($ap->transfer_option == 'Shared Transfer') || ($ap->transfer_option == 'Pvt Transfer'))
                                                                     @if($activity->entry_type=='Arrival')	
                                                                     <li><span>Dropoff Location:</span> {{$ap->dropoff_location}}</li>
                                                               <li><span>Passenger Name:</span> {{$ap->passenger_name}} </li>
                                                                     <li>Arrival Time:</span> {{$ap->actual_pickup_time}} </li>
                                                               <li><span>Flight Details:</span> {{$ap->flight_no}}</li>
                                                               <li><span>Remark:</span> {{$ap->remark}}</li>
                                                                         @elseif($activity->entry_type=='Interhotel')
                                                                         <li><span>Pickup Location:</span> {{$ap->pickup_location}}</li>
                                                                         <li><span>Dropoff Location: </span>{{$ap->dropoff_location}}</li>
                                                                         <li><span>Pickup Time:</span> {{$ap->actual_pickup_time}}</li>
                                                                         <li><span>Remark:</span> {{$ap->remark}}</li>
                                                                         @elseif($activity->entry_type=='Departure')
                                                                         <li><span>Pickup Location:</span> {{$ap->pickup_location}}</li>
                                                                         <li><span>Pickup Time:</span> {{$ap->actual_pickup_time}}</li>
                                                                         <li><span>Flight Details:</span> {{$ap->flight_no}}</li>
                                                                         <li><span>Remark:</span> {{$ap->remark}}</li>
                                                                         @else
                                                                         <li><span>Pickup Location:</span> {{$ap->pickup_location}}</li>
                                                                         @if(($activity->pvt_TFRS=='1') && ($activity->pick_up_required=='1'))
                                                                 <li><span>Pickup Time:</span> {{$ap->actual_pickup_time}}</li>
                                                                         @endif
                                                                         <li><span>Remark: </span>{{$ap->remark}}</li>
                                                                         @endif
                                                                         @endif
                                                                         
                                                                                                    
                                                                                                 </ul>
                                </div>
                              </div>
                            </div>
                            
                                        </div>
                                      </div>
                                      <div class="row">
                                    <div class="col-md-4">
                                        
				@if(($validTime['btm'] > 0) && ($ap->status > 2))

                @if(($ap->activity_product_type != 'Bundle_Same') && ($ap->activity_product_type != 'Bundle_Diff'))
                  <form id="cancel-form-{{$ap->id}}" method="post" action="{{route('agent-voucher.activity.cancel',$ap->id)}}" style="display:none;">
                  {{csrf_field()}}
                  </form>
                      <a class="btn-danger  float-right cancelAct  btn-sm ml-2" href="javascript:void(0)" data-variantcode="{{$ap->variant_code}}" href="javascript:void(0)" data-apid="{{$ap->id}}"> Cancel</a>
                      @elseif($caid != $ap->activity_id)

                      <form id="cancel-form-{{$ap->id}}" method="post" action="{{route('agent-voucher.activity.cancel',$ap->id)}}" style="display:none;">
                  {{csrf_field()}}
                  </form>
                      <a class="btn-danger  float-right cancelActBB  btn-sm ml-2" href="javascript:void(0)" data-variantcode="{{$ap->variant_code}}" href="javascript:void(0)" data-apid="{{$ap->id}}"> Cancel</a>
					  @endif
                   
                  </div>
                  <div class="col-md-4 text-center">
     
                  <form id="tickets-generate-form-{{$ap->id}}" method="post" action="{{route('tickets.generate',$ap->id)}}" style="display:none;">
                                      {{csrf_field()}}
                      <input type="hidden" id="statusv" value="2" name="statusv"  /> 
                      <input type="hidden" id="payment_date" name="payment_date"  /> 
                                  </form>
                                  @if(($voucher->status_main == 5) and ($ap->ticket_generated == '0') and ($ticketCount > '0') and ($ap->status == '3'))
                    <a class="" href="javascript:void(0)" onclick="TicketModel('{{$ap->id}}')">Download Ticket</a>
                    
                    @elseif(($ap->ticket_generated == '1') and ($ap->status == '4'))
                    <a class=""  href="javascript:void(0)" onclick="TicketModel('{{$ap->id}}')" >Download Ticket</a>
                    @endif
                    @endif
                                    </div>
<!--                     
                    @if($ap->status == 1)
                      <span style="color:red"  >{{ config('constants.voucherActivityStatus')[$ap->status] }}</span>
                      @endif -->
                      <div class="col-md-4 text-right">
                     
                      <a class="collapsed text-right" type="button" data-bs-toggle="collapse" data-bs-target="#travelcollapseOne_{{ $ak }}" aria-expanded="false" aria-controls="travelcollapseOne_{{ $ak }}">
                      More Details
                                </a>
                                    </div>

                                     
                                         
                                      </div>
                                 </div>
                                
                        </div>

                        
                    </div>                  

        


        
                  @endif
                  @php
					$totalGrand += $ap->totalprice; 
					$totalGrandDiscount += $totalDiscount; 
                    $caid = $ap->activity_id;
				  @endphp
				 @endforeach
                 @endif
				  @endif
          
<!-- End Block 2 -->

<div class="booking-form-wrap mb-40">
                          
					
                  <div class="col-md-12 text-right">
                    <h3>Final Amount : {{$voucher->currency_code}} {{($totalGrand - $totalGrandDiscount)*$voucher->currency_value}}</h3>
                    <span>Inclusive all Taxes</span>
                  
                  </div>
                         
                          </div>

                </div>
                
            </div>
        </div>
    </div>
    <!-- End View section -->

    <div class="modal fade" id="DownloadTicketmodel" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalLabelTkt" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabelTkt">Download Ticket</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="mbody">
            Once the Tickets are downloaded it’s Non Refundable.<br/>

Do you want proceed with the Download ?             </div>
            <div class="modal-footer">
			 
              
                <button type="button" class="btn btn-primary" onclick="downloadTicket()">Yes</button>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="apid" value="0"  /> 
	<div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cancellation Chart</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group" id="dataCancel">
                  <div id="cancel-header"></div>
                   <table id="cancellationTable" class="table table-striped" style="display: none;">
					<thead>
						
					</thead>
					<tbody>
						<!-- Table rows will be dynamically added here -->
					</tbody>
				</table>
        <div id="cancel-footer"></div>
                </div>
            </div>
           <div class="modal-footer d-flex justify-content-between">
			
            <button type="button" class="btn btn-sm btn-primary btn-sm" id="selectCancelBtn"><i class="fa fa-tick"></i> Yes</button>
		</div>

        </div>
    </div>
</div>


<div class="modal fade" id="cancelModalBB" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalLabelBB" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabelBB">Cancellation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group" id="dataCancelBB">
                  <div id="cancel-headerBB"></div>
                   <table id="cancellationTableBB" class="table table-striped" style="display: none;">
					<thead>
						
					</thead>
					<tbody>
						<!-- Table rows will be dynamically added here -->
					</tbody>
				</table>
        <div id="cancel-footerBB"></div>
                </div>
            </div>
           <div class="modal-footer d-flex justify-content-between">
			
           
		</div>

        </div>
    </div>
</div>

@endsection



@section('scripts')

<script type="text/javascript">

   $(".d-pdf").on('click', function (e) {
    e.preventDefault();
    window.location.href = this.getAttribute('href');
    // Reload the page after a delay (adjust the delay time as needed)
    setTimeout(function () {
        location.reload();
    }, 2000); // Reload after 2 seconds
});
$(document).ready(function() {
 $(document).on('click', '.cancelAct', function(evt) {
	 variantcode = $(this).data('variantcode');
	 formid = $(this).data('apid');
	  evt.preventDefault();
	
		 $.ajax({
			  url: "{{ route('get.vacancellation.chart') }}",
			  type: 'POST',
			  dataType: "json",
			  data: {
				  "_token": "{{ csrf_token() }}",
				  variantcode:variantcode,
          formid:formid
				  },
			  success: function(data) {
				   var cancellationData = data.cancel_table;
           $('#cancellationTable tbody').empty();
           $('#cancel-header').html("");
            $('#cancel-footer').html("");
				  if(cancellationData.length > 0) {
					
          
            if(data.free_cancel_till != '')
            {
              var row = '<p style="text-align: center;font-size: 12px;">To Avoid cancellation charges the booking must be cancelled on or before '+data.free_cancel_till+'</p>';
              $('#cancel-header').html(row);
            }
            else
            {
              var row = '<p style="text-align: center;font-size: 12px;">The Booking is Partial Refundable as Ticket is Not Refundable</p>';
              $('#cancel-header').html(row);
            }
            var row = '<p style="text-align: center;font-size: 12px;">All dates of special conditions are based on Dubai time. Please Consider local time difference and allow extra time where applicable</p>';
            $('#cancel-footer').html(row);
            var row = '<tr>' +
                '<tr><th>From Date</th><th>To Date</th><th>Refund Amount</th></tr>';
            $('#cancellationTable tbody').append(row);
           

						cancellationData.forEach(function(cancel) {
							var row = '<tr>' +
								'<td>' + cancel.start_time + '</td>' +
								'<td>' + cancel.end_time + '</td>' +
								'<td> ' + cancel.refund_amt + '</td>' +
								'</tr>';
							$('#cancellationTable tbody').append(row);
						});
					
						$('#cancellationTable').show();
						openModal(data.cancel,formid);
				} else {
						 var row = '<tr>' +
                '<td colspan="3" style="text-align: center;">Non-Refundable</td>' +
                '</tr>';
            $('#cancellationTable tbody').append(row);
			$('#cancellationTable').show();
			openModal(data.cancel,formid);
					}
				//console.log(data);
			  },
			  error: function(error) {
				console.log(error);
			  }
		});
	
	
 });

 $(document).on('click', '.cancelActBB', function(evt) {
	 variantcode = $(this).data('variantcode');
	 formid = $(this).data('apid');
	  evt.preventDefault();
	
		
				  
           $('#cancellationTableBB tbody').empty();
           $('#cancel-headerBB').html("");
            $('#cancel-footerBB').html("");
				
						 var row = '<tr>' +
                '<td colspan="3" style="text-align: center;"><p>To cancel a Combo Deal, please send an email to bookings@abaterab2b.com.</p><p>Our team will respond within 24 hours.</p><p>For urgent cancellation requests, feel free to contact us at +9714 2989992 or reach out to your account manager directly..</p></td>' +
                '</tr>';
            $('#cancellationTableBB tbody').append(row);
			$('#cancellationTableBB').show();
			openModalBB();
					
				//console.log(data);
			 
	
 });
 });
function openModal(cancel,formid) {
        $('#cancelModal').modal('show');
        $('#selectCancelBtn').on('click', function() {
			$("body #cancel-form-"+formid).submit();
        });
		
        $('#cancelModal .close').on('click', function() {
            $('#cancelModal').modal('hide');
        });
   
}

function openModalBB() {
        $('#cancelModalBB').modal('show');
        
        $('#cancelModalBB .close').on('click', function() {
            $('#cancelModalBB').modal('hide');
        });
   
}
$('#Ticketmodel .close').on('click', function() {
            $('#DownloadTicketmodel').modal('hide');
			$('#apid').val('0');
        });
function TicketModel(id) {

       $('#DownloadTicketmodel').modal('show');
	   $('#apid').val(id);
    }
function downloadTicket() {
		var id = $('#apid').val();
        event.preventDefault();
        document.getElementById('tickets-generate-form-'+id).submit();
    }</script>
@endsection
