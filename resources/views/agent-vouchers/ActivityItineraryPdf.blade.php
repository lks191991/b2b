<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Itinerary</title>
  <!-- <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet"> -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>
<!-- font-family: 'Poppins', sans-serif; -->
<body style="margin:0 auto; font-family: 'Inter', sans-serif; ">
  <table style="width: 780px; margin: 0 auto;  border: solid 1px #f1f1f1; padding: 40px;" cellpadding="0"
    cellspacing="0">
    <tbody>
      <tr>
        <td>
        	<div style="width: 220px;">
        		<span style="display: block;font-size: 28px;">
        		<b>{{$voucher->guest_name}}</b> Trip to
        		<span style="display:block;font-size: 66px;font-weight: bold;color: #1732bb;font-family: initial;">Dubai</span>
        	</div>
        </td>
        <td valign="bottom" colspan="2" align="right" >
	        <div style="width: 330px; margin-left: auto; font-size: 13px;">
	        	<img src="{{asset('images/1.png')}}" style="max-width: 120px">    
	        </div>
        </td>
      </tr>
      <tr>
        <td colspan="3" style="">
          <div style=" padding: 10px 40px">
          	<img src="{{asset('images/2.jpg')}}" style="width: 100%;border-radius: 30px">
          </div>
        </td>
      </tr>

      <tr>
      	<td>
			<div style="display: block;">
				<p style="margin-bottom: 0">Start Date:{{$voucher->travel_from_date}}</p>
				<p style="margin-top: 5px">End Date:{{$voucher->travel_to_date}}</p>
			</div>       		
      	</td>
      	<td align="right" colspan="2">
			<div style="display: block; float: right; text-align: left;">
				<p style="margin-bottom: 0">Quote ID:{{$voucher->code}}</p>
				<p style="margin-top: 5px;font-weight: bold"></p>
			</div>      		
      	</td>
      </tr>
      <tr style="">
        <td style="padding-top: 20px" colspan="3">
          <span style=" display: flex; gap:10px">
          	<span><img src="{{asset('images/2.jpg')}}" style="max-width: 40px"></span>
          	<span style="font-size: 20px;font-weight: 600">Inclusions</span>
          </span>
          	<ul style="padding-left: 20px; margin-bottom: 30px">
			  @if(!empty($voucherActivity))
			@foreach($voucherActivity as $k => $ap)
		@php
					$activity = SiteHelpers::getActivity($ap->activity_id);
					@endphp
				<li style="font-size: 16px; font-weight: 500;line-height: 1.8;">{{$ap->variant_name}}</li>
				@endforeach
			@endif
          	</ul>
          </div>
        </td>
      </tr>
      <tr>
      	<td colspan="3">
      		<div style="background: #7EC8E3; border-radius: 30px; border: dashed 3px #f1f1f1; display: flex; align-items: center;">
      			<div style="flex: 0 0 0 0 calc(65% - 40px );background: #ffffffc7;border-radius: 30px;border: dashed 3px #f1f1f1;padding:20px;margin-top:-3px; margin-bottom: -3px; margin-left: -3px">
      				<h6 style="margin:0  0 15px 0 !important; font-weight: 700;font-size: 18px">Adult : AED {{$dataArray['adultP']}} X {{$dataArray['adult']}}</h6>
      				<h6 style="margin:0  0 15px 0 !important; font-weight: 700;font-size: 18px">Child : AED {{$dataArray['childP']}} X {{$dataArray['child']}} </h6>
      				
      				<h6 style="margin:0  0 15px 0 !important; font-weight: 700;font-size: 18px">Infant : AED {{$dataArray['infantP']}}</h6>
      				<p style="font-size: 13px;margin-bottom: 0">Note: All above prices are subject to change without prior notice as per availability, the final date of travel and any changes in taxes.</p>
      			</div>
      			<div style="flex: 0 0  35%; text-align: center;">
      				<h4 style="color: #fff;font-size: 32px;font-weight: 600; margin-bottom: 5px">AED {{$dataArray['totalPrice']}}</h4>
      				<h6 style="font-size: 22px;color: #fff;margin-top: 0;">Total</h6>
      			</div>
      		</div>
      	</td>
      </tr>
      <tr>
        <td style="font-size: 20px; font-weight: bold; padding-top: 30px !important; padding: 30px 5px 5px;">
          <img src="{{asset('images/1.png')}}" alt="" style="max-width: 150px">
        </td>
        <td style=" font-size: 16px;  padding-top: 30px !important; padding: 5px;">
          <div style="margin-left: auto; display: flex;  align-items:center; justify-content: flex-end;">
      		<span>
      			<img src="{{asset('images/4.png')}}" alt="" style="max-width: 35px">
      		</span>
      		<span style="padding-left: 15px">
      			<p style="margin-top: 0; margin-bottom:0">info@abatera.com</p>
      			<p style="margin-bottom: 0; margin-top: 5px">+971 566036693</p>
      		</span>
          </div>
        </td>
      </tr>
      <tr>
      	<td>
			<div style="display: block; padding-top: 20px">
			<p style="margin-bottom: 0">Start Date:{{$voucher->travel_from_date}}</p>
				<p style="margin-top: 5px">End Date:{{$voucher->travel_to_date}}</p>
				
			</div>      		
      	</td>
      	<td align="right" colspan="2">
			<div style="display: block; float: right; text-align: left; padding-top: 20px">
				<p style="margin-bottom: 0">Quote ID:{{$voucher->code}}</p>
				<p style="margin-top: 5px;font-weight: bold; margin-bottom: 0"></p>
			</div>      		
      	</td>
      </tr>
      <tr>
      	<td colspan="3">
		@if(!empty($voucherHotel))
			@foreach($voucherHotel as $vh)
      		<div style="padding-top: 30px;display: flex;">
      			<div style="min-width:220px;width: 220px; height: 220px; border-radius: 30px; border: solid 5px #0096e0; overflow: hidden;">
      				<img src="{{asset('uploads/hotels/'.$vh->hotel->image)}}" alt="" style="width:100%;max-width: 100%; height: 100%">
      			</div>
      			<div style="padding-left: 15px">
      				<span style="display: flex; align-items: center;">
      					<h5 style="margin: 0;font-size:16px">{{$vh->hotel->name}}</h5> 
      					<span style="padding-left: 10px;"><!-- <img src="{{asset('images/6.png')}}"> -->{{$vh->hotel->hotelcategory->name}}</span>
      				</span>
      				<span style="display: flex; align-items: center; gap: 10px; padding-top: 10px">
      					<img src="{{asset('images/7.png')}}" alt="" style="width: 18px"> 
						{{$vh->hotel->address}},{{($vh->hotel->city)?$vh->hotel->city->name:''}},{{($vh->hotel->state)?$vh->hotel->state->name:''}},{{($vh->hotel->country)?$vh->hotel->country->name:''}}
      					
      				</span>
      				<div style="max-width: 350px; padding-top: 15px; display: flex;">
      					<span>
      						<span style="color: #ccc;">Check in :</span>
      						<p style="color: #121212; margin-top: 5px; margin-bottom: 0; font-weight: 500">{{date("d M- Y",strtotime($vh->check_in_date))}}</p>
      					</span>
      					<span style="margin-left: auto;">
      						<span style="color: #ccc;">Check out :</span>
      						<p style="color: #121212; margin-top: 5px; margin-bottom: 0; font-weight: 500">{{date("d M- Y",strtotime($vh->check_out_date))}}</p>
      					</span>
      				</div>
      				<div style="padding-top: 10px">
					@php
					$room = SiteHelpers::hotelRoomsDetails($vh->hotel_other_details)
					@endphp
      					<span style="font-size: 16px; display: block; margin-top: 5px">Room Type:{{$room['room_type']}}</span>
      					<span style="font-size: 16px; display: block; margin-top: 5px">Number of Rooms :{{$room['number_of_rooms']}}</span>
      					
      					<span style="font-size: 16px; display: block; margin-top: 5px">Occupancy :{{$room['occupancy']}}</span>
      				</div>
      			</div>
      		</div>
			@endforeach
			@endif
      	</td>
      </tr>
      <tr>
      	<td colspan="3" style="padding-top: 90px;">
		@if(!empty($voucherActivity))
			@foreach($voucherActivity as $k => $ap)
		@php
					$activity = SiteHelpers::getActivity($ap->activity_id);
					@endphp
      		<div style="background: #ddd; border-radius: 15px">
	      		<div style="display: flex; background:#dcedf7; padding: 15px; border-radius: 15px">
	      			<div style="min-width:220px;width: 220px; height: 220px; border-radius: 30px; border: solid 5px #0096e0; overflow: hidden;">
	      				<img src="{{asset('images/2.jpg')}}" alt="" style="width:100%;max-width: 100%; height: 100%">
	      			</div>
	      			<div style="width: 100%;padding-left: 15px">
	      				<div style="display: flex;">
	      					<h5 style="margin:0 ">Day {{$k+1}} : {{$activity->title}} - {{$ap->variant_name}}</h5>
	      					<h5  style="margin-left: auto !important; margin:0">16 June 2023, Sun</h5>
	      				</div>
	      				<p> {!!$activity->description!!}</p>
	      			</div>
	      		</div>
	      		<div style="padding: 30px;display: flex;">
	      			<span>
			  			<span style="margin:0"><b>Transfer Type </b>: {{$ap->transfer_option}}</span>
			  			<span style="display: block;padding-top: 6px">Adult : {{$ap->adult}} | Child : {{$ap->child}} | Infant : {{$ap->infant}}</span>
			  		</span>
					@if($ap->transfer_option == 'Shared Transfer')
						<span style="margin-left: auto">
			  			<p style="margin: 0; font-weight: 600">Pick Up Timings : {{$ap->actual_pickup_time}}</p>
			  		</span>
					
					@elseif($ap->transfer_option == 'Pvt Transfer')
					<span style="margin-left: auto">
			  			<p style="margin: 0; font-weight: 600">Pick Up Timings : {{$ap->actual_pickup_time}}</p>
			  		</span>
					@endif
					
			  		
	      		</div>
	      	</div>
			@endforeach
			@endif
      	</td>
      </tr>
      <tr>
      	<td colspan="3" style="padding-top: 90px !important;">
          <img src="{{asset('images/1.png')}}" alt="" style="max-width: 150px">
        </td>
      </tr>
      <tr>
      	<td colspan="3" style="padding-top: 20px !important;" align="right">
          	<div style="display: block;">
				<p style="margin-bottom: 0">Quote ID:{{$voucher->code}}</p>
				<p style="margin-top: 5px;font-weight: bold"></p>
			</div>    
        </td>
      </tr>
      <tr>
      	<td style="padding-top: 20px" colspan="3">
          <span style=" display: flex; gap:10px">
          	<span><img src="{{asset('images/2.jpg')}}" style="max-width: 40px"></span>
          	<span style="font-size: 20px;font-weight: 600">Inclusions</span>
          </span>
          	<ul style="padding-left: 20px; margin-bottom: 30px">
				<li style="font-size: 16px; font-weight: 500;line-height: 1.8;">After the confirmation of the booking below conditions are applicable</li>
<li style="font-size: 16px; font-weight: 500;line-height: 1.8;">Transfer options are made available for the Tour if the With Transfer option is been selected at the time of Booking.</li>
<li style="font-size: 16px; font-weight: 500;line-height: 1.8;">All entrance tickets are non - refundable.</li>
<li style="font-size: 16px; font-weight: 500;line-height: 1.8;">Any amendments to the tour date have to be informed to the agent via email.</li>
<li style="font-size: 16px; font-weight: 500;line-height: 1.8;">Amendment(s) are subject to the Cancellation policy.</li>
<li style="font-size: 16px; font-weight: 500;line-height: 1.8;">Agent reserves the right to reject/cancel the amendment request from you.</li>
<li style="font-size: 16px; font-weight: 500;line-height: 1.8;">Any entry tickets for any show/event/ museum/ amusement park or whatsoever are Non- Cancellable & cannot be refunded under any circumstances. There will be no refund for unused or partially used services.</li>
<li style="font-size: 16px; font-weight: 500;line-height: 1.8;">There is certain waiting time for the Guests to Pick up. If in case the Guests fail to turn on time it will be a No Show and there would be No Refund or Rescheduling. Refer to individual Tour Voucher for pickup time, Cancellation policy.</li>
<li style="font-size: 16px; font-weight: 500;line-height: 1.8;">Pick Up time advised are tentative and the exact timings will be notified a day prior.</li>
<li style="font-size: 16px; font-weight: 500;line-height: 1.8;">Shared Transfers waiting time is 5 minutes and Private transfers waiting time is 15 minutes</li>
          	</ul>
          </div>
        </td>
      </tr>
    </tbody>
  </table>
</body>

</html>