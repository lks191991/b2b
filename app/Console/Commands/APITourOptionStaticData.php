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
        $url = 'https://sandbox.raynatours.com/api/Tour/touroption';
        $token = config('services.rayna.token');
        foreach ($sourceData as $data) {
            $postData = [
                'tourId' => $data->tourId,
                'contractId' => $data->contractId,
                'travelDate' => "2025-02-20",
                'noOfAdult' => 1,
                'noOfChild' => 0,
                'noOfInfant' => 0,
            ];


            $response = Http::withHeaders([
        "Content-Type" => "application/json",
        "Authorization" => "Bearer " . trim($token),
        "Accept" => "application/json",
        "User-Agent" => "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36"
		])->post($url, $postData);

            if ($response->successful()) {
                $apiData = $response->json();

                if (isset($apiData['statuscode']) && $apiData['statuscode'] == 200) {
                    $tourOptions = $apiData['result'] ?? [];

                    // Only update the tourOption if there are valid tour options returned
                    if (!empty($tourOptions)) {
                        foreach ($tourOptions as $option) {
                            DB::table('tour_option_static_data')->updateOrInsert(
                                ['tourOptionId' => $option['tourOptionId']],
                                [
                                    'tourId' => $option['tourId'],
                                    'transferId' => $option['transferId'],
                                    'optionName' => $data->tourName.' - '.$option['transferName'],
                                    'transferName' => $option['transferName'],
                                    'adultPrice' => $option['adultPrice'],
                                    'childPrice' => $option['childPrice'],
                                    'infantPrice' => $option['infantPrice'],
                                    'withoutDiscountAmount' => $option['withoutDiscountAmount'],
                                    'finalAmount' => $option['finalAmount'],
                                    'startTime' => $option['startTime'],
                                    'departureTime' => $option['departureTime'],
                                    'disableChild' => $option['disableChild'],
                                    'disableInfant' => $option['disableInfant'],
                                    'allowTodaysBooking' => $option['allowTodaysBooking'],
                                    'cutOff' => $option['cutOff'],
                                    'isSlot' => $option['isSlot'],
                                    'isSeat' => $option['isSeat'],
                                    'isDefaultTransfer' => $option['isDefaultTransfer'],
                                    'rateKey' => $option['rateKey'],
                                    'inventoryId' => $option['inventoryId'],
                                    'adultBuyingPrice' => $option['adultBuyingPrice'],
                                    'childBuyingPrice' => $option['childBuyingPrice'],
                                    'infantBuyingPrice' => $option['infantBuyingPrice'],
                                    'adultSellingPrice' => $option['adultSellingPrice'],
                                    'childSellingPrice' => $option['childSellingPrice'],
                                    'infantSellingPrice' => $option['infantSellingPrice'],
                                    'companyBuyingPrice' => $option['companyBuyingPrice'],
                                    'companySellingPrice' => $option['companySellingPrice'],
                                    'agentBuyingPrice' => $option['agentBuyingPrice'],
                                    'agentSellingPrice' => $option['agentSellingPrice'],
                                    'subAgentBuyingPrice' => $option['subAgentBuyingPrice'],
                                    'subAgentSellingPrice' => $option['subAgentSellingPrice'],
                                    'finalSellingPrice' => $option['finalSellingPrice'],
                                    'vatbuying' => $option['vatbuying'],
                                    'vatselling' => $option['vatselling'],
                                    'currencyFactor' => $option['currencyFactor'],
                                    'agentPercentage' => $option['agentPercentage'],
                                    'transferBuyingPrice' => $option['transferBuyingPrice'],
                                    'transferSellingPrice' => $option['transferSellingPrice'],
                                    'serviceBuyingPrice' => $option['serviceBuyingPrice'],
                                    'serviceSellingPrice' => $option['serviceSellingPrice'],
                                    'rewardPoints' => $option['rewardPoints'],
                                    'tourChildAge' => $option['tourChildAge'],
                                    'maxChildAge' => $option['maxChildAge'],
                                    'maxInfantAge' => $option['maxInfantAge'],
                                    'minimumPax' => $option['minimumPax'],
                                    'pointRemark' => $option['pointRemark'],
                                    'adultRetailPrice' => $option['adultRetailPrice'],
                                    'childRetailPrice' => $option['childRetailPrice'],
                                ]
                            );
                        }

                        // Update the tourOption flag only if there are options
                       // DB::table('tourstaticdata')->where('tourId', $data->tourId)->update([
                         //   'tourOption' => 1
                       // ]);
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
