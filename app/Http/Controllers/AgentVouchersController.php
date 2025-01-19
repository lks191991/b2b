<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use App\Models\Airline;
use App\Models\User;
use App\Models\Customer;
use App\Models\Country;
use App\Models\Zone;
use App\Models\Hotel;
use App\Models\VoucherHotel;
use App\Models\Activity;
use App\Models\ActivityPrices;
use App\Models\ActivityVariant;
use App\Models\TransferData;
use Illuminate\Http\Request;
use App\Models\VoucherActivity;
use App\Models\Ticket;
use SiteHelpers;
use PriceHelper;
use Carbon\Carbon;
use SPDF;
use App\Models\VariantCanellation;
use Illuminate\Support\Facades\Auth;
use App\Models\AgentAmount;
use Illuminate\Support\Facades\Mail;
use App\Mail\VoucheredBookingEmailMailable;
use App\Models\Tag;
use App\Mail\VoucheredCancelEmail;

class AgentVouchersController extends Controller
{
	

	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		
		$redirectResponse = $this->chekAgentLogin();
		if ($redirectResponse) {
		return $redirectResponse;
		}
		
		 $perPage = config("constants.ADMIN_PAGE_LIMIT");
		 $data = $request->all();
		$query = VoucherActivity::whereHas('voucher', function($q){
			$q->where('agent_id', '=', Auth::user()->id);
			$q->where(function ($q) {
				$q->where('status_main', 3)->orWhere('status_main', 4)->orWhere('status_main', 5);
				});
		});
		
		if(isset($data['booking_type']) && !empty($data['booking_type'])) {
			
			if (isset($data['from_date']) && !empty($data['from_date']) &&  isset($data['to_date']) && !empty($data['to_date'])) {
			$startDate = date("Y-m-d",strtotime($data['from_date']));
			$endDate = date("Y-m-d",strtotime($data['to_date']));
				if($data['booking_type'] == 2) {
				 $query->whereDate('tour_date', '>=', $startDate);
				 $query->whereDate('tour_date', '<=', $endDate);
				}
				elseif($data['booking_type'] == 1) {
					$query->whereHas('voucher', function($q)  use($startDate,$endDate){
				 $q->where('booking_date', '>=', $startDate);
				 $q->where('booking_date', '<=', $endDate);
				});
		
				}
				}
			}
		 if(isset($data['vcode']) && !empty($data['reference'])) {
			$query->whereHas('voucher', function($q)  use($data){
				$q->where('agent_ref_no', '=', $data['reference']);
			});
		}
		
		 if(isset($data['vcode']) && !empty($data['vcode'])) {
			$query->whereHas('voucher', function($q)  use($data){
				$q->where('code', '=', $data['vcode']);
			});
		}
		 if(isset($data['activity_name']) && !empty($data['activity_name'])) {
			$query->whereHas('activity', function($q)  use($data){
				$q->where('title', 'like', '%' . $data['activity_name'] . '%');
			});
		}
		if(isset($data['customer']) && !empty($data['customer'])) {
			$query->whereHas('voucher', function($q)  use($data){
				$q->where('guest_name', 'like', '%' . $data['customer'] . '%');
			});
		}
		
       
        $records = $query->orderBy('created_at', 'DESC')->paginate($perPage);
		$agetid = '';
		$agetName = '';
		
		
		
        return view('agent-vouchers.index', compact('records'));

    }

    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$redirectResponse = $this->chekAgentLogin();
		if ($redirectResponse) {
		return $redirectResponse;
		}
		
		$countries = Country::where('status', 1)->orderBy('name', 'ASC')->get();
		$airlines = Airline::where('status', 1)->orderBy('name', 'ASC')->get();
		if(old('customer_id_select')){
		$customerTBA = Customer::where('id', old('customer_id_select'))->where('status', 1)->first();
		}else{
		$customerTBA = Customer::where('id', 1)->where('status', 1)->first();	
		}
		
        return view('agent-vouchers.create', compact('countries','airlines','customerTBA'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		$redirectResponse = $this->chekAgentLogin();
		if ($redirectResponse) {
		return $redirectResponse;
		}
		
		
        $request->validate([
            
			'travel_from_date'=>'required',
			'nof_night'=>'required',
        ], [
			'arrival_airlines_id.required_if' => 'The airlines id field is required.',
			'arrival_date.required_if' => 'The arrival date field is required .',
			'depature_date.required_if' => 'The depature date field is required .',
			'depature_airlines_id.required_if' => 'The depature airlines field is required .',
			'travel_from_date.required' => 'The travel date from field is required .',
			'nof_night.required' => 'The number of night field is required .',
		]);
		
		
		$arrival_date = $request->input('arrival_date'); // get the value of the date input
		$depature_date = '';//$request->input('depature_date'); // get the value of the date input
		$customer = Customer::where('mobile',Auth::user()->mobile)->first();
		
		$timestamp = strtotime($request->input('travel_from_date'));
		$travel_from_date = date('Y-m-d', $timestamp);
		$daysToAdd = $request->input('nof_night');
		$newTimestamp = strtotime("+{$daysToAdd} days", $timestamp);
		$travel_to_date = date('Y-m-d', $newTimestamp);
		
		if(empty($customer))
		{
			$customer = new Customer();
			$customer->name = $request->input('customer_name');
			$customer->mobile = Auth::user()->mobile;
			$customer->email = $request->input('customer_email');
			$customer->save();
		}
		else
		{
			//$customer->name = $request->input('customer_name');
			//$customer->email = $request->input('customer_email');
			//$customer->save();
		}
			
		

        $record = new Voucher();
        $record->agent_id = Auth::user()->id;
		$record->customer_id = $customer->id;
		$record->zone = Auth::user()->zone;
		$record->country_id = '1';
		$record->is_hotel = 0;
		$record->is_flight = 0;
		$record->is_activity = 1;
		$record->arrival_date = $arrival_date;
		$record->travel_from_date = $travel_from_date;
		$record->travel_to_date = $travel_to_date;
		$record->nof_night = $request->input('nof_night');
		$record->vat_invoice = 1;
		$record->status = 1;
		$record->adults = $request->input('adult_quantity');
		$record->childs = $request->input('child_quantity');
		$record->created_by = Auth::user()->id;
        $record->save();
		$no = sprintf("%03d",$record->id);	
		$code = 'ABT-'.date("Y")."-8".$no;
		
		$recordUser = Voucher::find($record->id);
		$recordUser->code = $code;
		
		$recordUser->save();
		
		
		if ($request->has('save_and_activity')) {
			if($record->is_activity == 1){
			return redirect()->route('agent-vouchers.add.activity',$record->id);
			}
			else
			{
				return redirect()->route('agent-vouchers.index')->with('error', 'If select hotel yes than you can add hotel.');
			}
		} else {
        return redirect()->route('agent-vouchers.index');
		}
		
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
	 
	public function show($id)
    {
		$redirectResponse = $this->chekAgentLogin();
		if ($redirectResponse) {
		return $redirectResponse;
		}
		
		$voucher = Voucher::with('agent')->find($id);
		
		if (empty($voucher)) {
            return abort(404); //record not found
        }
		
		$voucherHotel = VoucherHotel::where('voucher_id',$voucher->id)->get();
		$voucherActivity = VoucherActivity::where('voucher_id',$voucher->id)->orderBy("tour_date","ASC")->orderBy("serial_no","ASC")->get();
		
		if(empty($voucherActivity))
		{
			return redirect()->route('agent-vouchers.add.activity',$voucher->id);
		}
		
		if($voucher->status_main  > 4)
		{
			return redirect()->route('agentVoucherView',$voucher->id);
		}
		
		
		$voucherStatus = config("constants.voucherStatus");
	
		$name = explode(' ',$voucher->guest_name);
		
		$fname = '';
		$lname = '';
		if(!empty($name)){
			$fname = trim($name[0]);
			unset($name[0]);
			$lname = trim(implode(' ', $name));
		}
		$entries = VoucherActivity::where('voucher_id',$id)->count()+VoucherHotel::where('voucher_id',$id)->count();
		if($entries > 0)
        	return view('agent-vouchers.view', compact('voucher','voucherHotel','voucherActivity','voucherStatus','fname','lname'));
		else
		return redirect()->route('agent-vouchers.add.activity',$id);
    }
	
   
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $record = Voucher::where('id',$id)->where('agent_id',Auth::user()->id)->first();
		if (empty($record)) {
            return abort(404); //record not found
        }
		
		$countries = Country::where('status', 1)->orderBy('name', 'ASC')->get();
		$airlines = Airline::where('status', 1)->orderBy('name', 'ASC')->get();
		$customer = Customer::where('id',$record->customer_id)->first();
       return view('agent-vouchers.edit')->with(['record'=>$record,'countries'=>$countries,'airlines'=>$airlines,'customer'=>$customer]);
		
        
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
			'country_id'=>'required',
			'travel_from_date'=>'required',
			'nof_night'=>'required',
			'arrival_airlines_id' => 'required_if:is_flight,==,1',
			'arrival_date' => 'required_if:is_flight,==,1',
        ], [
			'arrival_airlines_id.required_if' => 'The airlines id field is required.',
			'arrival_date.required_if' => 'The arrival date field is required .',
			'depature_date.required_if' => 'The depature date field is required .',
			'depature_airlines_id.required_if' => 'The depature airlines field is required .',
			'travel_from_date.required' => 'The travel date from field is required .',
			'nof_night.required' => 'The number of night field is required .',
		]);

		$arrival_date = $request->input('arrival_date'); // get the value of the date input
		$depature_date = $request->input('depature_date'); // get the value of the date input
		$customer = Customer::where('mobile',$request->input('customer_mobile'))->first();
		
		if(empty($customer))
		{
			$customer = new Customer();
			$customer->name = $request->input('customer_name');
			$customer->mobile = $request->input('customer_mobile');
			$customer->email = $request->input('customer_email');
			$customer->save();
		}
		else
		{
			//$customer->name = $request->input('customer_name');
			//$customer->email = $request->input('customer_email');
			//$customer->save();
		}
		
        $record = Voucher::find($id);
        $record->agent_id = $request->input('agent_id_select');
		$record->customer_id = $customer->id;
		$record->country_id = $request->input('country_id');
		$record->is_hotel = $request->input('is_hotel');
		$record->is_flight = $request->input('is_flight');
		$record->is_activity = $request->input('is_activity');
		$record->arrival_airlines_id = $request->input('arrival_airlines_id');
		$record->arrival_date = $arrival_date;
		$record->arrival_airport = $request->input('arrival_airport');
		$record->arrival_terminal = $request->input('arrival_terminal');
		$record->depature_airlines_id = $request->input('depature_airlines_id');
		$record->depature_date = $depature_date;
		$record->depature_airport = $request->input('depature_airport');
		$record->depature_terminal = $request->input('depature_terminal');
		$record->travel_from_date = $request->input('travel_from_date');
		$record->travel_to_date = $request->input('travel_to_date');
		$record->nof_night = $request->input('nof_night');
		$record->vat_invoice = $request->input('vat_invoice');
		$record->agent_ref_no = $request->input('agent_ref_no');
		$record->guest_name = $request->input('guest_name');
		$record->arrival_flight_no = $request->input('arrival_flight_no');
		$record->depature_flight_no = $request->input('depature_flight_no');
		$record->remark = $request->input('remark');
		$record->status = 1;
		$record->updated_by = Auth::user()->id;
        $record->save();
		
		if($record->is_activity != 1)
		{
		$voucherActivity = VoucherActivity::where('voucher_id',$record->id)->delete();
		}
		
        return redirect('agent-vouchers')->with('success','Voucher Updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Voucher  $Voucher
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = Voucher::where('id',$id)->where('agent_id',Auth::user()->id)->first();
		if (empty($record)) {
            return abort(404); //record not found
        }
		//$voucherHotel = VoucherHotel::where('voucher_id',$id)->delete();
		$voucherActivity = VoucherActivity::where('voucher_id',$id)->delete();
		
        $record->delete();
        return redirect('agent-vouchers')->with('success', 'Voucher Deleted.');
    }
	
	
	public function autocompleteAgent(Request $request)
    {
		$search  = $request->get('search');
		$nameOrCompany  = ($request->get('nameorcom'))?$request->get('nameorcom'):'Company';
		if($nameOrCompany == 'Company'){
        $users = User::where('role_id', 3)
					->where('is_active', 1)
					->where(function ($query) use($search) {
						$query->where('company_name', 'LIKE', '%'. $search. '%')
						->orWhere('code', 'LIKE', '%'. $search. '%')
						->orWhere('mobile', 'LIKE', '%'. $search. '%');
					})->get();
		$response = array();
      foreach($users as $user){
		   $agentDetails = '<b>Code:</b> '.$user->code.' <b>Email:</b>'.$user->email.' <b> Mobile No:</b>'.$user->mobile.' <b>Address:</b>'.$user->address. " ".$user->postcode;
         $response[] = array("value"=>$user->id,"label"=>$user->company_name.'('.$user->code.')',"agentDetails"=>$agentDetails);
      }
	}
	elseif($nameOrCompany == 'Name'){
        $users = User::where('role_id', 3)
					->where('is_active', 1)
					->where(function ($query) use($search) {
						$query->where('name', 'LIKE', '%'. $search. '%')
						->orWhere('code', 'LIKE', '%'. $search. '%')
						->orWhere('mobile', 'LIKE', '%'. $search. '%');
					})->get();
		$response = array();
      foreach($users as $user){
		   $agentDetails = '<b>Code:</b> '.$user->code.' <b>Email:</b>'.$user->email.' <b> Mobile No:</b>'.$user->mobile.' <b>Address:</b>'.$user->address. " ".$user->postcode;
         $response[] = array("value"=>$user->id,"label"=>$user->full_name.'('.$user->code.')',"agentDetails"=>$agentDetails);
      }
	}	  
        return response()->json($response);
    }
	
	
	 public function addActivityList(Request $request,$vid)
    {
		$redirectResponse = $this->chekAgentLogin();
		if ($redirectResponse) {
		return $redirectResponse;
		}
		
       $data = $request->all();
		$typeActivities = config("constants.typeActivities"); 
        $perPage = config("constants.AGENT_PAGE_LIMIT");
		//$perPage = "15";
		$voucher = Voucher::find($vid);
		$startDate = $voucher->travel_from_date;
		$endDate = $voucher->travel_to_date;
		if($voucher->status_main  == '4')
		{
			return redirect()->route('agent-vouchers.show',$voucher->id)->with('error', 'You can not add more activity. your voucher already confirmed.');
		}
		if($voucher->status_main  == '5')
		{
			return redirect()->route('agentVoucherView',$voucher->id)->with('error', 'You can not add more activity. your voucher already vouchered.');
		}
		
        $query = Activity::has('activityVariants')->with('activityVariants.prices')->whereHas('activityVariants.variant', function ($q){
           $q->where('for_backend_only', '=', '0');
       })->where('status',1);
		
        if (isset($data['name']) && !empty($data['name'])) {
            $query->where('title', 'like', '%' . $data['name'] . '%');
        }
		
       
       $query->whereHas('activityVariants.prices', function ($query) use($startDate,$endDate) {
           $query->where('rate_valid_from', '<=', $startDate)->where('rate_valid_to', '>=', $endDate);
       });
	   
	   $totalCount = $query->count();
		if (!empty($data['porder']) && !empty($data['porder'])) {
			if($data['porder']=='popularity'){
				$records = $query->orderBy('popularity', 'ASC')->paginate($perPage);
			} else {
			$records = $query->orderByRaw('CAST(min_price AS DECIMAL) '.$data['porder'])->paginate($perPage);
			}
		} else { 
			$records = $query->orderBy('created_at', 'DESC')->paginate($perPage);
		}
		
		$voucherHotel = VoucherHotel::where('voucher_id',$vid)->get();
		$voucherActivity = VoucherActivity::where('voucher_id',$vid)->orderBy('tour_date','ASC')->get();
		
		$query2 = Activity::has('activityVariants')->with('activityVariants.prices')->whereHas('activityVariants.variant', function ($q){
           $q->where('for_backend_only', '=', '0');
       })->where('status',1);
		$query2->whereHas('activityVariants.prices', function ($query) use($startDate,$endDate) {
           $query->where('rate_valid_from', '<=', $startDate)->where('rate_valid_to', '>=', $endDate);
       });
		$tagsQ = $query2->pluck('tags')->unique()->values()->all();

		$tags = [];
		foreach ($tagsQ as $record) {
			$tagAll = explode(',', $record);
			foreach ($tagAll as $tag) {
				if(!empty($tag)){
				$tags[$tag] = $tag;
				}
			}
		}
		
		$priceMax = Activity::has('activityVariants')->where('status',1)->whereHas('activityVariants.prices', function ($q) use($startDate,$endDate) {
           $q->where('rate_valid_from', '<=', $startDate)->where('rate_valid_to', '>=', $endDate);
       })->whereHas('activityVariants.variant', function ($q){
           $q->where('for_backend_only', '=', '0');
       })->orderByRaw('CAST(min_price AS DECIMAL) DESC')->first();
		
		$minPrice = 1;
		$maxPrice = 0 ;
		if(!empty($priceMax)){
		$maxPrice = (int)$priceMax->min_price; 
		}
		

		
		//dd($maxPrice);
		$voucherActivityCount = VoucherActivity::where('voucher_id',$vid)->count();
        return view('agent-vouchers.activities-list', compact('records','typeActivities','vid','voucher','voucherActivityCount','voucherActivity','tags','minPrice','maxPrice','totalCount'));
    }
	
	public function searchActivityList(Request $request)
	{
		// Define the variable $vid by getting it from the request
		$vid = $request->input('vid');

		// Uncomment the lines below if you need to check agent login
		
		$redirectResponse = $this->chekAgentLogin();
		if ($redirectResponse) {
			return response()->json(['error' => 'Please login.']);
		}
		

		$data = $request->all();
		$typeActivities = config("constants.typeActivities"); 
		$perPage = config("constants.AGENT_PAGE_LIMIT");

		// Find the voucher based on $vid
		$voucher = Voucher::find($vid);

		$startDate = $voucher->travel_from_date;
		$endDate = $voucher->travel_to_date;

		if($voucher->status_main == '4') {
			return response()->json(['error' => 'You can not add more activity. Your voucher already confirmed.']);
		}

		if($voucher->status_main == '5') {
			return response()->json(['error' => 'You can not add more activity. Your voucher already vouchered.']);
		}

		$query = Activity::has('activityVariants')->with('activityVariants.prices')->where('status', 1);
	
		if (isset($data['name']) && !empty($data['name'])) {
			$query->where('title', 'like', '%' . trim($data['name']) . '%');
		}
		
		$selectedTags = $request->input('selectedTags');

		if (isset($selectedTags) && !empty($selectedTags)) {
			$tagsArray = is_array($selectedTags) ? $selectedTags : explode(',', $selectedTags);

			$query->where(function ($query) use ($tagsArray) {
				foreach ($tagsArray as $tag) {
					$query->orWhere('tags', 'like', '%' . trim($tag) . '%');
				}
			});
		}
		
		$query->whereHas('activityVariants.prices', function ($query) use($startDate,$endDate) {
		$query->where('rate_valid_from', '<=', $startDate)->where('rate_valid_to', '>=', $endDate);
		});
		
			if (!empty($data['minPrice']) && !empty($data['maxPrice'])) {
			$minPrice = (int) $data['minPrice'];
			$maxPrice = (int) $data['maxPrice'];

			$query->where('min_price', '>=' , $minPrice)->where('min_price', '<=' , $maxPrice);
			}
		
		$totalCount = $query->count();
		
		if (!empty($data['porder']) && !empty($data['porder'])) {
			if($data['porder']=='1'){
				$records = $query->orderBy('popularity', 'DESC')->paginate($perPage);
			} else {
			$records = $query->orderByRaw('CAST(min_price AS DECIMAL) '.$data['porder'])->paginate($perPage);
			}
			
		} else { 
			$records = $query->orderBy('created_at', 'DESC')->paginate($perPage);
		}		

		$voucherHotel = VoucherHotel::where('voucher_id', $vid)->get();
		$voucherActivity = VoucherActivity::where('voucher_id', $vid)->orderBy('tour_date','ASC')->get();
		$voucherActivityCount = VoucherActivity::where('voucher_id', $vid)->count();

		// Initialize an empty array for $response
		$response = [];

		$response = [
			'html' => view('agent-vouchers.activities-list-ajax', compact('records','typeActivities','vid','voucher','voucherActivityCount','voucherActivity'))->render(), // Include HTML content
			'pagination' => $records->links()->toHtml(), 
			'totalCount' => $totalCount,// Include pagination links
		];
		
		return response()->json($response);
	}
	
	public function addActivityView($aid,$vid,$d="",$a="",$c="",$i="",$tt="")
    {
		$redirectResponse = $this->chekAgentLogin();
		if ($redirectResponse) {
		return $redirectResponse;
		}
		$query = Activity::with('images')->where('id', $aid);
		$activity = $query->where('status', 1)->first();
		
		$voucher = Voucher::find($vid);
		$startDate = $voucher->travel_from_date;
		$endDate = $voucher->travel_to_date;
		$variantData = PriceHelper::getActivityVariantListArrayByTourDate($startDate,$aid);
		$voucherActivity = VoucherActivity::where('voucher_id',$vid)->orderBy('tour_date','ASC')->get();
		$typeActivities = config("constants.typeActivities"); 
			$voucherActivityCount = VoucherActivity::where('voucher_id',$vid)->count();
       return view('agent-vouchers.activities-add-details', compact('activity','aid','vid','voucher','typeActivities','variantData','voucherActivity','voucherActivityCount'));
    }
	
	
	
	public function getActivityVariant(Request $request)
    {
		$data = $request->all();
		$activityData = [];
		$aid = $data['act'];
		$vid = $data['vid'];
		$voucher = Voucher::find($data['vid']);
		$startDate = $voucher->travel_from_date;
		$endDate = $voucher->travel_to_date;
		$user = auth()->user();
		
		$variantData = PriceHelper::getActivityVariantListArrayByTourDate($startDate,$aid);
		//dd($variantData );
		
		$typeActivities = config("constants.typeActivities"); 
		
		$returnHTML = view('agent-vouchers.activities-add-view', compact('variantData','voucher','aid','vid'))->render();
		$dates = SiteHelpers::getDateListBoth($voucher->travel_from_date,$voucher->travel_to_date);
		//$disabledDay = SiteHelpers::getNovableActivityDays($activity->availability);
		
		// $dates = [];
		$disabledDay = [];
		return response()->json(array('success' => true, 'html'=>$returnHTML, 'dates'=>$dates,'disabledDay'=>$disabledDay));	
		//return response()->json(array('success' => true, 'html'=>$returnHTML, 'dates'=>json_encode($dates),'disabledDay'=>json_encode($disabledDay)));	
			
    }
	
	public function getActivityVariantPrice(Request $request)
    {
		$data = $request->all();
		$variantData = PriceHelper::getActivityPriceByVariant($data);
		
		return response()->json(array('success' => true,  'variantData'=>$variantData));	
			
    }
	
	
	public function getPVTtransferAmount(Request $request)
    {
		$variant = Variant::select('transfer_plan','pvt_TFRS')->where('id', $request->variant_id)->where('status', 1)->first();
		
		$price = 0;
		$total = 0;
		$totalPerson = $request->adult+$request->child;
		//$activityPrices = ActivityPrices::where('activity_id', $aid)->get();
		
		if($variant->pvt_TFRS == 1)
		{
			$td = TransferData::where('transfer_id', $variant->transfer_plan)->where('qty', $totalPerson)->first();
			
			if(!empty($td))
			{
				$price = $td->price;
			}
		}
		
		$totalPrice  = $price*$totalPerson;
		
		return $totalPrice;
    }
	
	
	public function activitySaveInVoucher(Request $request)
    {
		
		$redirectResponse = $this->chekAgentLogin();
		if ($redirectResponse) {
		return $redirectResponse;
		}
		$activity_select = $request->input('activity_select');
		
	if(isset($activity_select))
	{
		
		$voucher_id = $request->input('v_id');
		$activity_id = $request->input('activity_id');
		$activity_variant_id = $request->input('activity_variant_id');
		$voucher = Voucher::find($voucher_id);
		$startDate = $voucher->travel_from_date;
		$endDate = $voucher->travel_to_date;
		$transfer_option = $request->input('transfer_option');
		$tour_date = $request->input('tour_date');
		$transfer_zone = $request->input('transfer_zone');
		$adult = $request->input('adult');
		$child = $request->input('child');
		$infant = $request->input('infant');
		$discount = $request->input('discount');
		//dd($request->input('ucode'));
		//dd($request->all());
		$data = [];
		$total_activity_amount = 0;
		$k  = $request->input('ucode');
		$timeslot  = $request->input('timeslot');
		$activitySelectNew[$k] = $k;
		if(!empty($k)){
		foreach($activitySelectNew as $k => $v)
		{
			$activityVariant = ActivityVariant::with('variant', 'activity')->find($activity_variant_id[$k]);
			$activity = $activityVariant->activity;
			$variant = $activityVariant->variant;
			
			$tour_dt = date("Y-m-d",strtotime($tour_date[$k]));
			$getAvailableDateList = SiteHelpers::getDateList($tour_dt,$variant->black_out,$variant->sold_out,$variant->availability);
			$totalmember = $adult[$k] + $child[$k];
			//$priceCal = PriceHelper::getActivityPriceSaveInVoucher($transfer_option[$k],$activity_variant_id[$k],$voucher->agent_id,$voucher,$activityVariant->ucode,$adult[$k],$child[$k],$infant[$k],$discount[$k],$tour_dt);
			
			$priceCal = PriceHelper::getActivityPriceSaveInVoucher($transfer_option[$k],$activity_variant_id[$k],$voucher->agent_id,$adult[$k],$child[$k],$infant[$k],$discount[$k],$tour_dt);
				
			if($priceCal['totalprice'] <= 0){
				
				return redirect()->back()->with('error', $variant->title.' Tour is not available for Selected Date.');
				}
			elseif($priceCal['totalprice'] > 0){
				if(!in_array($tour_dt,$getAvailableDateList)){
				return redirect()->back()->with('error', $variant->title.' Tour is not available for Selected Date.');
				}
			if(empty($transfer_zone)){
				$transfer_zone = [];
			}
			
			
			$query = VariantCanellation::where('varidCode', $variant->ucode);
			$cancellation = $query->get();
			$data[] = [
			'voucher_id' => $voucher_id,
			'activity_id' => $activity_id,
			'activity_vat' => $priceCal['activity_vat'],
			'variant_price_id' => $priceCal['price_id'],
			'variant_unique_code' => $activityVariant->ucode,
			'variant_name' => $variant->title,
			'variant_code' => $variant->ucode,
			'activity_product_type' => $activity->product_type,
			'activity_entry_type' => $activity->entry_type,
			'variant_pvt_TFRS' => $variant->pvt_TFRS,
			'variant_type' => $variant->type,
			'variant_pick_up_required' => $variant->pick_up_required,
			'activity_title' => $activity->title,
			'variant_zones' => $variant->zones,
			'variant_pvt_TFRS_text' => $variant->pvt_TFRS_text,
			'transfer_option' => $transfer_option[$k],
			'tour_date' => $tour_dt,
			'pvt_traf_val_with_markup' => $priceCal['pvt_traf_val_with_markup'],
			'transfer_zone' => (array_key_exists($k,$transfer_zone))?$transfer_zone[$k]:'',
			'zonevalprice_without_markup' => $priceCal['zonevalprice_without_markup'],
			'adult' => $adult[$k],
			'child' => $child[$k],
			'infant' => $infant[$k],
			'markup_p_ticket_only' => $priceCal['markup_p_ticket_only'],
			'markup_p_sic_transfer' => $priceCal['markup_p_sic_transfer'],
			'markup_p_pvt_transfer' => $priceCal['markup_p_pvt_transfer'],
			'adultPrice' => $priceCal['adultPrice'],
			'childPrice' => $priceCal['childPrice'],
			'infPrice' => $priceCal['infPrice'],
			'original_tkt_rate' => $priceCal['ticketPrice'],
			'original_trans_rate' => $priceCal['transferPrice'],
			'vat_percentage' => $priceCal['vat_per'],
			'discountPrice' => $discount[$k],
			'time_slot' => $timeslot,
			'cancellation_chart' => json_encode($cancellation),
			'totalprice' => number_format($priceCal['totalprice'], 2, '.', ''),
			'created_by' => Auth::user()->id,
			'updated_by' => Auth::user()->id,	
                ];

				$total_activity_amount += $priceCal['totalprice'] - $discount[$k];
			}
		}
		
		
		
		if(count($data) > 0)
		{
			VoucherActivity::insert($data);
			$voucher = Voucher::find($voucher_id);
			$voucher->total_activity_amount += $total_activity_amount;
			$voucher->save();
		}

		} else {
			return redirect()->back()->with('error', $variant->title.' Please Select Tour Option.');
		}
		
		
		if ($request->has('save_and_continue')) {
			//return redirect()->back()->with('success', 'Activity added Successfully.');
        return redirect()->route('agent-vouchers.add.activity',$voucher_id)->with('success', 'Activity added Successfully.');
		} else {
			return redirect()->back()->with('success', 'Activity added Successfully.');
        //return redirect('vouchers')->with('success', 'Activity Added Successfully.');
		}
	}
		
       return redirect()->back()->with('error', 'Please select activity variant.');
	   
    }
	
	public function destroyActivityFromVoucher($id,$aid=0)
    {
		
		if($aid == 0)
		{
        	$record = VoucherActivity::find($id);
			$record->delete();
		}
		else
		{
        	$record = VoucherActivity::where('voucher_id',$id)->where('activity_id',$aid)->delete();
		}
	
        return redirect()->back()->with('success', 'Activity Deleted Successfully.');
    }
	

	public function autocompleteHotel(Request $request)
    {
		$search  = $request->get('search');
		$zone  = $request->get('zone');
		if(!empty($zone)){
        $hotels = Hotel::where('zone_id', $zone)
					->where('status', 1)
					->where('name', 'LIKE', '%'. $search. '%')
					->paginate(10);
		}else{
			$hotels = Hotel::where('status', 1)
					->where('name', 'LIKE', '%'. $search. '%')
					->paginate(10);
		}
		$response = array();
		
      foreach($hotels as $hotel){
         $response[] = array("value"=>$hotel->name,"label"=>$hotel->name);
      }
	
        return response()->json($response);
    }
	
	public function statusChangeVoucher(Request $request,$id)
    {
		$redirectResponse = $this->chekAgentLogin();
		if ($redirectResponse) {
		return $redirectResponse;
		}
		
		$data = $request->all();
		$hotelPriceTotal = 0;
		$grandTotal = 0;
		$record = Voucher::where('id',$id)->first();
		
		if (empty($record)) {
            return abort(404); //record not found
        }

		$voucherActivity = VoucherActivity::where('voucher_id',$record->id);
		$voucherActivityRecord = $voucherActivity->get();
		$voucherHotels = VoucherHotel::where('voucher_id',$record->id);
		if(($voucherActivity->count() == 0) && ($voucherHotels->count() == 0)){
			return redirect()->back()->with('error', 'Please add Activity or Hotel this booking.');
	   }
	   
	   
		$paymentDate = date('Y-m-d', strtotime('-2 days', strtotime($record->travel_from_date)));
		$currency = SiteHelpers::getCurrencyPrice();
		$record->guest_name = $data['fname'].' '.$data['lname'];
		$record->guest_email = $data['customer_email'];
		$record->guest_phone = $data['customer_mobile'];
		$record->agent_ref_no = $data['agent_ref_no'];
		$record->remark = $data['remark'];
		$record->updated_by = Auth::user()->id;
		$record->payment_date = $paymentDate;
		$record->currency_code = $currency['code'];
		$record->currency_value = $currency['value'];
		
		if ($request->has('btn_paynow')) 
		{
		$agent = User::find($record->agent_id);
		
		
		if(!empty($agent))
		{
			$voucherCnt = Voucher::where('agent_id',$agent->id)->where('status_main',7)->count();
			if($voucherCnt > 0)
			{
				return redirect()->back()->with('error', 'Booking is already in the process of being edited in an invoice. Please complete that process first before proceeding with this one.');
			}
			
			$voucherActivity = VoucherActivity::where('voucher_id',$record->id)->get();
			
			
			$agentAmountBalance = $agent->agent_amount_balance;
			$total_activity_amount = $record->voucheractivity->sum('totalprice');
			$grandTotal = $total_activity_amount + $hotelPriceTotal;
			if($agentAmountBalance >= $grandTotal)
			{
			
			if($record->vat_invoice == 1)
			{
				$voucherCount = Voucher::where('invoice_number','!=', NULL)->where('vat_invoice',1)->count();
				$voucherCountNumber = $voucherCount +1;
				$code = 'VIN-2100001'.$voucherCountNumber;
			}
			else
			{
				$voucherCount = Voucher::where('invoice_number','!=', NULL)->where('vat_invoice',0)->count();
				$voucherCountNumber = $voucherCount +1;
				$code = 'WVIN-2100001'.$voucherCountNumber;
			}
			
			$record->booking_date = date("Y-m-d H:i:s");
			$record->invoice_number = $code;
			$record->vouchered_by = Auth::user()->id;
			$record->updated_by = Auth::user()->id;
			$record->status_main = 5;
			$record->zone = Auth::user()->zone;
			$record->save();
			$agent->agent_amount_balance -= $grandTotal;
			$agent->save();
			
			$agentAmount = new AgentAmount();
			$agentAmount->agent_id = $record->agent_id;
			$agentAmount->amount = $grandTotal;
			$agentAmount->date_of_receipt = date("Y-m-d");
			$agentAmount->transaction_type = "Payment";
			$agentAmount->transaction_from = 2;
			$agentAmount->status = 2;
			$agentAmount->role_user = 3;
			$agentAmount->created_by = Auth::user()->id;
			$agentAmount->updated_by = Auth::user()->id;
			$agentAmount->save();
			
			$recordUser = AgentAmount::find($agentAmount->id);
			$recordUser->receipt_no = $code;
			$recordUser->is_vat_invoice = $record->vat_invoice;
			$recordUser->save(); 

			VoucherActivity::where('voucher_id', $record->id)->update(['booking_date' => Carbon::now(),'status' => '3']);
			
			$emailData = [
			'voucher'=>$record,
			'voucherActivity'=>$voucherActivityRecord,
			'voucherHotel'=>[],
			];
			
			$zoneUserEmails = SiteHelpers::getUserByZoneEmail($record->agent_id);
			
			Mail::to($agent->email,'Booking Confirmation.')->cc($zoneUserEmails)->bcc('bookings@abaterab2b.com')->send(new VoucheredBookingEmailMailable($emailData)); 	
			
			}else{
				 return redirect()->back()->with('error', 'Agency amount balance not sufficient for this booking.');
			}
			
		}
		else{
				 return redirect()->back()->with('error', 'Agency  Name not found this voucher.');
			}
		
		}
		else if ($request->has('btn_hold')) 
		{
			//$record->booking_date = date("Y-m-d");
			$record->status_main = 4;
			$record->save();
		}
		

		if ($data['payment'] == 'creditCard') {
			if($record->agent->flyremit_reg = "1")
			{
				$record->status_main = 3;
				$record->save();
				
				$totalf = $record->voucheractivity->sum('totalprice');
				$gtotal = round($totalf*$currency['value'],0);
				return redirect()->route('agentPaymentView',$record->id)->with('success', '');
				
				//https://v5agent.flyremit.com/Abatera/AbateraAgent/Result?AbateraId=46374&AbateraDealId=XXXXXXX&Amount=XXXX
				//$url = "https://v5agent.flyremit.com/Abatera/AbateraAgent/Result?AbateraId=".$record->agent->id."&AbateraDealId=".$record->code."&Amount=".$gtotal."&Currency=INR&TranGUID=".$record->code;
				//return redirect($url);
			}
		}
		foreach($voucherActivityRecord as $vac){
			if($record->status_main == 5)
			{
				$voucherActivityU = VoucherActivity::find($vac->id);
				$cancellation = VariantCanellation::where('varidCode', $voucherActivityU->variant_code)->get();
				$voucherActivityU->cancellation_chart = json_encode($cancellation);
				$voucherActivityU->status = 3;
				$voucherActivityU->save();
			}
			SiteHelpers::voucherActivityLog($record->id,$vac->id,$vac->discountPrice,$vac->totalprice,$record->status_main);
		}
		
	
		
		return redirect()->route('agentVoucherView',$record->id);
        
    }
	
	 public function agentVoucherView($vid)
    {
		$voucher =  Voucher::where('id',$vid)->where('agent_id',Auth::user()->id)->first();
		if (empty($voucher)) {
            return abort(404); //record not found
        }
		$voucherActivity = VoucherActivity::where('voucher_id',$voucher->id)->get();
		
		$voucherStatus = config("constants.voucherStatus");
        return view('agent-vouchers.bookedview', compact('voucher','voucherActivity','voucherStatus'));
    }
	public function agentPaymentView($vid)
    {
	
		$voucher =  Voucher::where('id',$vid)->where('agent_id',Auth::user()->id)->first();
		if (empty($voucher)) {
            return abort(404); //record not found
        }
		
		$voucherActivity = VoucherActivity::where('voucher_id',$voucher->id)->get();
		$totalf = $voucherActivity->sum('totalprice');
		$gtotal = round($totalf*$voucher->currency_value,0);
		$voucherStatus = config("constants.voucherStatus");
        return view('agent-vouchers.onlinepayment', compact('voucher','voucherActivity','gtotal'));
    }
	public function cancelActivityFromVoucher($id)
	{
		$record = VoucherActivity::find($id);
		$voucherActivity[0] = $record;
		$agent = User::find($record->agent_id);
		//if($record->ticket_downloaded == '0'){
		$record->status = 1;
		$record->canceled_date = Carbon::now()->toDateTimeString();
		$record->save();
		
		$tickets = Ticket::where("voucher_activity_id",$record->id)->where("voucher_id",$record->voucher_id)->where("ticket_generated",'1')->where("ticket_downloaded",'0')->get();
		foreach($tickets as $tc){
			if(!empty($tc))
			{
				$tc->voucher_activity_id = '0';
				$tc->ticket_generated = '0';
				$tc->ticket_generated_by = '';
				$tc->generated_time = '';
				$tc->voucher_id = 0;
				$tc->save();
			}
		}
		
		
		$recordCount = VoucherActivity::where("voucher_id",$record->voucher_id)->where("status",'0')->count();
		if($recordCount == '0'){
			$voucher = Voucher::find($record->voucher_id);
			$voucher->status_main = 6;
			$voucher->save();		
		}
		
		$zoneUserEmails = SiteHelpers::getUserByZoneEmail($record->agent_id);
		Mail::to($agent->email,'Booking Cancellation.')->cc($zoneUserEmails)->bcc('bookings@abaterab2b.com')->send(new VoucheredCancelEmail($voucherActivity)); 
		
		return redirect()->back()->with('success', 'Activity Canceled Successfully.');
		//}
		//else{
		//return redirect()->back()->with('error', "Ticket already downloaded you can not cancel this.");	
		//}
	}
	
	public function chekAgentLogin(){
		
		if (auth()->check()) {
			
			$user = auth()->user();
			if ($user->role_id == '3') {
			
			} else {
				return redirect()->route('dashboard')->withSuccess('You have Successfully logged in.');
			}
			
		} else {
			return redirect()->route('login');
		}
	}
	


}
