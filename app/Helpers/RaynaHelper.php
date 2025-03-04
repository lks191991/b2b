<?php

namespace App\Helpers;

use Ramsey\Uuid\Uuid;
use DB;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\Http;
use App\Models\tourOptionStaticData;
use App\Models\Tourstaticdata;
use App\Models\VoucherActivity;

class RaynaHelper
{
    protected static $token = 'eyJhbGciOiJodHRwOi8vd3d3LnczLm9yZy8yMDAxLzA0L3htbGRzaWctbW9yZSNobWFjLXNoYTI1NiIsInR5cCI6IkpXVCJ9.eyJqdGkiOiJkNWU4YWZhMC1mNGJhLTQ2NWUtYTAzOS1mZGJiYzMxZWZlZGUiLCJVc2VySWQiOiIzNzU0NSIsIlVzZXJUeXBlIjoiQWdlbnQiLCJQYXJlbnRJRCI6IjAiLCJFbWFpbElEIjoidHJhdmVsZ2F0ZXhAcmF5bmF0b3Vycy5jb20iLCJpc3MiOiJodHRwOi8vcmF5bmFhcGkucmF5bmF0b3Vycy5jb20iLCJhdWQiOiJodHRwOi8vcmF5bmFhcGkucmF5bmF0b3Vycy5jb20ifQ.i6GaRt-RVSlJXKPz7ZVx-axAPLW_hkl7usI_Dw8vP5w'; 
    public static  function getTourDetailsById($id)
    {
        if(!empty($id)){
            return Tourstaticdata::where('tourId',  $id)->select(['tourId', 'tourName', 'contractId', 'isSlot'])->first(); 
        }
        return false;
    }

    public static  function getTourOptionById($id)
    {
        if(!empty($id)){
            return  tourOptionStaticData::where('tourOptionId',  $id)
            ->select(['tourOptionId', 'optionName', 'contractId', 'tourId'])->first(); 
        }
       
        return false;
    }
   
    public static  function getSlot($postData)
    {
        $slots = [];
        $url = "https://sandbox.raynatours.com/api/Tour/timeslot";
        $token = config('services.rayna.token');
        $response = Http::withOptions(['verify' => false])
			->withHeaders([
				"Content-Type" => "application/json",
				"Authorization" => "Bearer " . trim($token),
				"Accept" => "application/json",
				"User-Agent" => "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36"
			])
			->post($url, $postData);

        if ($response->successful()) {
            $data = $response->json();
            if (isset($data['statuscode']) && $data['statuscode'] == 200) {
                foreach ($data['result'] as $slot) {
                    $slots[$slot['timeSlotId']] = $slot['timeSlot'];
                }
            } 
        }

        return $slots;
    }
	
	public static  function getTourAvailability($variantTouroptionId,$payload=[])
    {
        $touroption = self::getTourOptionById($variantTouroptionId);
		$pData = [   
        "tourId"       => (int) ($touroption['tourId'] ?? 0),
        "tourOptionId" => (int) ($touroption['tourOptionId'] ?? 0),
        "transferId"   => 41865,
        "contractId"   => (int) ($touroption['contractId'] ?? 0),
        "travelDate"   => $payload['travelDate'] ?? '',
        "adult"        => (int) ($payload['adult'] ?? 1),
        "child"        => (int) ($payload['child'] ?? 0),
        "infant"       => (int) ($payload['infant'] ?? 0)
        
		];

        $data = [];
        $url = "https://sandbox.raynatours.com/api/Tour/availability";
        $token = config('services.rayna.token');
        $response = Http::withOptions(['verify' => false])
			->withHeaders([
				"Content-Type" => "application/json",
				"Authorization" => "Bearer " . trim($token),
				"Accept" => "application/json",
				"User-Agent" => "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36"
			])
			->post($url, $pData);

       if ($response->successful()) {
            $data = $response->json();
            
            if (($data['statuscode'] ?? null) === 200) {
                if (!empty($data['result']) && ($data['result']['status'] ?? 0) > 0) {
                    return [
                        'status' => true,
                        'message' => '',
                    ];
                }
                return [
                    'status' => false,
                    'message' => $data['result']['message'] ?? 'No message available',
                ];
            }
            
            return [
                'status' => false,
                'message' => $data['error_description'] ?? 'Unknown error occurred',
            ];
            
        }


        return false;
    }
	
	public static function tourBooking($voucher)
	{
		
		$tourData = self::makeTourServicePayload($voucher);
		
		$postData = [
			"uniqueNo" => (int) ($voucher->id ?? 0),
			"TourDetails" => $tourData['tour'],
			"passengers" => $tourData['passengers']
		];
		echo(json_encode($postData));
exit;

		$url = "https://sandbox.raynatours.com/api/Booking/bookings";
		$token = config('services.rayna.token');
		
		$response = Http::withOptions(['verify' => false])
			->withHeaders([
				"Content-Type" => "application/json",
				"Authorization" => "Bearer " . trim($token),
				"Accept" => "application/json",
				"User-Agent" => "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36"
			])
			->post($url, $postData);
echo(json_encode($postData));
exit;
    if ($response->successful()) {
        $data = $response->json();

        if (isset($data['statuscode']) && $data['statuscode'] == 200) {
            $bookings = $data['result'];

            if (!empty($bookings)) { 
                foreach ($bookings as $booking) {
                    $voucherActivity = VoucherActivity::where('id', $va->id)->first();

                    if ($voucherActivity) {
                        $voucherActivity->update([
                            'rayna_bookingId' => $booking['bookingId'] ?? null,
                            'rayna_booking_details' => json_encode($booking)
                        ]);
                    }
                }
				
				 return true;
            } else {
				return false;
			}
			
			
        }
    }

    return false;
	}
	
	public static function makeTourServicePayload($voucher)
	{
		$voucherActivity = VoucherActivity::with("variant")->where('voucher_id', $voucher->id)->where('isRayna', true)->get();
		$fullName = $voucher->guest_name ?? "";
		$nameParts = explode(" ", trim($fullName), 2);
		$data = [];
		$tour = [];
		$passengers = [];
		foreach($voucherActivity as $vac){
		$variant = $vac->variant;
		$touroption = self::getTourOptionById($variant->touroption_id);
		$tour[] = [
					"serviceUniqueId" => mt_rand(100000, 999999),
					"tourId" => (int) ($touroption['tourId'] ?? 0),
					"optionId" => (int) ($touroption['tourOptionId'] ?? 0),
					"adult" => (int) ($vac->adult ?? 1),
					"child" => (int) ($vac->child ?? 0),
					"infant" => (int) ($vac->infant ?? 0),
					"tourDate" => !empty($vac->tour_date) ? (string) date("Y-m-d", strtotime($vac->tour_date)) : "2025-02-25",
					"timeSlotId" =>(int) $vac->timeSlotId,
					"startTime" => !empty($vac->time_slot) ? (string) date("h:i A", strtotime($vac->time_slot)) : "10:00 AM",
					"transferId" => 41865,
					"pickup" => (string) $vac->pickup_location ?? "Hotel XYZ",
					"adultRate" => ($vac->adult > 0 && isset($vac->adultPrice)) ? (float) ($vac->adultPrice * $vac->adult) : 0.00,
					"childRate" => ($vac->child > 0 && isset($vac->childPrice)) ? (float) ($vac->childPrice * $vac->child) : 0.00,
					"serviceTotal" => (string) ($vac->totalprice ?? 0.00),
		];
		
		$passengers[] = [
					"serviceType" => "Tour",
					"prefix" => $voucher->guest_salutation ?? "Mr",
					"firstName" => $nameParts[0] ?? "",
					"lastName" => $nameParts[1] ?? "", 
					"email" => $voucher->guest_email ?? "",
					"mobile" => $voucher->guest_phone ?? "",
					"nationality" => "UAE",
					"message" => $voucher->remark ?? "Looking forward to the tour",
					"leadPassenger" => 1,
					"paxType" => "Adult",
					"clientReferenceNo" => $voucher->agent_ref_no ?? "",
				];
		}
		
		$data['tour'] = $tour;
		$data['passengers'] = $passengers;
		
		return $data;
	}

}
