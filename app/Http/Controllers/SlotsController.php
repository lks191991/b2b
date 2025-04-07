<?php

namespace App\Http\Controllers;

use App\Models\Slot;
use App\Models\Variant;
use Illuminate\Http\Request;
use DB;
use RaynaHelper;
class SlotsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($varidid)
    {
		//$this->checkPermissionMethod('list.hotlecat');
        $records = Slot::where('variant_id',$varidid)->orderBy('slot_timing')->get();
		$variant = Variant::find($varidid);
		$dbSlot = [];
		foreach($records as $record) {
			$dbSlot[$record->slot_timing]['ticket_only'] = $record->ticket_only;
			$dbSlot[$record->slot_timing]['sic'] = $record->sic;
			$dbSlot[$record->slot_timing]['pvt'] = $record->pvt;
		}
		$start_time = strtotime($variant->start_time);
		$end_time = strtotime($variant->end_time);
		$slot_type = $variant->slot_type;
		$custom_slot = $variant->available_slots;
		$slots = [];

		if ($slot_type == 1) {
			$custom_slots = explode(',', $custom_slot);
			foreach ($custom_slots as $custom_time) {
				$slots[] = date('H:i', strtotime($custom_time));
			}
		} else if ($slot_type == 2) {
			$duration = $variant->slot_duration;

		while ($start_time < $end_time) {
        $slot_end_time = strtotime("+{$duration} minutes", $start_time);
        if ($slot_end_time > $end_time) {
            $slot_end_time = $end_time;
        }

        $start_time_formatted = date('H:i', $start_time);
        $end_time_formatted = date('H:i', $slot_end_time);

        $slots[] = $start_time_formatted;

        $start_time = $slot_end_time;

        if ($start_time == $end_time) {
            break;
        }
    }
  }


        return view('slots.index', compact('records','slots','variant','dbSlot'));

    }

    
   
    public function saveSlot(Request $request)
    {
        
		$slots = $request->input('slot');
		$varidid = $request->input('variant_id');
		
		
		if(!empty($slots)){
			Slot::where('variant_id', $varidid)->delete();
			$data = [];
			foreach($slots as $k=> $slot)
			{
				$data[$k]['variant_id'] = $varidid;
				$data[$k]['slot_timing'] = $slot['time'];
				$slot['to'] = (isset($slot['to']))?1:0;
				$slot['sic'] = (isset($slot['sic']))?1:0;
				$slot['pvt'] = (isset($slot['pvt']))?1:0;
				$data[$k]['ticket_only'] = $slot['to'];
				$data[$k]['sic'] = $slot['sic'];
				$data[$k]['pvt'] = $slot['pvt'];
				Slot::create($data[$k]);
			}
			
			$variant = Variant::find($varidid);
			if(count($data) > 0){
			$variant->is_slot = 1;
			} else {
				$variant->is_slot = 0;
			}
			
			$variant->save();
		}
		
        return back()->with('success', 'Slots saved Successfully.');

    }
	
	public function variantSlotGet(Request $request)
	{
		$variantId = $request->input('variant_id');
		$transferOption = $request->input('transferOptionName');
		$tourDate = $request->input('tour_date');
		$adult = (int) ($request->input('adult') ?? 0);
		$child = (int) ($request->input('child') ?? 0);
		
		$variant = Variant::find($variantId);
		if (!$variant) {
			return response()->json(["status" => 0, "message" => "Invalid variant."]);
		}

		$data = [];
		$isRayna = false;
		if ($variant->is_slot == 1) {
		
			if (!empty($variant->touroption_id)) {
				$optionDetails = RaynaHelper::getTourOptionById($variant->touroption_id);
				
				if (!empty($optionDetails['tourId'])) {
					$tour = RaynaHelper::getTourDetailsById($optionDetails['tourId']);
					$isRayna = !empty($tour['isSlot']) ? true : false;
				}
				
				

				if ($isRayna==true) {
					$postData = [
						"travelDate" => date('Y-m-d', strtotime($tourDate)),
						"tourId" => $optionDetails['tourId'],
						"tourOptionId" => $optionDetails['tourOptionId'],
						"transferId" => 41865, // Without Transfer
						"adult" => $adult,
						"child" => $child,
						"contractId" => $optionDetails['contractId'] ?? null
					];

					$raynaSlot = RaynaHelper::getSlot($postData);
					if (!is_array($raynaSlot) || empty($raynaSlot)) {
						return response()->json(["status" => 4, "message" => "No slots available for the selected date or tour."]);
					}
					
					
					
					$data = $raynaSlot;
					if($transferOption=='Shared Transfer'){
						$matchSlot = $this->matchSlotWithinternalAndRayna($raynaSlot,$variantId);
						if(empty($matchSlot)){
							return response()->json(["status" => 4, "message" => "No slots available for the selected date or tour."]);
						}
						
						$data = $matchSlot;
					}
				
					return response()->json([
					"status" => 1,
					"slots" => $data,
					"sstatus" => $variant->is_slot,
					"variant" => $variant,
					"is_rayna" => $isRayna
					]);
				}else{
					 return response()->json(["status" => 4, "message" => "No slots available for the selected date or tour."]);
				}
				
			} else 	if ($variant->slot_type < 3) {
				if (empty($data) && !empty($variantId)) {
					$query = Slot::where('variant_id', $variantId);
					$transferOptions = [
						'Ticket Only' => 'ticket_only',
						'Shared Transfer' => 'sic',
						'Pvt Transfer' => 'pvt'
					];
					
					if (isset($transferOptions[$transferOption])) {
						$query->where($transferOptions[$transferOption], 1);
					}

					$slots = $query->get();

					foreach($slots as $slot)
					{
					$data[$slot->slot_timing] = $slot->slot_timing;
					}
				}
				
				return response()->json([
					"status" => 1,
					"slots" => $data,
					"sstatus" => $variant->is_slot,
					"variant" => $variant,
					"is_rayna" => $isRayna
				]);
			}
		}
		
		 return response()->json([
			"status" => 2,
			"slots" => $data,
			"sstatus" => $variant->is_slot,
			"variant" => $variant,
			"is_rayna" => $isRayna
		]);
		
	   
	}

	public function matchSlotWithinternalAndRayna($raynaSlots, $variantId)
	{
		$internalSlots = Slot::where('variant_id', $variantId)
							 ->where('sic', 1)
							 ->pluck('slot_timing')
							 ->toArray(); 

		$matchedSlots = [];
		foreach ($raynaSlots as $slotId => $slotTime) {
			if (in_array($slotTime, $internalSlots)) {
				$matchedSlots[$slotId] = $slotTime;
			}
		}

		return $matchedSlots;
	}


}
