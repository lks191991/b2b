<?php

namespace App\Helpers;

use Ramsey\Uuid\Uuid;
use DB;
use Carbon\Carbon;
use Auth;
use App\Models\User;
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
use SiteHelpers;

class PriceHelper 
{
    
	public static function getActivityVariantListArrayByTourDate($date,$activityId)
    {
		$user = auth()->user();
		$data = [];
		$activity = Activity::find($activityId);
		$data['activity'] = $activity;
		$data['activityVariants'] = [];
		$date = date("Y-m-d",strtotime($date));
		
			$activityVariants = ActivityVariant::with('prices', 'variant', 'activity')
			->where('activity_id', $activityId)
			->whereHas('prices', function ($query) use ($date) {
				$query->where('rate_valid_from', '<=', $date)
					  ->where('rate_valid_to', '>=', $date);
			})->get();
	
	   if(!empty($activityVariants)){
			$data['activityVariants'] = $activityVariants;
		}
	   
	   return $data;
    }
	
	public static function getActivityVariantPrice($activityVariantId,$tourDate)
    {
		$user = auth()->user();
		$tourDate = date("Y-m-d",strtotime($tourDate));
		$price = VariantPrice::where('activity_variant_id', $activityVariantId)->where('rate_valid_from', '<=', $tourDate)->where('rate_valid_to', '>=', $tourDate)->first();
	
	   return $price;
    }

	public static function getVariantPrice($varaintPriceId)
    {
		$price = VariantPrice::where('id', $varaintPriceId)->first();
	   	return $price;
    }
	
	
	public static function getActivityPriceSaveInVoucher($transfer_option,$activity_variant_ids,$agent_id,$adult,$child,$infant,$discount,$tourDate,$zoneAdult=NULL,$zoneChild=NULL,$zoneid=NULL,$actType=NULL)
    {
		
		$adult = ($adult == null) ? 1 : (int) $adult;
		$child = ($child == null) ? 0 : (int) $child;
		$infant = ($infant == null) ? 0 : (int) $infant;
		
		$totalPrice = 0;
		$zonePrice = 0;
		$transferPrice = 0;
		$vatPrice = 0;
		$adult_total_rate = 0;
		$adultPrice = 0;
		$childPrice = 0;
		$infPrice = 0;
		
		$pvtTrafValWithMarkup = 0;
		$data['adultPrice'] = 0;
		$data['childPrice'] = 0;
		$data['infPrice'] = 0;
		$data['activity_vat'] = 0;
		$data['price_id'] = 0;
		$data['pvt_traf_val_with_markup'] = 0;
		$data['zonevalprice_without_markup'] = 0;
		$data['markup_p_ticket_only'] = 0;
		$data['markup_p_sic_transfer'] = 0;
		$data['markup_p_pvt_transfer'] = 0;
		$data['ticketPrice'] = 0;
		$data['transferPrice'] = 0;
		$data['adultTotalPrice'] = 0;
		$data['childTotalPrice'] = 0;
		$data['vat_per'] = 0;
		$data['zonePriceAd'] = 0;
		$data['totalprice'] = 0;
$zonePriceAr = [];
		$totalmember = $adult + $child;
		$vat_invoice = "1";
		// $vat_invoice = $voucher->vat_invoice;
		// $startDate = $voucher->travel_from_date;
		// $endDate = $voucher->travel_to_date;
		$user = auth()->user();

		$activity_variant_id_ar = explode(",",$activity_variant_ids);
		$zonePriceAd = $zonePriceCh = $zonePrice = 0;
		foreach($activity_variant_id_ar as $k => $activity_variant_id)
		{
				$activityVariant = ActivityVariant::with('variant', 'activity')->where("id",$activity_variant_id)->first();
				
				$activity = $activityVariant->activity;
				$variant = $activityVariant->variant;
				$avat = 0;
				if($activity->vat > 0){
				$avat = $activity->vat;	
				}

					
				
				$price = PriceHelper::getActivityVariantPrice($activity_variant_id,$tourDate);
				
				
				/* if($vat_invoice == 1){
					if(!empty($price)){
					$adultPrice = $price->adult_rate_without_vat;
					$childPrice = $price->child_rate_without_vat;
					$infPrice = $price->infant_rate_without_vat;
					}
				} else { */
				$pid = 0;
					if(!empty($price)){
					$adultPrice = $price->adult_rate_with_vat ;
					$childPrice = $price->child_rate_with_vat;
					$infPrice = $price->infant_rate_with_vat;
					$pid = $price->id;
					}
				//}
			
				if(isset($activityVariant->ucode)){
					$markup = SiteHelpers::getAgentMarkup($agent_id,$activityVariant->activity_id,$activityVariant->ucode);
					}else{
						$markup['ticket_only'] = 0;
						$markup['sic_transfer'] = 0;
						$markup['pvt_transfer'] = 0;
						$markup['ticket_only_m'] = 1;
						$markup['sic_transfer_m'] = 1;
						$markup['pvt_transfer_m'] = 1;
					}
					$markupTotal = 0;
					$ticket_markup = $sic_markup = $pvt_markup = 0;
					if($markup['pvt_transfer_m'] == '0')
					{
						$adultPriceMarkupTotal = (int) $markup['ticket_only'] * $adult; // ticket_only as adult
						$childPriceMarkupTotal = (int) $markup['sic_transfer'] * $child; // sic_transfer as child
						$infantPriceMarkupTotal = (int) $markup['pvt_transfer'] * $infant; // pvt_transfer as infant
						$markupTotal = $adultPriceMarkupTotal + $childPriceMarkupTotal + $infantPriceMarkupTotal;
					}
					else
					{
						$ticket_markup  = (int) $markup['ticket_only'];
						$sic_markup  = (int) $markup['sic_transfer'];
						$pvt_markup  = (int) $markup['pvt_transfer'];
					}


			$adultPriceTotal  = ($adultPrice+$ticket_markup) * $adult;
			$childPriceTotal  = ($childPrice+$ticket_markup) * $child;
			$infantPriceTotal  = ($infPrice+$ticket_markup) * $infant;
			$adult_total_rate = $adultPriceTotal + $childPriceTotal + $infantPriceTotal;
			$adult_total_rate = ($adult_total_rate > 0)?$adult_total_rate:0;

			$zonePriceAd = $zonePriceCh = $zonePrice = 0;
					if($variant->sic_TFRS==1)
					{
						
						if((!isset($variant->zones)))
							$variant->zones = "1";
						
						if($zoneAdult > 0)
						{
							if($k == 0)
							{
								$zonePriceAd = 0;
								$zonePriceAd = (@$zoneAdult+$sic_markup) * $adult;
								$zonePriceCh = (@$zoneChild+$sic_markup) * $child;
								$zonePrice = (int) $zonePriceAd + (int) $zonePriceCh;
							}
							else
							{
								$zonePrice = 0;
							}
							
						}
						else
						{
							if($actType == 'Bundle_Same')
							{
								if($k == 0)
								{
									$actZone = SiteHelpers::getZone($variant->zones,$variant->sic_TFRS,$zoneid);
									if(!empty($actZone))
									{
										$zonePriceAd = ($actZone[0]['zoneValue']+$sic_markup) * $adult;
										$zonePriceCh = (@$actZone[0]['zoneValueChild']+$sic_markup) * $child;
										$zonePrice = (int) $zonePriceAd + (int) $zonePriceCh;
									}
								}
							}
							else
							{
								$actZone = SiteHelpers::getZone($variant->zones,$variant->sic_TFRS,$zoneid);
								if(!empty($actZone))
								{
									$zonePriceAd = ($actZone[0]['zoneValue']+$sic_markup) * $adult;
									$zonePriceCh = (@$actZone[0]['zoneValueChild']+$sic_markup) * $child;
									$zonePrice = (int) $zonePriceAd + (int) $zonePriceCh;
								}
							}
						}
						
						
					}
					if($variant->pvt_TFRS==1){
							$td = TransferData::where('transfer_id', $variant->transfer_plan)->where('qty', $totalmember)->first();
							if(!empty($td))
							{
							$transferPrice = ($td->price+$pvt_markup) * $totalmember ;
							}
					}
					$netChildPrice = $netAdultPrice = 0;
					$totalTransferPrice = 0;
					$ticketPrice = $adultPriceTotal + $childPriceTotal  + $infantPriceTotal;
					if($transfer_option == 'Ticket Only'){
						$totalPrice = $ticketPrice;
						$netAdultPrice = ($adultPriceTotal/$adult);
						if($child > 0)
							$netChildPrice = $childPriceTotal/$child;
					} else {
					if($transfer_option == 'Shared Transfer'){
						$totalPrice =  $ticketPrice + $zonePrice;
						$totalTransferPrice = $zonePrice;
						$netAdultPrice = $adultPriceTotal+$zonePriceAd;
						$netChildPrice = $childPriceTotal+$zonePriceCh;

					}elseif($transfer_option == 'Pvt Transfer'){
						$totalPrice = $ticketPrice + $transferPrice;
						$totalTransferPrice = $transferPrice;

						$netAdultPrice = $adultPriceTotal+($transferPrice/$totalmember);
						$netChildPrice = $childPriceTotal+($transferPrice/$totalmember);
					}
					}
					
				
				$grandTotal = $totalPrice + $markupTotal;
				if($vat_invoice == 1){
				//$vatPrice = (($avat/100) * $grandTotal);
				}
				
				//$total = round(($grandTotal+$vatPrice - $discount),2);
				$total = round(($grandTotal),2);
				

				$data['adultPrice'] += $adultPrice;
				$data['childPrice'] += $childPrice;
				$data['adultTotalPrice'] += $netAdultPrice;
				$data['childTotalPrice'] += $netChildPrice;

				$data['infPrice']	+= $infPrice;
				$data['activity_vat'] += $avat;
				$data['price_id'] = $pid;
				$data['zoneAdult'] = $zoneAdult;
				
				$data['zonePriceAd'] += $zonePriceAd;
				
				$data['pvt_traf_val_with_markup'] += $transferPrice;
				$data['zonevalprice_without_markup']  += $zonePrice;
				$data['markup_p_ticket_only'] += $markup['ticket_only'];
				$data['markup_p_sic_transfer'] += $markup['sic_transfer'];
				$data['markup_p_pvt_transfer'] += $markup['pvt_transfer'];
				$data['ticketPrice'] += $ticketPrice;
				$data['transferPrice'] += $totalTransferPrice;
				$data['vat_per']+= $avat;
				$data['totalprice'] += $total;
					
				
				//dd($data);


			}
		return $data;
		
    }
	
		
	
	public static function getActivityPriceByVariant($postData)
    {
		$data = array();
		$data['adultPrice'] = 0;
		$data['childPrice'] = 0;
		$data['infPrice'] = 0;
		$data['activity_vat'] = 0;
		$data['pvt_traf_val_with_markup'] = 0;
		$data['zonevalprice_without_markup'] = 0;
		$data['markup_p_ticket_only'] = 0;
		$data['markup_p_sic_transfer'] = 0;
		$data['markup_p_pvt_transfer'] = 0;
		$data['adultTotalPrice'] = 0;
		$data['childTotalPrice'] = 0;
		$data['infTotalPrice'] = 0;
		$data['totalprice'] = 0;
		

		$currency = SiteHelpers::getCurrencyPrice();
		$transfer_option = (isset($postData['transfer_option']))?$postData['transfer_option']:0;
		$activity_variant_ids = (isset($postData['activity_variant_id']))?$postData['activity_variant_id']:0;
		$agent_id = (isset($postData['agent_id']))?$postData['agent_id']:0;
		$voucherId = (isset($postData['voucherId']))?$postData['voucherId']:0;
		$adult = (isset($postData['adult']) && $postData['adult'] > 0)?(int)$postData['adult']:0;
		$child = (isset($postData['child']) && $postData['child'] > 0)?(int)$postData['child']:0;
		$infant = (isset($postData['infant']) && $postData['infant'] > 0)?(int)$postData['infant']:0;
		$tourDate = (isset($postData['tourDate']))?date("Y-m-d",strtotime($postData['tourDate'])):0;
		$discount = (isset($postData['discount']))?$postData['discount']:0;
		$zonevalue = (isset($postData['zonevalue']))?$postData['zonevalue']:1;
		$zoneValueChild = (isset($postData['zoneValueChild']))?$postData['zoneValueChild']:1;
		$activityType = (isset($postData['activityType']))?$postData['activityType']:"activityType";
		$activity_variant_id_ar = explode(",",$activity_variant_ids);
		
		
			$data = PriceHelper::getActivityPriceSaveInVoucher($transfer_option,$activity_variant_ids,$agent_id,$adult,$child,$infant,"0",$tourDate,$zonevalue,$zoneValueChild,"",$activity_variant_id_ar);
	
		
		
	
		
	
		return $data;
		
    }
	

	public static function getActivityPriceByVariantOld($postData)
    {
		$data = array();
		$data['adultPrice'] = 0;
		$data['childPrice'] = 0;
		$data['infPrice'] = 0;
		$data['activity_vat'] = 0;
		$data['pvt_traf_val_with_markup'] = 0;
		$data['zonevalprice_without_markup'] = 0;
		$data['markup_p_ticket_only'] = 0;
		$data['markup_p_sic_transfer'] = 0;
		$data['markup_p_pvt_transfer'] = 0;
		$data['adultTotalPrice'] = 0;
		$data['childTotalPrice'] = 0;
		$data['infTotalPrice'] = 0;
		$data['totalprice'] = 0;
		

		$currency = SiteHelpers::getCurrencyPrice();
		$transfer_option = (isset($postData['transfer_option']))?$postData['transfer_option']:0;
		$activity_variant_ids = (isset($postData['activity_variant_id']))?$postData['activity_variant_id']:0;
		$agent_id = (isset($postData['agent_id']))?$postData['agent_id']:0;
		$voucherId = (isset($postData['voucherId']))?$postData['voucherId']:0;
		$adult = (isset($postData['adult']) && $postData['adult'] > 0)?(int)$postData['adult']:0;
		$child = (isset($postData['child']) && $postData['child'] > 0)?(int)$postData['child']:0;
		$infant = (isset($postData['infant']) && $postData['infant'] > 0)?$postData['infant']:0;
		$tourDate = (isset($postData['tourDate']))?date("Y-m-d",strtotime($postData['tourDate'])):0;
		$discount = (isset($postData['discount']))?$postData['discount']:0;
		$zonevalue = (isset($postData['zonevalue']))?$postData['zonevalue']:1;
		$zoneValueChild = (isset($postData['zoneValueChild']))?$postData['zoneValueChild']:1;
		$activity_variant_id_ar = explode(",",$activity_variant_ids);
		foreach($activity_variant_id_ar as $k => $activity_variant_id)
		{
		$adultTotalPrice = 0;
		$childTotalPrice = 0;
		$infantTotalPrice = 0;
		$totalPrice = 0;
		$zonePrice = 0;
		$transferPrice = 0;
		$vatPrice = 0;
		$adult_total_rate = 0;
		$adultPrice = 0;
		$childPrice = 0;
		$infPrice = 0;
		$pvtTrafValWithMarkup = 0;
		$totalmember = $adult + $child;
		$voucher = Voucher::where("id",$voucherId)->first();
		$vat_invoice = $voucher->vat_invoice;
		$startDate = $voucher->travel_from_date;
		$endDate = $voucher->travel_to_date;
		$user = auth()->user();
		$activityVariant = ActivityVariant::with('variant', 'activity')->where("id",$activity_variant_id)->first();
		$grandTotal = 0;
		$total = 0;
		$activity = $activityVariant->activity;
		$variant = $activityVariant->variant;
		$avat = 0;
		if($activity->vat > 0){
		$avat = $activity->vat;	
		}
		
		if(isset($activityVariant->ucode)){
			$markup = SiteHelpers::getAgentMarkup($agent_id,$activityVariant->activity_id, $activityVariant->ucode);
		}else{
			$markup['ticket_only'] = 0;
			$markup['sic_transfer'] = 0;
			$markup['pvt_transfer'] = 0;
			$markup['ticket_only_m'] = 1;
			$markup['sic_transfer_m'] = 1;
			$markup['pvt_transfer_m'] = 1;
		}

				
		$price = PriceHelper::getActivityVariantPrice($activity_variant_id,$tourDate);
		
		if(!empty($price)){
		
				/* if($vat_invoice == 1){
					if(!empty($price)){
					$adultPrice = $price->adult_rate_without_vat;
					$childPrice = $price->child_rate_without_vat;
					$infPrice = $price->infant_rate_without_vat;
					}
				} else {
			
					if(!empty($price)){ */
					$adultPrice = $price->adult_rate_with_vat ;
					$childPrice = $price->child_rate_with_vat;
					$infPrice = $price->infant_rate_with_vat;
					/* }
				} */

				$ticket_markup = $sic_markup = $pvt_markup = 0;
			if($markup['pvt_transfer_m'] == '0')
			{
				$adultPriceMarkupTotal = (int) $markup['ticket_only'] * $adult; // ticket_only as adult
				$childPriceMarkupTotal = (int) $markup['sic_transfer'] * $child; // sic_transfer as child
				$infantPriceMarkupTotal = (int) $markup['pvt_transfer'] * $infant; // pvt_transfer as infant
				$markupTotal = $adultPriceMarkupTotal + $childPriceMarkupTotal + $infantPriceMarkupTotal;
			}
			else
			{
				$ticket_markup  = (int) $markup['ticket_only'];
				$sic_markup  = (int) $markup['sic_transfer'];
				$pvt_markup  = (int) $markup['pvt_transfer'];
			}
			
				$adultPriceTotal  = ($adultPrice+$ticket_markup) * $adult;
				$childPriceTotal  = ($childPrice+$ticket_markup) * $child;
				$infantPriceTotal  = ($infPrice * $infant);
				$adult_total_rate = $adultPriceTotal + $childPriceTotal + $infantPriceTotal;
				$adult_total_rate = ($adult_total_rate > 0)?$adult_total_rate:0;
				
				$markupTotal = 0;
			

				
				// $adultPriceMarkupTotal = $markup['ticket_only'] * $adult; // ticket_only as adult
				// $childPriceMarkupTotal = $markup['sic_transfer'] * $child; // sic_transfer as child
				// $infantPriceMarkupTotal = $markup['pvt_transfer'] * $infant; // pvt_transfer as infant
				// $markupTotal = $adultPriceMarkupTotal + $childPriceMarkupTotal + $infantPriceMarkupTotal;
				$zonePricePerMember = 0;
				$zonePricePerMemberCH = 0;
				$transferPricePerMember = 0;
					if($variant->sic_TFRS==1){
						$zonePriceAD = (int)$zonevalue * $adult;
						$zonePriceCH = (int)$zoneValueChild * $child;
						$zonePrice = $zonePriceAD + $zonePriceCH;
						$zonePricePerMember = $zonevalue;
						$zonePricePerMemberCH = (int)$zoneValueChild;
					}
					
					if($variant->pvt_TFRS==1){
							$td = TransferData::where('transfer_id', $variant->transfer_plan)->where('qty', $totalmember)->first();
							if(!empty($td))
							{
							 $transferPrice = $td->price * $totalmember ;
							 $transferPricePerMember = $td->price;
							}
					}
					
					$ticketPrice = $adultPriceTotal + $childPriceTotal  + $infantPriceTotal;
					$adultTotalPrice = $adultPrice+$markup['ticket_only'];
				$childTotalPrice = $childPrice+$markup['sic_transfer'];
				$infantTotalPrice = $infPrice+$markup['pvt_transfer'];
				
					if($transfer_option == 'Ticket Only'){
						$totalPrice = $ticketPrice;
					} else {
					if($transfer_option == 'Shared Transfer'){
						$totalPrice =  $ticketPrice + $zonePrice;
						$adultTotalPrice += $zonePricePerMember;
						$childTotalPrice += $zonePricePerMemberCH;
						$infantTotalPrice += $zonePricePerMember;
					}elseif($transfer_option == 'Pvt Transfer'){

						  $totalPrice = $ticketPrice + $transferPrice;
						  $adultTotalPrice += $transferPricePerMember;
						  $childTotalPrice += $transferPricePerMember;
						$infantTotalPrice += $transferPricePerMember;
					}
					}
					
				
				$grandTotal = $totalPrice + $markupTotal;
				if($vat_invoice == 1){
				$vatPrice = (($avat/100) * $grandTotal);
				}
				
				//$total = round(($grandTotal+$vatPrice - $discount),2);
				$subTotal = $grandTotal;
				//$subTotal = $grandTotal+round($vatPrice,2);
				$priceConvert = $subTotal * round(($currency['value']),2);
				$total = round(($priceConvert),2);
				
				
		}
		
		$data['adultPrice'] += $zonePricePerMemberCH;
		$data['childPrice'] += $childPrice;
		$data['infPrice']	+= $infant;
		$data['activity_vat'] = $avat;
		$data['zone_value'] = $zonevalue;
		$data['pvt_traf_val_with_markup'] += $transferPrice;
		$data['zonevalprice_without_markup']  += $zonePrice;
		$data['markup_p_ticket_only'] += $markup['ticket_only'];
		$data['markup_p_sic_transfer'] += $markup['sic_transfer'];
		$data['markup_p_pvt_transfer'] += $markup['pvt_transfer'];
		$data['adultTotalPrice'] += $adultTotalPrice;
		$data['childTotalPrice'] += $childTotalPrice;
		$data['infTotalPrice']+= $infantTotalPrice;
		$data['totalprice'] += $total;
		$data['p'][$k] = $subTotal;
		$data['to'][$k] = $transfer_option;
		
	}
		return $data;
		
    }
	
	
	public static function getTotalTicketCostAllType($id) 
	{
		$voucherActivity = VoucherActivity::where('id',$id)->first();
		$returnTotalPrice = 0;
		if(!empty($voucherActivity)){
			$totalPrice = $voucherActivity->totalprice;
			$discounTkt = $voucherActivity->discount_tkt;
			$discountTrns = $voucherActivity->discount_sic_pvt_price;
			$totalDiscount = $discounTkt + $discountTrns;
			$returnTotalPrice = $totalPrice - $totalDiscount;
		}
		
		return $returnTotalPrice;
	}
	
	public static function getTotalCostTicketOnly($vid) 
	{
		$voucherActivity = VoucherActivity::where('id',$vid)->first();
		$returnTotalPrice = 0;
		if(!empty($voucherActivity)){
			$totalPrice = $voucherActivity->original_tkt_rate;
			$discounTkt = $voucherActivity->discount_tkt;
			$returnTotalPrice = $totalPrice - $discounTkt;
		}
		
		return $returnTotalPrice;
	}

	public static function getTotalActivitySP($vid,$aid) 
	{
		$totalprice = VoucherActivity::where('voucher_id',$vid)->where('activity_id',$aid)->sum("totalprice");
			
		return $totalprice;
	}
	
	public static function getTicketAllTypeCost($id) 
{
    $voucherActivity = VoucherActivity::where('id', $id)->first();
    $returnTotalPrice = [
        'totalPrice' => 0,
        'tkt_price' => 0,
        'trns_price' => 0,
        'discounTkt' => 0,
        'discountTrns' => 0,
        'totalPriceAfDis' => 0,
        'tkt_priceAfDis' => 0,
        'trns_priceAfDis' => 0,
        'totalDiscount' => 0,
    ];
	
    if (!empty($voucherActivity)) {
        $totalPrice = $voucherActivity->totalprice;
        $discounTkt = $voucherActivity->discount_tkt;
        $discountTrns = $voucherActivity->discount_sic_pvt_price;
        $totalDiscount = $discounTkt + $discountTrns;

        // Calculate total price after discount
        $returnTotalPrice['totalPriceAfDis'] = $totalPrice - $totalDiscount;
        $tkt_priceAfDis = $voucherActivity->original_tkt_rate - $discounTkt;
		$trns_priceAfDis = $voucherActivity->original_trans_rate - $discountTrns;
        // Assign values to array keys
        $returnTotalPrice['totalPrice'] = ($totalPrice)?$totalPrice:0;
        $returnTotalPrice['tkt_price'] = ($voucherActivity->original_tkt_rate)?$voucherActivity->original_tkt_rate:0;
        $returnTotalPrice['trns_price'] = ($voucherActivity->original_trans_rate)?$voucherActivity->original_trans_rate:0;
        $returnTotalPrice['discounTkt'] = ($discounTkt)?$discounTkt:0;
        $returnTotalPrice['discountTrns'] = ($discountTrns)?$discountTrns:0;
        $returnTotalPrice['totalDiscount'] = ($totalDiscount)?$totalDiscount:0;
        $returnTotalPrice['tkt_priceAfDis'] = ($tkt_priceAfDis)?$tkt_priceAfDis:0;
        $returnTotalPrice['trns_priceAfDis'] = ($trns_priceAfDis)?$trns_priceAfDis:0;
		
    }

    return $returnTotalPrice;
}

	
	
	public static function getRefundAmountAfterCancellation($voucherActivityId)
	{
    $totalPrice = self::checkCancellation($voucherActivityId);
    // $voucherActivity = VoucherActivity::where('id', $voucherActivityId)->first();
	
    // $cancelData = json_decode($voucherActivity->cancellation_chart);
	// $timeSlot = $voucherActivity->time_slot;
	// if (!empty($timeSlot)) 
	// {
	// $bookingDate = Carbon::parse($voucherActivity->booking_date);
	// list($hours, $minutes) = explode(':', $timeSlot);
	// $bookingDate->setTime($hours, $minutes, 0);
	// $cancelDate = Carbon::parse($voucherActivity->canceled_date);
	// } else 
	// {
	// $bookingDate = Carbon::parse($voucherActivity->booking_date);
	// $cancelDate = Carbon::parse($voucherActivity->canceled_date);
	// }
    // $minutesDifference = $bookingDate->diffInMinutes($cancelDate);
	// //dd($cancelDate);
	$returnTotalPrice = array();
	$tkt_priceAfDis = 	0;
	$trns_priceAfDis = 	0;
    $returnTotalPrice = [
        'refund_tkt_priceAfDis' => $tkt_priceAfDis,
        'refund_trns_priceAfDis' => $trns_priceAfDis,
    ];
	
	//dd($refundAmount);
    return $returnTotalPrice;
	}
	
public static function checkCancellation($voucherActivityId)
{
    $voucherActivity = VoucherActivity::where('id', $voucherActivityId)->first();
	$valid_time = "";
    $cancellation = json_decode($voucherActivity->cancellation_chart);
	$data = array();
	if($voucherActivity->cancellation_chart == '[]')
	{
		$data['ticketDownloaded'] = "0"; // Assuming this is some value you need to set
			$data['btm'] = "0"; // Cancellation not allowed
		
		// Include debugging information in the response
		$data['debug'] = array();
		$data['refundamt'] = 0 ;
		
		return $data;
	}
	else
	{
		$startHours = 0;
		$variant = Variant::where('ucode', $voucherActivity->variant_code)->first();

		if (!$voucherActivity) {
			return response()->json(['error' => 'Voucher activity not found'], 404);
		}

		$timeSlot = $voucherActivity->time_slot;
		if (!empty($timeSlot)) {
			$tourDate = strtotime($voucherActivity->tour_date . ' ' . $timeSlot);
		} 
		elseif($variant->start_time != '')
		{
			$timeSlot = $variant->start_time;
			$tourDate = strtotime($voucherActivity->tour_date . $variant->start_time); // Set time to the start of the day
		}
		else {
			$timeSlot = "00:00:00";
			$tourDate = strtotime($voucherActivity->tour_date . "00:00:00"); // Set time to the start of the day
		}
		$currentDate = time();
		//$currentDate = strtotime("30-07-2024 10:00");
		$hourdiff = round(($tourDate - $currentDate)/3600, 1);



					
					$ticketDownloaded = $voucherActivity->ticket_downloaded;
					$tkt_amt = $voucherActivity->original_tkt_rate-$voucherActivity->discount_tkt;
					$trf = $voucherActivity->original_trans_rate-$voucherActivity->discount_sic_pvt_price;
					$atotal_amt = $trf+$tkt_amt;
					if($ticketDownloaded == '1')
						$tkt_amt = 0;
					$total_amt = $trf+$tkt_amt;
					
					$cancellation_array_val = $cancellation_array = array();
					if(!empty($cancellation))
					{
						foreach ($cancellation as $ar_key => $ca) 
						{	
							$ticket_refund_per = $ca->ticket_refund_value;
							$trns_refund_per = $ca->transfer_refund_value;
							
							$startHours = $endHours = 0;
							if($ca->duration =='72+')
							{
								$startHours ='72';
								$endHours = 0;
							}
							else
							{
								$durationParts = explode('-', $ca->duration);
								$startHours = intval($durationParts[0]);
								$endHours = intval($durationParts[1] ?? PHP_INT_MAX);
							}
							$tkt_refund = ($tkt_amt * $ticket_refund_per) / 100;
							$trf_refund = ($trf * $trns_refund_per)/ 100;
				
							$total_refund = round(($tkt_refund+$trf_refund),2);
							$cancellation_array[$total_refund][$startHours] = $startHours;
							if($endHours > 0)
								$cancellation_array[$total_refund][$endHours] = $endHours;
							$cancellation_array_val[$total_refund]['tkt'] = $tkt_refund;
							$cancellation_array_val[$total_refund]['trf'] = $trf_refund;
							
							if(($ticket_refund_per == 100) && ($trns_refund_per == 100))
								break;

						}
					}
					
					$rk = 0;
					$cancellation_data = array();
					
					$free_cancel_till = "";
					$data['validuptoTime']  = "";
					$refund_type = "0";
					$refundAmt = "-1";
					if(!empty($cancellation_array_val))
					{
						krsort($cancellation_array_val);
					
					foreach($cancellation_array_val as $v => $ak)
					{
						
						$k = $cancellation_array[$v];
						$first_key = key($k);
						$startHours = $k[$first_key];
						$endHours = end($k);
						
						if(($startHours == 0) || ($v == 0))
						{
							if($currentDate > ($tourDate-((($endHours)*60*60))))
							{
								if($refundAmt < 0)
									$refundAmt = $v;
								$refund_type = 0;
							}
							
							$cancellation_data[$rk]['refund_amt'] = $v;
							$cancellation_data[$rk]['start_time'] = date('M d,Y H:i',($tourDate-((($endHours)*60*60))));
							$cancellation_data[$rk]['end_time'] = "or Later";
						}
						elseif(($v == $total_amt))
						{
							if($currentDate <= ($tourDate-((($startHours)*60*60))))
							{
								$refund_type = "2";
								if($refundAmt < 0)
									$refundAmt = $v;
								if($v == $atotal_amt)
									$refund_type = "1";
							}
						
							$cancellation_data[$rk]['refund_amt'] = $v;
							$cancellation_data[$rk]['start_time'] = "Before of Upto";
							$cancellation_data[$rk]['end_time'] = date('M d,Y H:i',($tourDate-((($startHours)*60*60))));
							$data['validuptoTime']  = $cancellation_data[$rk]['end_time'];
						}
						else
						{
							if(($currentDate >= ($tourDate-((($startHours)*60*60)))) && (($currentDate < ($tourDate-((($endHours)*60*60))))))
							{
								$refund_type = "2";
								if($refundAmt < 0)
									$refundAmt = $v;
							}
							elseif(($currentDate < ($tourDate-((($startHours)*60*60)))))
							{
								$refund_type = "2";
								if($refundAmt < 0)
									$refundAmt = $v;
							}
							$cancellation_data[$rk]['refund_amt'] = $v;
							$cancellation_data[$rk]['currentDate'] = date('M d,Y H:i',($currentDate));
							$cancellation_data[$rk]['startHours'] = $startHours;
							$cancellation_data[$rk]['endHours'] = $endHours;
							$cancellation_data[$rk]['start_time'] = date('M d,Y H:i',($tourDate-((($endHours)*60*60))));
							$cancellation_data[$rk]['end_time'] = date('M d,Y H:i',($tourDate-((($startHours)*60*60))));
						
						}
						
						$rk++;
					}
				}
	
		
			$data['ticketDownloaded'] = $ticketDownloaded; // Assuming this is some value you need to set
			$data['btm'] = $refund_type; // Cancellation not allowed
		
		// Include debugging information in the response
		$data['debug'] = $cancellation_data;
		$data['c_debug'] = $voucherActivity->cancellation_chart;
		$data['refundamt'] =$refundAmt;
		if(!empty($cancellation_array_val))
			$data['refundamt'] = $cancellation_array_val[$refundAmt];

		return $data;
	}
}




}
