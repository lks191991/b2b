<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\State;
use App\Models\City;
use Illuminate\Http\Request;
use DB;
use Image;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		$this->checkPermissionMethod('list.city');
		$data = $request->all();
		$perPage = config("constants.ADMIN_PAGE_LIMIT");
		$query = City::with('country','state');
		if(isset($data['name']) && !empty($data['name']))
        {
            $query->where('name','like', '%'.$data['name'].'%');
        }
		if(isset($data['country_id']) && !empty($data['country_id']))
        {
            $query->where('country_id',$data['country_id']);
        }
		if(isset($data['state_id']) && !empty($data['state_id']))
        {
            $query->where('state_id',$data['state_id']);
        }
		if(isset($data['status']) && !empty($data['status']))
        {
            if($data['status']==1)
            $query->where('status',1);
            if($data['status']==2)
            $query->where('status',0);
        }
		
		if(isset($data['show_home']) && !empty($data['show_home']))
        {
            if($data['show_home']==1)
            $query->where('show_home',1);
            if($data['show_home']==2)
            $query->where('show_home',0);
        }
		
        $records = $query->orderBy('created_at', 'DESC')->paginate($perPage);
		 
		$countries = Country::where('status',1)->orderBy('name', 'ASC')->get();
		$states = State::where('status',1)->orderBy('name', 'ASC')->get();
        return view('cities.index', compact('records','countries','states'));

    }

    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$this->checkPermissionMethod('list.city');
		 $countries = Country::where('status',1)->orderBy('name', 'ASC')->get();
        return view('cities.create',compact('countries'));
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
            'name'=>'required|max:255|sanitizeScripts',
			'state_id'=>'required',
			'country_id'=>'required',
			'image' => 'nullable|mimes:jpeg,jpg,png|max:' . ($options['allow_img_size'] * 1024),
        ], [
			'name.sanitize_scripts' => 'Invalid value entered for Name field.',
			'country_id.required' => 'The country field is required.',
			'state_id.required' => 'The state field is required.',
		]);
		
		$input = $request->all();
		$recordData = City::where('state_id',$request->input('state_id'))->where('name',$request->input('name'))->count();
		if($recordData > 0)
		{
		return redirect()->back()->withInput()->with('error','The City name has already been taken in this country.');
		}
		
		
        $record = new City();

		$destinationPath = public_path('/uploads/city/');
		if ($request->hasFile('image')) {

           
			$fileName = $input['image']->getClientOriginalName();
			$file = request()->file('image');
			$fileNameArr = explode('.', $fileName);
			$fileNameExt = end($fileNameArr);
			$newName = date('His').rand() . time() . '.' . $fileNameExt;
			
			$file->move($destinationPath, $newName);
			
			$img = Image::make(public_path('/uploads/city/'.$newName));
						
            $img->resize(100, 100, function($constraint) {
				$constraint->aspectRatio();
			});
			
			$img->save(public_path('/uploads/city/thumb/'.$newName));
            $record->image = $newName;
		}
		
		$record->show_home = $request->input('show_home');
		$record->country_id = $request->input('country_id');
		$record->state_id = $request->input('state_id');
        $record->name = $request->input('name');
		$record->status = $request->input('status');
        $record->save();
        return redirect('cities')->with('success','City Created Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\State  $State
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
		$this->checkPermissionMethod('list.city');
        $record = City::find($id);
		$countries = Country::where('status',1)->orderBy('name', 'ASC')->get();
		$states = State::where('status',1)->orderBy('name', 'ASC')->get();
        return view('cities.edit')->with('record',$record)->with('countries',$countries)->with('states',$states);
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
            'name'=>'required|max:255|sanitizeScripts',
			'state_id'=>'required',
			'country_id'=>'required',
			'image' => 'nullable|mimes:jpeg,jpg,png|max:' . ($options['allow_img_size'] * 1024), 
        ], [
			'name.sanitize_scripts' => 'Invalid value entered for Name field.',
			'country_id.required' => 'The country field is required.',
			'state_id.required' => 'The state field is required.',
		]);
		
		$recordData = City::where('id','!=',$id)->where('state_id',$request->input('state_id'))->where('name',$request->input('name'))->count();
		if($recordData > 0)
		{
		return redirect()->back()->withInput()->with('error','The City name has already been taken in this state.');
		}
		
        $record = City::find($id);
		
		$destinationPath = public_path('/uploads/city/');
        $input = $request->all();
		if ($request->hasFile('image')) {

           
			$fileName = $input['image']->getClientOriginalName();
			$file = request()->file('image');
			$fileNameArr = explode('.', $fileName);
			$fileNameExt = end($fileNameArr);
			$newName = date('His').rand() . time() . '.' . $fileNameExt;
			
			$file->move($destinationPath, $newName);
			$img = Image::make(public_path('/uploads/city/'.$newName));
						
            $img->resize(100, 100, function($constraint) {
				$constraint->aspectRatio();
			});
			
			$img->save(public_path('/uploads/city/thumb/'.$newName));
			
			if($record->image != 'no-image.png'){
            //** Below code for unlink old image **//
				$oldImage = public_path('/uploads/city/'.$record->image);
				$oldImageThumb = public_path('/uploads/city/thumb/'.$record->image);
				if(!empty($record->image) && @getimagesize($oldImage) && file_exists($oldImage)) {
					unlink($oldImage);
					unlink($oldImageThumb);
				}
			}
            $record->image = $newName;
		}
		
		$record->show_home = $request->input('show_home');
		
		$record->country_id = $request->input('country_id');
		$record->state_id = $request->input('state_id');
        $record->name = $request->input('name');
		$record->status = $request->input('status');
        $record->save();
        return redirect('cities')->with('success','City Updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\State  $State
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = City::find($id);
        $record->delete();
        return redirect('cities')->with('success', 'City Deleted.');
    }
	
}
