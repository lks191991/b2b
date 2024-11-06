<?php

namespace App\Http\Controllers;

use App\Models\HotelCategory;
use Illuminate\Http\Request;
use DB;
class HotelCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$this->checkPermissionMethod('list.hotlecat');
        $records = HotelCategory::orderBy('created_at', 'DESC')->get();
		
        return view('hotelcategories.index', compact('records'));

    }

    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$this->checkPermissionMethod('list.hotlecat');
        return view('hotelcategories.create');
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
            'name'=>'required|max:255|unique:hotelcategories,name|sanitizeScripts'
        ], [
			'name.sanitize_scripts' => 'Invalid value entered for Name field.',
		]);
		
		
        $record = new HotelCategory();
        $record->name = $request->input('name');
		 $record->status = $request->input('status');
        $record->save();
        return redirect('hotelcategories')->with('success','Hotel Category Created Successfully.');
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
		$this->checkPermissionMethod('list.hotlecat');
        $record = HotelCategory::find($id);
        return view('hotelcategories.edit')->with('record',$record);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HotelCategory  $HotelCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>'required|max:255|sanitizeScripts|unique:hotelcategories,name,' .$id,
            'status'=>'required'
        ], [
			'name.sanitize_scripts' => 'Invalid value entered for Name field.',
		]);

        $record = HotelCategory::find($id);
        $record->name = $request->input('name');
        $record->status = $request->input('status');
        $record->save();
        return redirect('hotelcategories')->with('success','Hotel Category Updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = HotelCategory::find($id);
        $record->delete();
        return redirect('hotelcategories')->with('success', 'Hotel Category Deleted.');
    }
	
}
