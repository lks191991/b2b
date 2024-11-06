<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use DB;
class VehiclesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$this->checkPermissionMethod('list.vehicle');
        $records = Vehicle::orderBy('created_at', 'DESC')->get();
		
        return view('vehicles.index', compact('records'));

    }

    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$this->checkPermissionMethod('list.vehicle');
        return view('vehicles.create');
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
            'name'=>'required|max:100|sanitizeScripts'
        ], [
			'name.sanitize_scripts' => 'Invalid value entered for Name field.',
		]);
		
		
        $record = new Vehicle();
        $record->name = $request->input('name');
		$record->code = $request->input('code');
		$record->status = $request->input('status');
        $record->save();
        return redirect('vehicles')->with('success','Vehicle Created Successfully.');
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
		$this->checkPermissionMethod('list.vehicle');
        $record = Vehicle::find($id);
        return view('vehicles.edit')->with('record',$record);
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
            'name'=>'required|max:100|sanitizeScripts',
            'status'=>'required'
        ], [
			'name.sanitize_scripts' => 'Invalid value entered for Name field.',
		]);

        $record = Vehicle::find($id);
        $record->name = $request->input('name');
		$record->code = $request->input('code');
        $record->status = $request->input('status');
        $record->save();
        return redirect('vehicles')->with('success','Vehicle Updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Zone  $Zone
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = Vehicle::find($id);
        $record->delete();
        return redirect('vehicles')->with('success', 'Vehicle Deleted.');
    }
	
}
