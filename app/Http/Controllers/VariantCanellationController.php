<?php

namespace App\Http\Controllers;

use App\Models\Slot;
use App\Models\Variant;
use App\Models\VariantCanellation;
use Illuminate\Http\Request;
use DB;
class VariantCanellationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($varidid)
    {
		//$this->checkPermissionMethod('list.hotlecat');
		$variant = Variant::select("id","title","ucode")->find($varidid);
        $records = VariantCanellation::where('variant_id',$varidid)->orderBy('duration')->get();
        return view('variants.canellation_chart', compact('records','varidid','variant'));

    }

    
   
    public function saveCanellation(Request $request)
    {
         $request->validate([
		'duration' => 'required',
		'ticket_refund_value' => 'required',
		], [
		]);
		
		$varidid = $request->input('varidid');
		$varidCode = $request->input('varidCode');
		$durations = $request->input('duration');
		$ticketRefundValue = $request->input('ticket_refund_value');
		$transferRefundValue = $request->input('transfer_refund_value');
		
		if(!empty($durations)){
			VariantCanellation::where('variant_id', $varidid)->delete();
			
			$data = [];
			foreach($durations as $k=> $duration)
			{
				$data[$k]['duration'] = $duration;
				$data[$k]['varidCode'] = $varidCode;
				$data[$k]['variant_id'] = $varidid;
				$data[$k]['ticket_refund_value'] = $ticketRefundValue[$k];
				$data[$k]['transfer_refund_value'] = $transferRefundValue[$k];
				
			}
			
			
			VariantCanellation::insert($data);
			
			$variant = Variant::find($varidid);
			if(count($data) > 0){
			$variant->is_canellation = 1;
			} else {
				$variant->is_canellation = 0;
			}
			
			$variant->save();
			
		}
		
		if($variant->slot_type < 3)
		{
			return redirect()->route('variant.slots',$variant->id)->with('success', 'Cancellation Chart saved Successfully.');
		} else {
			return back()->with('success', 'Cancellation Chart saved Successfully.');
		}
       

    }
	
	
	public function getVariantCanellation(Request $request)
    {
			$variantcode = $request->input('variantcode');
		
			$query = VariantCanellation::where('varidCode', $variantcode);
			$cancellation = $query->get();
		if($cancellation){
		$response = array("status"=>1,'cancellation'=>$cancellation);
		} else {
			$response = array("status"=>2,'cancellation'=>[]);
		}
		
		
        return response()->json($response);
    }
	
}
