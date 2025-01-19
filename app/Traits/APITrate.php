<?php

namespace App\Traits;
use App\Models\Voucher;
use App\Models\VoucherActivity;
use App\Models\ActivityVariant;
use App\Models\Ticket;
use Carbon\Carbon;
use PriceHelper;
use SiteHelpers;
use App\Models\TransferData;

trait APITrate
{
	public static function getActivityPriceSaveInVoucher(
		$transfer_option,
		$activity_variant_id,
		$agent_id,
		$voucher,
		$u_code,
		$adult = 0,
		$child = 0,
		$infant = 0,
		$discount = 0,
		$tourDate
	) {
		// Ensure numeric values for inputs
		$adult = (int) $adult;
		$child = (int) $child;
		$infant = (int) $infant;
	
		// Initialize variables
		$totalMembers = $adult + $child;
		$vatInvoice = $voucher->vat_invoice;
		$totalPrice = $transferPrice = $zonePrice = $vatPrice = $markupTotal = 0;
	
		// Fetch activity variant details with related models
		$activityVariant = ActivityVariant::with('variant', 'activity')
			->find($activity_variant_id);
	
		if (!$activityVariant) {
			return self::emptyPricingResponse($activity_variant_id, $adult, $child, $infant);
		}
	
		$activity = $activityVariant->activity;
		$variant = $activityVariant->variant;
		$vatPercentage = $activity->vat ?? 0;
	
		// Fetch pricing details
		$price = PriceHelper::getActivityVariantPrice($activity_variant_id, $tourDate);
		if (!$price) {
			return self::emptyPricingResponse($activity_variant_id, $adult, $child, $infant);
		}
	
		// Calculate individual prices
		$adultPrice = $price->adult_rate_with_vat ?? 0;
		$childPrice = $price->child_rate_with_vat ?? 0;
		$infPrice = $price->infant_rate_with_vat ?? 0;
	
		// Calculate total ticket price
		$ticketPrice = ($adultPrice * $adult) + ($childPrice * $child) + ($infPrice * $infant);
	
		// Fetch markup details
		$markup = SiteHelpers::getAgentMarkup($agent_id, $activityVariant->activity_id, $activityVariant->ucode ?? '') ?? [
			'ticket_only' => 0,
			'sic_transfer' => 0,
			'pvt_transfer' => 0,
		];
	
		$markupTotal = ($markup['ticket_only'] * $adult) +
					   ($markup['sic_transfer'] * $child) +
					   ($markup['pvt_transfer'] * $infant);
	
		// Calculate transfer price based on option
		if ($transfer_option === 'Shared Transfer') {
			$zonePrice = self::getZonePrice($variant->zones, $variant->sic_TFRS, $totalMembers);
			$totalPrice = $ticketPrice + $zonePrice;
			$transferPrice = $zonePrice;
		} elseif ($transfer_option === 'Pvt Transfer') {
			$transferPrice = self::getPrivateTransferPrice($variant->transfer_plan, $totalMembers);
			$totalPrice = $ticketPrice + $transferPrice;
		} else {
			$totalPrice = $ticketPrice; // Ticket Only
		}
	
		// Calculate VAT if applicable
		if ($vatInvoice === 1) {
			$vatPrice = ($vatPercentage / 100) * ($totalPrice + $markupTotal);
		}
	
		$grandTotal = round($totalPrice + $markupTotal + $vatPrice - $discount, 2);
	
		// Prepare response data
		return [
			'adultPrice' => $adultPrice,
			'childPrice' => $childPrice,
			'infPrice' => $infPrice,
			'activity_vat' => $vatPercentage,
			'pvt_traf_val_with_markup' => $transferPrice,
			'zonevalprice_without_markup' => $zonePrice,
			'markup_p_ticket_only' => $markup['ticket_only'],
			'markup_p_sic_transfer' => $markup['sic_transfer'],
			'markup_p_pvt_transfer' => $markup['pvt_transfer'],
			'ticketPrice' => $ticketPrice,
			'transferPrice' => $transferPrice,
			'vat_per' => $vatPercentage,
			'totalprice' => $grandTotal,
		];
	}
	
	private static function emptyPricingResponse($activity_variant_id, $adult, $child, $infant)
	{
		return [
			'variantCode' => $activity_variant_id,
			'activity_variant_id' => $activity_variant_id,
			'adult' => $adult,
			'child' => $child,
			'infant' => $infant,
			'ticketPrice' => 0,
			'transferPrice' => 0,
			'perAdultPrice' => 0,
			'perChildPrice' => 0,
			'perInfPrice' => 0,
			'adultPriceTotal' => 0,
			'childPriceTotal' => 0,
			'infPriceTotal' => 0,
			'totalprice' => 0,
		];
	}
	
	private static function getZonePrice($zones, $sic_TFRS, $totalMembers)
	{
		if ($sic_TFRS) {
			$zone = SiteHelpers::getZone($zones, $sic_TFRS);
			if (!empty($zone)) {
				return $zone[0]['zoneValue'] * $totalMembers;
			}
		}
		return 0;
	}
	
	private static function getPrivateTransferPrice($transferPlan, $totalMembers)
	{
		$transferData = TransferData::where('transfer_id', $transferPlan)
			->where('qty', $totalMembers)
			->first();
	
		return $transferData ? ($transferData->price * $totalMembers) : 0;
	}
	


}
