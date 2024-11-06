<?php

namespace App\Http\Controllers;

use App\Models\Zone;
use Illuminate\Http\Request;
use DB;
class ZonesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$this->checkPermissionMethod('list.zone');
        $records = Zone::orderBy('created_at', 'DESC')->get();
		
        return view('zones.index', compact('records'));

    }

    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$this->checkPermissionMethod('list.zone');
        return view('zones.create');
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
            'name'=>'required|max:255|unique:zones,name|sanitizeScripts'
        ], [
			'name.sanitize_scripts' => 'Invalid value entered for Name field.',
		]);
		
		
        $record = new Zone();
        $record->name = $request->input('name');
		 $record->status = $request->input('status');
        $record->save();
        return redirect('zones')->with('success','Zone Created Successfully.');
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
		$this->checkPermissionMethod('list.zone');
        $record = Zone::find($id);
        return view('zones.edit')->with('record',$record);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Zone  $Zone
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>'required|max:255|sanitizeScripts|unique:zones,name,' .$id,
            'status'=>'required'
        ], [
			'name.sanitize_scripts' => 'Invalid value entered for Name field.',
		]);

        $record = Zone::find($id);
        $record->name = $request->input('name');
        $record->status = $request->input('status');
        $record->save();
        return redirect('zones')->with('success','Zone Updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Zone  $Zone
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = Zone::find($id);
        $record->delete();
        return redirect('zones')->with('success', 'Zone Deleted.');
    }
	
}
