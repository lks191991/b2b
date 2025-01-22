<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class APITourData extends Command
{
    protected $signature = 'tourstaticdata';
    protected $description = 'Fetch and update tour static data from the API';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        
        $url = "https://sandbox.raynatours.com/api/Tour/tourstaticdata";
        $token = config('services.rayna.token');
        $postData = [
            "countryId" => 13063,
            "cityId" => 13668
        ];

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
            ])
            ->withOptions([
                'verify' => false, // Ensure SSL/TLS certificate verification
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
                    $this->info('Tour data updated or inserted successfully.');
                } else {
                    $this->error('API returned an error: ' . ($data['error'] ?? 'Unknown error'));
                }
            } else {
                $this->error('Failed to fetch data. Status Code: ' . $response->status());
                Log::error('API Error', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
            }
        } catch (\Exception $e) {
            $this->error('An exception occurred: ' . $e->getMessage());
            Log::error('Exception in APITourData Command', ['message' => $e->getMessage()]);
        }
    }
}
