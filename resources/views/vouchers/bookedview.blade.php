@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1>Booking Confirmation( {{$voucher->code}})</h1>
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
                    <div class="text-center multistep-stepname" style="font-size: 16px;">Confirmation</div>
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
                 <h3 class="card-title"><i class="nav-icon fas fa-user" style="color:black"></i> Agent Details</h3>
				 <h3 class="card-title" style="float:right">
				 @if(($voucher->status_main == 4) OR ($voucher->status_main == 5))

         <a class="btn btn-success btn-sm" href="{{route('voucherActivityItineraryPdf',$voucher->id)}}" >
                              Itinerary <i class="fas fa-download">
                              </i>
                             
                          </a>
                          @if(($voucher->status_main == 4))
          <a class="btn btn-info btn-sm" href="{{route('voucherInvoicePdf',$voucher->id)}}" >
                              Proforma Invoice <i class="fas fa-download">
                              </i>
                             
                          </a>
                          @else
                          @if(($voucher->summary_invoice == 1))
                          <a class="btn btn-secondary btn-sm" href="{{route('voucherInvoiceSummaryPdf',$voucher->id)}}" >
                            Invoice (Summary) <i class="fas fa-download">
                           </i>
                          
                       </a>
                       @else
                          <a class="btn btn-info btn-sm" href="{{route('voucherInvoicePdf',$voucher->id)}}" >
                               Invoice <i class="fas fa-download">
                              </i>
                             
                          </a>
                          @endif
                        
                          

						  @endif
              @endif
              @if($voucher->parent_id > 0)
						<a class="btn btn-danger btn-sm float-right" style=" margin-left: 10px;" href="{{ route('vouchers.show',[$voucher->parent_id]) }}" >View Parent Itinerary</a>
					@else
					<a class="btn btn-danger btn-sm float-right" style="margin-left: 10px;" href="{{ route('vouchers.create',['pid'=>$voucher->id]) }}" >Add More Services</a>
					@endif
						  </h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
            
                <div class="card-body">
                  <div class="row" style="margin-bottom: 15px;">
                    
                    <div class="col-6">
					<label for="inputName">Agency Name:</label>
          {{ ($voucher->agent)?$voucher->agent->company_name:''}}
                    </div>
                   
                
                   
                   
                    <div class="col-6">
					  <label for="inputName">Mobile No.:</label>
                     {{$voucher->mobile}}
                    </div>
                    
                  </div>

                  <div class="row" style="margin-bottom: 15px;">
                    
                    <div class="col-6">
					<label for="inputName">Created On:</label>
          {{ $voucher->created_at ? date("M d Y, H:i:s",strtotime($voucher->created_at)) : null }}
                    </div>
                   
                
                   
                   
                    <div class="col-6">
					  <label for="inputName">Created By.:</label>
            {{ ($voucher->createdBy)?$voucher->createdBy->name:''}}
                    </div>
                    
                  </div>
                  <div class="row" style="margin-bottom: 15px;">
                    
                    <div class="col-6">
					<label for="inputName">Vouchered On:</label>
          {{ $voucher->booking_date ? date("M d Y, H:i:s",strtotime($voucher->booking_date)) : null }}
                    </div>
                   
                
                   
                   
                    <div class="col-6">
					  <label for="inputName">Vouchered By.:</label>
            {{ ($voucher->createdBy)?$voucher->updatedBy->name:''}}
                    </div>
                    
                  </div>
                 
                </div>
                <!-- /.card-body -->
				
               
            </div>

            <div class="card card-default">
              <div class="card-header">
                 <h3 class="card-title"><i class="nav-icon fas fa-user" style="color:black"></i> Passenger Details</h3>
				 <h3 class="card-title" style="float:right">
				
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
					<div class="col-6">
                      
					   <label for="inputName">File Handling By:</label>
                     {{$voucher->file_handling_by}}
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
				$totalGrandDiscount =0; 
			  @endphp
			  @if(!empty($voucherActivity) && $voucher->is_activity == 1)
					@if(!empty($voucherActivity))
					  @foreach($voucherActivity as $ap)
				  @php
          if($ap->parent_code == 0)
            $ticketCount = SiteHelpers::getTicketCountByCode($ap->variant_code);
          else
					  $ticketCount = SiteHelpers::getTicketCountByCode($ap->parent_code);
					
					@endphp
					@php
				$tourDt = date("Y-m-d",strtotime($ap->tour_date));
				$validTime = PriceHelper::checkCancellation($ap->id);
				$activity = SiteHelpers::getActivity($ap->activity_id);
      
				@endphp
            <div class="card card-default">
              <div class="card-header">
                <div class="row">
				<div class="col-md-6 text-left">
                    <h3 class="card-title">
                      <strong> {{$ap->activity_title}}</strong>
                    
                   
                    
                    </h3>

                      
  @if($ap->status == '1')
 <span class='badge bg-danger' style='margin-left: 5px;'>Cancellation Requested</span>
  @elseif($ap->status == '2')
  <span class='badge bg-danger' style='margin-left: 5px;'>Cancelled</span> 
   @elseif($ap->status == '3')
   <span class='badge bg-warning' style='margin-left: 5px;'>{{ ($ap->isRayna == '1') ? "API Confirm" : "In Process" }}</span> 
   @elseif($ap->status == '4')
   <span class='badge bg-success' style='margin-left: 5px;'>Confirm</span> 
   @elseif($ap->status == '5')
   <span class='badge bg-success' style='margin-left: 5px;'>Vouchered</span>
     
     @elseif($ap->status == '13')
   <span class='badge bg-danger' style='margin-left: 5px;'>{{config('constants.voucherActivityStatus')[$ap->status]}}</span>
     @endif 
     </span> 
                  </div>
                  <div class="col-md-2 text-rihgt">
                    <h6 class="card-title" style="font-size:10px">
                  
					@if($validTime['btm'] == '0')
                      <strong> Non - Refundable</strong>
          @elseif($validTime['btm'] == '2')
                      <strong> Partial Refundable</strong>
					@else
						 <strong> Free Cancellation upto<br/>{{$validTime['validuptoTime']}}</strong>
					@endif
				  </h6>
                  </div>
				 
				  
                
        
     
   

        <div class="col-md-4 text-right ">
         
          @if($ap->status > 2)
		@if((auth()->user()->role_id == '1'))
						
						<form id="cancel-form-{{$ap->id}}" method="post" action="{{route('voucher.activity.cancel',$ap->id)}}" >
						{{csrf_field()}}
						<input type="hidden" id="cancel_remark_data-{{$ap->id}}" name="cancel_remark_data-{{$ap->id}}" class="form-control cancel_remark" />
						</form>
						@if(($ap->ticket_downloaded == '0'))
							<a class="btn btn-primary  float-right cancelAct btn-sm ml-2" data-variantcode="{{$ap->variant_code}}" data-apid="{{$ap->id}}" href="javascript:void(0)" ><i class="fas fa-times"></i> Cancel </a>
            @else
            <a class="btn btn-danger  float-right cancelAct btn-sm ml-2" style="color:#fff;" data-variantcode="{{$ap->variant_code}}" data-apid="{{$ap->id}}" href="javascript:void(0)" ><i class="fas fa-times"></i> Cancel </a>
            @endif
					
				@elseif(($ap->ticket_downloaded == '0') && ($validTime['btm'] == '1') || ($ap->status == '3'))
						
						<form id="cancel-form-{{$ap->id}}" method="post" action="{{route('voucher.activity.cancel',$ap->id)}}" style="display:none;">
						{{csrf_field()}}
						<input type="hidden" id="cancel_remark_data-{{$ap->id}}" name="cancel_remark_data-{{$ap->id}}" class="form-control cancel_remark" />
						</form>
						
							<a class="btn btn-primary  float-right cancelAct btn-sm ml-2" data-variantcode="{{$ap->variant_code}}" href="javascript:void(0)" data-apid="{{$ap->id}}" ><i class="fas fa-times"></i> Cancel </a>
						@endif
          	@endif
			
			
            @if(!empty($ap->referenceNo) && ($ap->isRayna == '1') && ($ap->ticket_generated == '0') && ($voucher->status_main == 5) && ($voucher->status == 3))
							<form id="tickets-generate-form-{{$ap->id}}" method="post" action="{{route('tickets.generate',$ap->id)}}" style="display:none;">
                {{csrf_field()}}
<input type="hidden" id="statusv" value="2" name="statusv"  /> 
<input type="hidden" id="payment_date" name="payment_date"  /> 
            </form>

<a class="btn btn-success float-right mr-3 btn-sm" href="javascript:void(0)" onclick="TicketModel('{{$ap->id}}')"><i class="fas fa-download"></i> Ticket</a>
<a class="btn btn-default float-right mr-3 btn-sm" target="_blank" href="{{route('logs.ticket.download',['apid'=>$ap->id])}}" ><i class="fas fa-eye"></i> Ticket Log</a>
                    @elseif(($voucher->status_main == 5) and ($ap->ticket_generated == '0') and ($ticketCount > '0') and ($ap->status == '3'))
						<form id="tickets-generate-form-{{$ap->id}}" method="post" action="{{route('tickets.generate',$ap->id)}}" style="display:none;">
                                {{csrf_field()}}
								<input type="hidden" id="statusv" value="2" name="statusv"  /> 
								<input type="hidden" id="payment_date" name="payment_date"  /> 
                            </form>
						
							<a class="btn btn-success float-right mr-3 btn-sm" href="javascript:void(0)" onclick="TicketModel('{{$ap->id}}')"><i class="fas fa-download"></i> Ticket</a>
							<a class="btn btn-default float-right mr-3 btn-sm" target="_blank" href="{{route('logs.ticket.download',['apid'=>$ap->id])}}" ><i class="fas fa-eye"></i> Ticket Log</a>
							
							@elseif($ap->ticket_generated == '1' && $ap->isRayna == '1' && $ap->status > 3 && $ap->status < 6)

							<a class="btn btn-success float-right  btn-sm  d-pdf" href="#" onclick='window.open("{{route('ticket.dwnload',$ap->id)}}");return false;'  ><i class="fas fa-download"></i> Ticket</a>
             
            <a class="btn btn-default float-right mr-3 btn-sm" target="_blank" href="{{route('logs.ticket.download',['apid'=>$ap->id])}}" ><i class="fas fa-eye"></i> Ticket Log</a>
							@elseif(($ap->ticket_generated == '1') and ($ap->status == '4'))
							<a class="btn btn-success float-right  btn-sm  d-pdf" href="#" onclick='window.open("{{route('ticket.dwnload',$ap->id)}}");return false;'  ><i class="fas fa-download"></i> Ticket</a>
							<a class="btn btn-default float-right mr-3 btn-sm" target="_blank" href="{{route('logs.ticket.download',['apid'=>$ap->id])}}" ><i class="fas fa-eye"></i> Ticket Log</a>
             
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
                @if($ap->time_slot != '')
                <div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-5 text-left">
                    <strong>Time Slot</strong>
                  </div>
                  <div class="col-md-7 text-right">
                   {{$ap->time_slot}}
                  </div>
                </div>
                @endif
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
				@if(($ap->transfer_option == 'Pvt Transfer') && ($ap->variant_pick_up_required == '1')  && ($ap->variant_pvt_TFRS == '1'))
					
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
                    <strong>Amount Incl. VAT</strong>
                  </div>
                  <div class="col-md-7 text-right">
                   AED {{$ap->totalprice}}
                  </div>
                </div>
                <div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-5 text-left">
                    <strong>Ticket Discount/Markup</strong>
                  </div>
                  <div class="col-md-7 text-right">
				  
                   AED {{($ap->discount_tkt>0)?$ap->discount_tkt*-1:$ap->discount_tkt*-1}}
                  </div>
                </div>
				<div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-5 text-left">
                    <strong>Transfer Discount / Markup</strong>
                  </div>
                  <div class="col-md-7 text-right">
                   AED {{($ap->discount_sic_pvt_price>0)?$ap->discount_sic_pvt_price*-1:$ap->discount_sic_pvt_price*-1}}
                  </div>
                </div>
                <div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-5 text-left">
                    <strong>Invoice Amt </strong>
                  </div>
                  <div class="col-md-7 text-right">
				  @php
				  $totalDiscount = (float)$ap->discount_tkt+ (float)$ap->discount_sic_pvt_price;
				  @endphp
                  AED {{$ap->totalprice - $totalDiscount}}
                  </div>
                </div>
				</div>
				 @if(($ap->transfer_option == 'Shared Transfer') || ($ap->transfer_option == 'Pvt Transfer'))
			   <div class="row" style="margin-bottom: 15px;">
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
                    <div class="col-8">
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
					
                    <div class="col-8">
					<label for="inputName">Remark:</label>
					{{$ap->remark}}
                    </div>
					
					
					@endif
					
                  </div>
				  @endif
				  @if($ap->status < '4' && $ap->transfer_option == 'Ticket Only')
				  <div class="row">
				  <div class="col-4">
					<label for="inputName">TKT Supplier:</label>
					<select name="supplier_ticket{{$ap->id}}" @if($ap->status == '4') disabled @endif id="supplier_ticket{{$ap->id}}" class="form-control inputsaveSp">
						<option data-name="supplier_ticket"  data-id="{{$ap->id}}" value="">All</option>
						@foreach($supplier_ticket as  $stv)
						
						<option data-name="supplier_ticket"  data-id="{{$ap->id}}" value = "{{$stv->id}}" @if($ap->supplier_ticket==$stv->id) selected="selected" @endif >{{$stv->company_name}}</option>
						@endforeach
                 </select>
                    </div>
					<div class="col-2">
					<label for="inputName">TKT Supplier Ref #:</label>
					<input type="text" class="form-control inputsave" @if($ap->status == '4') disabled @endif id="ticket_supp_ref_no{{$ap->id}}" data-name="ticket_supp_ref_no"  data-id="{{$ap->id}}" value="{{$ap->ticket_supp_ref_no}}" />
                    </div>
					<div class="col-2">
					<label for="inputName">TKT Net Cost:</label>
					<input type="text" class="form-control inputsave" @if($ap->status == '4') disabled @endif  id="actual_total_cost{{$ap->id}}" data-name="actual_total_cost"  data-id="{{$ap->id}}" value="{{$ap->actual_total_cost}}" />
           
                    </div>
					<div class="col-2">
					<label for="inputName">Status:</label>
					@if($ap->status == '4')
              Confirmed
            @else
					@php
					$actStatus = config('constants.voucherActivityStatus');
					@endphp
					<select name="status{{$ap->id}}" id="status{{$ap->id}}" class="form-control inputsaveSp">
						@foreach($actStatus as $k => $status)
						@if($k > 2)
						<option data-name="status"  data-id="{{$ap->id}}" value = "{{$k}}" @if($ap->status==$k) selected="selected" @endif >{{$status}}</option>
						@endif
						@endforeach
						</select>
            @endif
			  
                    </div>
					<div class="col-1 offset-md-1">
					<label for="inputName">Ticket:</label></br>
					@if($ap->ticket_generated=='1')
					 <a class="btn btn-info btn-sm uploadTicketbtn" href="javascript:void(0)" data-vaid="{{$ap->id}}" data-vid="{{$ap->voucher_id}}" ><i class="fas fa-upload"></i></a>
					@endif
                    </div>
					 </div>
					 @endif
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
@php
					$totalGrand += $ap->totalprice; 
					$totalGrandDiscount += $totalDiscount; 
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
                                              
  @if($vh->status == '1')
 <span class='badge bg-danger' style='margin-left: 5px;'>Cancellation Requested</span>
  @elseif($vh->status == '2')
  <span class='badge bg-danger' style='margin-left: 5px;'>Cancelled</span> 
  
     @endif 
     </span> 
                    </div>
                    <div class="col-md-4 text-right ">
        @if($vh->status > 2)
		
						
						<form id="cancel--hotel-form-{{$vh->id}}" method="post" action="{{route('voucher.hotel.cancel',$vh->id)}}" style="display:none;">
						{{csrf_field()}}
						</form>
						
							<a class="btn btn-primary  float-right btn-sm ml-2" data-variantcode="{{$vh->id}}" data-apid="{{$vh->id}}" href="javascript:void(0)"  onclick="HotelCancelModel('{{$vh->id}}')" ><i class="fas fa-times"></i> Cancel </a>
            @endif  
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
			<div class="row" style="margin-bottom: 15px;">
                      <div class="col-6">
                        <label for="inputName">Confirmation Number:</label>
					{{$vh->confirmation_number}}

                       
                      </div>
                     <div class="col-12">
                        <label for="inputName">Remark:</label>
					{{$vh->remark}}

                       
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


            
            <!-- /.startteldiv-->
          
         
          

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
                   AED {{$totalGrand - $totalGrandDiscount}}
                  </div>
                </div>
				 <div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-6 text-left">
                    <strong>Discount</strong>
                  </div>
                  <div class="col-md-6 text-right">
                   AED {{$totalGrandDiscount}}
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
                    <h5>Final Amount</h5>
                  </div>
                  <div class="col-md-6 text-right">
                   <h5>AED {{$totalGrand - $totalGrandDiscount}}</h5>
                  </div>
                </div>
				
              </div>
			  
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
			
            @if(count($childVoucher) > 0)
             
            
             <div class="card card-default">
               <div class="card-header">
               <h3 class="card-title">
                       <strong> Child Vouchers</strong></h3>
     
         
               </div>
               <div class="card-body">
         
         <div class="">
          
                 <div class="row" style="margin-bottom: 5px;">
                     <div class="col-md-12 text-left">
                       <table class="table table-condensed table-bordered">
                               <tr>
                                   <th>Voucher Code</th>
                                   <th>Created On</th>
                                   <th>Booked Code</th>
                                   <th>Invoice No</th>
                                   <th>Total Amount</th>
                               </tr>
                     @foreach($childVoucher as $vc)
                     <tr>
                                   <td>  <a class="btn btn-info btn-sm" target="_blank" href="{{route('voucherView',$vc->id)}}">
                                   {{$vc->code}}
                              
                          </a></td>
                                   <td> {{$vc->created_at}}</td>
                                   <td> {{$vc->booking_date}}</td>
                                   <td>
                                   @if($vc->status_main >= 4)
					 <a class="btn btn-secondary btn-sm" href="{{route('voucherInvoicePdf',$vc->id)}}" >
           {{$vc->invoice_number}}
                          </a>
						  @endif 
                                  </th>
                                   <td>{{  SiteHelpers::getVoucherTotalPriceNew($vc->id);}}</th>
                               </tr>
                     @endforeach
                             </table>
                     </div>
                   
                      
                  
                 </div>
                 
         </div>
 
               </div>
               <!-- /.card-body -->
             </div>
             <!-- /.card -->

       
                  @endif
          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
  
    <!-- /.content -->
	
    <div class="modal fade" id="HotelCancellation" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cancel Hotel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="mbody">
          To You Want to Cancel the Booking         </div>
            <div class="modal-footer">
			 
                <button type="button" class="btn btn-secondary close" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-danger" onclick="HotelCancelModelAPI()">Yes</button>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="hapid" value="0"  /> 
<div class="modal fade" id="DownloadTicketmodel" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Download Ticket</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="mbody">
            Once the Tickets are downloaded it’s Non Refundable.<br/>

Do you want proceed with the Download ?             </div>
            <div class="modal-footer">
			 
                <button type="button" class="btn btn-secondary close" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-danger" onclick="downloadTicket()">Yes</button>
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
				 <div >Remark : <input type="text" id="cancel_remark" name="cancel_remark" class="form-control cancel_remark" /></div>
            </div>
           <div class="modal-footer d-flex justify-content-between">
			<button type="button" class="btn btn-sm btn-primary-flip btn-sm" id="selectCancelBtn"><i class="fa fa-tick"></i> Yes</button>
			<button type="button" class="btn btn-sm btn-secondary close1" data-dismiss="modal">No</button>
		</div>

        </div>
    </div>
</div>
<div class="modal fade" id="ticketUploadModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	 <form id="ticketUploadForm" method="post" action="{{route('uploadTicketFromReport')}}" enctype="multipart/form-data">
	 @csrf
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Ticket Upload</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="file"  class="form-control" name="ticketFile" accept=".pdf" />
		 <input type="hidden"  id="vaid" name="vaid"   value="" />
	  <input type="hidden"  id="vid" name="vid"   value="" />
      </div>
	  
	 
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Upload</button>
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
  const loaderOverlay = $("body #loader-overlay");
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
 
 
$(document).on('change', '.inputsaveSp', function(evt) {
		$("#loader-overlay").show();
		var id = $(this).find(':selected').data('id');
		var inputname = $(this).find(':selected').data('name');
    var spInput = $(this).attr('id');
		//alert(inputname);
    if((spInput == 'status'+id) && ($(this).val() =='4')){
			 var cost = parseFloat($('#actual_total_cost' + id).val());
			var cost = $('#actual_total_cost' + id).val().trim(); // Get and trim the input value

					if (cost === '' || isNaN(parseFloat(cost)) || parseFloat(cost) <= 0) {
						alert("Please enter a valid Ticket Net Cost greater than or equal to 0");
						$('#' + spInput).val('3');  // Reset the value to an empty string or a default value
						$("#loader-overlay").hide();
						return false;
					}
		}
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
			   val: $(this).val(),
			   type: "Report",
			   report_type: "Ticket Only"
            },
            success: function( data ) {
            if(inputname == 'supplier_ticket')
            {
              
              $("#actual_total_cost"+id).val(data[0].cost);
              $("#supplier_email"+id).val(data[0].email);
              $("#adult_cost"+id).val(data[0].adult);
              $("#child_cost"+id).val(data[0].child);
            }
			        $("#loader-overlay").hide();
            }
          });
	 });
$(document).on('change', '.inputsave', function(evt) {
		$("#loader-overlay").show();
    var id= $(this).data('id');
    var txt_name =  $(this).data('name');
    var txt_var =  $(this).val();
    if(txt_name == 'internal_remark')
    {
      txt_var =  $("body #remark_old"+id).val()+"<br/>"+txt_var;
    }
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
        val: txt_var,
				type: "Report",
				report_type: "Ticket Only"
            },
            success: function( data ) {
               //console.log( data );
			  $("#loader-overlay").hide();
            }
          });
	 });

 $(".uploadTicketbtn").click(function () {
            $("#ticketUploadModal").modal("show");
			var vid= $(this).data('vid');
			var vaid= $(this).data('vaid');
			$("#vaid").val(vaid);
			$("#vid").val(vid);
        });	 
	 
 });
function openModal(cancel,formid) {
  const loaderOverlay = $("body #loader-overlay");
        $('#cancelModal').modal('show');
        $('#selectCancelBtn').on('click', function() {
			console.log($("body #cancel_remark").val());
      loaderOverlay.show();
			$("body #cancel_remark_data-"+formid).val($("body #cancel_remark").val());
			$("body #cancel-form-"+formid).submit();
        });
		
        $('#cancelModal .close,.close1').on('click', function() {
			$('body .cancel_remark').each(function() {
			$(this).val('');  
			});
            $('#cancelModal').modal('hide');
			 
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
    }

function HotelCancelModel(id) 
{
  $('#HotelCancellation').modal('show');
  $('#hapid').val(id);
}
function HotelCancelModelAPI() 
{
var id = $('#hapid').val();
 event.preventDefault();
 document.getElementById('cancel--hotel-form-'+id).submit();
}


</script>
@endsection
