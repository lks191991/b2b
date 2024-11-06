<?php
namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Variant;
use App\Models\VariantPrice;
use App\Models\ActivityVariant;
use DB;
use App\Rules\DateRange;
use Illuminate\Validation\Rule;

class VariantPriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	 
    public function index(Request $request,$vid)
    {
		//$this->checkPermissionMethod('list.activity');
        $data = $request->all();
        $perPage = config("constants.ADMIN_PAGE_LIMIT");
		
		//$vat = Activity::select('vat')->find($variant->vid);
        $query = VariantPrice::with("createdBy","updatedBy","av","av.activity","av.variant")->where('activity_variant_id',$vid);
        $records = $query->orderBy('created_at', 'DESC')->paginate($perPage);
		//dd($records);
        return view('activity_variant_prices.index', compact('records','vid'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($vid)
    {
		//$this->checkPermissionMethod('list.activity');
		$activityVariant = ActivityVariant::select('activity_id','variant_id')->find($vid);
		$activity = Activity::select('vat')->find($activityVariant->activity_id);
		$vat = $activity->vat;
        return view('activity_variant_prices.create',compact('vid','vat'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		$recordId = null;
		$options['allow_img_size'] = 10;
        $request->validate([
		'rate_valid_from' => 'required|date',
		'rate_valid_to' => 'required|date',
		'adult_rate_with_vat' => 'required',
		'adult_rate_without_vat' => 'required',
		], [
		'rate_valid_to.unique' => 'The date range must not overlap with an existing date range for the given activity variant.',
		]);

		//dd($request->all());
		$activity_variant_id = $request->input('activity_variant_id');
		$rate_valid_from = date("Y-m-d",strtotime($request->input('rate_valid_from')));
		$rate_valid_to = date("Y-m-d",strtotime($request->input('rate_valid_to')));
		$variantPriceCount = VariantPrice::where(function($query) use ($rate_valid_from, $rate_valid_to) {
			$query->where(function($subquery) use ($rate_valid_from, $rate_valid_to) {
				$subquery->whereDate('rate_valid_from', '<=', $rate_valid_from)
						 ->whereDate('rate_valid_to', '>=', $rate_valid_from);
			})->orWhere(function($subquery) use ($rate_valid_from, $rate_valid_to) {
				$subquery->whereDate('rate_valid_from', '<=', $rate_valid_to)
						 ->whereDate('rate_valid_to', '>=', $rate_valid_to);
			})->orWhere(function($subquery) use ($rate_valid_from, $rate_valid_to) {
				$subquery->whereDate('rate_valid_from', '>=', $rate_valid_from)
						 ->whereDate('rate_valid_to', '<=', $rate_valid_to);
			});
		})->where('activity_variant_id', $activity_variant_id)->count();
		
		if($variantPriceCount > 0){
		return redirect()->back()->withInput()->with('error', 'The date range must not overlap with an existing date range for the given activity variant.');;
		}
		
        $record = new VariantPrice();
		
		$record->activity_variant_id = $activity_variant_id;
        $record->rate_valid_from = $rate_valid_from;
		$record->rate_valid_to = $rate_valid_to;
		$record->adult_rate_with_vat = $request->input('adult_rate_with_vat');
		$record->adult_rate_without_vat = $request->input('adult_rate_without_vat');
		$record->adult_mini_selling_price = $request->input('adult_mini_selling_price');
		$record->adult_B2C_with_vat = $request->input('adult_B2C_with_vat');
		$record->adult_max_no_allowed = $request->input('adult_max_no_allowed');
		$record->adult_min_no_allowed = $request->input('adult_min_no_allowed');
		$record->adult_start_age = $request->input('adult_start_age');
		$record->adult_end_age = $request->input('adult_end_age');
		$record->child_rate_with_vat = $request->input('child_rate_with_vat');
		$record->child_rate_without_vat = $request->input('child_rate_without_vat');
		$record->child_mini_selling_price = $request->input('child_mini_selling_price');
		$record->child_B2C_with_vat = $request->input('child_B2C_with_vat');
        $record->child_max_no_allowed = $request->input('child_max_no_allowed');
		$record->child_min_no_allowed = $request->input('child_min_no_allowed');
		$record->child_start_age = $request->input('child_start_age');
		$record->child_end_age = $request->input('child_end_age');
		$record->infant_rate_with_vat = $request->input('infant_rate_with_vat');
		$record->infant_rate_without_vat = $request->input('infant_rate_without_vat');
		$record->infant_mini_selling_price = $request->input('infant_mini_selling_price');
		$record->infant_B2C_with_vat = $request->input('infant_B2C_with_vat');
		$record->infant_max_no_allowed = $request->input('infant_max_no_allowed');
		$record->infant_min_no_allowed = $request->input('infant_min_no_allowed');
		$record->infant_start_age = $request->input('infant_start_age');
		
		$record->infant_end_age = $request->input('infant_end_age');
		$record->created_by = auth()->user()->id;
		$record->save();
		
		$activityVariantCount = VariantPrice::where("activity_variant_id",$activity_variant_id)->count();
		$activityVariant = ActivityVariant::find($activity_variant_id);
		$variant = Variant::find($activityVariant->variant_id);
		
			if($activityVariantCount > 0){
			$variant->is_price = 1;
			$variant->save();
			} else {
				$variant->is_price = 0;
				$variant->save();
			}
			
			
			
        return redirect('activity-variant/prices/'.$activity_variant_id)->with('success', 'Prices Created Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
		$record = VariantPrice::find($id);
         return view('activity_variant_prices.view')->with(['record' => $record]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\State  $State
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
		//$this->checkPermissionMethod('list.activity');
        $record = VariantPrice::find($id);
		$vid = $record->activity_variant_id;
		$vat = @$record->av->activity->vat;
		(!empty($vat))?$vat:0;
		return view('activity_variant_prices.edit',compact('record','vid','vat'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\State  $State
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
		
		$recordId = null;
		$options['allow_img_size'] = 10;
        $request->validate([
		'rate_valid_from' => 'required|date',
		'rate_valid_to' => 'required|date',
		'adult_rate_with_vat' => 'required',
		'adult_rate_without_vat' => 'required',
		], [
		'rate_valid_to.unique' => 'The date range must not overlap with an existing date range for the given activity variant.',
		]);

		//dd($request->all());
		$activity_variant_id = $request->input('activity_variant_id');
		$rate_valid_from = date("Y-m-d",strtotime($request->input('rate_valid_from')));
		$rate_valid_to = date("Y-m-d",strtotime($request->input('rate_valid_to')));
		$variantPriceCount = VariantPrice::where(function($query) use ($rate_valid_from, $rate_valid_to) {
			$query->where(function($subquery) use ($rate_valid_from, $rate_valid_to) {
				$subquery->whereDate('rate_valid_from', '<=', $rate_valid_from)
						 ->whereDate('rate_valid_to', '>=', $rate_valid_from);
			})->orWhere(function($subquery) use ($rate_valid_from, $rate_valid_to) {
				$subquery->whereDate('rate_valid_from', '<=', $rate_valid_to)
						 ->whereDate('rate_valid_to', '>=', $rate_valid_to);
			})->orWhere(function($subquery) use ($rate_valid_from, $rate_valid_to) {
				$subquery->whereDate('rate_valid_from', '>=', $rate_valid_from)
						 ->whereDate('rate_valid_to', '<=', $rate_valid_to);
			});
		})->where('activity_variant_id', $activity_variant_id)->where('id','!=', $id)->count();
		
		if($variantPriceCount > 0){
		return redirect()->back()->withInput()->with('error', 'The date range must not overlap with an existing date range for the given activity variant.');;
		}

		//dd($request->all());
		$record = VariantPrice::find($id);
		$vid = $record->activity_variant_id;
        $record->rate_valid_from = date("Y-m-d",strtotime($request->input('rate_valid_from')));
		$record->rate_valid_to = date("Y-m-d",strtotime($request->input('rate_valid_to')));
		$record->adult_rate_with_vat = $request->input('adult_rate_with_vat');
		$record->adult_rate_without_vat = $request->input('adult_rate_without_vat');
		$record->adult_mini_selling_price = $request->input('adult_mini_selling_price');
		$record->adult_B2C_with_vat = $request->input('adult_B2C_with_vat');
		$record->adult_max_no_allowed = $request->input('adult_max_no_allowed');
		$record->adult_min_no_allowed = $request->input('adult_min_no_allowed');
		$record->adult_start_age = $request->input('adult_start_age');
		$record->adult_end_age = $request->input('adult_end_age');
		$record->child_rate_with_vat = $request->input('child_rate_with_vat');
		$record->child_rate_without_vat = $request->input('child_rate_without_vat');
		$record->child_mini_selling_price = $request->input('child_mini_selling_price');
		$record->child_B2C_with_vat = $request->input('child_B2C_with_vat');
        $record->child_max_no_allowed = $request->input('child_max_no_allowed');
		$record->child_min_no_allowed = $request->input('child_min_no_allowed');
		$record->child_start_age = $request->input('child_start_age');
		$record->child_end_age = $request->input('child_end_age');
		$record->infant_rate_with_vat = $request->input('infant_rate_with_vat');
		$record->infant_rate_without_vat = $request->input('infant_rate_without_vat');
		$record->infant_mini_selling_price = $request->input('infant_mini_selling_price');
		$record->infant_B2C_with_vat = $request->input('infant_B2C_with_vat');
		$record->infant_max_no_allowed = $request->input('infant_max_no_allowed');
		$record->infant_min_no_allowed = $request->input('infant_min_no_allowed');
		$record->infant_start_age = $request->input('infant_start_age');
		$record->infant_end_age = $request->input('infant_end_age');
		$record->updated_by = auth()->user()->id;
		$record->save();
		
		$activityVariantCount = VariantPrice::where("activity_variant_id",$vid)->count();
		$activityVariant = ActivityVariant::find($vid);
		$variant = Variant::find($activityVariant->variant_id);
		
			if($activityVariantCount > 0){
			$variant->is_price = 1;
			$variant->save();
			} else {
				$variant->is_price = 0;
				$variant->save();
			}
			
			
			
        return redirect('activity-variant/prices/'.$vid)->with('success', 'Prices Created Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\State  $State
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = VariantPrice::find($id);
		$activity_variant_id = $record->activity_variant_id;
        $record->delete();
		$activityVariantCount = VariantPrice::where("activity_variant_id",$activity_variant_id)->count();
		$activityVariant = ActivityVariant::find($vid);
		$variant = Variant::find($activityVariant->variant_id);
		
			if($activityVariantCount > 0){
			$variant->is_price = 1;
			$variant->save();
			} else {
				$variant->is_price = 0;
				$variant->save();
			}
			
			
		return redirect('activity-variant/prices/'.$record->activity_variant_id)->with('success', 'Prices Deleted Successfully.');
    }
	
	
	
}