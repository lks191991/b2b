<?php
namespace App\Http\Controllers;

use App\Models\Variant;
use App\Models\Slot;
use App\Models\VariantCanellation;
use App\Models\Transfer;
use App\Models\Zone;
use App\Models\Files;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Image;
use File;

class VariantsController extends Controller
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
        $query = Variant::where('id','!=', null);
        if (isset($data['name']) && !empty($data['name'])) {
            $query->where('title', 'like', '%' . $data['name'] . '%');
        }
       
	    if (isset($data['list_price']) && !empty($data['list_price'])) {
            $query->where('list_price', 'like', '%' . $data['list_price'] . '%');
        }
		
		if (isset($data['sell_price']) && !empty($data['sell_price'])) {
            $query->where('sell_price', 'like', '%' . $data['sell_price'] . '%');
        }
		
		
        if (isset($data['status']) && !empty($data['status'])) {
            if ($data['status'] == 1)
                $query->where('status', 1);
            if ($data['status'] == 2)
                $query->where('status', 0);
        }
		
		if (isset($data['is_slot']) && !empty($data['is_slot'])) {
            if ($data['is_slot'] == 1)
                $query->where('is_slot', 1);
            if ($data['is_slot'] == 2)
                $query->where('is_slot', 0);
        }
		
		if (isset($data['is_canellation']) && !empty($data['is_canellation'])) {
            if ($data['is_canellation'] == 1)
                $query->where('is_canellation', 1);
            if ($data['is_canellation'] == 2)
                $query->where('is_canellation', 0);
        }
		
		if (isset($data['for_backend_only']) && !empty($data['for_backend_only'])) {
            if ($data['for_backend_only'] == 1)
                $query->where('for_backend_only', 1);
            if ($data['for_backend_only'] == 2)
                $query->where('for_backend_only', 0);
        }

        $records = $query->orderBy('created_at', 'DESC')->paginate($perPage);
		//dd($records);
        return view('variants.index', compact('records'));
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
		$transfers = Transfer::where('status', 1)->orderBy('name', 'ASC')->get();
		$zones = Zone::where('status', 1)->orderBy('name', 'ASC')->get();
		$varaints = Variant::where('status', 1)->where('parent_code', 0)->orderBy('title', 'ASC')->get();
        return view('variants.create',compact('typeActivities','transfers','zones','varaints'));
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
			'code' => 'required',
			'slot_type' => 'required',
			'list_price' => 'required',
			'sell_price' => 'required',
			'start_time' => 'required|date_format:H:i',
			'end_time' => 'required|date_format:H:i',
			'available_slots' => ($request->slot_type == 1) ? 'required' : '',
            'slot_duration' => ($request->slot_type == 2) ? 'required|integer' : '',
			'ticket_banner_image' => 'nullable|image|max:' . ($options['allow_img_size'] * 1024),
			'ticket_footer_image' => 'nullable|image|max:' . ($options['allow_img_size'] * 1024),
			'brand_logo' => 'nullable|image|max:' . ($options['allow_img_size'] * 1024),
			'image.*' => 'nullable|image|max:' . ($options['allow_img_size'] * 1024),
        ], [
			'available_slots.required' => 'Available slots is required when Slot Type is Custom.',
			'sell_price.required' => 'Min Selling field is required.',
			'list_price.required' => 'Min Price field is required.',
            'slot_duration.required' => 'Sot Duration is required when Slot Type is Auto.',
			'start_time.date_format' => 'Date format in 24 hours like 11:00,23:00.',
            'end_time.date_format' => 'Date format in 24 hours like 11:00,23:00.',
            'title.sanitize_scripts' => 'Invalid value entered for title field.',
			'ticket_banner_image.max' => 'The featured ticket banner image must not be greater than '.$options['allow_img_size'].' MB.',
			'ticket_footer_image.max' => 'The featured ticket footer image must not be greater than '.$options['allow_img_size'].' MB.',
			'brand_logo.max' => 'The brand logo must not be greater than '.$options['allow_img_size'].' MB.',
			'image.*.max' => 'The image must not be greater than '. $options['allow_img_size'] .' MB.',
			'image.*.image' => 'The image must be an image.',
        ]);

		
        $record = new Variant();
		
		$allday = ($request->input('AllDay'))?$request->input('AllDay'):'';
		$weekdays = ($request->input('day'))?$request->input('day'):[];
		
		if($allday == 'All')
		{
			$record->availability = $allday;
		}
		else
		{
			if(count($weekdays) > 0)
			{
				$days = implode(",",$weekdays);
				$record->availability = $days;
			}
		}
		
		$sic_TFRS = $request->input('sic_TFRS');
		
		if($sic_TFRS == 1)
		{
			$zones = $request->input('zones');
			$zoneValue = $request->input('zoneValue');
			$zoneValueChild = $request->input('zoneValueChild');
			$pickup_time = $request->input('pickup_time');
			$dropup_time = $request->input('dropup_time');
			$zoneArray = [];
			foreach($zones as $k => $z)
			{
				$zv = @$zoneValue[$k];
				$zvC = @$zoneValueChild[$k];
				$zoneArray[] = [
				'zone' => $z,
				'zoneValue' => (!empty($zv))?$zv:0,
				'zoneValueChild' => (!empty($zvC))?$zvC:0,
				'pickup_time' => $pickup_time[$k],
				'dropup_time' => $dropup_time[$k],
				];
			}
			
			$zoneArrayJson = json_encode($zoneArray);
			$record->zones = $zoneArrayJson;
		}
		else
		{
			$record->zones = '';
		}
		
		if($request->hasfile('brand_logo')){
            $image = $request->file('brand_logo');
			$record->brand_logo = $this->uploadImages($image);
        }
		
		if($request->hasfile('ticket_banner_image')){
            $image = $request->file('ticket_banner_image');
			$record->ticket_banner_image = $this->uploadImages($image);
        }
		
		if($request->hasfile('ticket_footer_image')){
            $image = $request->file('ticket_footer_image');
			$record->ticket_footer_image = $this->uploadImages($image);
        }
		
		
		$record->sic_TFRS = $sic_TFRS;
        $record->title = $request->input('title');
		$record->code = $request->input('code');
		$record->advance_booking = $request->input('advance_booking');
		$record->days_for_advance_booking = $request->input('days_for_advance_booking');
		$record->booking_window = $request->input('booking_window');
		$record->cancellation_value = $request->input('cancellation_value');
		$record->booking_window = $request->input('booking_window');
		$record->booking_window = $request->input('booking_window');
		$record->booking_window = $request->input('booking_window');
		$record->black_out = $request->input('black_out');
		$record->sold_out = $request->input('sold_out');
		$record->is_opendated = $request->input('is_opendated');
		$record->valid_till = ($request->input('is_opendated')==1)?$request->input('valid_till'):'';
		$record->pvt_TFRS = $request->input('pvt_TFRS');
		$record->pvt_TFRS_text = $request->input('pvt_TFRS_text');
		$record->pick_up_required = $request->input('pick_up_required');
		$record->transfer_plan = ($request->input('pvt_TFRS')==1)?$request->input('transfer_plan'):0;
		$record->slot_type = $request->input('slot_type');
		$record->available_slots = ($request->slot_type == 3)?'':$request->input('available_slots');
		$record->slot_duration = ($request->slot_type == 3)?'':$request->input('slot_duration');
		$record->activity_duration = $request->input('activity_duration');
		$record->start_time = $request->input('start_time');
		$record->end_time = $request->input('end_time');
		$record->inclusion = $request->input('inclusion');
		$record->important_information = $request->input('important_information');
		$record->description = $request->input('description');
		$record->cancellation_policy = $request->input('cancellation_policy');
		$record->booking_cut_off = $request->input('booking_cut_off');
		$record->booking_policy = $request->input('booking_policy');
		$record->terms_conditions = $request->input('terms_conditions');
		$record->for_backend_only = $request->input('for_backend_only');
        $record->status = $request->input('status');
		$record->created_by = Auth::user()->id;
		$record->list_price = $request->input('list_price');
		$record->parent_code = $request->input('parent_code');
		$record->sell_price = $request->input('sell_price');
		$record->type = $request->input('type');
		$record->is_refundable = $request->input('is_refundable');
		$record->save();
		$ucode = 'UV'.$record->id;
		$vrt = Variant::find($record->id);
		$vrt->ucode = $ucode;
		$vrt->save();
		
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
					'model' => "Variant",
                ];
            }
			
			Files::insert($images);
        }
		
		//if ($request->has('save_and_continue')) {
        return redirect()->route('variant.canellation',$record->id)->with('success', 'Variant Created Successfully.');
		//} else {
        //return redirect('variants')->with('success', 'Variant Created Successfully.');
		//}
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Variant $variant)
    {
		$this->checkPermissionMethod('list.activity');
		$zoneArray = [];
		if($variant->sic_TFRS == 1)
		{
			$zoneArrayJson = json_decode($variant->zones);
			
			foreach($zoneArrayJson as $k => $z)
			{
				$zone = Zone::where('status', 1)->where('id', $z->zone)->orderBy('name', 'ASC')->first();
				
				$zoneArray[] = [
				'zone' => $zone->name,
				'zoneValue' => $z->zoneValue,
				'zoneValueChild' => $z->zoneValueChild,
				'pickup_time' => (!empty($z->pickup_time))?$z->pickup_time:'',
				'dropup_time' => (!empty($z->dropup_time))?$z->dropup_time:'',
				];
			}
			
			
		}
		
		$slots = Slot::where('variant_id', $variant->id)
		->where(function ($query) {
			$query->where('ticket_only', '>', 0)
				->orWhere('sic', '>', 0)->orWhere('pvt', '>', 0);
		})->orderBy('slot_timing')->get();
		$canellations = VariantCanellation::where('variant_id',$variant->id)->orderBy('duration')->get();
		
         return view('variants.view')->with(['variant' => $variant,'zoneArray'=>$zoneArray,'slots'=>$slots,'canellations'=>$canellations]);
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
        $record = Variant::find($id);
		$typeActivities = config("constants.typeActivities"); 
		$transfers = Transfer::where('status', 1)->orderBy('name', 'ASC')->get();
		$zones = Zone::where('status', 1)->orderBy('name', 'ASC')->get();
		$allDays = 0;
		$days = [];
		if($record->availability == 'All')
		{
			$allDays = 1;
		}
		else
		{
			$days = explode(",",$record->availability);
		}
		
		$zonesData = json_decode($record->zones);
		
		
		$images = '["';
		$image_key = [];
        if($record->images != ''){
            $image_path = [];
            $image_key = [];
            foreach($record->images as $image){
                $image_path[] = asset('/uploads/variants/' . $image->filename);
                $image_key[] = $image->id;
            }

            $images .= implode('","', $image_path );
        }
        $images .= '"]';
		$varaints = Variant::where('status', 1)->where('parent_code', 0)->orderBy('title', 'ASC')->get();
		return view('variants.edit',compact('record','typeActivities','transfers','zones','allDays','days','zonesData','images', 'image_key','varaints'));
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
        //  $request->validate([
        //     'title' => 'required|max:255|sanitizeScripts',
		// 	'description' => 'required',
		// 	'code' => 'required',
		// 	'slot_type' => 'required',
		// 	'start_time' => 'required|date_format:H:i',
		// 	'sell_price' => 'required',
		// 	'list_price' => 'required',
		// 	'end_time' => 'required|date_format:H:i',
		// 	'available_slots' => ($request->slot_type == 1) ? 'required' : '',
        //     'slot_duration' => ($request->slot_type == 2) ? 'required|integer' : '',
		// 	'ticket_banner_image' => 'nullable|image|max:' . ($options['allow_img_size'] * 1024),
		// 	'ticket_footer_image' => 'nullable|image|max:' . ($options['allow_img_size'] * 1024),
		// 	'brand_logo' => 'nullable|image|max:' . ($options['allow_img_size'] * 1024),
			
        // ], [
		// 	'available_slots.required' => 'Available slots is required when Slot Type is Custom.',
		// 	'sell_price.required' => 'Min Selling field is required.',
		// 	'list_price.required' => 'Min Price field is required.',
        //     'slot_duration.required' => 'Sot Duration is required when Slot Type is Auto.',
        //     'title.sanitize_scripts' => 'Invalid value entered for title field.',
		// 	'ticket_banner_image.max' => 'The featured ticket banner image must not be greater than '.$options['allow_img_size'].' MB.',
		// 	'ticket_footer_image.max' => 'The featured ticket footer image must not be greater than '.$options['allow_img_size'].' MB.',
		// 	'brand_logo.max' => 'The brand logo must not be greater than '.$options['allow_img_size'].' MB.',
		// 	'start_time.date_format' => 'Date format in 24 hours like 11:00,23:00.',
        //     'end_time.date_format' => 'Date format in 24 hours like 11:00,23:00.',
		// 	'image.*.image' => 'The image must be an image.',
        // ]);

        $record = Variant::find($id);
		
		if($request->hasfile('brand_logo')){
            $brand_logoimage = $request->file('brand_logo');
			$old = '';
			if($record->brand_logo != 'no-image.png'){
				$old = $record->brand_logo;
			}
			
			$record->brand_logo = $this->uploadImages($brand_logoimage,$old);
        }
		
		if($request->hasfile('ticket_banner_image')){
            $ticket_banner_image = $request->file('ticket_banner_image');
			$oldticket_banner_image = '';
			if($record->ticket_banner_image != 'no-image.png'){
				$oldticket_banner_image = $record->ticket_banner_image;
			}
			
			$record->ticket_banner_image = $this->uploadImages($ticket_banner_image,$oldticket_banner_image);
        }
		
		if($request->hasfile('ticket_footer_image')){
            $ticket_footer_image = $request->file('ticket_footer_image');
			$oldfooter_image = '';
			if($record->ticket_footer_image != 'no-image.png'){
				$oldfooter_image = $record->ticket_footer_image;
			}
			
			$record->ticket_footer_image = $this->uploadImages($ticket_footer_image,$oldfooter_image);
        }
		
		$allday = ($request->input('AllDay'))?$request->input('AllDay'):'';
		$weekdays = ($request->input('day'))?$request->input('day'):[];
		
		if($allday == 'All')
		{
			$record->availability = $allday;
		}
		else
		{
			if(count($weekdays) > 0)
			{
				$days = implode(",",$weekdays);
				$record->availability = $days;
			}
		}
		
		$sic_TFRS = $request->input('sic_TFRS');
		
		if($sic_TFRS == 1)
		{
			$zones = $request->input('zones');
			$zoneValue = $request->input('zoneValue');
			$zoneValueChild = $request->input('zoneValueChild');
			$pickup_time = $request->input('pickup_time');
			$dropup_time = $request->input('dropup_time');
			$zoneArray = [];
			foreach($zones as $k => $z)
			{
				$zv = @$zoneValue[$k];
				$zvC = @$zoneValueChild[$k];
				$zoneArray[] = [
				'zone' => $z,
				'zoneValue' => (!empty($zv))?$zv:0,
				'zoneValueChild' => (!empty($zvC))?$zvC:0,
				'pickup_time' => $pickup_time[$k],
				'dropup_time' => $dropup_time[$k],
				];
			}
			
			$zoneArrayJson = json_encode($zoneArray);
			$record->zones = $zoneArrayJson;
		}
		else
		{
			$record->zones = '';
		}
		
		
		
		$record->sic_TFRS = $sic_TFRS;
        $record->title = $request->input('title');
		$record->code = $request->input('code');
		$record->advance_booking = $request->input('advance_booking');
		$record->days_for_advance_booking = $request->input('days_for_advance_booking');
		$record->booking_window = $request->input('booking_window');
		$record->cancellation_value = $request->input('cancellation_value');
		$record->booking_window = $request->input('booking_window');
		$record->booking_window = $request->input('booking_window');
		$record->booking_window = $request->input('booking_window');
		$record->black_out = $request->input('black_out');
		$record->sold_out = $request->input('sold_out');
		$record->is_opendated = $request->input('is_opendated');
		$record->valid_till = ($request->input('is_opendated')==1)?$request->input('valid_till'):'';
		$record->pvt_TFRS = $request->input('pvt_TFRS');
		$record->pvt_TFRS_text = $request->input('pvt_TFRS_text');
		$record->pick_up_required = $request->input('pick_up_required');
		$record->transfer_plan = ($request->input('pvt_TFRS')==1)?$request->input('transfer_plan'):0;
		$record->slot_type = $request->input('slot_type');
		$record->available_slots = ($request->slot_type == 3)?'':$request->input('available_slots');
		$record->slot_duration = ($request->slot_type == 3)?'':$request->input('slot_duration');
		$record->activity_duration = $request->input('activity_duration');
		$record->start_time = $request->input('start_time');
		$record->end_time = $request->input('end_time');
		$record->inclusion = $request->input('inclusion');
		$record->important_information = $request->input('important_information');
		$record->description = $request->input('description');
		$record->cancellation_policy = $request->input('cancellation_policy');
		$record->booking_cut_off = $request->input('booking_cut_off');
		$record->booking_policy = $request->input('booking_policy');
		$record->terms_conditions = $request->input('terms_conditions');
		$record->for_backend_only = $request->input('for_backend_only');
        $record->status = $request->input('status');
		$record->updated_by = Auth::user()->id;
		$record->parent_code = $request->input('parent_code');
		$record->list_price = $request->input('list_price');
		$record->sell_price = $request->input('sell_price');
		$record->type = $request->input('type');
		$record->is_refundable = $request->input('is_refundable');
		
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
				$data['model'] = "Variant";
				$add_image = Files::create($data);
            }
        }
		
        return redirect('variants')->with('success', 'Variant Updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\State  $State
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = Variant::find($id);
        $record->delete();
        return redirect('variants')->with('success', 'Variant Deleted.');
    }
	
	/**
     * Specified  from upload company images and remove if already uploaded.
     *
     */
    public function uploadImages($file, $old ='')
    {
        $dest_fullfile = public_path('/uploads/variants/');
        $dest_thumb = public_path('/uploads/variants/thumb/');
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
	
	
	public function cloneVariant($id)
	{
		$original = Variant::findOrFail($id);

		$newRecord = $original->replicate();
		$newRecord->created_by = Auth::user()->id;
		$newRecord->ticket_banner_image = 'no-image.png';
		$newRecord->ticket_footer_image = 'no-image.png';
		$newRecord->brand_logo = 'no-image.png';
		$newRecord->save();
		
		$ucode = 'UV'.$newRecord->id;
		$newRecord->ucode = $ucode;
		$newRecord->save();

		return redirect('variants')->with('success', 'Variant Cloned Successfully.');
	}

}
