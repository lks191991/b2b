<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Customer;
use Illuminate\Http\Request;
use DB;

class CustomersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		$this->checkPermissionMethod('list.customer');
        $data = $request->all();
        $perPage = config("constants.ADMIN_PAGE_LIMIT");
        $query = Customer::with(['country', 'state', 'city']);
        if (isset($data['name']) && !empty($data['name'])) {
            $query->where('name', 'like', '%' . $data['name'] . '%');
        }
        if (isset($data['country_id']) && !empty($data['country_id'])) {
            $query->where('country_id', $data['country_id']);
        }
        if (isset($data['state_id']) && !empty($data['state_id'])) {
            $query->where('state_id', $data['state_id']);
        }
        if (isset($data['city_id']) && !empty($data['city_id'])) {
            $query->where('city_id', $data['city_id']);
        }
        if (isset($data['status']) && !empty($data['status'])) {
            if ($data['status'] == 1)
                $query->where('status', 1);
            if ($data['status'] == 2)
                $query->where('status', 0);
        }

        $records = $query->orderBy('created_at', 'DESC')->paginate($perPage);

        $countries = Country::where('status', 1)->orderBy('name', 'ASC')->get();
        $states = State::where('status', 1)->orderBy('name', 'ASC')->get();
        $cities = City::where('status', 1)->orderBy('name', 'ASC')->get();

        return view('customers.index', compact('records', 'countries', 'states', 'cities'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$this->checkPermissionMethod('list.customer');
        $countries = Country::where('status', 1)->orderBy('name', 'ASC')->get();
        return view('customers.create', compact('countries'));
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
            'name' => 'required|max:255|sanitizeScripts',
            'mobile' => 'required',
            'address' => 'required',
            'city_id' => 'required',
            'state_id' => 'required',
            'country_id' => 'required',
            'zip_code' => 'required',
			'code' => 'required'
        ], [
            'name.sanitize_scripts' => 'Invalid value entered for Name field.',
            'country_id.required' => 'The country field is required.',
            'state_id.required' => 'The state field is required.',
        ]);



        $record = new Customer();
        $record->name = $request->input('name');
		$record->code = $request->input('code');
        $record->mobile = $request->input('mobile');
		$record->email = $request->input('email');
        $record->address = $request->input('address');
        $record->zip_code = $request->input('zip_code');
        $record->country_id = $request->input('country_id');
        $record->state_id = $request->input('state_id');
        $record->city_id = $request->input('city_id');
        $record->status = $request->input('status');
        $record->save();
		if($request->ajax()){
            return response()->json([
            'success' => true,
            'message' => 'Customer Created Successfully.'
        ]);
        }
		else
		{
		 return redirect('customers')->with('success', 'Customer Created Successfully.');

		}
			
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
		$this->checkPermissionMethod('list.customer');
        $record = Customer::find($id);
        $countries = Country::where('status', 1)->orderBy('name', 'ASC')->get();
        $states = State::where('status', 1)->orderBy('name', 'ASC')->get();
        $cities = City::where('status', 1)->orderBy('name', 'ASC')->get();
        return view('customers.edit')->with(['record' => $record, 'countries' => $countries, 'states' => $states, 'cities' => $cities]);
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
        $request->validate([
            'name' => 'required|max:255|sanitizeScripts',
            'mobile' => 'required',
            'address' => 'required',
            'city_id' => 'required',
            'state_id' => 'required',
            'country_id' => 'required',
            'zip_code' => 'required',
			'code' => 'required'
        ], [
            'name.sanitize_scripts' => 'Invalid value entered for Name field.',
            'country_id.required' => 'The country field is required.',
            'state_id.required' => 'The state field is required.',
        ]);

        $record = Customer::find($id);
        $record->name = $request->input('name');
		$record->code = $request->input('code');
        $record->mobile = $request->input('mobile');
		$record->email = $request->input('email');
        $record->address = $request->input('address');
        $record->zip_code = $request->input('zip_code');
        $record->country_id = $request->input('country_id');
        $record->state_id = $request->input('state_id');
        $record->city_id = $request->input('city_id');
        $record->status = $request->input('status');
        $record->save();
        return redirect('customers')->with('success', 'Customer Updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\State  $State
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = Customer::find($id);
        $record->delete();
        return redirect('customers')->with('success', 'Customer Deleted.');
    }
}