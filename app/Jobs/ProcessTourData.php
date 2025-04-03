<?php
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProcessTourData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
        //
    }

    public function handle()
    {
        $url = "https://sandbox.raynatours.com/api/Tour/tourstaticdata";
        $token = config('services.rayna.token');
        $cities = [13668, 13236];

        try {
            foreach ($cities as $cityId) {
                $postData = [
                    "countryId" => 13063,
                    "cityId" => $cityId
                ];

                $response = Http::withOptions(['verify' => false])
                    ->withHeaders([
                        "Content-Type" => "application/json",
                        "Authorization" => "Bearer " . trim($token),
                        "Accept" => "application/json",
                        "User-Agent" => "Mozilla/5.0"
                    ])
                    ->post($url, $postData);

                if ($response->successful()) {
                    $data = $response->json();

                    if (isset($data['statuscode']) && $data['statuscode'] == 200) {
                        foreach ($data['result'] as $tour) {
                            DB::table('tourstaticdata')->updateOrInsert(
                                ['tourId' => $tour['tourId']],
                                [
                                    'countryId' => $tour['countryId'],
                                    'countryName' => $tour['countryName'],
                                    'cityId' => $tour['cityId'],
                                    'cityName' => $tour['cityName'],
                                    'tourName' => $tour['tourName'],
                                    'reviewCount' => $tour['reviewCount'],
                                    'rating' => $tour['rating'],
                                    'duration' => $tour['duration'],
                                    'imagePath' => $tour['imagePath'],
                                    'imageCaptionName' => $tour['imageCaptionName'],
                                    'cityTourTypeId' => $tour['cityTourTypeId'],
                                    'cityTourType' => $tour['cityTourType'],
                                    'tourShortDescription' => $tour['tourShortDescription'],
                                    'cancellationPolicyName' => $tour['cancellationPolicyName'],
                                    'isSlot' => $tour['isSlot'],
                                    'onlyChild' => $tour['onlyChild'],
                                    'contractId' => $tour['contractId'],
                                    'recommended' => $tour['recommended'],
                                    'isPrivate' => $tour['isPrivate'],
                                ]
                            );
                        }
                        Log::info("Tour data updated successfully for City ID: $cityId");
                    } else {
                        Log::error("API Error for City ID: $cityId - " . ($data['error'] ?? 'Unknown error'));
                    }
                } else {
                    Log::error("Failed to fetch data for City ID: $cityId. Status Code: " . $response->status());
                }
            }
        } catch (\Exception $e) {
            Log::error('Exception in ProcessTourStaticData', ['message' => $e->getMessage()]);
        }
    }
}
