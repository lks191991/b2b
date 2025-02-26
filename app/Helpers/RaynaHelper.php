<?php

namespace App\Helpers;

use Ramsey\Uuid\Uuid;
use DB;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\Http;
use App\Models\tourOptionStaticData;
use App\Models\Tourstaticdata;

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
	
	public static  function getTourBook($payload)
    {
			$postData = [
			"uniqueNo" => (int) ($payload['uniqueNo'] ?? 0),
			"TourDetails" => [
				[
					"serviceUniqueId" => (int) ($payload['serviceUniqueId'] ?? 0), 
					"tourId" => (int) ($payload['tourId'] ?? 0), 
					"optionId" => (int) ($payload['optionId'] ?? 0), 
					"adult" => (int) ($payload['adult'] ?? 1),
					"child" => (int) ($payload['child'] ?? 0), 
					"infant" => (int) ($payload['infant'] ?? 0),
					"tourDate" => $payload['tourDate'] ?? "2025-02-25",
					"timeSlotId" => (int) ($payload['timeSlotId'] ?? 5),
					"startTime" => $payload['startTime'] ?? "10:00 AM",
					"transferId" => (int) ($payload['transferId'] ?? 303),
					"pickup" => $payload['pickup'] ?? "Hotel XYZ",
					"adultRate" => (float) ($payload['adultRate'] ?? 100.50),
					"childRate" => (float) ($payload['childRate'] ?? 50.25),
					"serviceTotal" => (float) (($payload['adultRate'] ?? 100.50) + ($payload['childRate'] ?? 50.25)),
				]
			],
			"passengers" => [
				[
					"serviceType" => "Tour",
					"prefix" => $payload['prefix'] ?? "Mr",
					"firstName" => $payload['firstName'] ?? "",
					"lastName" => $payload['lastName'] ?? "",
					"email" => $payload['email'] ?? "",
					"mobile" => $payload['mobile'] ?? "",
					"nationality" => $payload['nationality'] ?? "",
					"message" => $payload['message'] ?? "Looking forward to the tour",
					"leadPassenger" => (bool) ($payload['leadPassenger'] ?? true),
					"paxType" => $payload['paxType'] ?? "Adult",
					"clientReferenceNo" => $payload['clientReferenceNo'] ?? "",
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
                if ($data['count'] > 0) {
                    return $data['result'];
                }
            } 
        }

        return false;
    }
}
