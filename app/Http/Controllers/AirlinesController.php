<?php

namespace App\Http\Controllers;

use App\Models\Airline;
use Illuminate\Http\Request;
use DB;
use Image;
use Illuminate\Support\Facades\Auth;

class AirlinesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		$this->checkPermissionMethod('list.airline');
		$data = $request->all();
		$perPage = config("constants.ADMIN_PAGE_LIMIT");
		$query = Airline::where('id','!=', null);
        if (isset($data['name']) && !empty($data['name'])) {
            $query->where('name', 'like', '%' . $data['name'] . '%');
        }
		
		if (isset($data['code']) && !empty($data['code'])) {
            $query->where('code', $data['code']);
        }
		
        $records = $query->orderBy('created_at', 'DESC')->paginate($perPage);
		
        return view('airlines.index', compact('records'));

    }

    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$this->checkPermissionMethod('list.airline');
        return view('airlines.create');
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
            'name'=>'required|max:255|unique:airlines,name|sanitizeScripts',
			'code'=>'required|max:10',
			'logo' => 'nullable|mimes:jpeg,jpg,png|max:' . ($options['allow_img_size'] * 1024),  
        ], [
			'name.sanitize_scripts' => 'Invalid value entered for Name field.',
		]);
		
		 $input = $request->all();
        $record = new Airline();
        $record->name = $request->input('name');
		$record->code = $request->input('code');
		$record->status = $request->input('status');
		$record->created_by = Auth::user()->id;
		 /** Below code for save image **/
		$destinationPath = public_path('/uploads/airlines/');
       
		if ($request->hasFile('logo')) {

			$fileName = $input['logo']->getClientOriginalName();
			$file = request()->file('logo');
			$fileNameArr = explode('.', $fileName);
			$fileNameExt = end($fileNameArr);
			$newName = date('His').rand() . time() . '.' . $fileNameExt;
			
			$file->move($destinationPath, $newName);
			$img = Image::make(public_path('/uploads/airlines/'.$newName));
            $img->resize(100, 100, function($constraint) {
				$constraint->aspectRatio();
			});
			$img->save(public_path('/uploads/airlines/thumb/'.$newName));
            $record->logo = $newName;
		}
        $record->save();
        return redirect('airlines')->with('success','Airline Created Successfully.');
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
		$this->checkPermissionMethod('list.airline');
        $record = Airline::find($id);
        return view('airlines.edit')->with('record',$record);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Airline  $Airline
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
		$options['allow_img_size'] = 10;
        $request->validate([
            'name'=>'required|max:255|sanitizeScripts|unique:airlines,name,' .$id,
            'status'=>'required',
			'code'=>'required|max:10',
			'logo' => 'nullable|mimes:jpeg,jpg,png|max:' . ($options['allow_img_size'] * 1024),  
        ], [
			'name.sanitize_scripts' => 'Invalid value entered for Name field.',
		]);
		
		$input = $request->all();
        $record = Airline::find($id);
		 /** Below code for save image **/
		$destinationPath = public_path('/uploads/airlines/');
       
		if ($request->hasFile('logo')) {

			$fileName = $input['logo']->getClientOriginalName();
			$file = request()->file('logo');
			$fileNameArr = explode('.', $fileName);
			$fileNameExt = end($fileNameArr);
			$newName = date('His').rand() . time() . '.' . $fileNameExt;
			
			$file->move($destinationPath, $newName);
			$img = Image::make(public_path('/uploads/airlines/'.$newName));
            $img->resize(250, 250, function($constraint) {
				$constraint->aspectRatio();
			});
			$img->save(public_path('/uploads/airlines/thumb/'.$newName));
			if($record->logo != 'no-image.png'){
            //** Below code for unlink old image **//
			$oldImage = public_path('/uploads/airlines/'.$record->logo);
			$oldImageThumb = public_path('/uploads/airlines/thumb/'.$record->logo);
			if(!empty($record->logo) && @getimagesize($oldImage) && file_exists($oldImage)) {
				unlink($oldImage);
				unlink($oldImageThumb);
			}
			}
			
            $record->logo = $newName;
		}
		
		$record->code = $request->input('code');
        $record->name = $request->input('name');
        $record->status = $request->input('status');
		$record->updated_by = Auth::user()->id;
        $record->save();
        return redirect('airlines')->with('success','Airline Updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Airline  $Airline
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = Airline::find($id);
        $record->delete();
        return redirect('airlines')->with('success', 'Airline Deleted.');
    }
	
	public function autocompleteAirline(Request $request)
    {
		$search  = $request->get('search');
		$airlines = Airline::where('status', 1)
					->where('name', 'LIKE', '%'. $search. '%')
					->paginate(20);
		$response = array();
		
      foreach($airlines as $airline){
         $response[] = array("value"=>$airline->name,"label"=>$airline->name);
      }
	
        return response()->json($response);
    }
	
}
