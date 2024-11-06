<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Itinerary</title>
  
  <!-- <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet"> -->
  <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  <style>
	body
	{
		/* background: url("{{asset('images/itinerary_bg.png')}}") repeat left top; */
		margin:	0 auto; 
		font-family: 'Rubik', Helvetica, Arial, sans-serif; 
		font-weight:normal;
		font-size: 14px;
	}
	.outter-div
	{
		width: 800px;
		margin: 0 auto;  
		padding: 5px 10px 5px 10px; 
		clear:both;
	}
	.inner-div
	{
		width:100%; 
		padding: 0px 0px 0px 0px;
		margin-bottom:20px;
		clear:both;
	}
	.col-1
	{
		width: 8.33%!important;
	}
	.col-2
	{
		width: 16.6%!important;
	}
	.col-3
	{
		width: 25%!important;
	}
	.col-4
	{
		width: 33.33%!important;
	}
	.col-5
	{
		width: 41.66%!important;
	}
	.col-6
	{
		width: 50%!important;
	}
	.col-7
	{
		width: 58.33%!important;
	}
	.col-8
	{
		width: 66.66%!important;
	}
	.col-9
	{
		width: 75%!important;
	}
	.col-11
	{
		width: 91.66%!important;
	}
	.col-12
	{
		width: 100%!important;
	}
	
	.float-left
	{
		float: left!important;
	}
	.float-right
	{
		float: right!important;
	}
	.text-right
	{
		text-align: right!important;
	}
	.hotel-outter-div
	{
		background: #dcedf7; 
		border-radius: 15px; 
		 margin-bottom: 20px;
		 padding: 10px;
	}
	.hd-outter-div
	{
		background: #dcedf7; 
		border-radius: 10px; 
		 margin-bottom: 5px;
		 font-size: 20px; 
		 width: 100%;
		
	}
	.activity-outter-div
	{
		width:100%;
		background: #F5F5F5; 
		border-radius: 15px; 
		 margin-bottom: 20px;
	}
	.activity-outter-div p
	{
		padding: 0px 10px;
	}
	.activity-innter-div
	{
		background:#dcedf7; 
		border-radius: 10px; 
		width:100%;
	}
	.activity-innter-div p
	{
		padding-left: 0px;
	}
	.font-bold
	{
		/* font-weight: 300; */
	}
	.no-margin
	{
		margin: 0px;
	}
	.inclusion-div ul {
  list-style: none;
  padding-left: 10px;
}
.inclusion-div ul li {
	background: url("{{asset('images/checkmark-16.png')}}") no-repeat left center;
  min-height: 20px;
  padding-top: 0px;
  padding-left: 20px;
  margin-bottom: 5px;
  text-align: justify;
  color: #808080 !important;
  
}

.tnc-div ul {
  list-style: none;
  padding-left: 10px;
}
/* .tnc-div ul li {
	background: url("{{asset('images/tnc-16.png')}}") no-repeat left center;
  min-height: 20px;
  padding-top: 0px;
  padding-left: 20px;
  margin-bottom: 5px;
  text-align: justify;
  color: #808080 !important;
  
} */
.tnc-div  ul li:before {
  content: '✓';
  font-weight: bold;
  color: green;
  padding-right: 10px;
  font-size: 16pt;
  color: #808080 !important;
}
.tnc-div  ul li {
	color: #808080 !important;
}
.bg-calender {
	background: url("{{asset('images/calender-32.png')}}") no-repeat left center;
  min-height: 32px;
  padding-top: 0px;

}
.bg-calender-end {
	background: url("{{asset('images/calender-32.png')}}") no-repeat right center;
  min-height: 32px;
  padding-top: 0px;

}

.text-grey
{
	color: #808080 !important;
}
.text-black
{
	color: #000000 !important;
}
.mb-20
{
	margin-bottom: 20px;
}
.agent-logo
{
	max-width: 120px;
	max-height: 100px;
	width: auto;
	height: auto;
}
.mt-10
{
	margin-top: 10px;
}
.mt-5
{
	margin-top: 5px;
}
.mt-40
{
	margin-top: 40px!important;
}
.ml-20
{
	margin-left: 20px;
}
.ml-30
{
	margin-left: 30px;
}
.pl-30
{
	padding-left: 30px;
}
.pl-40
{
	padding-left: 40px;
}
.ml-40
{
	margin-left: 40px;
}
.pl-40
{
	padding-left: 40px;
}
.mr-10
{
	margin-right: 10px;
}
.pr-30
{
	padding-right: 30px;
}
.pr-40
{
	padding-right: 40px;
}
.clear
{
	clear:both;
}
.hotel-image
{
	border-radius: 10px;
	max-width: 180px;
	width: auto;
	max-height: 180px;
	 height: auto;
}
.p-10
{
	padding: 10px;
}
.p-15
{
	padding: 15px; 
}
.p-20
{
	padding: 20px;
}
.pt-40
{
	padding-top: 40px;
}
.text-center
{
	text-align:center;
}
.text-right
{
	text-algin: right;
}
div.footer {
      display: block;
      text-align: center;
      position: running(footer);
    }
@page {
        @bottom-center {
            content: element(footer);
        }
    }

</style>
</head>
<!-- font-family: 'Poppins', sans-serif; -->
<body >
@php
			
			$total_activites = count($voucherActivity);
		@endphp
	<div class="outter-div">
		@if($total_activites > 0)
		<div class="inner-div mb-20" >
			<div class="col-6 float-left text-left" >
				@if(file_exists(public_path('uploads/users/thumb/'.$voucher->agent->image)) && !empty($voucher->agent->image))
					<img src="{{asset('uploads/users/thumb/'.$voucher->agent->image)}}" class="agent-logo">
				@else
				{{-- Code to show a placeholder or alternate image --}}
					<img src="{{asset('Abatera_logo.jpg')}}" class="agent-logo">
				@endif
			</div>
			<div class="col-6 float-right text-right">
				<span class="pt-40">
				<p class="no-margin mt-40"><i class="fa fa-headset mr-10" aria-hidden="true"></i> {{$voucher->agent->mobile}}</p>
				<p class="no-margin" style=""><i class="fas fa-envelope mr-10" ></i> {{$voucher->agent->email}}</p>
				</span>
			</div>
			<div class="clear"></div>
		</div>
		<div class="inner-div">
		<p class="col-12 mt-20 mb-20" style="text-align:center;font-size: 28px"><span class="text-grey">Voucher No.</span> : {{$voucher->code}}</p>
		</div>
		<div class="col-12 mb-20">
			<img src="{{asset('images/2.jpg')}}" style="width: 100%;border-radius: 30px;">
		</div>
		
		<div class="inner-div mb-20">
			
			<div class="col-4 float-left bg-calender " style="">
				<div class="pl-40"> {{date("d-m-Y",strtotime($voucher->travel_from_date))}}
					<br/><span class="text-grey">Start Date </span>
				</div>
				
				
			</div>
			<div class="col-4 float-left text-center">
				@php
				$no_of_days = $no_of_nights =  0;
					$no_of_days = SiteHelpers::dateDiffInDays($voucher->travel_from_date,$voucher->travel_to_date)
					
				@endphp
				<p style=" text-center"> 
				@if(($no_of_days-1) > 0) <i class="fa fa-moon " aria-hidden="true"></i>  {{$no_of_days-1}} Nights @endif <i class="fa fa-sun ml-10" aria-hidden="true"></i> {{$no_of_days}} Days
				</p>
			</div>
			
			<div class="col-4 float-right text-right bg-calender-end">
			<div class="pr-40"> {{date("d-m-Y",strtotime($voucher->travel_to_date))}}
				<br/><span class="text-grey">End Date </span>
			</div>
			</div>
		</div>
		<div class="inner-div inclusion-div mt-40" style="padding-top: 20px;">
				<span class="font-bold mt-40" style="">Inclusions</span>
			<ul style="">
				@if(!empty($voucherActivity))
					@foreach($voucherActivity as $k => $ap1)
						<li style="">{{$ap1->variant_name}}</li>
					@endforeach
					@endif
				@if($voucher->is_flight =='1')
				<li style="">Meet & greet at arrival</li>
				@endif
			</ul>
		</div>
		<div style = "display:block; clear:both; page-break-after:always;"></div>
		@endif
		<!-- <div class="width:95%; padding: 10px 0px;margin-bottom:20px;clear:both;">
			<div style="background: #2300c1; border-radius: 30px; border: dashed 3px #f1f1f1; display: block; align-items: center;clear:both;max-height:170px;height:auto;min-height: 130px;">
				<div style="width:60%;float:left;background: #CFC7F1;border-radius: 30px;border: dashed 3px #f1f1f1;padding:20px;margin-top:-3px; margin-bottom: -3px; margin-left: -3px;min-height: 130px;max-height:170px;height:auto;display: block;">
					<h6 style="margin:0  0 15px 0 !important; font-weight: 700;font-size: 18px">Adult : AED {{$dataArray['adultP']}} X {{$dataArray['adult']}}</h6>
					@if($dataArray['child'] > 0)
      				<h6 style="margin:0  0 15px 0 !important; font-weight: 700;font-size: 18px">Child : AED {{$dataArray['childP']}} X {{$dataArray['child']}} </h6>
					@endif
      				@if($dataArray['infant'] > 0)
      				<h6 style="margin:0  0 15px 0 !important; font-weight: 700;font-size: 18px">Infant : AED {{$dataArray['infantP']}}</h6>
					@endif
      				<p style="font-size: 13px;margin-bottom: 0">Note: All above prices are subject to change without prior notice as per availability, the final date of travel and any changes in taxes.</p>
				</div>
				<div style="width:30%;float:right;text-align: center;">
					<h4 style="color: #fff;font-size: 32px;font-weight: 600; margin-bottom: 5px">AED {{$dataArray['totalPrice']}}</h4>
      				<h6 style="font-size: 22px;color: #fff;margin-top: 0;">Total</h6>
				</div>
				<div style="width:100%;clear:both;"></div>
			</div>
		</div> -->
	
	
	<!-- Hotel Block End -->
	@if(count($voucherHotel) > 0)
	<!-- Hotel Block Start -->
	
	
		
		
		@php
			$sno = 0;
			$thotel = count($voucherHotel);
		@endphp
			@foreach($voucherHotel as $vh)
				@php
					$sno++;
				@endphp
				
	<div class="inner-div mb-20" >
			<div class="col-6 float-left text-left" >
				@if(file_exists(public_path('uploads/users/thumb/'.$voucher->agent->image)) && !empty($voucher->agent->image))
					<img src="{{asset('uploads/users/thumb/'.$voucher->agent->image)}}" class="agent-logo">
				@else
				{{-- Code to show a placeholder or alternate image --}}
					<img src="{{asset('Abatera_logo.jpg')}}" class="agent-logo">
				@endif
			</div>
			<div class="col-6 float-right text-right">
				<span class="pt-40">
				<p class="no-margin mt-40"><i class="fa fa-headset mr-10" aria-hidden="true"></i> {{$voucher->agent->mobile}}</p>
				<p class="no-margin" style=""><i class="fas fa-envelope mr-10" ></i> {{$voucher->agent->email}}</p>
				</span>
			</div>
			@if($total_activites == 0)
				<div class="col-12 float-right text-right">
					<div class="inner-div">
						<p class="col-12 mt-20 mb-20" style="text-align:center;font-size: 28px"><span class="text-grey">Voucher No.</span> : {{$voucher->code}}</p>
					</div>
				</div>
			@endif
			<div class="clear"></div>
		</div>
			
      		<div class="hotel-outter-div">
      			<div class="col-3 float-left" >
					@if(file_exists(public_path('uploads/hotels/'.$vh->hotel->image))  && !empty($vh->hotel->image))
					<img src="{{asset('uploads/hotels/'.$vh->hotel->image)}}" alt=""  class="hotel-image">
					@else
					{{-- Code to show a placeholder or alternate image --}}
					<img src="{{ asset('uploads/hotels/thumb/no-image.png') }}" class="hotel-image" alt="no-image">
					@endif
      			</div>
      			<div class="col-9 float-right" >
      				
      					<p class="col-12 no-margin" style="font-size: 24px">
							{{$vh->hotel->name}}
							<span style="padding-left: 10px;">
							@for($i=1;$i<=$vh->hotel->hotelcategory->name;$i++)
								<img src="{{asset('images/star-24.png')}}">
							@endfor
							</span>
						</p> 
					<p class="col-12 no-margin mt-10">
					  <i class="fas fa-map-marker-alt"></i> 
						 {{$vh->hotel->address}},{{($vh->hotel->city)?$vh->hotel->city->name:''}},{{($vh->hotel->country)?$vh->hotel->country->name:''}}
      				
					</p>
      				<div class="col-12 mt-10" >
      					<span class="col-6 float-left">
      						<span ><span class="text-grey">Check in :</span></span>
      						<p class="no-margin mt-5">{{date("d M- Y",strtotime($vh->check_in_date))}}</p>
							 
      					</span>
      					<span class="col-6 float-right">
      						<span ><span class="text-grey">Check out :</span></span>
      						<p class="no-margin mt-5">{{date("d M- Y",strtotime($vh->check_out_date))}}</p>
							  
						</span>	
      				</div>
					  <div class="col-12 mt-10" >
      					<span class="col-12 float-left">
						 	 <p  class="no-margin mt-10" ><span class="text-grey">Guest Name </span>: {{$voucher->guest_name}}</p>
							 
      					</span>
      					
								
      				</div>
					  <div class="col-12 mt-10" >
      					<span class="col-6 float-left">
      						  <div class="col-12">
								@php
								$room = SiteHelpers::hotelRoomsDetails($vh->hotel_other_details)
	
								
								@endphp
								
								<p  class="no-margin mt-10" ><span class="text-grey">Room Type </span>: {{$room['room_type']}}</p>
							
								<p class="no-margin mt-10" ><span class="text-grey">Number of Rooms </span>: {{$room['number_of_rooms']}}</p>
									
									
									
								</div>
      					</span>
      					<span class="col-6 float-right">
      						  <div class="col-12">
							  		<p  class="no-margin mt-10" ><span class="text-grey">Meal Plan </span>: {{$room['mealplan']}}</p>
									<p class="no-margin mt-10" ><span class="text-grey">Number of Adult(s) </span>: {{$room['occupancy']}}</p>
									@if($room['childs'] > 0)
									<p class="no-margin mt-10" ><span class="text-grey">Number of Child(s) </span>: {{$room['childs']}}</p>
									@endif
								</div>
      					</span>
						  @if($vh->confirmation_number != '')
						  <div style="clear:both;"></div>
						  	<span class="col-12">
						  		<p class="no-margin mt-10"><span class="text-grey">Hotel Confirmation No.</span> : {{$vh->confirmation_number}}</p>
      						</span>
						  @endif
						  @if($vh->remark != '')
						  <div style="clear:both;"></div>
						  	<span class="col-12">
						  		<p class="no-margin mt-10"><span class="text-grey">Remark.</span> : {{$vh->remark}}</p>
      						</span>
						  @endif
									
								
      				</div>
      				
      			</div>
				<div style="clear:both;"></div>
			
      		</div>
			  <div class="inner-div ">
				<div class="hd-outter-div">
					<!-- <img src="{{asset('images/2.jpg')}}" style="max-width: 40px" /> -->
					<p class="font-bold p-10" >Check-in/Check-out Policy</p>
				</div>
				<ul style="padding-left: 20px; margin-bottom: 30px;text-align: justify" class="text-grey">
					<li>The usual check-in time is 2:00 PM and checkout time is at 12:00 hours however this might vary from hotel to hotel and with different destinations.</li>
					<li>Early Check in and Late Check out is not guaranteed and additional charges may be applicable. However, luggage may be deposited at the hotel reception.</li>
					<li>Note that reservation may be canceled automatically after 18:00 hours if hotel is not informed about the approximate time of late arrivals.</li>
					<li>For any specific queries related to a particular hotel, kindly reach out to local support team for further assistance.</li>
				</ul>
				<div class="hd-outter-div">
					<!-- <img src="{{asset('images/2.jpg')}}" style="max-width: 40px" /> -->
					<p class="font-bold p-10">Booking Notes</p>
				</div>
				<div>
					<!-- <img src="{{asset('images/2.jpg')}}" style="max-width: 40px" /> -->
					<p style="text-align: justify" class="text-grey">Booking payable as per reservation details.Please collect all extras directly from clients prior to departure.All vouchers issued are on the condition that all arrangements operated by person or bodies are made as agents only and that they shall not be responsible for any damage, loss, injury, delay or inconvenience caused to passengers as a result of any such arrangements. We will not accept any responsibility for additional expenses due to the changes or delays in air, road, rail, sea or indeed any other causes, all such expenses will have to be borne by passengers.</p>
				</div>
			</div>
			<div style = "display:block; clear:both; page-break-after:always;"></div>
			@endforeach
			
		
		
	
	
	<!-- Hotel Block End -->
	@endif	



	@if(count($voucherActivity) > 0)
	<div style = "display:block; clear:both; page-break-after:always;"></div>
	<!-- Activity Block Start -->
	
		<div class="inner-div mb-20" >
			<div class="col-6 float-left text-left" >
				@if(file_exists(public_path('uploads/users/thumb/'.$voucher->agent->image)) && !empty($voucher->agent->image))
					<img src="{{asset('uploads/users/thumb/'.$voucher->agent->image)}}" class="agent-logo">
				@else
				{{-- Code to show a placeholder or alternate image --}}
					<img src="{{asset('Abatera_logo.jpg')}}" class="agent-logo">
				@endif
			</div>
			<div class="col-6 float-right text-right">
				<span class="pt-40">
				<p class="no-margin mt-40" style="margin-top: 40px;"><i class="fa fa-headset mr-10" aria-hidden="true"></i> {{$voucher->agent->mobile}}</p>
				<p class="no-margin" style=""><i class="fas fa-envelope mr-10" ></i> {{$voucher->agent->email}}</p>
				</span>
			</div>
			<div class="clear"></div>
		</div>
			
		
		
		@php
			$old_day_no = 0;
			$tr_dt = "";
			$day_no = 0;
			$avt_no = 0;
			$sno = 0;
			$tact = count($voucherActivity);
			$shared = $private = $arrival = 0;
		@endphp
		@foreach($voucherActivity as $k => $ap)
		@php
					$activity = SiteHelpers::getActivity($ap->activity_id);
					$variant = SiteHelpers::getVariant($ap->variant_code);
					$pickup_time = SiteHelpers::getPickupTimeByZone($ap->variant_zones,$ap->transfer_zone);
					if($tr_dt != $ap->tour_date)
					{
						$avt_no = 0;
						$day_no++;
					}
					$sno++;
					$avt_no++;
					
					
					@endphp

      		<div class="activity-outter-div">
			
			  	<div class=" col-12 font-bold no-margin p-10">
				  <img src="{{asset('images/time-span-50.png')}}" style="float:left;margin-right: 10px;margin-top: 2px; width: 32px; height: 32px;"/>
						<div class="col-5 float-left" style="padding-top: 7px;">Day {{$day_no}} :  {{date("d M Y l",strtotime($ap->tour_date))}} </div>
						<div class="col-5 float-right"  style="padding-top: 7px;">
							@if(($ap->transfer_option == 'Shared Transfer') && ($pickup_time != ''))
							 <span class="text-grey">Pickup Timing</span> : {{$pickup_time}} * 
							@endif
							@if(($ap->transfer_option == 'Pvt Transfer'))
								@if($ap->actual_pickup_time != '')
								<span class="text-grey">Pickup Timing</span> : {{$ap->actual_pickup_time}}*
								@elseif($ap->variant__pvt_TFRS_text != '')
								<span class="text-grey">Pickup Timing</span> : {{$ap->variant_pvt_TFRS_text}}*
								@endif
							@endif
						</div>
				</div>
				<div class="clear"></div>
				<div class="activity-innter-div mt-10 ">
	      			<div class="col-3 float-left p-15" >
						@if(file_exists(public_path('uploads/activities/'.$activity->image)) && !empty($activity->image))
						<img src="{{asset('uploads/activities/'.$activity->image)}}" alt="" class="hotel-image">
						@else
						{{-- Code to show a placeholder or alternate image --}}
						<img src="{{ asset('uploads/activities/thumb/no-image.png') }}" alt="" class="hotel-image"  alt="no-image">
						@endif
	      			</div>
	      			<div class="col-8 float-left p-15">
						<div class="col-12 mo-margin" style="font-size: 14px; ">{{$ap->activity_title}}</div>
						<div  class="col-12 mo-margin"" style="font-size: 14px; "><span  class="text-grey">Tour Option</span> : {{$ap->variant_name}}</div>
						<div  class="col-12 mo-margin text-grey" style="height: 67px;overflow:hidden;text-align:justify!important;"> {!!$activity->description!!}</div>...
						<div class="clear"></div>
	      			</div>
					<div class="clear"></div>
	      		</div>
	      		<div class="col-12 mt-10">
	      			<span class="col-5 float-left"style="padding: 15px 0px 15px 15px;">
					  	<p class="no-margin"><span  class="text-grey">Transfer Type </span>: @if(($ap->transfer_option == 'Pvt Transfer')) Private Transfer @else {{$ap->transfer_option}} @endif</p>	
					 	 <p class="no-margin">
							@if(($ap->activity_entry_type == 'Yacht') || ($ap->activity_entry_type == 'Limo'))
							<span class="text-grey">Hour(s)</span> : {{$ap->adult}} 
							@else
							<span class="text-grey">Adult</span> : {{$ap->adult}} 
							@if($ap->child > 0) | <span  class="text-grey">Child</span> : {{$ap->child}} @endif 
							@if($ap->infant > 0) | <span  class="text-grey">Infant</span> :  {{$ap->infant}} @endif
							@endif
						</p>
			  		</span>
					  <span class="col-5 float-right" style="padding: 15px 15px 15px 15px;">
						
						@if($ap->flight_no != '')
			  				<p class="no-margin">
								<span  class="text-grey">Flight Details</span> : {{$ap->flight_no}}
							</p>
						@endif
						@if($ap->passenger_name != '')
			  				<p class="no-margin"><span  class="text-grey">Passenger Name</span> : {{$ap->passenger_name}}</p>
						@endif
						@if($ap->pickup_location != '')
			  				<p class="no-margin"><span  class="text-grey">Pickup Location</span> : {{$ap->pickup_location}}</p>
						@endif
						@if($ap->dropoff_location != '')
			  				<p class="no-margin"><span  class="text-grey">Dropoff Location</span> : {{$ap->dropoff_location}}</p>
						@endif
			  		</span>
					  <div class="clear"></div>
					@if($ap->remark != '')
					
					<p class="col-md-11" style="margin: 10px;"><span  class="text-grey">Remark</span> : {!!$ap->remark!!}</p>
					@endif
					@if($variant->cancellation_policy != '')
					
						<p class="col-md-11" style="margin: 10px;">{!!$variant->cancellation_policy!!}</p>
					@endif
					
					
						
					
					<div class="clear"></div>
	      		</div>
				  @if(($ap->transfer_option == 'Shared Transfer') || ($ap->transfer_option == 'Pvt Transfer') || ($activity->entry_type == 'Arrival'))
				  <div style="background: #3C4A70; border-radius: 0px 0px 10px 10px;min-height: 30px;color:#fff;padding: 5px 5px 5px 5px;">
					<div style="width: 70px;height: 70px;float:left;text-algin:center; ">
					<div style="width: 50px;border-radius: 50%;height: 50px;float:left;text-algin:center; background:red;margin: 5px 10px;">
				  		<p style="font-size: 25px;text-align:center;margin-top: 10px;">!</p>
				  	</div>
					  </div>
				  	@if($ap->transfer_option == 'Shared Transfer')
					<p style="font-weight:bold;margin:5px 5px 2px 5px;">Driver will wait for 5 minutes from the Scheduled Pick Time</p>
					<p style="margin:0px 5px 10px 5px">It is highly recommended that guest should be in the hotel lobby at least 10 mins before the advised pick up time.</p>
					@endif
					
					@if($activity->entry_type == 'Arrival')
					<p style="font-weight:bold;margin:5px 5px 10px 5px">Driver will be waiting outside the airport at the Exit or Arrival Hall with Guest name on Placard</p>
					<p style="font-weight:bold;margin:5px 5px 10px 5px">
Note : Driver will wait for 90 Minutes</p>
@elseif($ap->transfer_option == 'Pvt Transfer')
					<p style="font-weight:bold;margin:5px 5px 2px 5px;">Driver will wait for 10 minutes from the Scheduled Pick Time.</p>
					<p style="margin:0px 5px 10px 5px">It is highly recommended that guest should be in the hotel lobby at least 10 mins before the advised pick up time.</p>
					@endif
					</div>
					@endif

	      	</div>
			
			
			  @php
			  $kn = ($sno%2);
					$tr_dt = $ap->tour_date;
					$old_day_no = $day_no;
					@endphp
					@if(($kn == 0) && ($tact > $sno))
					<div style = "display:block; clear:both; page-break-after:always;"></div>
					<div class="inner-div mb-20" >
						<div class="col-6 float-left text-left" >
							@if(file_exists(public_path('uploads/users/thumb/'.$voucher->agent->image)) && !empty($voucher->agent->image))
								<img src="{{asset('uploads/users/thumb/'.$voucher->agent->image)}}" class="agent-logo">
							@else
							{{-- Code to show a placeholder or alternate image --}}
								<img src="{{asset('Abatera_logo.jpg')}}" class="agent-logo">
							@endif
						</div>
						<div class="col-6 float-right text-right">
							<span class="pt-40">
							<p class="no-margin mt-40"><i class="fa fa-headset mr-10" aria-hidden="true"></i> {{$voucher->agent->mobile}}</p>
							<p class="no-margin" style=""><i class="fas fa-envelope mr-10" ></i> {{$voucher->agent->email}}</p>
							</span>
						</div>
						<div class="clear"></div>
					</div>
					
					@endif
			@endforeach
			
			
		</div>
		
	<div style = "display:block; clear:both; page-break-after:always;"></div>
	
	<!-- Activity Block End -->
	@endif	

	@if($total_activites > 0)
	
	
		<div class="inner-div mb-20" >
			<div class="col-6 float-left text-left" >
				@if(file_exists(public_path('uploads/users/thumb/'.$voucher->agent->image)) && !empty($voucher->agent->image))
					<img src="{{asset('uploads/users/thumb/'.$voucher->agent->image)}}" class="agent-logo">
				@else
				{{-- Code to show a placeholder or alternate image --}}
					<img src="{{asset('Abatera_logo.jpg')}}" class="agent-logo">
				@endif
			</div>
			<div class="col-6 float-right text-right">
				<span class="pt-40">
				<p class="no-margin mt-40"><i class="fa fa-headset mr-10" aria-hidden="true"></i> {{$voucher->agent->mobile}}</p>
				<p class="no-margin" style=""><i class="fas fa-envelope mr-10" ></i> {{$voucher->agent->email}}</p>
				</span>
			</div>
			<div class="clear"></div>
		</div>
		
		<div class="inner-div tnc-div">
			<div>
				<!-- <img src="{{asset('images/2.jpg')}}" style="max-width: 40px" /> -->
				<span class="font-bold mt-40" style="">Terms & Conditions</span>
			</div>
			<ul style="">
				<li style="">After the confirmation of the booking below conditions are applicable</li>
				<li style="">Transfer options are made available for the Tour if the With Transfer option is been selected at the time of Booking.</li>
				<li style="">All entrance tickets are non - refundable.</li>
				<li style="">Any amendments to the tour date have to be informed to the agent via email.</li>
				<li style="">Amendment(s) are subject to the Cancellation policy.</li>
				<li style="">Agent reserves the right to reject/cancel the amendment request from you.</li>
				<li style="">Any entry tickets for any show/event/ museum/ amusement park or whatsoever are Non- Cancellable & cannot be refunded under any circumstances. There will be no refund for unused or partially used services.</li>
				<li style="">There is certain waiting time for the Guests to Pick up. If in case the Guests fail to turn on time it will be a No Show and there would be No Refund or Rescheduling. Refer to individual Tour Voucher for pickup time, Cancellation policy.</li>
				<li style="">Pick Up time advised are tentative and the exact timings will be notified a day prior.</li>
				<li style="">Shared Transfers waiting time is 5 minutes and Private transfers waiting time is 15 minutes</li>
			</ul>
		</div>
		@endif	
	</div>

</body>

</html>
