<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\User;
use App\Models\Activity;
use App\Models\ActivityPrices;
use App\Models\SupplierDetails;
use App\Models\AgentPriceMarkup;
use Illuminate\Http\Request;
use DB;
use Image;
use Illuminate\Support\Facades\Auth;
use jeremykenedy\LaravelRoles\Models\Role;
use jeremykenedy\LaravelRoles\Models\Permission;
use App\Models\ActivityVariant;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SuppliersExport;
class SuppliersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		$this->checkPermissionMethod('list.supplier');
        $data = $request->all();
        $perPage = config("constants.ADMIN_PAGE_LIMIT");
        $query = User::with(['country', 'state', 'city'])->where('role_id',9);
        if (isset($data['name']) && !empty($data['name'])) {
            $query->where('name', 'like', '%' . $data['name'] . '%');
        }
		if (isset($data['company_name']) && !empty($data['company_name'])) {
            $query->where('company_name', 'like', '%' . $data['company_name'] . '%');
        }
        if (isset($data['email']) && !empty($data['email'])) {
            $query->where('email', 'like', '%' . $data['email'] . '%');
        }
       
        if (isset($data['city_id']) && !empty($data['city_id'])) {
            $query->where('city_id', $data['city_id']);
        }
         if(isset($data['status']) && !empty($data['status']))
        {
            if($data['status']==1)
            $query->where('is_active',1);
            if($data['status']==2)
            $query->where('is_active',0);
        }
		
        $records = $query->orderBy('created_at', 'DESC')->paginate($perPage);

        $countries = Country::where('status', 1)->orderBy('name', 'ASC')->get();
        $states = State::where('status', 1)->orderBy('name', 'ASC')->get();
        $cities = City::where('status', 1)->orderBy('name', 'ASC')->get();

        return view('suppliers.index', compact('records', 'countries', 'states', 'cities'));
    }

	public function supplierExport(Request $request)
    {
		$this->checkPermissionMethod('list.supplier');
		$data = $request->all();
        $perPage = config("constants.ADMIN_PAGE_LIMIT");
        $query = User::with(['country', 'state', 'city'])->where('role_id',9);
        if (isset($data['name']) && !empty($data['name'])) {
            $query->where('name', 'like', '%' . $data['name'] . '%');
        }
		if (isset($data['company_name']) && !empty($data['company_name'])) {
            $query->where('company_name', 'like', '%' . $data['company_name'] . '%');
        }
        if (isset($data['email']) && !empty($data['email'])) {
            $query->where('email', 'like', '%' . $data['email'] . '%');
        }
       
        if (isset($data['city_id']) && !empty($data['city_id'])) {
            $query->where('city_id', $data['city_id']);
        }
         if(isset($data['status']) && !empty($data['status']))
        {
            if($data['status']==1)
            $query->where('is_active',1);
            if($data['status']==2)
            $query->where('is_active',0);
        }
		
        $records = $query->orderBy('created_at', 'DESC')->get();

        
		return Excel::download(new SuppliersExport($records), 'suppliers_records'.date('d-M-Y s').'.csv');    
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$this->checkPermissionMethod('list.supplier');
        $countries = Country::where('status', 1)->orderBy('name', 'ASC')->get();
        return view('suppliers.create', compact('countries'));
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
           'first_name' => 'required|max:255|sanitizeScripts',
            'last_name' => 'required|max:255|sanitizeScripts',
            'mobile' => 'required',
            'address' => 'required',
			'email' => 'required|max:255|sanitizeScripts|email|unique:suppliers|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
			'password' => 'required|min:6|max:255|sanitizeScripts',
            'city_id' => 'required',
            'state_id' => 'required',
            'country_id' => 'required',
            'zip_code' => 'required',
			//'code' => 'required',
			'service_type' => 'required'
        ], [
            //'name.sanitize_scripts' => 'Invalid value entered for Name field.',
            'country_id.required' => 'The country field is required.',
            'state_id.required' => 'The state field is required.',
        ]);


		$input = $request->all();
        $record = new User();
		 /** Below code for save image **/
		$destinationPath = public_path('/uploads/suppliers/');
       
		if ($request->hasFile('logo')) {

			$fileName = $input['logo']->getClientOriginalName();
			$file = request()->file('logo');
			$fileNameArr = explode('.', $fileName);
			$fileNameExt = end($fileNameArr);
			$newName = date('His').rand() . time() . '.' . $fileNameExt;
			
			$file->move($destinationPath, $newName);
			$img = Image::make(public_path('/uploads/suppliers/'.$newName));
            $img->resize(100, 100, function($constraint) {
				$constraint->aspectRatio();
			});
			$img->save(public_path('/uploads/suppliers/thumb/'.$newName));
            $record->image = $newName;
		}
		
       $record->name = $request->input('first_name');
        $record->lname = $request->input('last_name');
		
        $record->mobile = $request->input('mobile');
		$record->email = $request->input('email');
		$record->company_name = $request->input('company_name');
		$record->department = $request->input('department');
		$record->phone = $request->input('phone_number');
        $record->address = $request->input('address');
        $record->postcode = $request->input('zip_code');
        $record->country_id = $request->input('country_id');
        $record->state_id = $request->input('state_id');
        $record->city_id = $request->input('city_id');
		$record->service_type = $request->input('service_type');
		$record->booking_email = $request->input('booking_email');
        $record->is_active = $request->input('status');
		$record->created_by = Auth::user()->id;
		$record->password = bcrypt($request->input('password'));
		$record->role_id = 9; 
        $record->save();
		$record->attachRole('9');
		$count = User::where("role_id",9)->count();
		$code = 'SP-900'.$count;
		$recordUser = User::find($record->id);
		$recordUser->code = $code;
		$recordUser->save();
		
        return redirect('suppliers')->with('success', 'Supplier Created Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(User $supplier)
    {
		$this->checkPermissionMethod('list.supplier');
		$activity_ids = explode(",",$supplier->activity_id);
		
		$variants = [];
		$markups = [];
		foreach($activity_ids as $aid)
		{
			$activity = Activity::find($aid);
			$variants[$aid] = ActivityPrices::select('variant_code')->distinct()->where('activity_id',  $aid)->get()->toArray();
			
			foreach($variants[$aid] as $variant)
			{
				$m = AgentPriceMarkup::where('agent_id',  $supplier->id)->where('activity_id',  $aid)->where('variant_code',  $variant['variant_code'])->first();
				
				if(!empty($m))
				{
					$markups[$activity->title][$variant['variant_code']] = [
						'ticket_only'=>$m->ticket_only,
						'sic_transfer'=>$m->sic_transfer,
						'pvt_transfer'=>$m->pvt_transfer,
					];
				}
			}
			
		}
		
		
        return view('suppliers.view', compact('supplier','markups'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\State  $State
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
		$this->checkPermissionMethod('list.supplier');
        $record = User::find($id);
        $countries = Country::where('status', 1)->orderBy('name', 'ASC')->get();
        $states = State::where('status', 1)->orderBy('name', 'ASC')->get();
        $cities = City::where('status', 1)->orderBy('name', 'ASC')->get();
        return view('suppliers.edit')->with(['record' => $record, 'countries' => $countries, 'states' => $states, 'cities' => $cities]);
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
           'first_name' => 'required|max:255|sanitizeScripts',
            'last_name' => 'required|max:255|sanitizeScripts',
            'mobile' => 'required',
            'address' => 'required',
            'city_id' => 'required',
            'state_id' => 'required',
            'country_id' => 'required',
            'zip_code' => 'required',
			//'code' => 'required',
			'service_type' => 'required'
        ], [
            //'name.sanitize_scripts' => 'Invalid value entered for Name field.',
            'country_id.required' => 'The country field is required.',
            'state_id.required' => 'The state field is required.',
        ]);
		
		$input = $request->all();
        $record = User::find($id);
		 /** Below code for save image **/
		$destinationPath = public_path('/uploads/suppliers/');
       
		if ($request->hasFile('logo')) {

			$fileName = $input['logo']->getClientOriginalName();
			$file = request()->file('logo');
			$fileNameArr = explode('.', $fileName);
			$fileNameExt = end($fileNameArr);
			$newName = date('His').rand() . time() . '.' . $fileNameExt;
			
			$file->move($destinationPath, $newName);
			$img = Image::make(public_path('/uploads/suppliers/'.$newName));
            $img->resize(250, 250, function($constraint) {
				$constraint->aspectRatio();
			});
			$img->save(public_path('/uploads/suppliers/thumb/'.$newName));
			if($record->image != 'no-image.png'){
            //** Below code for unlink old image **//
			$oldImage = public_path('/uploads/suppliers/'.$record->image);
			$oldImageThumb = public_path('/uploads/suppliers/thumb/'.$record->image);
			
			if(!empty($record->image) && @getimagesize($oldImage) && file_exists($oldImage)) {
				unlink($oldImage);
				unlink($oldImageThumb);
			}
			}
			
            $record->image = $newName;
		}
         $record->name = $request->input('first_name');
        $record->lname = $request->input('last_name');
        $record->mobile = $request->input('mobile');
		$record->email = $request->input('email');
		$record->company_name = $request->input('company_name');
		$record->department = $request->input('department');
		$record->phone = $request->input('phone_number');
        $record->address = $request->input('address');
        $record->postcode = $request->input('zip_code');
        $record->country_id = $request->input('country_id');
        $record->state_id = $request->input('state_id');
        $record->city_id = $request->input('city_id');
		$record->service_type = $request->input('service_type');
        $record->is_active = $request->input('status');
		$record->booking_email = $request->input('booking_email');
		$record->updated_by = Auth::user()->id;
        $record->save();
        return redirect('suppliers')->with('success', 'Supplier Updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\State  $State
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = User::find($id);
        $record->delete();
        return redirect('suppliers')->with('success', 'Supplier Deleted.');
    }
	
	public function priceMarkupActivityList($id)
    {
		$this->checkPermissionMethod('list.supplier');
		$supplierId = $id;
		//$perPage = config("constants.ADMIN_PAGE_LIMIT");
        $perPage = "1000";
		$records = Activity::where('status', 1)->orderBy('title', 'ASC')->paginate($perPage);
		$supplier = User::find($supplierId);
		$activity_ids = explode(",",$supplier->activity_id);
		$agentCompany =$supplier->company_name;
        return view('suppliers.priceActivities', compact('records','supplierId','activity_ids','agentCompany'));
    }
	
	public function priceMarkupActivitySave(Request $request)
    {
		//$perPage = config("constants.ADMIN_PAGE_LIMIT");
        $perPage = "1000";
        $input = $request->all();
        $supplier = User::find($request->input('supplier_id'));
		
		$activity_id = $request->input('activity_id');
		$data = [];
		if(!empty($activity_id))
		{
			foreach($activity_id as $k => $av)
			{
				$data[] = $av;
			}
			
			$jsonData = implode(",",$data);
			
			$supplier->activity_id = $jsonData;
			$supplier->save();
			return redirect()->route('suppliers.markup.price',[$request->input('supplier_id')])->with('success', 'Activity Saved.');
		}
		else
		{
			return redirect()->back()->with('error', 'Please select at least one activity.');
		}
        
		
        
        
    }
	
	public function markupPriceList($id)
    {
		$this->checkPermissionMethod('list.supplier');
		$supplierId = $id;
		$supplier = User::find($supplierId);
		$activity_ids = explode(",",$supplier->activity_id);
		$agentCompany = $supplier->company_name;
		$activities = Activity::whereIn('id', $activity_ids)->where(['status'=> 1])->get();
		$variants = [];
		$markups = [];
		foreach($activity_ids as $aid)
		{
			$variants[$aid] = ActivityVariant::with('variant')->where('activity_id', $aid)->get();
			
			foreach($variants[$aid] as $variant)
			{
				
				$m = AgentPriceMarkup::where('agent_id',  $supplierId)->where('activity_id',  $aid)->where('variant_code',  $variant['ucode'])->first();
				
					if(!empty($m))
					{
						$markups[$variant->ucode] = [
							'ticket_only'=>$m->ticket_only,
							'sic_transfer'=>$m->sic_transfer,
							'pvt_transfer'=>$m->pvt_transfer,
						];
					} else {
						$markups[$variant->ucode] = [
							'ticket_only'=>0,
							'sic_transfer'=>0,
							'pvt_transfer'=>0,
						];
					} 
			}
			
		}
		
		
		
		/* print_r($markups);
		exit; */
        return view('suppliers.supplierPriceMarkup', compact('supplierId','activities','variants','markups','agentCompany'));
    }
	
	public function markupPriceSave(Request $request)
    {
		$perPage = config("constants.ADMIN_PAGE_LIMIT");
        $input = $request->all();
        $record = new AgentPriceMarkup();
		$agent_id = $request->input('supplier_id');
		$ticket_only = $request->input('ticket_only');
		$sic_transfer = $request->input('sic_transfer');
		$pvt_transfer = $request->input('pvt_transfer');
		$data = [];
		if(!empty($ticket_only))
		{
			foreach($ticket_only as $activity_id => $acv)
			{
				foreach($acv as $variant_code => $ac)
				{
				$data[] = [
				'agent_id' => $agent_id,
				'activity_id' => $activity_id,
				'variant_code' => $variant_code,
				'ticket_only' => $ac,
				'sic_transfer' => $sic_transfer[$activity_id][$variant_code],
				'pvt_transfer' => $pvt_transfer[$activity_id][$variant_code],
				'created_by' => Auth::user()->id,
				'updated_by' => Auth::user()->id,
				];
				}
			}
		}
        
		if(count($data) > 0)
		{
			AgentPriceMarkup::where("agent_id",$agent_id)->delete();
			AgentPriceMarkup::insert($data);
			 return redirect('suppliers')->with('success', 'Markup saved successfully.');
		}
		else
		{
			 return redirect()->back()->with('error', 'Something went wrong.');
		}
		
    }
}
