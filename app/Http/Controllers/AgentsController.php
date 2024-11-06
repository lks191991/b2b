<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\User;
use App\Models\Activity;
use App\Models\AgentPriceMarkup;
use App\Models\ActivityPrices;
use App\Models\AgentDetails;
use App\Models\AgentAdditionalUser;
use Illuminate\Http\Request;
use jeremykenedy\LaravelRoles\Models\Role;
use jeremykenedy\LaravelRoles\Models\Permission;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegisterToAgencyMailable;
use App\Models\ReportLog;

use DB;
use Image;
use SiteHelpers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Currency;
use App\Models\ActivityVariant;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use App\Services\FlyremitService;

class AgentsController extends Controller
{
	
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		$this->checkPermissionMethod('list.agent');
        $data = $request->all();
        $perPage = config("constants.ADMIN_PAGE_LIMIT");
        $query = User::with(['country', 'state', 'city']);
		if(!empty(Auth::user()->zone)){
			$query->where('zone', Auth::user()->zone);
		}
		
		$query->where('role_id', 3);
        if (isset($data['name']) && !empty($data['name'])) {
            $query->where('name', 'like', '%' . $data['name'] . '%');
        }
       if (isset($data['email']) && !empty($data['email'])) {
            $query->where('email', 'like', '%' . $data['email'] . '%');
        }
		if (isset($data['cname']) && !empty($data['cname'])) {
            $query->where('company_name', 'like', '%' . $data['cname'] . '%');
        }
       
        if (isset($data['code']) && !empty($data['code'])) {
            $query->where('code', $data['code']);
        }
		
		 if (isset($data['mobile']) && !empty($data['mobile'])) {
            $query->where('mobile', $data['mobile']);
        }
		
		if (isset($data['city_id']) && !empty($data['city_id'])) {
            $query->where('city_id', $data['city_id']);
        }
		
        if (isset($data['status']) && !empty($data['status'])) {
            if ($data['status'] == 1)
                $query->where('is_active', 1);
            if ($data['status'] == 2)
                $query->where('is_active', 0);
        }

        //$records = $query->orderBy('created_at', 'DESC')->paginate($perPage);
		$records = $query->orderBy('created_at', 'DESC')->get();

        $countries = Country::where('status', 1)->orderBy('name', 'ASC')->get();
        $states = State::where('status', 1)->orderBy('name', 'ASC')->get();
        $cities = City::where('status', 1)->orderBy('name', 'ASC')->get();

        return view('agents.index', compact('records', 'countries', 'states', 'cities'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$this->checkPermissionMethod('list.agent');
        $countries = Country::where('status', 1)->orderBy('name', 'ASC')->get();
		$currencies = Currency::where('status', 1)->orderBy('name', 'ASC')->get();
        return view('agents.create', compact('countries','currencies'));
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
           'first_name' => 'required|max:255|sanitizeScripts|alpha',
            'last_name' => 'required|max:255|sanitizeScripts|alpha',
            'mobile' => 'required',
            'address' => 'required',
			'email' => 'required|max:255|sanitizeScripts|email|unique:users|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
			'password' => 'required|min:6|max:255|sanitizeScripts',
			'image' => 'nullable|mimes:jpeg,jpg,png|max:' . ($options['allow_img_size'] * 1024),  
            'city_id' => 'required',
            'state_id' => 'required',
            'country_id' => 'required',
			'currency_id' => 'required',
            'postcode' => 'required',
			'trade_license_no_file' => 'nullable|mimes:jpeg,jpg,png,pdf|max:' . ($options['allow_img_size'] * 1024), 
			'pan_no_file' => 'nullable|mimes:jpeg,jpg,png,pdf|max:' . ($options['allow_img_size'] * 1024), 
        ], [
            'name.sanitize_scripts' => 'Invalid value entered for Name field.',
            'country_id.required' => 'The country field is required.',
            'state_id.required' => 'The state field is required.',
			'currency_id.required' => 'The currency field is required.',
        ]);
		
		$input = $request->all();
		
        $record = new User();
		
		$destinationPath = public_path('/uploads/users/');
		if ($request->hasFile('image')) {

           
			$fileName = $input['image']->getClientOriginalName();
			$file = request()->file('image');
			$fileNameArr = explode('.', $fileName);
			$fileNameExt = end($fileNameArr);
			$newName = date('His').rand() . time() . '.' . $fileNameExt;
			
			$file->move($destinationPath, $newName);
			
			//$user_config = json_decode($options['user'],true);
			
			$img = Image::make(public_path('/uploads/users/'.$newName));
						
            $img->resize(250, 250, function($constraint) {
				$constraint->aspectRatio();
			});
			
			$img->save(public_path('/uploads/users/thumb/'.$newName));

            $record->image = $newName;
		}
		
		if ($request->hasFile('pan_no_file')) {

			$destinationPath3 = public_path('/uploads/users/');
			$fileName3 = $input['pan_no_file']->getClientOriginalName();
			$file3 = request()->file('pan_no_file');
			$fileNameArr3 = explode('.', $fileName3);
			$fileNameExt3 = end($fileNameArr3);
			$newName3 = date('His').rand() . time() . '.' . $fileNameExt3;
			$file3->move($destinationPath3, $newName3);
            $record->pan_no_file = $newName3;
		} 
		if ($request->hasFile('trade_license_no_file')) {

			$destinationPath2 = public_path('/uploads/users/');
			$fileName2 = $input['trade_license_no_file']->getClientOriginalName();
			$file2 = request()->file('trade_license_no_file');
			$fileNameArr2 = explode('.', $fileName2);
			$fileNameExt2 = end($fileNameArr2);
			$newName2 = date('His').rand() . time() . '.' . $fileNameExt2;
			$file2->move($destinationPath2, $newName2);
            $record->trade_license_no_file = $newName2;
		} 
		
        $record->name = $request->input('first_name');
        $record->lname = $request->input('last_name');
		
        $record->mobile = $request->input('mobile');
		$record->email = $request->input('email');
		$record->company_name = $request->input('company_name');
		$record->department = $request->input('department');
		$record->phone = $request->input('phone_number');
        $record->address = $request->input('address');
        $record->postcode = $request->input('postcode');
        $record->country_id = $request->input('country_id');
        $record->state_id = $request->input('state_id');
        $record->city_id = $request->input('city_id');
		$record->currency_id = $request->input('currency_id');
        $record->is_active = $request->input('status');
		$record->agent_category = $request->input('agent_category');
		$record->agent_credit_limit = (!empty($request->input('agent_credit_limit')))?$request->input('agent_credit_limit'):0;
		$record->sales_person = $request->input('sales_person');
		$record->agent_amount_balance = (!empty($request->input('agent_credit_limit')))?$request->input('agent_credit_limit'):0;
        $record->created_by = Auth::user()->id;
		$record->role_id = 3; 
        $record->password = bcrypt($request->input('password'));
		$record->ticket_only = (!empty($request->input('ticket_only')))?$request->input('ticket_only'):0;
		$record->sic_transfer = (!empty($request->input('sic_transfer')))?$request->input('sic_transfer'):0;
		$record->pvt_transfer = (!empty($request->input('pvt_transfer')))?$request->input('pvt_transfer'):0;
		$record->vat = $request->input('vat');
		$record->agency_mobile = $request->input('agency_mobile');
		$record->agency_email = $request->input('agency_email');
		$record->address_two = $request->input('address_two');
		$record->pan_no = $request->input('pan_no');
		$record->trade_license_no = $request->input('trade_license_no');
		$record->trn_no = $request->input('trn_no');
		$record->group_id  = $request->input('group_id');
		$record->zone = $request->input('zone');
		
        $record->save();
        $record->attachRole('3');
		
		$userCount = User::where("role_id",3)->count();
		$codeNumber  = $userCount + 1;
		$code = 'TA-700'.$codeNumber;
		$recordUser = User::find($record->id);
		$recordUser->code = $code;
		$recordUser->save();
		
		$additionalContactInsert = [];
		$additionalContact = $request->input('a_name');
		$department = $request->input('a_department');
		$mobile = $request->input('a_mobile');
		$phone = $request->input('a_phone');
		$email = $request->input('a_email');
		if(!empty($additionalContact) > 0)
		{
			foreach($additionalContact as $k => $data)
			{
				if(!empty($data))
				{
				$additionalContactInsert[$k]=[
				'user_id' => $record->id,
				'name' => $data,
				'department' => $department[$k],
				'mobile' => $mobile[$k],
				'phone' => $phone[$k],
				'email' => $email[$k],
				];
				}
			}
			
			if(!empty($additionalContactInsert)){
				AgentAdditionalUser::insert($additionalContactInsert);
			}
		}
		
		if($request->input('status') == '1'){
				$password = $request->input('password');
				$agentData['name'] =  $recordUser->name;
				$agentData['company'] =  $recordUser->company_name;
				$agentData['email'] =  $recordUser->email;
				$agentData['password'] =  $password;
				$recordUser = User::find($record->id);
				$recordUser->email_verified_at = now();
				$recordUser->save(); 
				$admin = User::where("role_id",1)->first();
				Mail::to($record->email,'Abaterab2b Login Details.')->cc($admin->email)->send(new RegisterToAgencyMailable($agentData)); 
				
		}
		
        return redirect('agents')->with('success', 'Agent Created Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(User $agent)
    {
		$this->checkPermissionMethod('list.agent');
		$activity_ids = explode(",",$agent->activity_id);
		
		$variants = [];
		$markups = [];
		foreach($activity_ids as $aid)
		{
			$activity = Activity::find($aid);
			$variants[$aid] = ActivityPrices::select('variant_code')->distinct()->where('activity_id',  $aid)->get()->toArray();
			
			foreach($variants[$aid] as $variant)
			{
				$m = AgentPriceMarkup::where('agent_id',  $agent->id)->where('activity_id',  $aid)->where('variant_code',  $variant['variant_code'])->first();
				
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
		
		$creditLogs = ReportLog::where('agent_id',$agent->id)->get();

		$agentAdditionalUsers = AgentAdditionalUser::where('user_id', $agent->id)->get();
		
        return view('agents.view', compact('agent','markups','agentAdditionalUsers','creditLogs'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\State  $State
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
		$this->checkPermissionMethod('list.agent');
        $record = User::find($id);
        $countries = Country::where('status', 1)->orderBy('name', 'ASC')->get();
        $states = State::where('status', 1)->orderBy('name', 'ASC')->get();
        $cities = City::where('status', 1)->orderBy('name', 'ASC')->get();
		$agentAdditionalUsers = AgentAdditionalUser::where('user_id', $record->id)->get();
		$currencies = Currency::where('status', 1)->orderBy('name', 'ASC')->get();
        return view('agents.edit')->with(['record' => $record, 'countries' => $countries, 'currencies' => $currencies, 'states' => $states, 'cities' => $cities,'agentAdditionalUsers' => $agentAdditionalUsers]);
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
		$options['allow_img_size'] = 10;
        $request->validate([
            'first_name' => 'required|max:255|sanitizeScripts|alpha',
            'last_name' => 'required|max:255|sanitizeScripts|alpha',
            'mobile' => 'required',
			'email'=>'required|max:255|sanitizeScripts|email|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix|unique:users,email,' .$id,
            'address' => 'required',
            'city_id' => 'required',
            'state_id' => 'required',
            'country_id' => 'required',
            'postcode' => 'required',
			'currency_id' => 'required',
			
			'image' => 'nullable|mimes:jpeg,jpg,png|max:' . ($options['allow_img_size'] * 1024), 
			
			'trade_license_no_file' => 'nullable|mimes:jpeg,jpg,png,pdf|max:' . ($options['allow_img_size'] * 1024), 
			'pan_no_file' => 'nullable|mimes:jpeg,jpg,png,pdf|max:' . ($options['allow_img_size'] * 1024), 
        ], [
            'name.sanitize_scripts' => 'Invalid value entered for Name field.',
            'country_id.required' => 'The country field is required.',
            'state_id.required' => 'The state field is required.',
			'currency_id.required' => 'The currency field is required.',
        ]);
		
		$input = $request->all();
        $record = User::find($id);
		 /** Below code for save image **/
		$destinationPath = public_path('/uploads/users/');
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
			
			//$user_config = json_decode($options['record'],true);
			
			$img = Image::make(public_path('/uploads/users/'.$newName));
						
            $img->resize(250, 250, function($constraint) {
				$constraint->aspectRatio();
			});
			
			$img->save(public_path('/uploads/users/thumb/'.$newName));
			
			if($record->image != 'no-image.png'){
            //** Below code for unlink old image **//
				$oldImage = public_path('/uploads/users/'.$record->image);
				$oldImageThumb = public_path('/uploads/users/thumb/'.$record->image);
				if(!empty($record->image) && @getimagesize($oldImage) && file_exists($oldImage)) {
					unlink($oldImage);
					unlink($oldImageThumb);
				}
			}
            $record->image = $newName;
		}
		
		if ($request->hasFile('pan_no_file')) {

			$destinationPath3 = public_path('/uploads/users/');
			$fileName3 = $input['pan_no_file']->getClientOriginalName();
			$file3 = request()->file('pan_no_file');
			$fileNameArr3 = explode('.', $fileName3);
			$fileNameExt3 = end($fileNameArr3);
			$newName3 = date('His').rand() . time() . '.' . $fileNameExt3;
			$file3->move($destinationPath3, $newName3);
            $record->pan_no_file = $newName3;
		} 
		if ($request->hasFile('trade_license_no_file')) {

			$destinationPath2 = public_path('/uploads/users/');
			$fileName2 = $input['trade_license_no_file']->getClientOriginalName();
			$file2 = request()->file('trade_license_no_file');
			$fileNameArr2 = explode('.', $fileName2);
			$fileNameExt2 = end($fileNameArr2);
			$newName2 = date('His').rand() . time() . '.' . $fileNameExt2;
			$file2->move($destinationPath2, $newName2);
            $record->trade_license_no_file = $newName2;
		} 
		
		 if(!empty($request->input('password'))){
            request()->validate([
                'password' => 'required|confirmed',
            ]);
            $record->password = bcrypt(trim($request->input('password')));
        }
		
		$record->name = $request->input('first_name');
        $record->lname = $request->input('last_name');
		
        $record->mobile = $request->input('mobile');
		$record->email = $request->input('email');
		$record->company_name = $request->input('company_name');
		$record->department = $request->input('department');
		$record->phone = $request->input('phone_number');
        $record->address = $request->input('address');
        $record->postcode = $request->input('postcode');
        $record->country_id = $request->input('country_id');
        $record->state_id = $request->input('state_id');
        $record->currency_id = $request->input('currency_id');
		$record->city_id = $request->input('city_id');
		$record->is_active = $request->input('status');
		$record->agent_category = $request->input('agent_category');
		//$record->agent_credit_limit = (!empty($request->input('agent_credit_limit')))?$request->input('agent_credit_limit'):0;
		$record->sales_person = $request->input('sales_person');
		//$record->agent_amount_balance = (!empty($request->input('agent_amount_balance')))?$request->input('agent_amount_balance'):0;
		$record->ticket_only = (!empty($request->input('ticket_only')))?$request->input('ticket_only'):0;
		$record->sic_transfer = (!empty($request->input('sic_transfer')))?$request->input('sic_transfer'):0;
		$record->pvt_transfer = (!empty($request->input('pvt_transfer')))?$request->input('pvt_transfer'):0;
		$record->vat = $request->input('vat');
		$record->agency_mobile = $request->input('agency_mobile');
		$record->agency_email = $request->input('agency_email');
		$record->address_two = $request->input('address_two');
		$record->pan_no = $request->input('pan_no');
		$record->trade_license_no = $request->input('trade_license_no');
		$record->trn_no = $request->input('trn_no');
		$record->group_id  = $request->input('group_id');
		$record->zone = $request->input('zone');
		$record->updated_by = Auth::user()->id;
		
		if(($request->input('credit_limit_type') == 1) && ($request->input('credit_amount') > 0))
		{

			ReportLog::create([
				"input"=>"Add",
				"input_vaue"=>$request->input('credit_amount'),
				"updated_by"=>Auth::user()->id,
				"report_type"=>"agent_credit",
				"agent_id"=>$record->id,
			
				]);

			$record->agent_credit_limit +=$request->input('credit_amount');
			$record->agent_amount_balance +=$request->input('credit_amount');
		}elseif(($request->input('credit_limit_type') == 2) && ($request->input('credit_amount') > 0))
		{
			if($record->agent_amount_balance >= $request->input('credit_amount'))
			{
				ReportLog::create([
					"input"=>"Minus",
					"input_vaue"=>$request->input('credit_amount'),
					"updated_by"=>Auth::user()->id,
					"report_type"=>"agent_credit",
					"agent_id"=>$record->id,
				
					]);
	
				$record->agent_credit_limit -= $request->input('credit_amount');
				$record->agent_amount_balance -= $request->input('credit_amount');
			}
		}
		
		
		if($request->input('country_id') == 94 && $record->flyremit_reg == 0 && $request->input('status') == 1 && $request->input('pan_no') != ''){


			//$flyremitCityID = SiteHelpers::getFlyremitCityById($request->input('city_id'));

		$dataAgent = [
            
            'agentID' => $record->id,
            'panNumber' => $request->input('pan_no'),
            'name' => $request->input('first_name').' '.$request->input('last_name'),
			 'mobile' =>$request->input('mobile'),
            'email' => $request->input('email'),
            'cityId' => $request->input('city_id'),
        ];
		
		$flyremitService = new FlyremitService();
		 $response = $flyremitService->registerAgent($dataAgent);
		$record->flyremit_response = $response['message'];
		if($response['status'] == 1){
			$record->flyremit_reg = 1;
		}
		
		}
		
        $record->save();
		
		$additionalContactInsert = [];
		$additionalContact = $request->input('a_name');
		$department = $request->input('a_department');
		$mobile = $request->input('a_mobile');
		$phone = $request->input('a_phone');
		$email = $request->input('a_email');
		if(!empty($additionalContact) > 0)
		{
			AgentAdditionalUser::where('user_id', $record->id)->delete();
			foreach($additionalContact as $k => $data)
			{
				if(!empty($data))
				{
				$additionalContactInsert[$k]=[
				'user_id' => $record->id,
				'name' => $data,
				'department' => $department[$k],
				'mobile' => $mobile[$k],
				'phone' => $phone[$k],
				'email' => $email[$k],
				];
				}
			}
			
			if(!empty($additionalContactInsert)){
				AgentAdditionalUser::insert($additionalContactInsert);
			}
		}
		
		if(empty($record->email_verified_at)){
			
				$agentData['name'] =  $record->name;
				$agentData['company'] =  $record->company_name;
				$agentData['email'] =  $record->email;
				$recordUser = User::find($record->id);
				$recordUser->email_verified_at = now();
				$recordUser->save();
		}
		
		
        return redirect('agents')->with('success', 'Agent Updated.');
    }
	
	public function passwordResetAdmin(Request $request, $id)
    {
		
		$input = $request->all();
		$password = Str::random(10);
        $record = User::find($id);
		
        $record->password = bcrypt($password);
		$record->updated_by = Auth::user()->id;
        $record->save();
		$agentData['name'] =  $record->name;
		$agentData['company'] =  $record->company_name;
		$agentData['email'] =  $record->email;
		$agentData['password'] =  $password;
		//dd($agentData);
		$admin = User::where("role_id",1)->first();
		Mail::to($record->email,'Abaterab2b Login Details.')->cc($admin->email)->send(new RegisterToAgencyMailable($agentData)); 
		if($input['user'] == 'agent'){
        return redirect('agents')->with('success', 'Password Reset Successfully.');
		}
		elseif($input['user'] == 'user'){
			 return redirect('users')->with('success', 'Password Reset Successfully.');
		}
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
        return redirect('agents')->with('success', 'Agent Deleted.');
    }
	
	public function priceMarkupActivityList($id)
    {
		$this->checkPermissionMethod('list.agent');
		$agentId = $id;
		//$perPage = config("constants.ADMIN_PAGE_LIMIT");
        $perPage = "1000";
		$records = Activity::where('status', 1)->orderBy('title', 'ASC')->paginate($perPage);
		$agent = User::find($agentId);
		$activity_ids = explode(",",$agent->activity_id);
		$agentCompany =$agent->company_name;
        return view('agents.priceActivities', compact('records','agentId','activity_ids','agentCompany'));
    }
	
	public function priceMarkupActivitySave(Request $request)
    {
		$perPage = config("constants.ADMIN_PAGE_LIMIT");
        $input = $request->all();
        $agent = User::find($request->input('agent_id'));
		
		$activity_id = $request->input('activity_id');
		$data = [];
		if(!empty($activity_id))
		{
			foreach($activity_id as $k => $av)
			{
				$data[] = $av;
			}
			
			$jsonData = implode(",",$data);
			
			$agent->activity_id = $jsonData;
			$agent->save();
			return redirect()->route('agents.markup.price',[$request->input('agent_id')])->with('success', 'Activity Saved.');
		}
		else
		{
			return redirect()->back()->with('error', 'Please select at least one activity.');
		}
        
		
        
        
    }
	
	public function markupPriceList($id)
    {
		$this->checkPermissionMethod('list.agent');
		$agentId = $id;
		$agent = User::find($agentId);
		$activity_ids = explode(",",$agent->activity_id);
		$activities = Activity::whereIn('id', $activity_ids)->where(['status'=> 1])->get();
		$agentCompany = $agent->company_name;
		
		$variants = [];
		$markups = [];
		foreach($activity_ids as $aid)
		{
			$variants[$aid] = ActivityVariant::with('variant')->where('activity_id', $aid)->get();
			 
			foreach($variants[$aid] as $variant)
			{
				
				$m = AgentPriceMarkup::where('agent_id',  $agentId)->where('activity_id',  $aid)->where('variant_code',  $variant['ucode'])->first();
				
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
		
		//dd($variants);
		 //print_r($variants);
		 //exit; 
		
		 
		
        return view('agents.agentPriceMarkup', compact('agentId','activities','variants','markups','agentCompany'));
    }
	
	public function markupPriceSave(Request $request)
    {
		$perPage = config("constants.ADMIN_PAGE_LIMIT");
        $input = $request->all();
        $record = new AgentPriceMarkup();
		$agent_id = $request->input('agent_id');
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
			 return redirect('agents')->with('success', 'Markup saved successfully.');
		}
		else
		{
			 return redirect()->back()->with('error', 'Something went wrong.');
		}
		
    }
	
	public function autocompleteAgentSupp(Request $request)
    {
		$search  = $request->get('search');
		$nameOrCompany  = ($request->get('nameorcom'))?$request->get('nameorcom'):'Company';
		if($nameOrCompany == 'Company'){
        $users = User::whereIn('role_id', [3,9])
					//->where('is_active', 1)
					
					->where(function ($query) use($search) {
						if(!empty(Auth::user()->zone)){
							$query->where('zone',Auth::user()->zone);
					}
						$query->where('company_name', 'LIKE', '%'. $search. '%')
						->orWhere('code', 'LIKE', '%'. $search. '%')
						->orWhere('mobile', 'LIKE', '%'. $search. '%');
					})->get();
		$response = array();
      foreach($users as $user){
		  if($user->role_id == 3){
		   $agentDetails = '<b>Address: </b>'.$user->address. " ".$user->postcode.'<br/><b>Mobile No: </b>'.$user->mobile.'<br/><b>Tin No: </b>'.$user->vat.'<br/><b>Available Limit: </b> AED '.$user->agent_amount_balance;
		  } else {
			 $agentDetails = '<b>Address: </b>'.$user->address. " ".$user->postcode.'<br/><b>Mobile No: </b>'.$user->mobile;  
			}
         $response[] = array("value"=>$user->id,"label"=>$user->company_name.'('.$user->code.')',"agentDetails"=>$agentDetails);
      }
	}
	elseif($nameOrCompany == 'Name'){
        $users = User::whereIn('role_id', [3,9])
					// ->where('is_active', 1)
					->where(function ($query) use($search) {
						$query->where('name', 'LIKE', '%'. $search. '%')
						->orWhere('code', 'LIKE', '%'. $search. '%')
						->orWhere('mobile', 'LIKE', '%'. $search. '%');
					})->get();
		$response = array();
      foreach($users as $user){
		   if($user->role_id == 3){
		  $agentDetails = '<b>Code:</b> '.$user->code.' <b>Email:</b>'.$user->email.' <b> Mobile No:</b>'.$user->mobile.' <b>Address:</b>'.$user->address. " ".$user->postcode;
		  } else {
			 $agentDetails = '<b>Address: </b>'.$user->address. " ".$user->postcode.'<br/><b>Mobile No: </b>'.$user->mobile;  
			}
		   
         $response[] = array("value"=>$user->id,"label"=>$user->full_name.'('.$user->code.')',"agentDetails"=>$agentDetails);
      }
	}	  
        return response()->json($response);
    }
	
	public function CurrencyChange(Request $request,$user_currency)
    {
		$user = Auth::user();
		$input = $request->all();
		$currency = Currency::where('code', $user_currency)->first();
		if(!empty($currency)){
        $user->currency_id = $currency->id;
		$user->save();
		}
		return redirect()->back();
    }
	
	

/* public function sendApiRequest()
    {
        $response = $this->flyremitService->registerAgent(
            31146,
            'abetera3344',
            'ANxxx7440F',
            'robert',
            '888xxxx366',
            'test@gmail.com',
            21
        );

        // Handle the response as needed
        dd($response);
    } */

	
}
