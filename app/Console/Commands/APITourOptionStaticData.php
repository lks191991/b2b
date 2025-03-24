<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class APITourOptionStaticData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'touroption';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch data from a table, call an API, and insert the response into another table';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $sourceData = DB::table('tourstaticdata')->get();
        $url = 'https://sandbox.raynatours.com/api/Tour/touroptionstaticdata';
        $token = config('services.rayna.token');
        foreach ($sourceData as $data) {
            $postData = [
                'tourId' => $data->tourId,
                'contractId' => $data->contractId,
            ];


            $response = Http::withOptions(['verify' => false])
			->withHeaders([
				"Content-Type" => "application/json",
				"Authorization" => "Bearer " . trim($token),
				"Accept" => "application/json",
				"User-Agent" => "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36"
			])
			->post($url, $postData);

            if ($response->successful()) {
                $apiData = $response->json();

                if (isset($apiData['statuscode']) && $apiData['statuscode'] == 200) {
                    $tourOptions = $apiData['result']['touroption'] ?? [];

                    // Only update the tourOption if there are valid tour options returned
                    if (!empty($tourOptions)) {
                        foreach ($tourOptions as $option) {
                            DB::table('tour_option_static_data')->updateOrInsert(
                                ['tourOptionId' => $option['tourOptionId']],
                                [
                                    'tourId' => $data->tourId,
                                    'contractId' => $data->contractId,
                                    'optionName' => $option['optionName'],
                                    'childAge' => $option['childAge'],
                                    'infantAge' => $option['infantAge'],
                                    'optionDescription' => $option['optionDescription'],
                                    'cancellationPolicy' => $option['cancellationPolicy'],
                                    'cancellationPolicyDescription' => $option['cancellationPolicyDescription'],
                                    'childPolicyDescription' => $option['childPolicyDescription'],
                                    'xmlcode' => $option['xmlcode'],
                                    'xmloptioncode' => $option['xmloptioncode'],
                                    'countryId' => $option['countryId'],
                                    'cityId' => $option['cityId'],
                                    'minPax' => $option['minPax'],
                                    'maxPax' => $option['maxPax'],
                                    'duration' => $option['duration'],
                                    'timeZone' => $option['timeZone'],
                                    'isWithoutAdult' => $option['isWithoutAdult'],
                                    'isTourGuide' => $option['isTourGuide'],
                                    'compulsoryOptions' => $option['compulsoryOptions'],
                                    'isHideRateBreakup' => $option['isHideRateBreakup'],
                                    'isHourly' => $option['isHourly'],
                                ]
                            );
                        }

                        // Update the tourOption flag only if there are options
                        DB::table('tourstaticdata')->where('tourId', $data->tourId)->update([
                            'tourOption' => 1
                        ]);
                    }

                    $this->info('Tour options data updated or inserted successfully.');
                } else {
                    $this->error('API returned an error or unexpected data structure.');
                    $this->error('Status Code: ' . $apiData['statuscode']);
                }
            } else {
                $this->error('Failed to fetch data from the API.');
                $this->error('Status Code: ' . $response->status());
                $this->error('Response Body: ' . $response->body());
            }
        }
    }
}
