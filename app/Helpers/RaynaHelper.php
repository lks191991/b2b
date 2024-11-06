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
}
