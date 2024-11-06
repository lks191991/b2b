<?php

namespace App\Http\Controllers;

use App\Models\Slot;
use App\Models\Variant;
use Illuminate\Http\Request;
use DB;
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
		$variant = Variant::find($variantId);
		$data= [] ;
		if($variant->slot_type < 3){
		
		if(!empty($variantId)){
			$query = Slot::where('variant_id', $variantId);
			if($transferOption == 'Ticket Only'){
				$query->where('ticket_only', 1);
			}
			if($transferOption == 'Shared Transfer'){
				$query->where('sic', 1);
			}
			if($transferOption == 'Pvt Transfer'){
				$query->where('pvt', 1);
			}
			$slots = $query->get();
			
			foreach($slots as $slot)
			{
				$data[$slot->slot_timing] = $slot->slot_timing;
			}
			
		}
		
		$response = array("status"=>1,'slots'=>$data,"sstatus"=>$variant->is_slot,'variant'=>$variant);
		} else {
			$response = array("status"=>2,'slots'=>$data,"sstatus"=>$variant->is_slot,'variant'=>$variant);
		}
		
        return response()->json($response);
    }


	
}
