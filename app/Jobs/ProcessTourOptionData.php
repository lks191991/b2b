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

class ProcessTourOptionData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Job timeout (optional, default: 60 sec)
     */
    public $timeout = 600; // 10 minutes

    /**
     * Execute the job.
     */
    public function handle()
    {
        $sourceData = DB::table('tourstaticdata')->get();
        $url = config('services.rayna.base_url') . '/Tour/touroptionstaticdata';
        $token = config('services.rayna.token');

        foreach ($sourceData as $data) {
            $postData = [
                'tourId' => $data->tourId,
                'contractId' => $data->contractId,
            ];

            try {
                $response = Http::withOptions(['verify' => false])
                    ->withHeaders([
                        "Content-Type" => "application/json",
                        "Authorization" => "Bearer " . trim($token),
                        "Accept" => "application/json"
                    ])
                    ->post($url, $postData);

                if ($response->successful()) {
                    $apiData = $response->json();
                    if (isset($apiData['statuscode']) && $apiData['statuscode'] == 200) {
                        $tourOptions = $apiData['result']['touroption'] ?? [];
                        
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
										'termsAndConditions' => $option['termsAndConditions'],
										
                                    ]
                                );
                            }
                            // Update tourstaticdata table flag
                            DB::table('tourstaticdata')->where('tourId', $data->tourId)->update([
                                'tourOption' => 1
                            ]);
                        }
                    }
                } else {
                    Log::error('API request failed', [
                        'status' => $response->status(),
                        'body' => $response->body(),
                        'tourId' => $data->tourId
                    ]);
                }
            } catch (\Exception $e) {
                Log::error('Error in ProcessTourOptionStaticData job', ['message' => $e->getMessage()]);
            }
        }
    }
}
