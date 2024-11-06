@extends('emails.layout')
@section('message')

<div style="width: 100%;margin: 20px 0px;padding: 0px 20px">
		<p>
			<strong>Dear Travel Partner,</strong>
		</p>
		<p>Greetings from Abaterab2b!</p>
 <p>Booking Confirmation Details</p>
 <!-- Content Header (Page header) -->
   
    <!-- /.content-header -->

    <style type="text/css">
    /* Multistep */
/* See below for SASS (allows you easily set dot radius and progress bar thickness and adjusts everything else! */
.multistep .multistep-step {
    padding: 0;
    position: relative;
    margin-bottom: 10px;
}

    .multistep .multistep-step .multistep-stepname {
        margin-bottom: 16px;
        color: #595959;
        font-size: 1.6rem;
        white-space: nowrap;
    }

    .multistep .multistep-step .multistep-dot {
        position: absolute;
        right: 50%;
        left: 50%;
        width: 32px;
        height: 32px;
        display: block;
        margin-top: -16px;
        margin-left: -15.5px;
        border-radius: 50%;
        background: #f5f5f5;
        /* Inner Dot */
    }

        .multistep .multistep-step .multistep-dot:after {
            content: ' ';
            border-radius: 50px;
            position: absolute;
            top: 8px;
            bottom: 8px;
            left: 8px;
            right: 8px;
            background: #e0e0e0;
        }

    .multistep .multistep-step .progress {
        position: absolute;
        width: 100%;
        height: 10.56px;
        margin-top: -5.28px;
        box-shadow: none;
        border-radius: 0;
    }

        .multistep .multistep-step .progress .progress-bar {
            width: 0px;
            box-shadow: none;
            background: #808080;
        }

    .multistep .multistep-step:first-child > .progress {
        left: 50%;
        width: 50%;
    }

    .multistep .multistep-step:last-child > .progress {
        width: 50%;
    }

    .multistep .multistep-step.complete .multistep-dot {
        background: #808080;
    }

        .multistep .multistep-step.complete .multistep-dot:after {
            /*  /* background: #fbbd19; */ */
        }

    .multistep .multistep-step.complete .progress > .progress-bar {
        width: 100%;
    }

    .multistep .multistep-step.next:hover .multistep-dot {
        background: #808080;
    }

        .multistep .multistep-step.next:hover .multistep-dot:after {
             /* background: #fbbd19; */
        }

    .multistep .multistep-step.current .multistep-dot {
        background: #808080;
    }

        .multistep .multistep-step.current .multistep-dot:after {
             /* background: #fbbd19; */
        }

    .multistep .multistep-step.current .progress > .progress-bar {
        width: 50%;
    }

    .multistep .multistep-step.current:first-child > .progress > .progress-bar {
        width: 0%;
    }

    .multistep .multistep-step.current:last-child > .progress > .progress-bar {
        width: 100%;
    }

    .multistep .multistep-step a.multistep-dot {
        pointer-events: none;
    }

    .multistep .multistep-step.next a.multistep-dot {
        pointer-events: all;
    }
    
    
/* SASS
$inactiveColor: #f5f5f5;
$inactiveDotColor: #e0e0e0;
$activeColor: #808080;
$activeDotColor: #fbbd19;
$stepNameColor: #595959;
$dotRadius: 16px;
$barThickness: $dotRadius * .66;
$stepNameSize: 1.6rem;

.multistep {
    .multistep-step {
        padding: 0;
        position: relative;
        margin-bottom: 10px;

        .multistep-stepname {
            margin-bottom: $dotRadius;
            color: $stepNameColor;
            font-size: $stepNameSize;
            white-space: nowrap;
        }

        .multistep-dot {
            position: absolute;
            right: 50%;
            left: 50%;
            width: $dotRadius * 2;
            height: $dotRadius * 2;
            display: block;
            margin-top: -$dotRadius;
            margin-left: -$dotRadius + .5;
            border-radius: 50%;
            background: $inactiveColor;
            &:after {
                content: ' ';
                border-radius: 50px;
                position: absolute;
                top: $dotRadius / 2;
                bottom: $dotRadius / 2;
                left: $dotRadius / 2;
                right: $dotRadius / 2;
                background: $inactiveDotColor;
            }
        }

        .progress {
            position: absolute;
            width: 100%;
            height: $barThickness;
            margin-top: -$barThickness / 2;
            box-shadow: none;
            border-radius: 0;

            .progress-bar {
                width: 0px;
                box-shadow: none;
                background: $activeColor;
            }
        }

        &:first-child > .progress {
            left: 50%;
            width: 50%;
        }

        &:last-child > .progress {
            width: 50%;
        }

        &.complete {
            .multistep-dot {
                background: $activeColor;

                &:after {
                    background: $activeDotColor;
                }
            }

            .progress > .progress-bar {
                width: 100%;
            }
        }

        &.next:hover {
            .multistep-dot {
                background: $activeColor;
            }

            .multistep-dot:after {
                background: $activeDotColor;
            }
        }

        &.current {
            .multistep-dot {
                background: $activeColor;

                &:after {
                    background: $activeDotColor;
                }
            }

            .progress > .progress-bar {
                width: 50%;
            }

            &:first-child > .progress > .progress-bar {
                width: 0%;
            }

            &:last-child > .progress > .progress-bar {
                width: 100%;
            }
        }

        a.multistep-dot {
            pointer-events: none;
        }

        &.next a.multistep-dot {
            pointer-events: all;
        }
    }
}
*/    </style>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
     

        <div class="row" style="margin-top: 30px;">
       
		
          <!-- left column -->
          <div class="offset-md-2 col-md-8">
		   
            <!-- general form elements -->
            <div class="card card-default">
              <div class="card-header">
                 <h3 class="card-title"><i class="nav-icon fas fa-user" style="color:black"></i> Passenger Details</h3>
				
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
            @if(!empty($voucherActivity) )
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
                <h3 class="card-title"><i class="nav-icon fas fa-book" style="color:black"></i> Additional Information Activity</h3>
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

               
            </div>
            @endif

            @if(!empty($voucherHotel) && $voucher->is_hotel == 1)
        @if($voucherHotel->count() > 0)
              <div class="card card-default ">
                <div class="card-header">
                  <h3 class="card-title"><i class="nav-icon fas fa-book" style="color:black"></i> Additional Information Hotel</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
              
                  <div class="card-body">
            
              @foreach($voucherHotel as $vah)
           
                    <div class="row" style="margin-bottom: 15px;">
                      <div class="col-12"><p>{{$vah->hotel->name}} - {{$vah->hotel->hotelcategory->name}}</p></div>
                      <div class="col-4">
                        <label for="inputName">Confirmation Number:</label>
					{{$vah->confirmation_number}}

                       
                      </div>
                     <div class="col-8">
                        <label for="inputName">Remark:</label>
					{{$vah->remark}}

                       
                      </div>
                    </div>
            
            @endforeach
                 
            
                  </div>
         
                  <!-- /.card-body -->
  
                 
              </div>
			    @endif
              @endif

       
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
					  @foreach($voucherActivity as $ka => $ap)
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
                      <strong> Activity {{$ka+1}}: {{$activity->title}}</strong></h3>
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
            <!-- /.startteldiv-->
            @if(!empty($voucherHotel) && $voucher->is_hotel == 1)
            @if(!empty($voucherHotel))
              @foreach($voucherHotel as $kh => $vh)
              @php
              $room = SiteHelpers::hotelRoomsDetails($vh->hotel_other_details)
              @endphp
              <div class="card card-default">
                <div class="card-header">
                  <div class="row">
          <div class="col-md-8 text-left">
                      <h3 class="card-title">
                        <strong>Hotel {{$kh+1}}: {{$vh->hotel->name}}</strong></h3>
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
                  </div>
                </div>
             
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

<p><strong>Thanks </strong></p><p><strong></br>Team Abatera B2B </strong></p>
	</div>
@endsection
