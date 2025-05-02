<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use DB;
use App\Models\Tourstaticdata;
use App\Models\tourOptionStaticData;

class APITourDataController extends Controller
{
   
   protected $token = 'eyJhbGciOiJodHRwOi8vd3d3LnczLm9yZy8yMDAxLzA0L3htbGRzaWctbW9yZSNobWFjLXNoYTI1NiIsInR5cCI6IkpXVCJ9.eyJqdGkiOiJkNWU4YWZhMC1mNGJhLTQ2NWUtYTAzOS1mZGJiYzMxZWZlZGUiLCJVc2VySWQiOiIzNzU0NSIsIlVzZXJUeXBlIjoiQWdlbnQiLCJQYXJlbnRJRCI6IjAiLCJFbWFpbElEIjoidHJhdmVsZ2F0ZXhAcmF5bmF0b3Vycy5jb20iLCJpc3MiOiJodHRwOi8vcmF5bmFhcGkucmF5bmF0b3Vycy5jb20iLCJhdWQiOiJodHRwOi8vcmF5bmFhcGkucmF5bmF0b3Vycy5jb20ifQ.i6GaRt-RVSlJXKPz7ZVx-axAPLW_hkl7usI_Dw8vP5w';  
   
	public function tourStaticData(Request $request)
	{
		$data = $request->all();
		$query = DB::table('tourstaticdata')->where('id', '!=' , '0');
		if (isset($data['name']) && !empty($data['name'])) {
            $query->where('tourName', 'like', '%' . $data['name'] . '%');
        }
       
	   if (isset($data['tourId']) && !empty($data['tourId'])) {
            $query->where('tourId',  $data['tourId']);
        }
		
		if (!empty($data['tourOption'])) {
			if ($data['tourOption'] == 1) {
				$query->where('tourOption', 1);
			} elseif ($data['tourOption'] == 2) {
				$query->where('tourOption', 0);
			}
		}
		
		
		
        if (isset($data['isSlot']) && !empty($data['isSlot'])) {
            if($data['isSlot'] == 1)
                $query->where('isSlot', 1);
            if($data['isSlot'] == 2)
                $query->where('isSlot', 0);
        }
		    $records = $query->orderBy('tourId', 'desc')->paginate(10);

			return view('tourApiData.tourstaticdata', compact('records'));
	}

    public function tourOptionStaticData(Request $request,int $id = 0)
	{
		$data = $request->all();
		$query = DB::table('tour_option_static_data'); // No need to use select('*')
		
		if (isset($data['name']) && !empty($data['name'])) {
            $query->where('optionName', 'like', '%' . $data['name'] . '%');
        }
       
	   if (isset($data['tourId']) && !empty($data['tourId'])) {
            $query->where('tourId',  $data['tourId']);
        }

		if (isset($data['tourOptionId']) && !empty($data['tourOptionId'])) {
            $query->where('tourOptionId',  $data['tourOptionId']);
        }

		$tourName = null;
		if ($id > 0) {
			$query->where('tourId', $id);
			$tourName = DB::table('tourstaticdata')->where('tourId', $id)->value('tourName'); 
		}

		$records = $query->paginate(10);

		return view('tourApiData.tour_option_static_data', compact('records', 'tourName'));
	}

	public function tourStaticDataFromAPI($countryId='13063',$cityId='13668')
	{
		$url = 'http://sandbox.raynatours.com/api/Tour/tourstaticdata';
		$postData = [
			"countryId" => $countryId,
			"cityId" => $cityId
		];
		
		$response = Http::withHeaders([
			'Authorization' => 'Bearer ' . $this->token,
		])->post($url, $postData);
	return json_encode($this->token);
		if ($response->successful()) {
			$data = $response->json();

			if ($data['statuscode'] == 200) {
				$tourData = $data['result'];
				return json_encode(['message'=>'Tour data updated or inserted successfully.','code'=>$data['statuscode'],'data'=>$tourData]);
			} else {
				return json_encode(['message'=>'API returned an error: ' . $data['error']]);
			}
		} else {
			return json_encode(['message'=>'Failed to fetch data from the API.','code'=>$response->status(),'data'=>$response->body()]);
		}
	}
	
	
	public function tourOptionStaticDataFromAPI($tourId='',$contractId='')
	{
		$postData = [
                'tourId' => $tourId,
                'contractId' => $contractId,
            ];
			
		$url = 'http://sandbox.raynatours.com/api/Tour/tourstaticdata';
		

		 $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->token,
            ])->post('http://sandbox.raynatours.com/api/Tour/touroptionstaticdata', $postData);

		if ($response->successful()) {
                $data = $response->json();

			if (isset($data['statuscode']) && $data['statuscode'] == 200) {
				$tourOptions = $data['result']['touroption'] ?? [];
				return json_encode(['message'=>'Tour options data fetched successfully.','code'=>$data['statuscode'],'data'=>$tourOptions]);
			} else {
				return json_encode(['message'=>'API returned an error: ' . $data['error']]);
			}
		} else {
			return json_encode(['message'=>'Failed to fetch data from the API.','code'=>$response->status(),'data'=>[]]);
		}
	}

}
