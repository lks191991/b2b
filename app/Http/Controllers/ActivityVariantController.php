<?php
namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Files;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Variant;
use App\Models\ActivityVariant;
use App\Models\VariantPrice;
use DB;
use Image;
use File;

class ActivityVariantController extends Controller
{
    
	 
    public function index(Request $request)
    {
		$this->checkPermissionMethod('list.activity');
        $data = $request->all();
        $perPage = config("constants.ADMIN_PAGE_LIMIT");
        $query = ActivityVariant::with(['activity','variant'])->where('id','!=','');
		if (isset($data['activity_name']) && !empty($data['activity_name'])) {
                $query->whereHas('activity', function ($q) use ($data) {
				$q->where('title', 'like', '%' . $data['activity_name'] . '%');
			});
        }
		if (isset($data['variant_name']) && !empty($data['variant_name'])) {
                $query->whereHas('variant', function ($q) use ($data) {
				$q->where('title', 'like', '%' . $data['variant_name'] . '%');
			});
        }
		
		if (isset($data['code']) && !empty($data['code'])) {
            $query->where('code', 'like', '%' . $data['code'] . '%');
        }
		
        $records = $query->orderBy('created_at', 'DESC')->paginate($perPage);
		//dd($records);
        return view('activity_variants.index', compact('records'));
    }


  public function create(Request $request)
    {
		$this->checkPermissionMethod('list.activity');
        $data = $request->all();
		$activities = Activity::where('status',1)->get();
		$variants = Variant::where('status',1)->get();
		//dd($records);
        return view('activity_variants.create', compact('activities','variants'));
    }
	
	public function store(Request $request)
	{
    $request->validate([
        'code' => 'required',
        'activity_id' => 'required',
        'variant_id' => 'required_if:activity_id,1', 
        'variant_id.*' => 'exists:variants,id',
    ], [
        'activity_id.required' => 'Please select activity.',
		'code.required' => 'Display Name required.',
        'variant_id.required_if' => 'Please select at least one variant.',
        'variant_id.*.exists' => 'One or more selected variants do not exist in the database.',
    ]);

    $variantIds = $request->input('variant_id');

  

    $code = $request->input('code');
    $is_popular = $request->input('is_popular');

    $activityId = $request->input('activity_id');

    $activity = Activity::find($activityId);
   
    $type = 'bundle';
    if($activity->product_type == 'Standalone')
        $type = 'single';
    foreach ($variantIds as $variantId) {

        $variant = Variant::find($variantId);
        $avname = array();
        $avname[$activity->title] = $activity->title;
        $avname[$variant->title] = $variant->title;

		$existingRecord = ActivityVariant::where('activity_id', $activityId)
        ->where('variant_id', $variantId)
        ->count();
		if ($existingRecord == 0) {
        $record = ActivityVariant::create([
            'code' => $code,
            'is_popular' => $is_popular,
            'activity_id' => $activityId,
            'variant_id' => $variantId,
            'type' => $type,
            'ActivityVariantName' => implode(" ",$avname)
        ]);

        $record->update(['ucode' => 'AV'.$record->id]);
		}
    }

    return redirect('activity-variants')->with('success', 'Activity Variant(s) Created Successfully.');
	}
	
	
	public function edit(Request $request,$id)
    {
		$this->checkPermissionMethod('list.activity');
        $data = $request->all();
		$activityVariant = ActivityVariant::find($id);
		$activities = Activity::where('status',1)->get();
		$variants = Variant::where('status',1)->get();
		//dd($records);
        return view('activity_variants.edit', compact('activities','variants','activityVariant'));
    }
	
	public function update(Request $request, $id)
	{
    $request->validate([
        'code' => 'required',
        'activity_id' => 'required',
        'variant_id' => 'required_if:activity_id,1', 
    ], [
        'activity_id.required' => 'Please select activity.',
		'code.required' => 'Display Name required.',
        'variant_id.required_if' => 'Please select variant.',
        'variant_id.*.exists' => 'One or more selected variants do not exist in the database.',
    ]);

    $variantIds = $request->input('variant_id');
    $code = $request->input('code');
    $activityId = $request->input('activity_id');
    $activity = Activity::find($activityId);
    $variant = Variant::find($variantIds);
    $avname = array();
    $avname[$activity->title] = $activity->title;
    $avname[$variant->title] = $variant->title;
    $type = 'bundle';
    if($activity->product_type == 'Standalone')
        $type = 'single';
    $is_popular = $request->input('is_popular');
		$existingRecord = ActivityVariant::where('activity_id', $activityId)
        ->where('variant_id', $variantIds)->where('id', '!=',$id)
        ->count();
		if ($existingRecord == 0) {
        $record = ActivityVariant::where('id', $id)->update([
            'code' => $code,
            'is_popular' => $is_popular,
            'activity_id' => $activityId,
            'variant_id' => $variantIds,
            'type' => $type,
            'ActivityVariantName' => implode(" ",$avname)
        ]);

		}

    return redirect('activity-variants')->with('success', 'Activity Variant Updated Successfully.');
	}
	
	public function destroy($id)
    {
        $record = ActivityVariant::find($id);
        $record->delete();
		return redirect('activity-variants')->with('success', 'Activity Variant Deleted Successfully.');
    }
}