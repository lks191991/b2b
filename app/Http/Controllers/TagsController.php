<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use DB;
use Image;

class TagsController extends Controller
{
    
    public function index(Request $request)
    {
		$this->checkPermissionMethod('list.activity');
        $data = $request->all();
        $perPage = config("constants.ADMIN_PAGE_LIMIT");
        $records = Tag::orderBy('created_at', 'DESC')->get();
		
        return view('tags.index', compact('records'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$this->checkPermissionMethod('list.activity');
       
        return view('tags.create');
    }

   
    public function store(Request $request)
    {
        $options['allow_img_size'] = 10;
        $request->validate([
            'name' => 'required|max:255|sanitizeScripts|unique:tags,name',
            'image' => 'nullable|mimes:jpeg,jpg,png|max:' . ($options['allow_img_size'] * 1024), 
        ], [
            'name.sanitize_scripts' => 'Invalid value entered for Name field.',
            'image' => 'nullable|mimes:jpeg,jpg,png|max:' . ($options['allow_img_size'] * 1024), 
        ]);


		$input = $request->all();
        $record = new Tag();
		$destinationPath = public_path('/uploads/tags/');
		if ($request->hasFile('image')) {

           
			$fileName = $input['image']->getClientOriginalName();
			$file = request()->file('image');
			$fileNameArr = explode('.', $fileName);
			$fileNameExt = end($fileNameArr);
			$newName = date('His').rand() . time() . '.' . $fileNameExt;
			
			$file->move($destinationPath, $newName);
			
			//$user_config = json_decode($options['user'],true);
			
			$img = Image::make(public_path('/uploads/tags/'.$newName));
						
            $img->resize(250, 250, function($constraint) {
				$constraint->aspectRatio();
			});
			
			$img->save(public_path('/uploads/tags/thumb/'.$newName));

            $record->image = $newName;
		}
		
        $record->name = $request->input('name');
        $record->icon_css = $request->input('icon_css');
        $record->status = $request->input('status');
        $record->save();
        return redirect('tags')->with('success', 'Tag Created Successfully.');
    }

   
    public function show(Tag $tag)
    {
		$this->checkPermissionMethod('list.activity');
       return view('tags.view', compact('tag'));
    }

   
    public function edit($id)
    {
		$this->checkPermissionMethod('list.activity');
        $record = Tag::find($id);
        return view('tags.edit')->with(['record' => $record]);
    }

    
    public function update(Request $request, $id)
    {
        $options['allow_img_size'] = 10;
        $request->validate([
            'name' => 'required|max:255|sanitizeScripts|unique:tags,name,' .$id,
            'image' => 'nullable|mimes:jpeg,jpg,png|max:' . ($options['allow_img_size'] * 1024), 
        ], [
            'name.sanitize_scripts' => 'Invalid value entered for Name field.',
            'image' => 'nullable|mimes:jpeg,jpg,png|max:' . ($options['allow_img_size'] * 1024), 
        ]);

        $record = Tag::find($id);
		 /** Below code for save image **/
		$destinationPath = public_path('/uploads/tags/');
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
			
			$img = Image::make(public_path('/uploads/tags/'.$newName));
						
            $img->resize(250, 250, function($constraint) {
				$constraint->aspectRatio();
			});
			
			$img->save(public_path('/uploads/tags/thumb/'.$newName));

            //** Below code for unlink old image **//
			if($record->image != 'no-image.png'){

			$oldImage = public_path('/uploads/tags/'.$record->image);
			$oldImageThumb = public_path('/uploads/tags/thumb/'.$record->image);
			if(!empty($record->image) && @getimagesize($oldImage) && file_exists($oldImage)) {
				unlink($oldImage);
				unlink($oldImageThumb);
			}
			}
            $record->image = $newName;
		}
		
        $record->name = $request->input('name');
        $record->icon_css = $request->input('icon_css');
        $record->status = $request->input('status');
        $record->save();
        return redirect('tags')->with('success', 'Tag Updated.');
    }

   
    public function destroy($id)
    {
        $record = Tag::find($id);
        $record->delete();
        return redirect('tags')->with('success', 'Tag Deleted.');
    }
	
	public function deleteImage($id)
    {
        $record = Tag::find($id);
        $record->image = 'no-image.png';
        $record->save();
        return redirect('tags')->with('success', 'Tag Image Deleted.');
    }
}