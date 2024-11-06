<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use DB;

class APITourData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tourstaticdata';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

  public function __construct()
    {
        parent::__construct();
    }

    public function handle()
{
    $url = 'http://sandbox.raynatours.com/api/Tour/tourstaticdata';
    $postData = [
        "countryId" => 13063,
        "cityId" => 13668
    ];

    $token = 'eyJhbGciOiJodHRwOi8vd3d3LnczLm9yZy8yMDAxLzA0L3htbGRzaWctbW9yZSNobWFjLXNoYTI1NiIsInR5cCI6IkpXVCJ9.eyJqdGkiOiJkNWU4YWZhMC1mNGJhLTQ2NWUtYTAzOS1mZGJiYzMxZWZlZGUiLCJVc2VySWQiOiIzNzU0NSIsIlVzZXJUeXBlIjoiQWdlbnQiLCJQYXJlbnRJRCI6IjAiLCJFbWFpbElEIjoidHJhdmVsZ2F0ZXhAcmF5bmF0b3Vycy5jb20iLCJpc3MiOiJodHRwOi8vcmF5bmFhcGkucmF5bmF0b3Vycy5jb20iLCJhdWQiOiJodHRwOi8vcmF5bmFhcGkucmF5bmF0b3Vycy5jb20ifQ.i6GaRt-RVSlJXKPz7ZVx-axAPLW_hkl7usI_Dw8vP5w';  

    $response = Http::withHeaders([
        'Authorization' => 'Bearer ' . $token,
    ])->post($url, $postData);

    if ($response->successful()) {
        $data = $response->json();

        if ($data['statuscode'] == 200) {
            $tourData = $data['result'];

            foreach ($tourData as $tour) {
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
                        'isPrivate' => $tour['isPrivate']
                    ]
                );
            }

            $this->info('Tour data updated or inserted successfully.');
        } else {
            $this->error('API returned an error: ' . $data['error']);
        }
    } else {
        $this->error('Failed to fetch data from the API.');
        $this->error('Status Code: ' . $response->status());
        $this->error('Response Body: ' . $response->body());
    }
}

}