<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use DB;
use Image;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$this->checkPermissionMethod('list.countries');
        $records = Country::orderBy('created_at', 'DESC')->get();
		
        return view('countries.index', compact('records'));

    }

    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$this->checkPermissionMethod('list.countries');
        return view('countries.create');
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
            'name'=>'required|max:255|unique:countries,name|sanitizeScripts',
			'image' => 'nullable|mimes:jpeg,jpg,png|max:' . ($options['allow_img_size'] * 1024),
        ], [
			'name.sanitize_scripts' => 'Invalid value entered for Name field.',
		]);
		
		$input = $request->all();
        $record = new Country();
		$destinationPath = public_path('/uploads/country/');
		if ($request->hasFile('image')) {

           
			$fileName = $input['image']->getClientOriginalName();
			$file = request()->file('image');
			$fileNameArr = explode('.', $fileName);
			$fileNameExt = end($fileNameArr);
			$newName = date('His').rand() . time() . '.' . $fileNameExt;
			
			$file->move($destinationPath, $newName);
			
			$img = Image::make(public_path('/uploads/country/'.$newName));
						
            $img->resize(100, 100, function($constraint) {
				$constraint->aspectRatio();
			});
			
			$img->save(public_path('/uploads/country/thumb/'.$newName));
            $record->image = $newName;
		}
		
		$record->show_home = $request->input('show_home');
		
        $record->name = $request->input('name');
		$record->status = $request->input('status');
		
        $record->save();
        return redirect('countries')->with('success','Country Created Successfully.');
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
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
		$this->checkPermissionMethod('list.countries');
        $record = Country::find($id);
        return view('countries.edit')->with('record',$record);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
		$options['allow_img_size'] = 10;
        $request->validate([
            'name'=>'required|max:255|sanitizeScripts|unique:countries,name,' .$id,
            'status'=>'required',
			'image' => 'nullable|mimes:jpeg,jpg,png|max:' . ($options['allow_img_size'] * 1024), 
			
        ], [
			'name.sanitize_scripts' => 'Invalid value entered for Name field.',
		]);

        $record = Country::find($id);
		
		$destinationPath = public_path('/uploads/country/');
        $input = $request->all();
		if ($request->hasFile('image')) {

           
			$fileName = $input['image']->getClientOriginalName();
			$file = request()->file('image');
			$fileNameArr = explode('.', $fileName);
			$fileNameExt = end($fileNameArr);
			$newName = date('His').rand() . time() . '.' . $fileNameExt;
			
			$file->move($destinationPath, $newName);
			$img = Image::make(public_path('/uploads/country/'.$newName));
						
            $img->resize(100, 100, function($constraint) {
				$constraint->aspectRatio();
			});
			
			$img->save(public_path('/uploads/country/thumb/'.$newName));
			
			if($record->image != 'no-image.png'){
            //** Below code for unlink old image **//
				$oldImage = public_path('/uploads/country/'.$record->image);
				$oldImageThumb = public_path('/uploads/country/thumb/'.$record->image);
				if(!empty($record->image) && @getimagesize($oldImage) && file_exists($oldImage)) {
					unlink($oldImage);
					unlink($oldImageThumb);
				}
			}
            $record->image = $newName;
		}
		
		$record->show_home = $request->input('show_home');
        $record->name = $request->input('name');
        $record->status = $request->input('status');
        $record->save();
        return redirect('countries')->with('success','Country Updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = Country::find($id);
        $record->delete();
        return redirect('countries')->with('success', 'Country Deleted.');
    }
	
}
