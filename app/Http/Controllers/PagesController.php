<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;

use Illuminate\Validation\Rule;
use Validator;
use Illuminate\Support\Facades\Redirect;
use Auth;

class PagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {	
		//Show all categories from the database and return to view
        $pages = Page::get();
		
        return view('pages.index',compact('pages'));

    }

   

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
		
       //Find the category
        $page = Page::find($id);
		return view('pages.edit',compact('page'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
		$validator = Validator::make($request->all(), [
            'page_content' => [
                'required',
            ],
            
        ]);
                                
        // if the validator fails, redirect back to the form
        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator) // send back all errors to the form
                ->withInput();
        }
		
        //Retrieve the category and update
        $page = Page::find($id);
		
		
            $title = str_replace("'", "\'", $request->input('title'));
            $title = str_replace('"', "'+String.fromCharCode(34)+'",$request->input('title'));
            $page_content = str_replace("'", "\'", $request->input('page_content'));
            $page_content = str_replace('"', "'+String.fromCharCode(34)+'", $request->input('page_content'));

            $title = addslashes(trim(ucwords(strtolower($title))));
            $page_content = addslashes(trim(ucwords(strtolower($page_content))));

		//echo "<pre>"; print_r($school); exit;
        //$page->title = $title;
		$page->page_content =$page_content;
		$page->save(); //persist the data
        return redirect()->route('pages.index')->with('success','Information Updated Successfully');

    }

   
}
