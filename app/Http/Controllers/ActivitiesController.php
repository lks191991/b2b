<?php
namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Files;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Currency;
use App\Models\Tag;
use DB;
use Image;
use File;

class ActivitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	 
    public function index(Request $request)
    {
		$this->checkPermissionMethod('list.activity');
        $data = $request->all();
		$typeActivities = config("constants.typeActivities"); 
        $perPage = config("constants.ADMIN_PAGE_LIMIT");
        $query = Activity::where('id','!=', null);
        if (isset($data['name']) && !empty($data['name'])) {
            $query->where('title', 'like', '%' . $data['name'] . '%');
        }
       
	   if (isset($data['min_price']) && !empty($data['min_price'])) {
            $query->where('min_price', 'like', '%' . $data['min_price'] . '%');
        }
		
		if (isset($data['list_price']) && !empty($data['list_price'])) {
            $query->where('list_price', 'like', '%' . $data['list_price'] . '%');
        }
		
        if (isset($data['status']) && !empty($data['status'])) {
            if($data['status'] == 1)
                $query->where('status', 1);
            if($data['status'] == 2)
                $query->where('status', 0);
        }
		
        $records = $query->orderBy('created_at', 'DESC')->paginate($perPage);
		//dd($records);
        return view('activities.index', compact('records','typeActivities'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$this->checkPermissionMethod('list.activity');
		$typeActivities = config("constants.typeActivities"); 
		
		$countries = Country::where('status', 1)->orderBy('name', 'ASC')->get();
		$currencies = Currency::where('status', 1)->orderBy('name', 'ASC')->get();
		$tags = Tag::select("name")->where('status', 1)->orderBy('name', 'ASC')->get();
        return view('activities.create',compact('typeActivities','countries','currencies','tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		$options['allow_img_size'] = 10;
        $request->validate([
            'title' => 'required|max:255|sanitizeScripts',
			'description' => 'required',
			'product_type' => 'required',
			'entry_type' => 'required',
			'min_price' => 'required',
			'list_price' => 'required',
			'country_id' => 'required',
			'state_id' => 'required',
			'city_id' => 'required',
			'featured_image' => 'nullable|image|max:' . ($options['allow_img_size'] * 1024),
			'image.*' => 'nullable|image|max:' . ($options['allow_img_size'] * 1024),
        ], [
            'title.sanitize_scripts' => 'Invalid value entered for title field.',
			'min_price.required' => 'Min Price field is required.',
			'list_price.required' => 'Selling Price field is required.',
			'image.*.max' => 'The image must not be greater than '. $options['allow_img_size'] .' MB.',
			'featured_image.max' => 'The featured image must not be greater than '.$options['allow_img_size'].' MB.',
			'image.*.image' => 'The image must be an image.',
        ]);

		
        $record = new Activity();
		
		
		if($request->hasfile('featured_image')){
            $image = $request->file('featured_image');
			$record->image = $this->uploadImages($image);
        }
		
		if($request->has('tags') && !empty($request->tags)){
           $tags = implode(",",$request->tags);
			$record->tags = $tags;
        }
		
		if($request->has('tagsforshow') && !empty($request->tagsforshow)){
           $tagsforshow = implode(",",$request->tags);
			$record->tagsforshow = $tagsforshow;
        }
		
        $record->title = $request->input('title');
		$record->city_id = $request->input('city_id');
		$record->state_id = $request->input('state_id');
		$record->entry_type = $request->input('entry_type');
		$record->country_id = $request->input('country_id');
		$record->vat = $request->input('vat');
		$record->currency_id = $request->input('currency_id');
		$record->product_type = $request->input('product_type');
		$record->short_description = $request->input('short_description');
		$record->bundle_product_cancellation = $request->input('bundle_product_cancellation');
		$record->notes = $request->input('notes');
		$record->longitute = $request->input('longitute');
		$record->latitude = $request->input('latitude');
		$record->min_price = $request->input('min_price');
		$record->list_price = $request->input('list_price');
		$record->description = $request->input('description');
        $record->status = $request->input('status');
		$record->popularity = $request->input('popularity');
		$record->created_by = Auth::user()->id;
		$record->save();
		
		//Upload Additional images
        $images = array();
        if($request->hasfile('image'))
        {
           foreach($request->file('image') as $file)
           {
               $filename = $this->uploadImages($file);
			   $images[] = [
                    'filename' => $filename,
                    'model_id' => $record->id,
					'model' => "Activity",
                ];
            }
			
			Files::insert($images);
        }
		
		
		/* if ($request->has('save_and_continue')) {
        return redirect()->route('activity.prices.create',$record->id)->with('success', 'Activity Created Successfully.');
		} else { */
        return redirect('activities')->with('success', 'Activity Created Successfully.');
		//}
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Activity $activity)
    {
		$this->checkPermissionMethod('list.activity');
		$typeActivities = config("constants.typeActivities"); 
		$activity = $activity::where('id',$activity->id)->first();
		
         return view('activities.view')->with(['activity' => $activity,'typeActivities'=>$typeActivities]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\State  $State
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
		$this->checkPermissionMethod('list.activity');
        $record = Activity::find($id);
		$typeActivities = config("constants.typeActivities"); 
		$countries = Country::where('status', 1)->orderBy('name', 'ASC')->get();
        $states = State::where('status', 1)->where('country_id', $record->country_id)->orderBy('name', 'ASC')->get();
        $cities = City::where('status', 1)->where('state_id', $record->state_id)->orderBy('name', 'ASC')->get();
		$currencies = Currency::where('status', 1)->orderBy('name', 'ASC')->get();
		$images = '["';
		$image_key = [];
        if($record->images != ''){
            $image_path = [];
            $image_key = [];
            foreach($record->images as $image){
                $image_path[] = asset('/uploads/activities/' . $image->filename);
                $image_key[] = $image->id;
            }

            $images .= implode('","', $image_path );
        }
        $images .= '"]';
		
		$tags = Tag::select("name")->where('status', 1)->orderBy('name', 'ASC')->get();
		
		return view('activities.edit',compact('record','typeActivities','countries','states','cities','images', 'image_key','currencies','tags'));
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
		
		$options['allow_img_size'] = 10;
        $request->validate([
            'title' => 'required|max:255|sanitizeScripts',
			'description' => 'required',
			'product_type' => 'required',
			'entry_type' => 'required',
			'list_price' => 'required',
			'min_price' => 'required',
			'country_id' => 'required',
			'state_id' => 'required',
			'city_id' => 'required',
			'featured_image' => 'nullable|image|max:' . ($options['allow_img_size'] * 1024),
			'image.*' => 'nullable|mimes:jpeg,jpg,png|max:' . ($options['allow_img_size'] * 1024),
        ], [
		'min_price.required' => 'Min Price field is required.',
		'list_price.required' => 'Selling Price field is required.',
		'featured_image.max' => 'The featured image must not be greater than '.$options['allow_img_size'].' MB.',
         'title.sanitize_scripts' => 'Invalid value entered for title field.',
        ]);

        $record = Activity::find($id);
		//check featured_image
        if($request->hasfile('featured_image')){
            $image = $request->file('featured_image');
			$old = '';
			if($record->image != 'no-image.png'){
				$old = $record->image;
			}
			
			$record->image = $this->uploadImages($image,$old);
        }
		
		
		$record->title = $request->input('title');
		$record->city_id = $request->input('city_id');
		$record->state_id = $request->input('state_id');
		$record->entry_type = $request->input('entry_type');
		$record->country_id = $request->input('country_id');
		$record->vat = $request->input('vat');
		$record->currency_id = $request->input('currency_id');
		$record->product_type = $request->input('product_type');
		$record->short_description = $request->input('short_description');
		$record->bundle_product_cancellation = $request->input('bundle_product_cancellation');
		$record->notes = $request->input('notes');
		$record->longitute = $request->input('longitute');
		$record->latitude = $request->input('latitude');
		$record->description = $request->input('description');
		$record->min_price = $request->input('min_price');
		$record->list_price = $request->input('list_price');
        $record->status = $request->input('status');
		$record->popularity = $request->input('popularity');
		$record->updated_by = Auth::user()->id;
		if($request->has('tags') && !empty($request->tags)){
           $tags = implode(",",$request->tags);
			$record->tags = $tags;
        }
		if($request->has('tagsforshow') && !empty($request->tagsforshow)){
           $tagsforshow = implode(",",$request->tagsforshow);
			$record->tagsforshow = $tagsforshow;
        }
        $record->save();
		
		//Upload Additional images
        if($request->hasfile('image'))
        {
           foreach($request->file('image') as $file)
           {
				$additional_filename = $this->uploadImages($file);
				$original_name = $file->getClientOriginalName();
				$data['filename'] = $additional_filename;
				$data['model_id'] = $record->id;
				$data['model'] = "Activity";
				$add_image = Files::create($data);
            }
        }
		
        return redirect('activities')->with('success', 'Activity Updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\State  $State
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = Activity::find($id);
        $record->delete();
        return redirect('activities')->with('success', 'Activity Deleted.');
    }
	
	
	/**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createPriceForm($id)
    {
		$this->checkPermissionMethod('list.activity');
		$activity = Activity::find($id);
        return view('activities.create_prices',compact('activity'));
    }
	
	
	
    public function editPriceForm($id)
    {
		$this->checkPermissionMethod('list.activity');
		$activity = Activity::find($id);
		$priceData = ActivityPrices::where('activity_id',$id)->get();
		
        return view('activities.edit_prices',compact('activity','priceData'));
    }
	
	 /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
	 
    public function activityPriceSave(Request $request)
    {
		
		//print_r($request->all());
		//exit;
		$act = Activity::find($request->input('activity_id'));
		
		$variant_name = $request->input('variant_name');
		$variant_code = $request->input('variant_code');
		$slot_duration = $request->input('slot_duration');
		$activity_duration = $request->input('activity_duration');
		$end_time = $request->input('end_time');
		$start_time = $request->input('start_time');
		$rate_valid_from = $request->input('rate_valid_from');
		$rate_valid_to = $request->input('rate_valid_to');
		$pickup_time = $request->input('pickup_time');
		$drop_time = $request->input('drop_time');
		$for_backend_only = $request->input('for_backend_only');
		
		$adult_rate_without_vat = $request->input('adult_rate_without_vat');
		$adult_rate_with_vat = $request->input('adult_rate_with_vat');
		$adult_max_no_allowed = $request->input('adult_max_no_allowed');
		$adult_min_no_allowed = $request->input('adult_min_no_allowed');
		$adult_start_age = $request->input('adult_start_age');
		$adult_end_age = $request->input('adult_end_age');
		$chield_rate_without_vat = $request->input('chield_rate_without_vat');
		$chield_rate_with_vat = $request->input('chield_rate_with_vat');
		$chield_max_no_allowed = $request->input('chield_max_no_allowed');
		$chield_min_no_allowed = $request->input('chield_min_no_allowed');
		$chield_start_age = $request->input('chield_start_age');
		$chield_end_age = $request->input('chield_end_age');
		$infant_rate_without_vat = $request->input('infant_rate_without_vat');
		$infant_rate_with_vat = $request->input('infant_rate_with_vat');
		$infant_max_no_allowed = $request->input('infant_max_no_allowed');
		$infant_min_no_allowed = $request->input('infant_min_no_allowed');
		$infant_start_age = $request->input('infant_start_age');
		$infant_end_age = $request->input('infant_end_age');
		
		$booking_window_valueto = $request->input('booking_window_valueto');
		$cancellation_value_to = $request->input('cancellation_value_to');
		$booking_window_valueSIC = $request->input('booking_window_valueSIC');
		$cancellation_valueSIC = $request->input('cancellation_valueSIC');
		$booking_window_valuePVT = $request->input('booking_window_valuePVT');
		$cancellation_valuePVT = $request->input('cancellation_valuePVT');
		$u_code = $request->input('u_code');
		$data = [];
		foreach($variant_name as $k => $v)
		{
			$data[] = [
					'u_code' => $u_code[$k],	
					'activity_id' => $request->input('activity_id'),
                    'variant_name' => $v,
					'variant_code' => $variant_code[$k],
                    'slot_duration' => $slot_duration[$k],
					'activity_duration' => $activity_duration[$k],
					'start_time' => $start_time[$k],
					'end_time' => $end_time[$k],
					'rate_valid_from' => $rate_valid_from[$k],
					'rate_valid_to' => $rate_valid_to[$k],
					'pickup_time' => '',
					'drop_time' => '',
					'for_backend_only' => (!empty($for_backend_only[$k]))?$for_backend_only[$k]:0,
					
					'adult_rate_without_vat' => $adult_rate_without_vat[$k],
					'adult_rate_with_vat' => $adult_rate_with_vat[$k],
					'adult_max_no_allowed' => $adult_max_no_allowed[$k],
					'adult_min_no_allowed' => $adult_min_no_allowed[$k],
					'adult_start_age' => $adult_start_age[$k],
					'adult_end_age' => $adult_end_age[$k],
					'chield_rate_without_vat' => $chield_rate_without_vat[$k],
					'chield_rate_with_vat' => $chield_rate_with_vat[$k],
					'chield_max_no_allowed' => $chield_max_no_allowed[$k],
					'chield_min_no_allowed' => $chield_min_no_allowed[$k],
					'chield_start_age' => $chield_start_age[$k],
					'chield_end_age' => $chield_end_age[$k],
					
					'infant_rate_without_vat' => $infant_rate_without_vat[$k],
					'infant_rate_with_vat' => $infant_rate_with_vat[$k],
					'infant_max_no_allowed' => $infant_max_no_allowed[$k],
					'infant_min_no_allowed' => $infant_min_no_allowed[$k],
					'infant_start_age' => $infant_start_age[$k],
					'infant_end_age' => $infant_end_age[$k],
					
					'booking_window_valueto' => $booking_window_valueto[$k],
					'cancellation_value_to' => $cancellation_value_to[$k],
					'booking_window_valueSIC' => $booking_window_valueSIC[$k],
					'cancellation_valueSIC' => $cancellation_valueSIC[$k],
					'booking_window_valuePVT' => $booking_window_valuePVT[$k],
					'cancellation_valuePVT' => $cancellation_valuePVT[$k],
					'created_by' => Auth::user()->id,
					'updated_by' => Auth::user()->id,
					
                ];
		}
		if(count($data) > 0)
		{
			ActivityPrices::where("activity_id",$request->input('activity_id'))->delete();
			ActivityPrices::insert($data);
			$act->is_price = 1;
			$act->save();
		}
		else
		{
			$act->is_price = 0;
			$act->save();
		}
		
		
        return redirect('activities')->with('success', 'Activity Created Successfully.');
    }
	
	
	public function activityPricesDelete($u_code)
    {
       
		$vaCount = VoucherActivity::where('variant_unique_code',$u_code);
			if($vaCount->count() > 0){
				$dd = $vaCount->first();
				return redirect('activities/'.$dd->activity_id)->with('error', 'This Activity variant assigned in voucher so cannot delete.');
			}else{
			 $record = ActivityPrices::where('u_code',$u_code);
			 $data = $record->first();
			 $record->delete();
			 return redirect('activities/'.$data->activity_id)->with('success', 'Activity Variant Deleted.');
			}
        
		
		
    }
	
	/**
     * Specified  from upload company images and remove if already uploaded.
     *
     */
    public function uploadImages($file, $old ='')
    {
        $dest_fullfile = public_path('/uploads/activities/');
        $dest_thumb = public_path('/uploads/activities/thumb/');
        File::isDirectory($dest_fullfile) or File::makeDirectory($dest_fullfile,  0777, true, true);
        File::isDirectory($dest_thumb) or File::makeDirectory($dest_thumb,  0777, true, true);
        if(!empty($old) && File::exists($dest_fullfile.$old)){
            File::delete($dest_fullfile.$old);
            if(File::exists($dest_thumb .$old)){
                File::delete($dest_thumb .$old);
            }
        }
        $imgFile = Image::make($file->getRealPath());
        $imagename = time().rand(10,1000) . '.'. $file->getClientOriginalExtension();
        $imgFile->save($dest_fullfile . $imagename);
        $imgFile->resize(360, 250, function ($constraint) {
            $constraint->aspectRatio();
        })->save($dest_thumb . $imagename);
        return $imagename;
    }
	
	public function newRowAddmore(Request $request)
    {
		$activity_id = $request->input('activity_id');
		$rowCount = $request->input('rowCount');
		$activity = Activity::find($activity_id);
		$view = view("activities.addmore_prices",['rowCount'=>$rowCount,'activity'=>$activity])->render();
         return response()->json(['success' => 1, 'html' => $view]);
    }
	
	
	public function cloneActivity($id)
	{
    $original = Activity::findOrFail($id);

    $newRecord = $original->replicate();
    $newRecord->created_by = Auth::user()->id; 
    $newRecord->image = 'no-image.png'; 
    $newRecord->save();

    return redirect('activities')->with('success', 'Activity Cloned Successfully.');
	}

}
