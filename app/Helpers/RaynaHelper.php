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
use App\Models\Ticket;
use App\Models\AgentAmount;
use Validator;
use App\Models\User;
use App\Models\RaynaBookingLog;

class RaynaHelper
{
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
        $url = config('services.rayna.base_url') . "/Tour/timeslot";

        $token = config('services.rayna.token');
        $response = Http::withOptions(['verify' => false])
			->withHeaders([
				"Content-Type" => "application/json",
				"Authorization" => "Bearer " . trim($token),
				"Accept" => "application/json",
				"User-Agent" => "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36"
			])
			->post($url, $postData);

		RaynaBookingLog::logBooking($postData, $response->json(),'Tour/timeslot');
        if ($response->successful()) {
            $data = $response->json();
            
			
            
			
			
            if (isset($data['statuscode']) && $data['statuscode'] == 200) {
                foreach ($data['result'] as $slot) {
                    $slots[] = [
                        'id' => $slot['timeSlotId'],
                        'time' => $slot['timeSlot'],
                        'available' => $slot['available'] ?? 0,
                    ];
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
        $url = config('services.rayna.base_url') . "/Tour/availability";
        $token = config('services.rayna.token');
        $response = Http::withOptions(['verify' => false])
			->withHeaders([
				"Content-Type" => "application/json",
				"Authorization" => "Bearer " . trim($token),
				"Accept" => "application/json",
				"User-Agent" => "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36"
			])
			->post($url, $pData);
		
		RaynaBookingLog::logBooking($pData, $response->json(),'Tour/availability');
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
    $tourDataAll = self::makeTourServicePayload($voucher);
   
    $tourData = $tourDataAll['tour'];
    
    $returnData = [];
    $bookedId = []; // Corrected spelling
    $nonbooked = [];
    
    if (count($tourData) > 0) {
        foreach ($tourData as $actId => $tour) {
            $uniqueNo = self::generateUniqueNo(); // Generate unique number
            
            $postData = [
                "uniqueNo" => $uniqueNo,
                "TourDetails" => [
                    $tour
                ],   
                "passengers" => [
                    $tourDataAll['passengers']
                ]
            ];
            //dd($postData);
          $url = config('services.rayna.base_url') . "/Booking/bookings"; 
            $token = config('services.rayna.token');

            // API request to Rayna
            $response = Http::withOptions(['verify' => false])
                ->withHeaders([
                    "Content-Type" => "application/json",
                    "Authorization" => "Bearer " . trim($token), 
                    "Accept" => "application/json",
                    "User-Agent" => "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36"
                ])
                ->post($url, $postData);
			$log = RaynaBookingLog::logBooking($postData, $response->json(),'Booking/bookings',$voucher->id,$actId);
            // Handling API response
            if ($response->successful()) {
                $data = $response->json(); 

                if (isset($data['statuscode']) && $data['statuscode'] == 200) {
                    $bookings = $data['result'] ?? null;

                    if (!empty($bookings)) {
                        $bookingDetails = $bookings['details'] ?? [];

                        if (!empty($bookingDetails)) {
                            $voucherActivity = VoucherActivity::where('id', $actId)
                                ->where('isRayna', true)
                                ->first();

                            if ($voucherActivity) {
                                $voucherActivity->RaynaBooking_uniqNO = $uniqueNo;
                                $voucherActivity->referenceNo = $bookings['referenceNo'];
                                $voucherActivity->rayna_booking_details = json_encode($bookingDetails);
                                $voucherActivity->save();
                                $returnData[$actId] = ['status' => true, 'error' => ''];
								$log->update(['status' => 1]);
                            } else {
                                $returnData[$actId] = ['status' => false, 'error' => 'Voucher activity not found.'];
                            }
                        } else {
                            $errorDescription = $data['error']['description'] ?? 'No description available.';
                            $returnData[$actId] = ['status' => false, 'error' => $errorDescription];
                        }
                    } else {
                        $errorDescription = $data['error']['description'] ?? 'No description available.';
                        $returnData[$actId] = ['status' => false, 'error' => $errorDescription];
                    }
                } else {
                    $returnData[$actId] = ['status' => false, 'error' => 'Unexpected error occurred.'];
                }
            } else {
                $returnData[$actId] = ['status' => false, 'error' => 'Request failed with status code: ' . $response->status()];
            }
        }

        // Categorize booked and non-booked activities
        foreach ($returnData as $key => $value) {
            if ($value['status'] == true) {
                $bookedId[$key] = $key;
            } else {
                $nonbooked[$key] = $key;
            }
        }

        if (count($bookedId) > 0 && count($nonbooked) > 0) {
            $errorMessage = 'The following activities were not booked: ' . implode(', ', $nonbooked) . '. The following activities were booked: ' . implode(', ', $bookedId) . '.';
        } elseif (count($bookedId) > 0) {
            $errorMessage = 'All activities were successfully booked: ' . implode(', ', $bookedId) . '.';
        } elseif (count($nonbooked) > 0) {
            $errorMessage = 'The following activities were not booked: ' . implode(', ', $nonbooked) . '.';
        } else {
            $errorMessage = 'No activities were processed.';
        }
        
       // dd($errorMessage);
        return [
            'status' => (count($nonbooked) > 0) ? false : true,
            'error' => $errorMessage
        ];
    }

    return ['status' => true, 'error' => 'No Rayna data'];
}

    
    

	public static function makeTourServicePayload($voucher)
	{
        
		$voucherActivity = VoucherActivity::with("variant")->where('voucher_id', $voucher->id)->where('isRayna', true)->get();
        
		$fullName = $voucher->guest_name ?? "";
		$nameParts = explode(" ", trim($fullName), 2);
		$data = [];
		$tour = [];
		$passengers = [];
        if($voucherActivity->count()){

		foreach($voucherActivity as $vac){
       // $serviceUniqueId = str_pad($voucherActivity->id, 6, '0', STR_PAD_LEFT);   
       // $serviceUniqueId = $vac->id;  
        $serviceUniqueId = self::generateUniqueNo(); //mt_rand(100000, 999999);
		$variant = $vac->variant;
		$touroption = self::getTourOptionById($variant->touroption_id);
		$tour[$vac->id] = [
					"serviceUniqueId" => $serviceUniqueId,
					"tourId" => (int) ($touroption['tourId'] ?? 0),
					"optionId" => (int) ($touroption['tourOptionId'] ?? 0),
					"adult" => (int) ($vac->adult ?? 0),
					"child" => (int) ($vac->child ?? 0),
					"infant" => (int) ($vac->infant ?? 0),
					"tourDate" => !empty($vac->tour_date) ? (string) date("Y-m-d", strtotime($vac->tour_date)) : "2025-02-25",
					"timeSlotId" =>(int) $vac->timeSlotId,
					"startTime" => !empty($vac->time_slot) ? (string) date("h:i A", strtotime($vac->time_slot)) : "10:00 AM",
					"transferId" => 41865,
					"pickup" => (string) $vac->pickup_location ?? "Hotel XYZ",
					"adultRate" =>($vac->adult > 0 && isset($vac->rayna_adultPrice)) ? (float) ($vac->rayna_adultPrice) : 0.00,
					"childRate" => ($vac->child > 0 && isset($vac->rayna_childPrice)) ? (float) ($vac->rayna_childPrice) : 0.00,
					"serviceTotal" => (string) ($vac->rayna_adultPrice+$vac->rayna_childPrice ?? 0.00),
		];
		
		
		
		$passengers = [
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

    }
		
		$data['tour'] = $tour;
		$data['passengers'] = $passengers;
		
		return $data;
	}

    public static function getTourOptionByTourId($variantTouroptionId, $payload = [])
{
    $touroption = self::getTourOptionById($variantTouroptionId);

    $pData = [
        "tourId"      => (int)($touroption['tourId'] ?? 0),
        "contractId"  => (int)($touroption['contractId'] ?? 0),
        "travelDate"  => $payload['travelDate'] ?? '',
        "noOfAdult"       => (int)($payload['adult'] ?? 1),
        "noOfChild"       => (int)($payload['child'] ?? 0),
        "noOfInfant"      => (int)($payload['infant'] ?? 0)
    ];

   $url = config('services.rayna.base_url') . "/Tour/touroption";
    $token = config('services.rayna.token');

    $response = Http::withOptions(['verify' => false])
        ->withHeaders([
            "Content-Type"  => "application/json",
            "Authorization" => "Bearer " . trim($token),
            "Accept"        => "application/json",
            "User-Agent"    => "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36"
        ])
        ->post($url, $pData);
       
	RaynaBookingLog::logBooking($pData, $response->json(),'Tour/touroption');
    if ($response->successful()) {
        $data = $response->json();

        if (($data['statuscode'] ?? null) === 200 && !empty($data['result'])) {
            // Response ke "result" array se matching tourOptionId find karna
            foreach ($data['result'] as $tourOption) {
                if ($tourOption['tourOptionId'] == $variantTouroptionId) {
                    return [
                        'status' => true,
                        'message' => 'Tour option found',
                        'variantTouroptionId'  => $variantTouroptionId,
                        'rayna_adultPrice'  => $tourOption['adultPrice'],
                        'rayna_childPrice'  => $tourOption['childPrice'],
                        'rayna_infantPrice' => $tourOption['infantPrice'],
                    ];
                }
            }
        }

        return [
            'status' => false,
            'message' => 'Tour option not found'
        ];
    }

    return [
        'status' => false,
        'message' => 'API request failed'
    ];
}

public static function cancelBooking($referenceNo, $bookingId,$vid=0,$vaid=0)
{
    $postData = [
        "bookingId" => (int) $bookingId,
        "referenceNo" => (string) $referenceNo,
        "cancellationReason" => "cancel booking other"
    ];

  $url = config('services.rayna.base_url') . "/Booking/cancelbooking";
    $token = config('services.rayna.token');

    $response = Http::withOptions(['verify' => false])
        ->withHeaders([
            "Content-Type" => "application/json",
            "Authorization" => "Bearer " . trim($token),
            "Accept" => "application/json",
            "User-Agent" => "Mozilla/5.0"
        ])
        ->post($url, $postData);
	$log = RaynaBookingLog::logBooking($postData, $response->json(),'Booking/cancelbooking',$vid,$vaid);
    if (!$response->successful()) {
        return ['status' => false, 'error' => 'Request failed with status code: ' . $response->status()];
    }

    $data = $response->json();
    $booking = $data['result'] ?? null;
    $errorMessage = $data['error'] ?? 'Booking canceled.';
	if(isset($data['statuscode']) && $data['statuscode'] == 200 && !empty($booking) && ($booking['status'] ?? 0) == 1)
	{
		$log->update(['status' => 1]);
		return ['status' => true];
	}
	
    return  ['status' => false, 'error' => $booking['message'] ?? $errorMessage];
}
    
public static function getBookedTicket($acvt)
{
    $voucherActivity = VoucherActivity::with("variant:id,ucode")
        ->where('id', $acvt)
        ->first();

    if (!$voucherActivity || empty($voucherActivity->rayna_booking_details)) {
        return ['status' => false, 'error' => 'Voucher activity not found or booking details missing.'];
    }

    $bookingDetails = json_decode($voucherActivity->rayna_booking_details, true);
    if (empty($bookingDetails[0]['bookingId']) || empty($bookingDetails[0]['serviceUniqueId'])) {
        return ['status' => false, 'error' => 'Invalid booking details.'];
    }

    $postData = [
        "uniqNO" => (int) $voucherActivity->RaynaBooking_uniqNO,
        "referenceNo" => (string) $voucherActivity->referenceNo,
        "bookedOption" => [
            [
            "serviceUniqueId" => (string) $bookingDetails[0]['serviceUniqueId'],
            "bookingId" => (int) $bookingDetails[0]['bookingId'],
        ]
            ],
    ];

  $url = config('services.rayna.base_url') . "/Booking/GetBookedTickets";
    $token = trim(config('services.rayna.token'));

    $response = Http::withOptions(['verify' => false])
        ->withHeaders([
            "Content-Type" => "application/json",
            "Authorization" => "Bearer $token",
            "Accept" => "application/json",
            "User-Agent" => "Mozilla/5.0"
        ])
        ->post($url, $postData);
		
    $log = RaynaBookingLog::logBooking($postData, $response->json(),'Booking/GetBookedTickets',$voucherActivity->voucher_id,$voucherActivity->id);
		
    if (!$response->successful()) {
        return ['status' => false, 'error' => 'Request failed with status code: ' . $response->status()];
    }

    $data = $response->json();
    if (($data['statuscode'] ?? null) !== 200 || empty($data['result'])) {
        return ['status' => false, 'error' => $data['error'] ?? 'Ticket not found.'];
    }

    $ticket = self::ticketSaveInDB($data['result'], $voucherActivity);
	$log->update(['status' => 1]);
    return ['status' => true, 'ticket' => $ticket];
}

public static function ticketSaveInDB($raynaData, $voucherActivity)
{
   
    $validityDate = self::extractDate($raynaData['validity']);
    $ticketNo = $raynaData['ticketDetails'][0]['barCode'] ?? '';
    if (!empty($ticketNo)) {
        $existingTicket = Ticket::where('ticket_no', $ticketNo)->first();
        
        if ($existingTicket && !empty($existingTicket->id)) {
            return $existingTicket; 
        }
    }

    $ticketData = [
        'ticket_for' => isset($raynaData['ticketDetails'][0]['type']) ? ucfirst($raynaData['ticketDetails'][0]['type']) : '',
        'type_of_ticket' => ($raynaData['printType'] ?? '') === 'QR Code' ? 'QR-Code' : 'Media-Code',
        'activity_id' => 0,
        'activity_variant' => $voucherActivity->variant->ucode ?? '',
        'ticket_no' => $raynaData['ticketDetails'][0]['barCode'] ?? '',
        'serial_number' => $raynaData['pnrNumber'] ?? '',
        'valid_from' => $validityDate ?? null,
        'valid_till' => $validityDate ?? null,
        'created_at' => now(),
        'updated_at' => now(),
        'voucher_id' => $voucherActivity->voucher_id ?? 0,
        'voucher_activity_id' => $voucherActivity->id ?? 0,
        'ticket_generated' => 1,
        'ticket_downloaded' => 1,
        'supplier_ticket' => '947d43d9-c999-446c-a841-a1aee22c7257',
        'ticket_downloaded_by' => Auth::user()->id,
        'generated_time' => now(),
        'downloaded_time' => now(),
        'rayna_ticket_details' => json_encode($raynaData['ticketDetails'][0] ?? []),
        'rayna_ticketURL' => $raynaData['ticketURL'] ?? '',
        'isRayna' => 1,
    ];
    
    $ticket = Ticket::create($ticketData);
}

private static function extractDate($dateStr)
{
    if (preg_match('/\d{2}-\d{2}-\d{4}/', $dateStr, $matches)) {
        return Carbon::createFromFormat('d-m-Y', $matches[0])->format('Y-m-d');
    }
    return null;
}
    
    public static function generateUniqueNo() {
        $year = date('y');  
        $second = date('s'); 
        $random = mt_rand(10, 99);
    
        $uniqueNo = $year . $second . $random;
    
        $uniqueNo = substr($uniqueNo, -6);
    
        while (
            DB::table('voucher_activity')->where('RaynaBooking_uniqNO', $uniqueNo)->exists() ||
            DB::table('voucher_activity')->whereJsonContains('rayna_booking_details->serviceUniqueId', (string)$uniqueNo)->exists()
        ) {
            $random = mt_rand(10, 99);
            $uniqueNo = $year . $second . $random;
            $uniqueNo = substr($uniqueNo, -6);
        }
    
        return (int) $uniqueNo;
    }

    
}
