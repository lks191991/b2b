<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Image;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$this->checkPermissionMethod('list.notification');
        $records = Notification::orderBy('created_at', 'DESC')->get();
		
        return view('notifications.index', compact('records'));

    }

    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$this->checkPermissionMethod('list.notification');
        return view('notifications.create');
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
          	'image' => 'nullable|mimes:jpeg,jpg,png|max:' . ($options['allow_img_size'] * 1024),
        ], [
			'name.sanitize_scripts' => 'Invalid value entered for Name field.',
		]);
		
		$input = $request->all();
        $record = new Notification();
		$destinationPath = public_path('/uploads/notification/');
		if ($request->hasFile('image')) {

           
			$fileName = $input['image']->getClientOriginalName();
			$file = request()->file('image');
			$fileNameArr = explode('.', $fileName);
			$fileNameExt = end($fileNameArr);
			$newName = date('His').rand() . time() . '.' . $fileNameExt;
			
			$file->move($destinationPath, $newName);
			
			$img = Image::make(public_path('/uploads/notification/'.$newName));
						
            $img->resize(200, 150, function($constraint) {
				$constraint->aspectRatio();
			});
			
			$img->save(public_path('/uploads/notification/thumb/'.$newName));
            $record->image = $newName;
		}
		
        $record->content = $request->input('content');
		$record->type = $request->input('type');
		
        $record->title = $request->input('title');
		$record->status = $request->input('status');
        $record->created_by = Auth::user()->id;
		
        $record->save();
        return redirect('notifications')->with('success','Notification Created Successfully.');
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
     * @param  \App\Models\Notification  $Notification
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
		$this->checkPermissionMethod('list.notification');
        $record = Notification::find($id);
        return view('notifications.edit')->with('record',$record);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Notification  $Notification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
		$options['allow_img_size'] = 10;
        $request->validate([
            'status'=>'required',
			'image' => 'nullable|mimes:jpeg,jpg,png|max:' . ($options['allow_img_size'] * 1024), 
			
        ], [
			'name.sanitize_scripts' => 'Invalid value entered for Name field.',
		]);

        $record = Notification::find($id);
		
		$destinationPath = public_path('/uploads/notification/');
        $input = $request->all();
		if ($request->hasFile('image')) {

           
			$fileName = $input['image']->getClientOriginalName();
			$file = request()->file('image');
			$fileNameArr = explode('.', $fileName);
			$fileNameExt = end($fileNameArr);
			$newName = date('His').rand() . time() . '.' . $fileNameExt;
			
			$file->move($destinationPath, $newName);
			$img = Image::make(public_path('/uploads/notification/'.$newName));
						
            $img->resize(100, 100, function($constraint) {
				$constraint->aspectRatio();
			});
			
			$img->save(public_path('/uploads/notification/thumb/'.$newName));
			
			if($record->image != 'no-image.png'){
            //** Below code for unlink old image **//
				$oldImage = public_path('/uploads/notification/'.$record->image);
				$oldImageThumb = public_path('/uploads/notification/thumb/'.$record->image);
				if(!empty($record->image) && @getimagesize($oldImage) && file_exists($oldImage)) {
					unlink($oldImage);
					unlink($oldImageThumb);
				}
			}
            $record->image = $newName;
		}
		
        $record->content = $request->input('content');
		$record->type = $request->input('type');
		
        $record->title = $request->input('title');
        $record->status = $request->input('status');
        $record->created_by = Auth::user()->id;
        $record->save();
        return redirect('notifications')->with('success','Notification Updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = Notification::find($id);
        $record->delete();
        return redirect('notifications')->with('success', 'Notification Deleted.');
    }
	
}
