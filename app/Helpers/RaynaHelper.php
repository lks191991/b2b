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
                    $slots[$slot['timeSlot']] = $slot['timeSlot'];
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
	
	public static function tourBooking($voucher, $va)
	{
		$variant = $va->variant;
		$touroption = self::getTourOptionById($variant->touroption_id);
		$fullName = $voucher->guest_name ?? "";
		$nameParts = explode(" ", trim($fullName), 2);

		$postData = [
			"uniqueNo" => (int) ($voucher->id ?? 0),
			"TourDetails" => [
				[
					"serviceUniqueId" => (int) ($voucher->id ?? 0),
					"tourId" => (int) ($touroption['tourId'] ?? 0),
					"optionId" => (int) ($touroption['optionId'] ?? 0),
					"adult" => (int) ($va->adult ?? 1),
					"child" => (int) ($va->child ?? 0),
					"infant" => (int) ($va->infant ?? 0),
					"tourDate" => !empty($va->tour_date) ? date("Y-m-d", strtotime($va->tour_date)) : "2025-02-25",
					"timeSlotId" => 0,
					"startTime" => !empty($va->time_slot) ? date("h:i A", strtotime($va->time_slot)) : "10:00 AM",
					"transferId" => 41865,
					"pickup" => $va->pickup_location ?? "Hotel XYZ",
					"adultRate" => (float) ($va->adultPrice ?? 100.50),
					"childRate" => (float) ($va->childPrice ?? 50.25),
					"serviceTotal" => (float) (($va->adultPrice ?? 100.50) + ($va->childPrice ?? 50.25)),
				]
			],
			"passengers" => [
				[
					"serviceType" => "Tour",
					"prefix" => "Mr",
					"firstName" => $nameParts[0] ?? "",
					"lastName" => $nameParts[1] ?? "", 
					"email" => $voucher->guest_email ?? "",
					"mobile" => $voucher->guest_phone ?? "",
					"nationality" => "UAE",
					"message" => $voucher->remark ?? "Looking forward to the tour",
					"leadPassenger" => true,
					"paxType" => "Adult",
					"clientReferenceNo" => $voucher->agent_ref_no ?? "",
				]
			]
		];

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
            }
			
			 return true;
        }
    }

    return false;
	}

}
