<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\HotelCategory;
use App\Models\Hotel;
use App\Models\Zone;
use Illuminate\Http\Request;
use DB;
use Image;

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		$this->checkPermissionMethod('list.hotel');
        $data = $request->all();
        $perPage = config("constants.ADMIN_PAGE_LIMIT");
        $query = Hotel::with(['country', 'state', 'city', 'hotelcategory']);
        if (isset($data['name']) && !empty($data['name'])) {
            $query->where('name', 'like', '%' . $data['name'] . '%');
        }
        if (isset($data['country_id']) && !empty($data['country_id'])) {
            $query->where('country_id', $data['country_id']);
        }
        if (isset($data['state_id']) && !empty($data['state_id'])) {
            $query->where('state_id', $data['state_id']);
        }
        if (isset($data['city_id']) && !empty($data['city_id'])) {
            $query->where('city_id', $data['city_id']);
        }
		if (isset($data['zone_id']) && !empty($data['zone_id'])) {
            $query->where('zone_id', $data['zone_id']);
        }
		if (isset($data['hotel_category_id']) && !empty($data['hotel_category_id'])) {
            $query->where('hotel_category_id', $data['hotel_category_id']);
        }
        if (isset($data['status']) && !empty($data['status'])) {
            if ($data['status'] == 1)
                $query->where('status', 1);
            if ($data['status'] == 2)
                $query->where('status', 0);
        }

        $records = $query->orderBy('created_at', 'DESC')->paginate($perPage);
		$zones = Zone::where('status', 1)->orderBy('name', 'ASC')->get();
        $countries = Country::where('status', 1)->orderBy('name', 'ASC')->get();
        $states = State::where('status', 1)->orderBy('name', 'ASC')->get();
        $cities = City::where('status', 1)->orderBy('name', 'ASC')->get();
        $hotelcategories = HotelCategory::where('status', 1)->orderBy('name', 'ASC')->get();

        return view('hotels.index', compact('records', 'countries', 'states', 'cities', 'hotelcategories','zones'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$this->checkPermissionMethod('list.hotel');
        $countries = Country::where('status', 1)->orderBy('name', 'ASC')->get();
		$zones = Zone::where('status', 1)->orderBy('name', 'ASC')->get();
        $hotelcategories = HotelCategory::where('status', 1)->orderBy('name', 'ASC')->get();

        return view('hotels.create', compact('countries', 'hotelcategories','zones'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|sanitizeScripts',
            'mobile' => 'required',
            'address' => 'required',
            'hotel_category_id' => 'required',
            'city_id' => 'required',
            'state_id' => 'required',
            'country_id' => 'required',
            'zip_code' => 'required',
			'zone_id' => 'required',
			'location' => 'required'
        ], [
            'name.sanitize_scripts' => 'Invalid value entered for Name field.',
            'country_id.required' => 'The country field is required.',
            'state_id.required' => 'The state field is required.',
        ]);


		$input = $request->all();
        $record = new Hotel();
		$destinationPath = public_path('/uploads/hotels/');
		if ($request->hasFile('image')) {

           
			$fileName = $input['image']->getClientOriginalName();
			$file = request()->file('image');
			$fileNameArr = explode('.', $fileName);
			$fileNameExt = end($fileNameArr);
			$newName = date('His').rand() . time() . '.' . $fileNameExt;
			
			$file->move($destinationPath, $newName);
			
			//$user_config = json_decode($options['user'],true);
			
			$img = Image::make(public_path('/uploads/hotels/'.$newName));
						
            $img->resize(250, 250, function($constraint) {
				$constraint->aspectRatio();
			});
			
			$img->save(public_path('/uploads/hotels/thumb/'.$newName));

            $record->image = $newName;
		}
		
        $record->name = $request->input('name');
        $record->mobile = $request->input('mobile');
        $record->address = $request->input('address');
        $record->hotel_category_id = $request->input('hotel_category_id');
        $record->zip_code = $request->input('zip_code');
        $record->country_id = $request->input('country_id');
        $record->state_id = $request->input('state_id');
        $record->city_id = $request->input('city_id');
		$record->zone_id = $request->input('zone_id');
		$record->location = $request->input('location');
		$record->brand_name = $request->input('brand_name');
		$record->formerly_name = $request->input('formerly_name');
		$record->translates_name = $request->input('translates_name');
		$record->address2 = $request->input('address2');
		$record->longitude = $request->input('longitude');
		$record->latitude = $request->input('latitude');
		$record->overview = $request->input('overview');
		$record->continent_name = $request->input('continent_name');
		$record->accommodation_type = $request->input('accommodation_type');
        $record->status = $request->input('status');
        $record->save();
        return redirect('hotels')->with('success', 'Hotel Created Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Hotel $hotel)
    {
		$this->checkPermissionMethod('list.hotel');
       return view('hotels.view', compact('hotel'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\State  $State
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
		$this->checkPermissionMethod('list.hotel');
        $record = Hotel::find($id);
        $countries = Country::where('status', 1)->orderBy('name', 'ASC')->get();
		$zones = Zone::where('status', 1)->orderBy('name', 'ASC')->get();
        $states = State::where('status', 1)->orderBy('name', 'ASC')->get();
        $cities = City::where('status', 1)->orderBy('name', 'ASC')->get();
        $hotelcategories = HotelCategory::where('status', 1)->orderBy('name', 'ASC')->get();
        return view('hotels.edit')->with(['record' => $record, 'countries' => $countries, 'states' => $states, 'cities' => $cities, 'hotelcategories' => $hotelcategories,'zones'=>$zones]);
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
        $request->validate([
            'name' => 'required|max:255|sanitizeScripts',
            'mobile' => 'required',
            'address' => 'required',
            'hotel_category_id' => 'required',
            'city_id' => 'required',
            'state_id' => 'required',
            'country_id' => 'required',
            'zip_code' => 'required',
			'zone_id' => 'required',
            'location' => 'required'
        ], [
            'name.sanitize_scripts' => 'Invalid value entered for Name field.',
            'country_id.required' => 'The country field is required.',
            'state_id.required' => 'The state field is required.',
        ]);

        $record = Hotel::find($id);
		 /** Below code for save image **/
		$destinationPath = public_path('/uploads/hotels/');
		//$newName = '';
        //pr($request->all()); die;
        $input = $request->all();
		if ($request->hasFile('image')) {

           
			$fileName = $input['image']->getClientOriginalName();
			$file = request()->file('image');
			$fileNameArr = explode('.', $fileName);
			$fileNameExt = end($fileNameArr);
			$newName = date('His').rand() . time() . '.' . $fileNameExt;
			
			$file->move($destinationPath, $newName);
			
			$img = Image::make(public_path('/uploads/hotels/'.$newName));
						
            $img->resize(250, 250, function($constraint) {
				$constraint->aspectRatio();
			});
			
			$img->save(public_path('/uploads/hotels/thumb/'.$newName));

            //** Below code for unlink old image **//
			if($record->image != 'no-image.png'){

			$oldImage = public_path('/uploads/hotels/'.$record->image);
			$oldImageThumb = public_path('/uploads/hotels/thumb/'.$record->image);
			if(!empty($record->image) && @getimagesize($oldImage) && file_exists($oldImage)) {
				unlink($oldImage);
				unlink($oldImageThumb);
			}
			}
            $record->image = $newName;
		}
		
        $record->name = $request->input('name');
        $record->mobile = $request->input('mobile');
        $record->address = $request->input('address');
        $record->hotel_category_id = $request->input('hotel_category_id');
        $record->zip_code = $request->input('zip_code');
        $record->country_id = $request->input('country_id');
        $record->state_id = $request->input('state_id');
        $record->city_id = $request->input('city_id');
		$record->zone_id = $request->input('zone_id');
		$record->location = $request->input('location');
		$record->brand_name = $request->input('brand_name');
		$record->formerly_name = $request->input('formerly_name');
		$record->translates_name = $request->input('translates_name');
		$record->address2 = $request->input('address2');
		$record->longitude = $request->input('longitude');
		$record->latitude = $request->input('latitude');
		$record->overview = $request->input('overview');
		$record->continent_name = $request->input('continent_name');
		$record->accommodation_type = $request->input('accommodation_type');
        $record->status = $request->input('status');
        $record->save();
        return redirect('hotels')->with('success', 'Hotel Updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\State  $State
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = Hotel::find($id);
        $record->delete();
        return redirect('hotels')->with('success', 'Hotel Deleted.');
    }
}