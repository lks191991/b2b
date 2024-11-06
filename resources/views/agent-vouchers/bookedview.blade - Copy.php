@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Booking Confirmation( {{$voucher->code}})</h1>
          </div>
		 
						  <div class="col-sm-3 text-right">
						  </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
      <div class="row">
       
		
       <!-- left column -->
       <div class="offset-md-2 col-md-8">
              <div class="row multistep">
                <div class="col-md-3 multistep-step complete">
                    <div class="text-center multistep-stepname" style="font-size: 16px;">Add to Cart</div>
                    <div class="progress"><div class="progress-bar"></div></div>
                    <a href="#" class="multistep-dot"></a>
                </div>

                <div class="col-md-3 multistep-step complete">
                    <div class="text-center multistep-stepname" style="font-size: 16px;">Payment</div>
                    <div class="progress"><div class="progress-bar"></div></div>
                    <a href="#" class="multistep-dot"></a>
                </div>

                <div class="col-md-3 multistep-step current">
                    <div class="text-center multistep-stepname" style="font-size: 16px;">Confimation</div>
                    <div class="progress"><div class="progress-bar"></div></div>
                    <a href="#" class="multistep-dot"></a>
                </div>

                
            </div>
</div>
</div>

        <div class="row" style="margin-top: 30px;">
       
		
          <!-- left column -->
          <div class="offset-md-2 col-md-8">
		   <form id="cusDetails" method="post" action="{{route('agent.vouchers.status.change',$voucher->id)}}" >
			 {{ csrf_field() }}
            <!-- general form elements -->
            <div class="card card-default">
              <div class="card-header">
                 <h3 class="card-title"><i class="nav-icon fas fa-user" style="color:black"></i> Passenger Details</h3>
				 <h3 class="card-title" style="float:right">
				  @if($voucher->status_main == 5)
          <a class="btn btn-info btn-sm" href="{{route('voucherInvoicePdf',$voucher->id)}}" >
                              Download Invoice <i class="fas fa-download">
                              </i>
                             
                          </a>
						  @endif
         
						  </h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
            
                <div class="card-body">
                  <div class="row" style="margin-bottom: 15px;">
                    
                    <div class="col-6">
					<label for="inputName">Guest Name:</label>
                     {{$voucher->guest_name}}
                    </div>
                   
                
                    <div class="col-6">
					<label for="inputName">Email:</label>
                     {{$voucher->guest_email}}
                    </div>
                   
                    <div class="col-6">
					  <label for="inputName">Mobile No.:</label>
                     {{$voucher->guest_phone}}
                    </div>
                    <div class="col-6">
                      
					   <label for="inputName">Agent Reference No.:</label>
                     {{$voucher->agent_ref_no}}
                    </div>
                  </div>
                  <div class="row" style="margin-bottom: 5px;">
                    <div class="col-12">
					 <label for="inputName">Remark.:</label>
                     {{$voucher->remark}}
                     
                    </div>
                   
                  </div>
                </div>
                <!-- /.card-body -->
				
               
            </div>
            <!-- /.card -->
@if(!empty($voucherActivity) && $voucher->is_activity == 1)
	@php
					$ii = 0;
					@endphp
				@foreach($voucherActivity as $ap)
				  @if(($ap->transfer_option == 'Shared Transfer') || ($ap->transfer_option == 'Pvt Transfer'))
				  @php
					$ii = 1;
					@endphp
				@endif
					@endforeach
					
            <div class="card card-default {{($ii=='0')?'hide':''}}">
              <div class="card-header">
                <h3 class="card-title"><i class="nav-icon fas fa-book" style="color:black"></i> Additional Information</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <div class="card-body">
			
					@if(!empty($voucherActivity))
						 @php
					$c=0;
					@endphp
					  @foreach($voucherActivity as $ap)
				  @if(($ap->transfer_option == 'Shared Transfer') || ($ap->transfer_option == 'Pvt Transfer'))
				  @php
			  $c++;
					$activity = SiteHelpers::getActivity($ap->activity_id);
					@endphp
                  <div class="row" style="margin-bottom: 15px;">
                    <div class="col-12"><p><strong>{{$c}}. {{$ap->variant_name}} : {{$ap->transfer_option}}</strong></p></div>
					@if($activity->entry_type=='Arrival')
                    <div class="col-6">
					<label for="inputName">Dropoff Location:</label>
					{{$ap->dropoff_location}}
                     
                    </div>
					 <div class="col-6">
					<label for="inputName">Passenger Name:</label>
					{{$ap->passenger_name}}
                     
                    </div>
					<div class="col-6">
					<label for="inputName">Arrival Time:</label>
					{{$ap->actual_pickup_time}}
                     
                    </div>
					<div class="col-6">
					<label for="inputName">Flight Details:</label>
					{{$ap->flight_no}}
                     
                    </div>
                    <div class="col-6">
					<label for="inputName">Remark:</label>
					{{$ap->remark}}
                    </div>
				
					@elseif($activity->entry_type=='Interhotel')
					<div class="col-6">
					<label for="inputName">Pickup Location:</label>
					{{$ap->pickup_location}}
                     
                    </div>
					 <div class="col-6">
					<label for="inputName">Dropoff Location:</label>
					{{$ap->dropoff_location}}
                     
                    </div>
					<div class="col-6">
					<label for="inputName">Pickup Time:</label>
					{{$ap->actual_pickup_time}}
                     
                    </div>
                    <div class="col-12 pt-3">
					<label for="inputName">Remark:</label>
					{{$ap->remark}}
                    </div>
					@elseif($activity->entry_type=='Departure')
					<div class="col-6">
					<label for="inputName">Pickup Location:</label>
					{{$ap->pickup_location}}
                     
                    </div>
					
					<div class="col-6">
					<label for="inputName">Pickup Time:</label>
					{{$ap->actual_pickup_time}}
                     
                    </div>
					<div class="col-6">
					<label for="inputName">Flight Details:</label>
					{{$ap->flight_no}}
                     
                    </div>
                    <div class="col-12 pt-3">
					<label for="inputName">Remark:</label>
					{{$ap->remark}}
                    </div>
					@else
					<div class="col-6">
					<label for="inputName">Pickup Location:</label>
					{{$ap->pickup_location}}
                     
                    </div>
					
					 
					@if(($activity->pvt_TFRS=='1') && ($activity->pick_up_required=='1'))
					<div class="col-6">
					<label for="inputName">Pickup Time:</label>
					{{$ap->actual_pickup_time}}
                     
                    </div>
					
					@endif
					
                    <div class="col-6">
					<label for="inputName">Remark:</label>
					{{$ap->remark}}
                    </div>
					
					
					@endif
					
                  </div>
				   @endif
				  @endforeach
                 @endif
				 
                </div>
                <!-- /.card-body -->

               
            </div> @endif
            <!-- /.card -->

           
            <!-- /.card -->
 <!-- general form elements -->
 
<!-- /.card -->

            <!-- Horizontal Form -->
            
            <!-- /.card -->
</form>
          </div>
          <!--/.col (left) -->
          <!-- right column -->
          <div class="offset-md-2 col-md-8">
            <!-- Form Element sizes -->
			@php
				$totalGrand =0; 
			  @endphp
			  @if(!empty($voucherActivity) && $voucher->is_activity == 1)
					@if(!empty($voucherActivity))
					  @foreach($voucherActivity as $ap)
				   @php
					$activity = SiteHelpers::getActivity($ap->activity_id);
					$ticketCount = SiteHelpers::getTicketCountByCode($ap->variant_unique_code);
					@endphp
					
					@php
				$tourDt = date("Y-m-d",strtotime($ap->tour_date));
				$validTime = SiteHelpers::checkCancelBookingTime($ap->variant_unique_code,$activity->id,$tourDt,$ap->transfer_option);
				
				@endphp
            <div class="card card-default">
              <div class="card-header">
                <div class="row">
				<div class="col-md-5 text-left">
                    <h3 class="card-title">
                      <strong> {{$activity->title}}</strong></h3>
                  </div>
				  
				    <div class="col-md-3 text-rihgt">
                    <h6 class="card-title" style="font-size:10px">
                     @if($validTime['btm'] == '0')
                      <strong> Non - Refundable</strong>
					@else
						 <strong> Cancellation upto {{$validTime['validuptoTime']}}</strong>
					@endif
					</h6>
                  </div>
                  <div class="col-md-4 text-right pl-5">
                   @if(($ap->status == '4') && ($validTime['btm'] =='1') && ($ap->ticket_downloaded == '0'))
						<form id="cancel-form-{{$ap->id}}" method="post" action="{{route('agent-voucher.activity.cancel',$ap->id)}}" style="display:none;">
						{{csrf_field()}}
						</form>
							<a class="btn-danger  float-right  btn-sm ml-2" href="javascript:void(0)" onclick="
							if(confirm('Are you sure, You want to cancel this?'))
							{
							event.preventDefault();
							document.getElementById('cancel-form-{{$ap->id}}').submit();
							}
							else
							{
							event.preventDefault();
							}

							"><i class="fas fa-times"></i> Cancel</a>
						@endif
						
                                @if(($voucher->status_main == 5) and ($ap->ticket_generated == '0') and ($ticketCount > '0') and ($ap->status == '3'))
                        <form id="tickets-generate-form-{{$ap->id}}" method="post" action="{{route('tickets.generate',$ap->id)}}" style="display:none;">
                                            {{csrf_field()}}
                            <input type="hidden" id="statusv" value="2" name="statusv"  /> 
                            <input type="hidden" id="payment_date" name="payment_date"  /> 
                                        </form>
                        
                          <a class="btn btn-success float-right mr-3 btn-sm" href="javascript:void(0)" onclick="
                                            if(confirm('You want to download ticket?'))
                                            {
                                                event.preventDefault();
                                                document.getElementById('tickets-generate-form-{{$ap->id}}').submit();
                                            }
                                            else
                                            {
                                                event.preventDefault();
                                            }
                                        
                                        "><i class="fas fa-download"></i> Ticket</a>
                          
                          @elseif(($ap->ticket_generated == '1') and ($ap->status == '4))
						  <a class="btn btn-success float-right  btn-sm  d-pdf" href="#" onclick='window.open("{{route('ticket.dwnload',$ap->id)}}");return false;'  ><i class="fas fa-download"></i> Ticket</a>
                         
                          @endif
						  
						  @if($ap->status == 1)
							<span style="color:red"  >{{ config('constants.voucherActivityStatus')[$ap->status] }}</span>
							@endif
                          
                                
                              </div>
				   </div>
              </div>
              <div class="card-body">
			  
			  <div class="">
                <div class="row" style="margin-bottom: 5px;">
                    <div class="col-md-5 text-left">
                      <strong>Tour Option</strong>
                    </div>
                    <div class="col-md-7 text-right">
                      {{$ap->variant_name}}
                    </div>
                </div>
                <div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-5 text-left">
                    <strong>Date</strong>
                  </div>
                  <div class="col-md-7 text-right">
                   {{$ap->tour_date}}
                  </div>
                </div>
				@if($ap->transfer_option == 'Shared Transfer')
					@php
					$pickup_time = SiteHelpers::getPickupTimeByZone($ap->variant_zones,$ap->transfer_zone);
					@endphp
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
					$pickup_time = SiteHelpers::getPickupTimeByZone($activity->zones,$ap->transfer_zone);
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
				@if(($ap->transfer_option == 'Pvt Transfer') && ($activity->pick_up_required == '1')  && ($activity->pvt_TFRS == '1'))
					@php
					$pickup_time = SiteHelpers::getPickupTimeByZone($activity->zones,$ap->transfer_zone);
					@endphp
                <div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-5 text-left">
                    <strong>Pickup Timing</strong>
                  </div>
                  <div class="col-md-7 text-right">
                   {{$activity->pvt_TFRS_text}}
                  </div>
                </div>
				@endif
                <div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-5 text-left">
                    <strong>Pax</strong>
                  </div>
                  <div class="col-md-7 text-right">
                   {{$ap->adult}} Adult {{$ap->child}} Child
                  </div>
                </div>
                <div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-5 text-left">
                    <strong>Amount Incl. VAT</strong>
                  </div>
                  <div class="col-md-7 text-right">
                   AED {{$ap->totalprice}}
                  </div>
                </div>
                <div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-5 text-left">
                    <strong>Total</strong>
                  </div>
                  <div class="col-md-7 text-right">
                   AED {{$ap->totalprice}}
                  </div>
                </div>
				</div>
				
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
@php
					$totalGrand += $ap->totalprice; 
				  @endphp
				 @endforeach
                 @endif
				  @endif
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
                  </div>
                </div>
               <!-- <div class="row" style="margin-bottom: 15px;">
                  <div class="col-md-6 text-left">
                    <strong>Handling charges (2%)</strong>
                  </div>
                  <div class="col-md-6 text-right">
                   AED 2.30
                  </div>
                </div> -->
                <div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-6 text-left">
                    <h3>Final Amount</h3>
                  </div>
                  <div class="col-md-6 text-right">
                   <h3>AED {{$totalGrand}}</h3>
                  </div>
				  
                </div>
				
              </div>
			  
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
			
            
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

   $(".d-pdf").on('click', function (e) {
    e.preventDefault();
    window.location.href = this.getAttribute('href');
    // Reload the page after a delay (adjust the delay time as needed)
    setTimeout(function () {
        location.reload();
    }, 2000); // Reload after 2 seconds
});

</script>
@endsection