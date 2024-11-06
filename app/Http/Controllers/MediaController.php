<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Image;
use App\Models\Files;
use Response;
use File;

class MediaController extends Controller
{
    /*
     * Upload image from CKEditor
     */
    public function uploadImage(Request $request)
    {
        $file = $request->file('upload');
        $uploadDestination = public_path() . '/uploads/images';
        $filename = preg_replace('/\s+/', '', $file->getClientOriginalName());
        $fileName = time() . "_" . $filename;
        $file->move($uploadDestination, $fileName);

        $data = array(
            'fileName' => $fileName,
            'uploaded' => 1,
            'error' => ['number' => '', 'message' => ''],
            'url' => '/uploads/images/' . $fileName, //url('/uploads/images/' . $fileName)
        );

        return response()->json($data);
    }

    /*
     * Browse images for CKEditor
     */
    public function browseImage(Request $request)
    {
        $test = $_GET['CKEditorFuncNum'];
        $images = [];
        $files = \File::files(public_path() . '/uploads/images');
        foreach ($files as $file) {
            $images[] = pathinfo($file);
        }
        return view('media.file', [
            'files' => $images,
            'test' => $test
        ]);
    }

    /*
     * function to upload media file using ajax - demo perpose
     */
    public function uploadFile(Request $request)
    {
        $file = $request->file('imagefile');
        $uploadDestination = public_path() . '/uploads/images';
        $filename = preg_replace('/\s+/', '', $file->getClientOriginalName());
        $fileName = time() . "_" . $filename;
        $file->move($uploadDestination, $fileName);

        //echo url('/uploads/images/'.$fileName); die;

        $img = Image::make(url('/uploads/images/' . $fileName));
        $img->crop(1920, 450, 0, 0);

        $img->save($uploadDestination . '/' . 'banner_' . $filename);

        $data = array(
            'uploaded' => $fileName
        );

        return response()->json($data);
    }

    /**
     * To display the show page
     *
     * @return \Illuminate\Http\Response
     */
    public function showJqueryImageUpload()
    {
        return view('demo.jqueryimageupload');
    }

    /**
     * To handle the comming post request
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function saveJqueryImageUpload(Request $request)
    {
        $validator = Validator::make($request->all(), [
                    'profile_picture' => 'required|image|max:5000',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $status = "";

        if ($request->hasFile('profile_picture')) {
            $image = $request->file('profile_picture');
            // Rename image
            $filename = time() . '.' . $image->guessExtension();

            $path = $request->file('profile_picture')->storeAs(
                'profile_pictures',
                $filename
            );

            $status = "uploaded";
        }

        return response($status, 200);
    }
	
	/**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProductAdditionalImage  $delete
     * @return \Illuminate\Http\Response json
     */
    public function imageDelete($id){
        $data =  Files::where('id',$id);
		$file = $data->first();
		$old= $file->filename;
		$dest_fullfile = public_path('/uploads/activities/');
        $dest_thumb = public_path('/uploads/activities/thumb/');
		if(!empty($old) && File::exists($dest_fullfile.$old)){
            File::delete($dest_fullfile.$old);
            if(File::exists($dest_thumb .$old)){
                File::delete($dest_thumb .$old);
            }
        }
		
		$data->delete();

        return Response::json(['success' => 'Image Deleted Sussfully']);
    }
}
