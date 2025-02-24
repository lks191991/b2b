<?php

namespace App\Helpers;

use Ramsey\Uuid\Uuid;
use DB;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\Http;

class RaynaHelper
{
    protected static $token = 'eyJhbGciOiJodHRwOi8vd3d3LnczLm9yZy8yMDAxLzA0L3htbGRzaWctbW9yZSNobWFjLXNoYTI1NiIsInR5cCI6IkpXVCJ9.eyJqdGkiOiJkNWU4YWZhMC1mNGJhLTQ2NWUtYTAzOS1mZGJiYzMxZWZlZGUiLCJVc2VySWQiOiIzNzU0NSIsIlVzZXJUeXBlIjoiQWdlbnQiLCJQYXJlbnRJRCI6IjAiLCJFbWFpbElEIjoidHJhdmVsZ2F0ZXhAcmF5bmF0b3Vycy5jb20iLCJpc3MiOiJodHRwOi8vcmF5bmFhcGkucmF5bmF0b3Vycy5jb20iLCJhdWQiOiJodHRwOi8vcmF5bmFhcGkucmF5bmF0b3Vycy5jb20ifQ.i6GaRt-RVSlJXKPz7ZVx-axAPLW_hkl7usI_Dw8vP5w'; 
   
    public static  function tourStaticDataFromAPI($countryId = '13063', $cityId = '13668')
    {
        $url = 'http://sandbox.raynatours.com/api/Tour/tourstaticdata';
        $postData = [
            "countryId" => $countryId,
            "cityId" => $cityId
        ];
        
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . self::$token,  // Use $this->token
        ])->post($url, $postData);

        if ($response->successful()) {
            $data = $response->json();

            if ($data['statuscode'] == 200) {
                $tourData = $data['result'];
                return json_encode([
                    'message' => 'Tour data updated or inserted successfully.',
                    'code' => $data['statuscode'],
                    'data' => $tourData
                ]);
            } else {
                return json_encode([
                    'message' => 'API returned an error: ' . $data['error']
                ]);
            }
        } else {
            return json_encode([
                'message' => 'Failed to fetch data from the API.',
                'code' => $response->status(),
                'data' => $response->body()
            ]);
        }
    }

    public static  function tourOptionStaticDataFromAPI($tourId = '', $contractId = '')
    {
        $postData = [
            'tourId' => $tourId,
            'contractId' => $contractId,
        ];
        
        $url = 'http://sandbox.raynatours.com/api/Tour/touroptionstaticdata';
        
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . self::$token,  // Use $this->token
        ])->post($url, $postData);

        if ($response->successful()) {
            $data = $response->json();

            if (isset($data['statuscode']) && $data['statuscode'] == 200) {
                $tourOptions = $data['result']['touroption'] ?? [];
                return json_encode([
                    'message' => 'Tour options data fetched successfully.',
                    'code' => $data['statuscode'],
                    'data' => $tourOptions
                ]);
            } else {
                return json_encode([
                    'message' => 'API returned an error: ' . $data['error']
                ]);
            }
        } else {
            return json_encode([
                'message' => 'Failed to fetch data from the API.',
                'code' => $response->status(),
                'data' => []
            ]);
        }
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
	
	public static  function getTourAvailability($payload)
    {
		$pData = [   
        "tourId"       => (int) ($payload['tourId'] ?? 0),
        "tourOptionId" => (int) ($payload['tourOptionId'] ?? 0),
        "transferId"   => (int) ($payload['transferId'] ?? 0),
        "travelDate"   => $payload['travelDate'] ?? '',
        "adult"        => (int) ($payload['adult'] ?? 1),
        "child"        => (int) ($payload['child'] ?? 0),
        "infant"       => (int) ($payload['infant'] ?? 0),
        "contractId"   => (int) ($payload['contractId'] ?? 0),
		];

		$postData =  json_encode($pData);
		
        $slots = [];
        $url = "https://sandbox.raynatours.com/api/Tour/availability";
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
                    return true;
                }
            } 
        }

        return false;
    }
	
	public static  function getTourAvailability($payload)
    {
			$pData = [
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




		$postData =  json_encode($pData, JSON_PRETTY_PRINT);
		
        $slots = [];
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
