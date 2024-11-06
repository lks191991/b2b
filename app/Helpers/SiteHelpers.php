<?php

namespace App\Helpers;

use Ramsey\Uuid\Uuid;
use DB;
use Carbon\Carbon;
use Auth;
use App\Models\User;
use App\Models\State;
use App\Models\VoucherActivity;
use App\Models\VoucherHotel;
use App\Models\ActivityPrices;
use App\Models\AgentPriceMarkup;
use App\Models\ActivityVariant;
use App\Models\VariantPrice;
use App\Models\Zone;
use App\Models\TransferData;
use App\Models\Variant;
use App\Models\Activity;
use App\Models\Voucher;
use App\Models\Ticket;
use App\Models\VoucherActivityLog;
use App\Models\Currency;
use App\Models\City;

class SiteHelpers
{
    
	public static function statusColor($val)
    {
		$color ='';
		if($val ==1) {
			$color = '<span class="badge bg-success">Active</span>';
		} else {
			$color = '<span class="badge bg-danger">Inactive</span>';
		}
		
	   
        return $color;
    }
	
	public static function statusColorYesNo($val)
    {
		$color = '';
		if($val ==1) {
			$color = '<span class="badge bg-success">Yes</span>';
		} else {
			$color = '<span class="badge bg-danger">No</span>';
		}
		
	   
        return $color;
    }
	
	public static function notificationType($val)
    {
		$color = '';
		if($val ==1) {
			$color = '<span class="badge bg-success">Notification</span>';
		} else {
			$color = '<span class="badge bg-info">Announcements</span>';
		}
		
	   
        return $color;
    }

	public static function notificationTypeHome($val)
    {
		$color = '';
		if($val ==1) {
			$color = '<span class="badge bg-success" style="margin-left:10px;">Notification</span>';
		} else {
			$color = '<span class="badge bg-info" style="margin-left:10px;">Announcements</span>';
		}
		
	   
        return $color;
    }
	
	public static function getAgentMarkup($agent_id,$activity_id,$variant_code)
    {
		$markup = [];
		$markup['ticket_only'] = 0;
		$markup['sic_transfer'] = 0;
		$markup['pvt_transfer'] = 0;
		$markup['ticket_only_m'] = 1;
		$markup['sic_transfer_m'] = 1;
		$markup['pvt_transfer_m'] = 1;
		$user = User::where('id',  $agent_id)->first();
		$m = AgentPriceMarkup::where('agent_id',  $agent_id)->where('activity_id',  $activity_id)->where('variant_code',  $variant_code)->first();
		
			if(!empty($m->ticket_only))
			{
				$markup['ticket_only_m'] = 0;
				$markup['ticket_only'] = $m->ticket_only;
			}
			elseif(!empty($user->ticket_only))
			{
				$markup['ticket_only_m'] = 1;
				$markup['ticket_only'] = $user->ticket_only;
			}
			if(!empty($m->sic_transfer))
			{
				$markup['sic_transfer_m'] = 0;
				$markup['sic_transfer'] = $m->sic_transfer;
			}
			elseif(!empty($user->sic_transfer))
			{
				$markup['sic_transfer_m'] = 1;
				$markup['sic_transfer'] = $user->sic_transfer;
			}
			if(!empty($m->pvt_transfer))
			{
				$markup['pvt_transfer_m'] = 0;
				$markup['pvt_transfer'] = $m->pvt_transfer;
			}
			elseif(!empty($user->pvt_transfer))
			{
				$markup['pvt_transfer_m'] = 1;
				$markup['pvt_transfer'] = $user->pvt_transfer;
			}
		
		
        return $markup;
    }
	
	public static function getZone($activity_zones,$sic_TFRS,$zoneid=NULL)
    {
		$zoneArray = [];
		
		if($sic_TFRS == 1) {
			$zoneArrayJson = json_decode($activity_zones);
			
			if(count($zoneArrayJson) > 0 or !empty($zoneArrayJson)) {
				foreach($zoneArrayJson as $k => $z) {
					$zone = Zone::where('status', 1)->where('id', $z->zone)->orderBy('name', 'ASC')->first();
					if(!empty($zone))
					{
						if(($zoneid != ''))
						{
							if($zoneid == $zone->id)
							{
								$zoneArray[] = [
									'zone_id' => $zone->id,
									'zone' => $zone->name,
									'zoneValue' => $z->zoneValue,
									'zoneValueChild' => @$z->zoneValueChild,
									'pickup_time' => (!empty($z->pickup_time))?$z->pickup_time:'',
									'dropup_time' => (!empty($z->dropup_time))?$z->dropup_time:'',
									];
							}
						}
						else
						{
					$zoneArray[] = [
					'zone_id' => $zone->id,
					'zone' => $zone->name,
					'zoneValue' => $z->zoneValue,
					'zoneValueChild' => @$z->zoneValueChild,
					'pickup_time' => (!empty($z->pickup_time))?$z->pickup_time:'',
					'dropup_time' => (!empty($z->dropup_time))?$z->dropup_time:'',
					];
				}
					}
				}
			}
			
		}
		
		return $zoneArray;
    }
	
	public static function getPickupTimeByZone($activity_zones,$zoneId)
    {
		$pickup_time = '';
		
		if($zoneId > 0){
			$zoneArrayJson = json_decode($activity_zones);
			if(!empty($zoneArrayJson)){
				foreach($zoneArrayJson as $k => $z){
					if($zoneId == $z->zone){
					$pickup_time =   (!empty($z->pickup_time))?$z->pickup_time:'';
					}
				}
			}
			
		}
		
		return $pickup_time;
    }
	
	
	public static function getActivity($activity_id)
    {
		
		$activity = Activity::where('status', 1)->where('id', $activity_id)->first();
		return $activity;
    }
	
	public static function getVariant($ucode)
    {
		
		$variant = Variant::where('status', 1)->where('ucode', $ucode)->first();
		return $variant;
    }
	
	public static function getActivityVariant($ucode)
    {
		
		$activityVariant = ActivityVariant::with('activity','variant')->where('ucode', $ucode)->first();
		return $activityVariant;
    }
	
	public static function getActivityVariantTotalCount($aid)
    {
		
		$activityVariantTotalCount = ActivityVariant::where('activity_id', $aid)->count();
		return $activityVariantTotalCount;
    }
	
	public static function getActivityImageName($aid)
    {
		
		$activity = Activity::select('image')->where('id', $aid)->first();
		return (!empty($activity))?$activity->image:'';
    }
	
	public static function getActivityEntryType($aid)
    {
		
		$activity = Activity::select('entry_type')->where('id', $aid)->first();
		return (!empty($activity))?$activity->entry_type:'';
    }
	public static function getSupplierBookingEmail($sid)
    {
		
		$supplier = User::select('booking_email')->where('id', $sid)->first();
		return (!empty($supplier))?$supplier->booking_email:'';
    }
	public static function getSupplierName($sid)
    {
		
		$supplier = User::select('company_name')->where('id', $sid)->first();
		return (!empty($supplier))?$supplier->company_name:'';
    }
	public static function getStateCityZone($sid,$cid)
    {
		$zone = "";
		
		$city = City::select('zone')->where('id', $cid)->first();
		if(!empty($city->zone)) 
		{
			$zone = $city->zone;
		}
		else
		{
			$state = State::select('zone')->where('id', $sid)->first();
			if(!empty($state->zone)) 
			{
				$zone = $state->zone;
			}
			
		}
		return $zone;
		
    }
	public static function getZoneName($zoneId)
    {
				$zone = Zone::where('status', 1)->where('id', $zoneId)->first();
				
		return $zone;
    }
	public static function getDateListHotel($startDate,$endDate,$blackoutDates='',$soldoutDates='',$operDays='')
    {
			$blackDate = [];
			$soldDate = [];
			$operationDays = [];
			$check_days = "1";
			if(($operDays == '') || ($operDays == 'All'))
			{
				$check_days = 0;
			}
			else
			{
				$operationDays = explode(",",$operDays);
			}
			if(!empty($blackoutDates)){
				$blackDate = explode(",",$blackoutDates);
			}
			
			if(!empty($soldoutDates)){
				$soldDate = explode(",",$soldoutDates);
			}
			// Create DateTime objects from the start and end dates
			$start = new \DateTime($startDate);
			$end = new \DateTime($endDate);

			// Add one day to the end date to include it in the range
			$end->modify('+1 day');

			// Initialize an empty array to store the dates
			$dates = [];

			// Iterate over each day and add it to the array
			$interval = new \DateInterval('P1D'); // 1 day interval
			$period = new \DatePeriod($start, $interval, $end);
			foreach ($period as $date) {
				$dt = $date->format('Y-m-d');
				if((!in_array($dt,$blackDate)) OR (!in_array($dt,$soldDate)))
				{
					if($check_days == '1')
					{
						$day = $date->format('l');
						if((in_array($day,$operationDays)))
						{
							$dates[] = $dt;
						}
					}
					else
					{
						$dates[] = $dt;
					}
				}
			}

		return $dates;
    }
	public static function getDateList($tour_dt,$blackoutDates='',$soldoutDates='',$operDays='')
    {
			$blackDate = [];
			$soldDate = [];
			$operationDays = [];
			$check_days = "1";
			if(($operDays == '') || ($operDays == 'All'))
			{
				$check_days = 0;
			}
			if(!empty($blackoutDates)){
				$blackDate = explode(",",$blackoutDates);
			}
			
			if(!empty($soldoutDates)){
				$soldDate = explode(",",$soldoutDates);
			}
			// Create DateTime objects from the start and end dates
			

			// Add one day to the end date to include it in the range
			

			// Initialize an empty array to store the dates
			$dates = [];

			// Iterate over each day and add it to the array
			
				if((!in_array($tour_dt,$blackDate)) OR (!in_array($tour_dt,$soldDate)))
				{
					if($check_days == '1')
					{
						$day = date('l',strtotime($tour_dt));
						if((in_array($day,$operationDays)))
						{
							$dates[] = $tour_dt;
						}
					}
					else
					{
						$dates[] = $tour_dt;
					}
				}

		return $dates;
    }
	public static function getDateListOld($startDate,$endDate,$blackoutDates='',$soldoutDates='')
    {
			$blackDate = [];
			$soldDate = [];
			if(!empty($blackoutDates)){
				$blackDate = explode(",",$blackoutDates);
			}
			
			if(!empty($soldoutDates)){
				$soldDate = explode(",",$soldoutDates);
			}
			// Create DateTime objects from the start and end dates
			$start = new \DateTime($startDate);
			$end = new \DateTime($endDate);

			// Add one day to the end date to include it in the range
			$end->modify('+1 day');

			// Initialize an empty array to store the dates
			$dates = [];

			// Iterate over each day and add it to the array
			$interval = new \DateInterval('P1D'); // 1 day interval
			$period = new \DatePeriod($start, $interval, $end);
			foreach ($period as $date) {
				$dt = $date->format('Y-m-d');
				if((!in_array($dt,$blackDate)) OR (!in_array($dt,$soldDate))){
				$dates[] = $dt;
				}
			}

		return $dates;
    }
	
	public static function getDateListBoth($startDate,$endDate,$blackoutDates='',$soldOutDates='')
    {
			$blackDate = [];
			$soldOutDate = [];
			if(!empty($blackoutDates)){
				$blackDate = explode(",",$blackoutDates);
			}
			if(!empty($soldOutDates)){
				$soldOutDate = explode(",",$blackoutDates);
			}
			// Create DateTime objects from the start and end dates
			$start = new \DateTime($startDate);
			$end = new \DateTime($endDate);

			// Add one day to the end date to include it in the range
			$end->modify('+1 day');

			// Initialize an empty array to store the dates
			$dateData = [];
			$availableDates = [];
			$disabledDates = [];
			// Iterate over each day and add it to the array
			$interval = new \DateInterval('P1D'); // 1 day interval
			$period = new \DatePeriod($start, $interval, $end);
			
			foreach ($blackDate as $date) {
				$dt = $date->format('Y-m-d');
				
					$disabledDates[] = $dt;
				
				
				
			}
			foreach ($soldOutDate as $date) {
				$dt = $date->format('Y-m-d');
				
					$disabledDates[] = $dt;
				
				
				
			}
		
		$dateData['availableDates'] = json_encode($availableDates);
		$dateData['disabledDates'] = json_encode($disabledDates);
		return $dateData;
    }
	public static function getDisableDates($blackoutDates='',$soldOutDates='')
    {
			$blackDate = [];
			$soldOutDate = [];
			if(!empty($blackoutDates)){
				$blackDate = explode(",",$blackoutDates);
			}
			if(!empty($soldOutDates)){
				$soldOutDate = explode(",",$soldOutDates);
			}
			// Create DateTime objects from the start and end dates
			
			// Initialize an empty array to store the dates
			$dateData = "";
			$disabledDates = [];
			
			foreach ($blackDate as $date) {
				$disabledDates[] = $date;
			}
			foreach ($soldOutDate as $date) {
				$disabledDates[] = $date;
			}
		
		$dateData = json_encode($disabledDates);
		return $dateData;
    }
	
	public static function getNovableActivityDays($availability)
    {
		$days = [];
			$notAvDay = [];
		if(($availability != 'All') and !empty(($availability))){
		
		$daysName = [
		'Sunday' => 0,
		'Monday' => 1,
		'Tuesday' => 2,
		'Wednesday' => 3,
		'Thursday' => 4,
		'Friday' => 5,
		'Saturday' => 6,
		];
			
			if(!empty($availability)){
				$days = explode(",",$availability);
				
			foreach ($daysName as $k => $day) {
				if(!in_array($k,$days)){
						$notAvDay[] = $day;
				}
			}
			}
			
			//print_r($notAvDay);
	
		}
		
		return json_encode($notAvDay);
    }
	
	public static function voucherActivityStatusName($val)
    {
		$color = '';
		$voucherActivityStatus = config("constants.voucherActivityStatus");
		if($val ==0){
			$color = '<span class="badge bg-primary">'.$voucherActivityStatus[$val].'</span>';
		}
		else if($val == 1) {
			$color = '<span class="badge bg-secondary">'.$voucherActivityStatus[$val].'</span>';
		} 
		 else if($val == 2) {
			$color = '<span class="badge bg-secondary">'.$voucherActivityStatus[$val].'</span>';
		} 
		else if($val == 3) {
			$color = '<span class="badge bg-secondary">'.$voucherActivityStatus[$val].'</span>';
		} else if($val == 4) {
			$color = '<span class="badge bg-success">'.$voucherActivityStatus[$val].'</span>';
		} else if($val == 5) 
		{
			$color = '<span class="badge bg-success">'.$voucherActivityStatus[$val].'</span>';
		} 
		else if($val == 6) {
			$color = '<span class="badge bg-danger">'.$voucherActivityStatus[$val].'</span>';
		}
		else if($val == 7) 
		{
			$color = '<span class="badge bg-danger">'.$voucherActivityStatus[$val].'</span>';
		}
		else if($val == 8) 
		{
			$color = '<span class="badge bg-danger">'.$voucherActivityStatus[$val].'</span>';
		}
		else if($val == 9) {
			$color = '<span class="badge bg-danger">'.$voucherActivityStatus[$val].'</span>';
		}
		else if($val == 10) {
			$color = '<span class="badge bg-danger">'.$voucherActivityStatus[$val].'</span>';
		}
		else if($val == 11) {
			$color = '<span class="badge bg-danger">'.$voucherActivityStatus[$val].'</span>';
		}
		else if($val == 12) {
			$color = '<span class="badge bg-danger">'.$voucherActivityStatus[$val].'</span>';
		}
		 return $color;
	}
	
	public static function voucherActivityStatus($val)
    {
		$color = '';
		$voucherStatus = config("constants.voucherActivityStatus");
		if($val ==1){
			$color = 'bg-danger';
		}
		else if($val ==3){
			$color = 'bg-warning';
		} 
		else if($val ==4){
			$color = 'bg-success';
		} 
		else{
			$color = 'bg-default';
		} 
		 return $color;
	}
	public static function voucherStatus($val)
    {
		$color = '';
		$voucherStatus = config("constants.voucherStatus");
		if($val == 1) {
			$color = '<span class="badge bg-primary">'.$voucherStatus[$val].'</span>';
		} 
		 else if($val == 2) {
			$color = '<span class="badge bg-secondary">'.$voucherStatus[$val].'</span>';
		} 
		else if($val == 3) {
			$color = '<span class="badge bg-warning">'.$voucherStatus[$val].'</span>';
		} else if($val == 4) {
			$color = '<span class="badge bg-warning">'.$voucherStatus[$val].'</span>';
		} else if($val == 5) 
		{
			$color = '<span class="badge bg-success">'.$voucherStatus[$val].'</span>';
		} 
		else if($val == 6) {
			$color = '<span class="badge bg-danger">'.$voucherStatus[$val].'</span>';
		}
		else if($val == 7) 
		{
			$color = '<span class="badge bg-danger">'.$voucherStatus[$val].'</span>';
		}
		
		 return $color;
	}
	
	public static function slotType($val)
    {
		$color = '';
		if($val ==3){
			$color = '<span class="badge bg-secondary">No Slot</span>';
		} else if($val == 1) {
			$color = '<span class="badge bg-success">Vouchered</span>';
		} else if($val == 2) {
			$color = '<span class="badge bg-danger">Canceled</span>';
		}
		 return $color;
	}
	
	
	
	public static function getActivityLowPrice($activity_variant_id,$agent_id,$voucher)
    {
		$minPrice = 0;
		$zonePrice = 0;
		$transferPrice = 0;
		$vatPrice = 0;
		$adult_rate = 0;
		$vat_invoice = $voucher->vat_invoice;
		$startDate = $voucher->travel_from_date;
		$endDate = $voucher->travel_to_date;
		$user = auth()->user();
		$activityVariant = ActivityVariant::where('id', $activity_variant_id)->first();
		$variant = Variant::where('id', $activityVariant->variant_id)->select('sic_TFRS','pvt_TFRS','zones','transfer_plan')->first();
		$activity = Activity::where('id', $activityVariant->activity_id)->select('entry_type','vat')->first();
		
		$avat = 0;
		if($activity->vat > 0){
		$avat = $activity->vat;	
		}
		
		$query = VariantPrice::where('activity_variant_id', $activityVariant->id)->where('rate_valid_from', '<=', $startDate)->where('rate_valid_to', '>=', $endDate);
		/* if($user->role_id == '3'){
			$query->where('for_backend_only', '0');
		} */
		
		if($vat_invoice == 1){
			$ap = $query->orderByRaw('CAST(adult_rate_without_vat AS DECIMAL(10, 2))')
    ->select('adult_rate_without_vat')
    ->first();
	if(isset($ap->variant_code)){
	$adult_rate = $ap->adult_rate_without_vat;
	}
	
	
	} else {
	$ap = $query->orderByRaw('CAST(adult_rate_with_vat AS DECIMAL(10, 2))')
    ->select('adult_rate_with_vat')
    ->first();
	
	if(isset($ap->adult_rate_with_vat)){
	$adult_rate = $ap->adult_rate_with_vat;
	}
	}
		/* if(isset($ap->variant_code)){
		$markup = self::getAgentMarkup($agent_id,$activity_id, $ap->variant_code);
		}else{ */
			$markup['ticket_only'] = 0;
			$markup['sic_transfer'] = 0;
			$markup['pvt_transfer'] = 0;
			$markup['ticket_only_m'] = 1;
			$markup['sic_transfer_m'] = 1;
			$markup['pvt_transfer_m'] = 1;
		//}
		
		
		 
			if($variant->sic_TFRS==1){
				
				 $actZone = self::getZone($variant->zones,$variant->sic_TFRS);
				 if(!empty($actZone))
				 {
					  $zonePrice = $actZone[0]['zoneValue'];
				 }
			}
			if($variant->pvt_TFRS==1){
					$td = TransferData::where('transfer_id', $variant->transfer_plan)->where('qty', 1)->first();
					if(!empty($td))
					{
					 $transferPrice = $td->price;
					}
			}
			
		$adultPriceMarkupTotal = $markup['ticket_only'] * 1; // ticket_only as adult
		$childPriceMarkupTotal = $markup['sic_transfer'] * 0; // sic_transfer as child
		$infentPriceMarkupTotal = $markup['pvt_transfer'] * 0; // pvt_transfer as infent
		$markupTotal = $adultPriceMarkupTotal + $childPriceMarkupTotal + $infentPriceMarkupTotal;
		
		if($adult_rate > 0){
			
			
			if($activity->entry_type=='Ticket Only'){
				$minPrice = $adult_rate;
			} else {
				if($variant->sic_TFRS==1){
					$minPrice =  $adult_rate + $zonePrice;
				}elseif($variant->pvt_TFRS==1){
					  $minPrice = $adult_rate + $transferPrice;
				}
			}
			
		} else {
			
			if($variant->sic_TFRS==1){
			
				$minPrice =  $zonePrice;
				
			}elseif($variant->pvt_TFRS==1){
				$minPrice =   $transferPrice;
			}
			

		}
		$minP = $minPrice + $markupTotal;
		if($vat_invoice == 1){
		$vatPrice = (($avat/100) * $minP);
		}
		
		$total = $minP+$vatPrice;
		
		return number_format($total, 2, '.', "");
    }
	
	public static function hotelRoomsDetails($data)
    {
		$rooms = json_decode($data);
		$room_type = '';
		$number_of_rooms = 0;
		$occupancy = 0;
		$price = 0;
		$child = 0;
		$cost = 0;
		$markup = 0;
		if(count($rooms) > 0) {
			
			foreach($rooms as $room) {
				$room_type.=$room->room_type.',';
				$number_of_rooms += $room->nom_of_room ;
				$occupancy +=$room->nop_s + $room->nop_d+ $room->nop_eb;
				$child +=$room->nop_cwb + $room->nop_cnb;
				$mealplan =(!empty($room->mealplan))?$room->mealplan:'';
				$cost +=($room->nr_s + $room->nr_d + $room->nr_eb + $room->nr_cwb + $room->nr_cnb);
				$markup +=($room->markup_v_s + $room->markup_v_d + $room->markup_v_eb + $room->markup_v_cwb + $room->markup_v_cnb);
				$price +=($room->nr_s + $room->nr_d + $room->nr_eb + $room->nr_cwb + $room->nr_cnb+$room->markup_v_s + $room->markup_v_d + $room->markup_v_eb + $room->markup_v_cwb + $room->markup_v_cnb);
			}
		}
		
		$dataArray = [
		'room_type' => rtrim($room_type, ','),
		'number_of_rooms' => $number_of_rooms,
		'occupancy' => $occupancy,
		'mealplan' => $mealplan,
		'childs' => $child,
		'price' => $price,
		'cost' => $cost,
		'markup' => $markup,
		];
		
		return $dataArray;
    }
	
	function format_minutes_to_hours($totalMinutes)
    {
        $hours = floor($totalMinutes / 60);
        $minutes = $totalMinutes % 60;
        
        return sprintf("%02d:%02d", $hours, $minutes). ' Hour(s)';
    }
	
	
	public static function getTicketCountByCode($code)
    {
		
		$ticketCount = Ticket::where('activity_variant', $code)->count();
		return $ticketCount;
    }

	public static function voucherActivityCount($vid)
    {
		
		$voucherActivity = VoucherActivity::where('voucher_id',$vid)->count();

		$voucherActivityBundle = VoucherActivity::where('voucher_id',$vid)->where('activity_product_type','Bundle_Same')->count();
		if($voucherActivityBundle > 0 )
		{
			return $voucherActivity-$voucherActivityBundle+1;
		}
		else
		{
			return $voucherActivity;
		}
    }

	public static function voucherHotelCount($vid)
    {
		
		$voucherHotel = VoucherHotel::where('voucher_id',$vid)->count();
		
		return $voucherHotel;
    }
	
	public static function checkPermissionMethod($p)
    {
		$user = auth()->user();
		$role = $user->role;
		$permission = $user->hasPermission($p, $role);
		if(!empty($permission)){
			return 1;
		} else {
			return abort(403, 'Unauthorized');;
		}
		
    }
	
	
	public static function checkAvailableBookingTimeSlot($u_code,$activity_id,$tourDt,$transfer_option,$is_opendated)
    {
		
		$activityPrice = ActivityPrices::where(['u_code'=>$u_code,'activity_id'=>$activity_id])->select('start_time','end_time','booking_window_valueto','booking_window_valueSIC','booking_window_valuePVT')->first();
			$startTime = $activityPrice->start_time;
			$combinedDatetime = $tourDt . ' ' . $startTime;
			$validuptoTime = strtotime($combinedDatetime);
			$booking_window_valueto = 0;
			$currentTimestamp = strtotime("now");
			if(($transfer_option == 'Ticket Only') && ($is_opendated == '1')){
				return 0;
			}
			
			if($transfer_option == 'Shared Transfer'){
				$cancelHours = ($activityPrice->cancellation_valueSIC>0)?$activityPrice->cancellation_valueSIC:0;
			}
			elseif($transfer_option == 'Pvt Transfer'){
				$cancelHours = ($activityPrice->cancellation_valuePVT>0)?$activityPrice->cancellation_valuePVT:0;
			}else{
				$cancelHours = ($activityPrice->cancellation_value_to>0)?$activityPrice->cancellation_value_to:0;
			}
			
			if($cancelHours > 0){
			$booking_window_valueto  = $cancelHours * 60*60;
			}
			
			
			$bookingTime = $currentTimestamp + $booking_window_valueto;
			
			if($validuptoTime >= $bookingTime){
				return 0;
			} else {
				return 1;
			}
		
    }
	
	public static function getAgentlastVoucher()
    {
		$user = auth()->user();
		$startDate = date("Y-m-d");
		$voucher = Voucher::where('status_main','1')->where('agent_id',$user->id)->whereDate('travel_from_date','>=', $startDate)->first();
		if(!empty($voucher)){
			return $voucher;
		}
		else{
		return 0;	
		}
		
    }
	
	public static function checkCancelBookingTime($u_code,$activity_id,$tourDt,$transfer_option)
    {
		
		/* $activityPrice = ActivityPrices::where(['u_code'=>$u_code,'activity_id'=>$activity_id])->select('start_time','end_time','cancellation_value_to','cancellation_valueSIC','cancellation_valuePVT')->first();
			$startTime = $activityPrice->start_time;
			$combinedDatetime = $tourDt . ' ' . $startTime;
			$validuptoTime = strtotime($combinedDatetime);
			$booking_window_valueto = 0;
			$cancelHours = 0;
			$currentTimestamp = strtotime("now");
			
			if($transfer_option == 'Shared Transfer'){
				$cancelHours = ($activityPrice->cancellation_valueSIC>0)?$activityPrice->cancellation_valueSIC:0;
			}
			elseif($transfer_option == 'Pvt Transfer'){
				$cancelHours = ($activityPrice->cancellation_valuePVT>0)?$activityPrice->cancellation_valuePVT:0;
			}else{
				$cancelHours = ($activityPrice->cancellation_value_to>0)?$activityPrice->cancellation_value_to:0;
			}
			
			if($cancelHours > 0){
			$booking_window_valueto  = $cancelHours * 60*60;
			}
			
			$vlt= $validuptoTime - $booking_window_valueto;
			$bookingTime = $currentTimestamp;
			$data['validuptoTime'] = date("d-m-Y h:i a",$vlt);
			$data['cancelhwr'] = $cancelHours;
			if($cancelHours == 0){
				$data['btm'] = 0;
			} else {
			if($vlt >= $bookingTime){
				$data['btm'] = 1;
			} else {
				$data['btm'] = 0;
			}
			} */
			
			$data['btm'] = 0;
			return $data;
		
    }
	
	public static function getActivityVarByCutoffCancellation($activity_id)
    {
		
		$activityPrice = ActivityPrices::where(['activity_id'=>$activity_id])->where(function ($query) {
        $query->where('cancellation_value_to', '0');
			 $query->orWhere('cancellation_valueSIC', '0');
			   $query->orWhere('cancellation_valuePVT', '0');
    })->count();
			
			
			if($activityPrice == 0){
				$booking_window_text  = 'Free Cancellation';
			} else{
				$booking_window_text  = 'Non - Refundable';
				
			}
		return $booking_window_text;
    }
	
	


	public static function getActivitySupplierCost($activity_id,$agent_id,$voucher,$variant_code,$adult,$child,$infent,$discount)
    {
		$totalPrice = 0;
		$infantPriceTotal = 0;
		$adultPriceTotal = 0;
		$childPriceTotal = 0;
		$adult_total_rate = 0;
		$adultPrice = 0;
		$childPrice = 0;
		$infPrice = 0;
		$pvtTrafValWithMarkup = 0;
		$totalmember = $adult + $child;
		$user = auth()->user();

		if(isset($variant_code)){
			$markup = self::getAgentMarkup($agent_id,$activity_id, $variant_code);
			}else{
				$markup['ticket_only'] = 0;
				$markup['sic_transfer'] = 0;
				$markup['pvt_transfer'] = 0;
				$markup['ticket_only_m'] = 1;
				$markup['sic_transfer_m'] = 1;
				$markup['pvt_transfer_m'] = 1;
			}
		
			
	$adultPriceTotal  = $markup['ticket_only'] * $adult;
	$childPriceTotal  = $markup['sic_transfer'] * $child;
	$infantPriceTotal  = $markup['pvt_transfer'] * $infent;
	
	$totalPrice = $adultPriceTotal + $childPriceTotal +  $infantPriceTotal;
		
	
		$data = [
		'adultPrice' =>$adultPriceTotal,
		'childPrice' =>$childPriceTotal,
		'infPrice' =>$infantPriceTotal,
		'totalprice' =>$totalPrice,
		'activity_vat' =>"0",
		'pvt_traf_val_with_markup' =>"0",
		'zonevalprice_without_markup' =>"0",
		'markup_p_ticket_only' =>$markup['ticket_only'],
		'markup_p_sic_transfer' =>$markup['sic_transfer'],
		'markup_p_pvt_transfer' =>$markup['pvt_transfer'],
		];
		
		return $data;
		
    }
	
	public static function dateDiffInDays($date1, $date2) 
	{
		$diff = strtotime($date2) - strtotime($date1);
		$days =  (abs(round($diff / 86400)))+1;
		return $days;
	}
	
	public static function numberOfNight($date1, $date2) 
{
    $diff = strtotime($date2) - strtotime($date1);
    
    $nights =  (abs(round($diff / 86400)));
    return $nights;
}
	
	
	
	
	public static function voucherActivityLog($vid,$vaid,$discount,$priceTotal,$voucherstatus)
    {
		$data = [
			'voucher_id'=>$vid,
			'voucher_activity_id'=>$vaid,
			'discount'=>$discount,
			'priceTotal'=>$priceTotal,
			'voucher_status'=>$voucherstatus,
			'created_by'=> auth()->user()->id,
		];
		
		$voucherActivity = VoucherActivityLog::create($data);
		
		return $voucherActivity;
    }
	public function voucherActivityValue($id,$supplier_id)
    {
		$voucher_activity = VoucherActivity::where('id',  $id)->first();
		$records = array();
		$a = $voucher_activity->adult;
		$c = $voucher_activity->child;
		$activity_id = $voucher_activity->activity_id ;
		$markup = [];
		$markup['ticket_only'] = 0;
		$markup['sic_transfer'] = 0;
		$markup['pvt_transfer'] = 0;
	  	$markup = self::getAgentMarkup($supplier_id,$activity_id, $voucher_activity->variant_code);
		$total_amt = 0;
		$total_amt = $a*$markup['ticket_only']+$c*$markup['sic_transfer'];
	  	return $total_amt;
    }
	public static function getVoucherTotalPrice($voucherId)
    {
		$user = auth()->user();
		$totalprice = VoucherActivity::where('voucher_id',$voucherId)->sum("totalprice");
		return $totalprice;
    }
	
	public static function getVoucherTotalPriceNew($voucherId)
    {
		$user = auth()->user();
		$totalprice = VoucherActivity::where('voucher_id',$voucherId)->sum("totalprice")-(VoucherActivity::where('voucher_id',$voucherId)->sum("discount_tkt")+VoucherActivity::where('voucher_id',$voucherId)->sum("discount_sic_pvt_price"));
		$voucherHotel = VoucherHotel::where('voucher_id',$voucherId)->sum("total_price");;
		return $totalprice+$voucherHotel;
    }
	
	
	public static function getCurrencyAll()
    {
		$records = Currency::where('status',1)->orderBy('created_at', 'DESC')->get();
		return $records;
    }
	
	public static function getCurrencyPrice()
    {
		$user = auth()->user();
		$data = [];
		$record = Currency::where('id', $user->currency_id)->first();
		if(!empty($record)){
			$data['name'] = $record->name;
			$data['code'] = $record->code;
			$data['value'] = $record->value;
			$data['markup_value'] = $record->markup_value;
		} else {
			$data['name'] = 'AED';
			$data['code'] = 'AED';
			$data['value'] = '1';
			$data['markup_value'] = '1';
		}
		
		return $data;
    }
	
	

	public static function getCurrencyPriceById($curreny_id)
    {
		$data = [];
		$record = Currency::where('id', $curreny_id)->first();
		if(!empty($record)){
			$data['name'] = $record->name;
			$data['code'] = $record->code;
			$data['value'] = $record->value;
			$data['markup_value'] = $record->markup_value;
		} else {
			$data['name'] = 'AED';
			$data['code'] = 'AED';
			$data['value'] = '1';
			$data['markup_value'] = '1';
		}
		
		return $data;
    }
	public static function getFlyremitCityById($cityId)
    {
		$data = "119";
		$record = City::where('id', $cityId)->first();
		if(!empty($record)){
			if($record->flyremitID > 0)
				$data = $record->flyremitID;
		} 
		return $data;
    }
	public static function getUserName($user_id)
    {
		$user = User::where('id',  $user_id)->first();
		return $user->name." ".$user->lname;
    }

	public static function getActivityVaraint($avid)
    {
		$av_ar = ActivityVariant::where('id',$avid)->first();
		return $av_ar->code;
    }
	
	public static function getUserByZoneEmail($agentId)
	{
		$agent = User::find($agentId);
		if (!$agent) {
			return "";
		}
		
		$emails = [];
		if(!empty($agent->zone)){
		$emails = User::where('zone', $agent->zone)->whereIN('role_id',[13,10,11])->pluck('email')->toArray();
		}
		
		if (empty($emails)) {
			return "";
		}
		
		return $emails;
	}

	
}
