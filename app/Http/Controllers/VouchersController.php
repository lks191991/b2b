<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use App\Models\Airline;
use App\Models\User;
use App\Models\Customer;
use App\Models\Country;
use App\Models\Vehicle;
use App\Models\VoucherAirline;
use App\Models\HotelCategory;
use App\Models\VariantPrice;
use App\Models\State;
use App\Models\City;
use App\Models\Zone;
use App\Models\VoucherHotel;
use App\Models\Hotel;
use App\Models\Activity;
use App\Models\ActivityPrices;
use App\Models\ActivityVariant;
use App\Models\AgentPriceMarkup;
use App\Models\TransferData;
use Illuminate\Http\Request;
use App\Models\VoucherActivity;
use App\Models\VoucherActivityLog;
use App\Models\VariantCanellation;
use App\Models\Ticket;
use App\Models\Variant;
use DB;
use SiteHelpers;
use PriceHelper;
use Carbon\Carbon;
use SPDF;
use Illuminate\Support\Facades\Auth;
use App\Models\AgentAmount;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Mail;
use App\Mail\VoucheredBookingEmailMailable;
use App\Mail\VoucheredCancelEmail;
use App\Mail\InvoiceEditRequestEmail;
use App\Models\ReportLog;
use RaynaHelper;

class VouchersController extends Controller
{
	public function __construct()
    {
		
    } 
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		$this->checkPermissionMethod('list.voucher');
		
		 $perPage = config("constants.ADMIN_PAGE_LIMIT");
		 $data = $request->all();
		$query = Voucher::where('id','!=', null);
		$query->where('is_quotation',"0");
		if (isset($data['agent_id_select']) && !empty($data['agent_id_select'])) {
            $query->where('agent_id', $data['agent_id_select']);
        }
		if (isset($data['zone']) && !empty($data['zone'])) {
            $query->where('zone', $data['zone']);
        }
		
		if (isset($data['code']) && !empty($data['code'])) {
            $query->where('code', 'like', '%' . $data['code'] . '%');
        }
		if (isset($data['invcode']) && !empty($data['invcode'])) {
            $query->where('invoice_number', 'like', '%' . $data['invcode'] . '%');
        }
		if (isset($data['guest_name']) && !empty($data['guest_name'])) {
            $query->where('guest_name', 'like', '%' . $data['guest_name'] . '%');
        }
		
		if (isset($data['status']) && !empty($data['status'])) {
                $query->where('status_main', $data['status']);
        }
		
		if (isset($data['is_hotel']) && !empty($data['is_hotel'])) {
            if ($data['is_hotel'] == 1)
                $query->where('is_hotel', 1);
            if ($data['is_hotel'] == 2)
                $query->where('is_hotel', 0);
        }
		
		if (isset($data['is_flight']) && !empty($data['is_flight'])) {
            if ($data['is_flight'] == 1)
                $query->where('is_flight', 1);
            if ($data['is_flight'] == 2)
                $query->where('is_flight', 0);
        }
		
		if (isset($data['is_activity']) && !empty($data['is_activity'])) {
            if ($data['is_activity'] == 1)
                $query->where('is_activity', 1);
            if ($data['is_activity'] == 2)
                $query->where('is_activity', 0);
        }
			if(!empty(Auth::user()->zone)){

			$query->where('zone', '=', Auth::user()->zone);

			}
        $records = $query->orderBy('created_at', 'DESC')->paginate($perPage);
		$agetid = '';
		$agetName = '';
		
		if(old('agent_id')){
		$agentTBA = User::where('id', old('agent_id_select'))->where('status', 1)->first();
		$agetid = $agentTBA->id;
		$agetName = $agentTBA->company_name;
		}
		
        return view('vouchers.index', compact('records','agetid','agetName'));

    }

    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
		$pid = 0;
		$voucher = [];
		if($request->has('pid'))
		{
			$pid = $request->pid;
			$voucher = Voucher::select("agent_id")->find($pid);
		}
		
		$this->checkPermissionMethod('list.voucher');
		$countries = Country::where('status', 1)->orderBy('name', 'ASC')->get();
		$airlines = Airline::where('status', 1)->orderBy('name', 'ASC')->get();
		if(old('customer_id_select'))
		{
			$customerTBA = Customer::where('id', old('customer_id_select'))->where('status', 1)->first();
		}
		else
		{
			$customerTBA = Customer::where('id', 1)->where('status', 1)->first();	
		}
		
		/* if(Auth::user()->role_id == '3'){
			
			 return view('vouchers.createbyagent', compact('countries','airlines','customerTBA'));
		}else{ */
        return view('vouchers.create', compact('countries','airlines','customerTBA','pid','voucher'));
		//}
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
            'agent_id'=>'required',
			'country_id'=>'required',
			'travel_from_date'=>'required',
			'nof_night'=>'required',
			//'customer_name'=>'required',
			//'customer_mobile'=>'required',
			//'arrival_airlines_id' => 'required_if:is_flight,==,1',
			//'arrival_date' => 'required_if:is_flight,==,1',
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
		$agent = User::find($request->input('agent_id_select'));
		$customer = Customer::where('mobile',$agent->mobile)->first();
		
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
			
		
        $record = new Voucher();
        $record->agent_id = $request->input('agent_id_select');
		$record->zone = $agent->zone;
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
		$record->adults = $request->input('adults');
		$record->childs = $request->input('childs');
		$record->infants = $request->input('infants');
		$record->parent_id = $request->input('parent_id');
		$record->summary_invoice = $request->input('summary_invoice');
		$record->status = 1;
		$record->created_by = Auth::user()->id;
		$record->updated_by = Auth::user()->id;
        $record->save();
		
		$no = sprintf("%03d",$record->id);	
		$code = 'ABT-'.date("Y")."-8".$no;
		if($request->input('parent_id') > 0)
		{
			$voucherCount = Voucher::where('parent_id',$request->input('parent_id'))->count();
			$voucherCountNumber = $voucherCount +1;
			$pcno = sprintf("%03d",$request->input('parent_id'));	
			$code = 'ABT-'.date("Y")."-8".$pcno."-".$voucherCountNumber;
		}
		$recordUser = Voucher::find($record->id);
		$recordUser->code = $code;
		
		$recordUser->save();
		
		/* if ($request->has('save_and_hotel')) {
			if($record->is_hotel == 1){
			return redirect()->route('voucher.add.hotels',$record->id)->with('success', 'Voucher Created Successfully.');
			}
			else
			{
				return redirect()->route('vouchers.index')->with('error', 'If select hotel yes than you can add hotel.');
			}
		} */
			if($record->is_hotel == 1){
			return redirect()->route('voucher.add.hotels',$record->id)->with('success', 'Voucher Created Successfully.');
			} elseif($record->is_activity == 1){
			return redirect()->route('voucher.add.activity',$record->id)->with('success', 'Voucher Created Successfully.');
			} else {
				return redirect()->route('vouchers.index')->with('error', 'If select activity yes than you can add activity.');
			}
		
		
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function show(Voucher $voucher)
    {
		$this->checkPermissionMethod('list.voucher');
		$voucherHotel = VoucherHotel::where('voucher_id',$voucher->id)->get();
		$voucherActivity = VoucherActivity::where('voucher_id',$voucher->id)->orderBy("tour_date","ASC")->orderBy("serial_no","ASC")->get();
		if($voucher->status_main  > 4)
		{
			return redirect()->route('voucherView',$voucher->id);
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
		$countriesCode = Country::where('status', 1)->where('code','!=', null)->orderBy('id', 'ASC')->get();

		$supplier_ticket = User::where("service_type",'Ticket')->orWhere('service_type','=','Both')->get();
		$vehicle_type = Vehicle::where("status",'1')->get();
        return view('vouchers.view', compact('voucher','voucherHotel','voucherActivity','voucherStatus','fname','lname','supplier_ticket','countriesCode','vehicle_type'));
    }
	
	public function voucherAddDiscount($vid)
    {
		
		$this->checkPermissionMethod('list.voucher');
		$voucher = Voucher::find($vid);
		//dd($voucher);
		$voucherHotel = VoucherHotel::where('voucher_id',$voucher->id)->get();
		$voucherActivity = VoucherActivity::where('voucher_id',$voucher->id)->orderBy("tour_date","ASC")->orderBy("serial_no","ASC")->get();
		if($voucher->status_main  > 4)
		{
			return redirect()->route('voucherView',$voucher->id);
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
		
		$supplier_ticket = User::where("service_type",'Ticket')->orWhere('service_type','=','Both')->get();
        return view('vouchers.add-discount', compact('voucher','voucherHotel','voucherActivity','voucherStatus','fname','lname','supplier_ticket'));
    }

	public function voucherView($vid)
    {
		$voucher =  Voucher::where('id',$vid)->first();
		if (empty($voucher)) {
            return abort(404); //record not found
        }
		$voucherActivity = VoucherActivity::where('voucher_id',$voucher->id)->orderBy("tour_date","ASC")->orderBy("serial_no","ASC")->get();
		$voucherHotel = VoucherHotel::where('voucher_id',$voucher->id)->get();
		$childVoucher =  Voucher::where('parent_id',$vid)->get();
		$supplier_ticket = User::where("is_active",'1')->whereIn("service_type",['Ticket','Both'])->get();
		$voucherStatus = config("constants.voucherStatus");
        return view('vouchers.bookedview', compact('voucher','voucherActivity','voucherStatus','voucherHotel','childVoucher','supplier_ticket'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
		$this->checkPermissionMethod('list.voucher');
        $record = Voucher::find($id);
		$countries = Country::where('status', 1)->orderBy('name', 'ASC')->get();
		$airlines = Airline::where('status', 1)->orderBy('name', 'ASC')->get();
		$customer = Customer::where('id',$record->customer_id)->first();
		/* if(Auth::user()->role_id == '3'){
			
			return view('vouchers.editbyagent')->with(['record'=>$record,'countries'=>$countries,'airlines'=>$airlines,'customer'=>$customer]);
		}else{ */
       return view('vouchers.edit')->with(['record'=>$record,'countries'=>$countries,'airlines'=>$airlines,'customer'=>$customer]);
		//}
		
        
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
            'agent_id'=>'required',
			'country_id'=>'required',
			'travel_from_date'=>'required',
			//'customer_name'=>'required',
			//'customer_mobile'=>'required',
			'nof_night'=>'required',
			//'arrival_airlines_id' => 'required_if:is_flight,==,1',
			//'arrival_date' => 'required_if:is_flight,==,1',
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
		$agent = User::find($request->input('agent_id_select'));
		$customer = Customer::where('mobile',$agent->mobile)->first();
		
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
		//$record->vat_invoice = $request->input('vat_invoice');
		$record->agent_ref_no = $request->input('agent_ref_no');
		$record->guest_name = $request->input('guest_name');
		$record->arrival_flight_no = $request->input('arrival_flight_no');
		$record->depature_flight_no = $request->input('depature_flight_no');
		$record->remark = $request->input('remark');
		$record->adults = $request->input('adults');
		$record->childs = $request->input('childs');
		$record->infants = $request->input('infants');
		$record->summary_invoice = $request->input('summary_invoice');
		$record->status = 1;
		$record->updated_by = Auth::user()->id;
        $record->save();
		if($record->is_hotel != 1)
		{
		$voucherHotel = VoucherHotel::where('voucher_id',$record->id)->delete();
		}
		if($record->is_activity != 1)
		{
		$voucherActivity = VoucherActivity::where('voucher_id',$record->id)->delete();
		}
		
        return redirect('vouchers')->with('success','Voucher Updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Voucher  $Voucher
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
		$this->checkPermissionMethod('list.voucher');
        $record = Voucher::find($id);
		$voucherHotel = VoucherHotel::where('voucher_id',$id)->delete();
		$voucherActivity = VoucherActivity::where('voucher_id',$id)->delete();
		
        $record->delete();
        return redirect('vouchers')->with('success', 'Voucher Deleted.');
    }
	
	public function statusChangeVoucher(Request $request,$id)
    {
		
		$this->checkPermissionMethod('list.voucher');
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
		
		$record->guest_name = $data['fname'].' '.$data['lname'];
		$record->guest_email = $data['customer_email'];
		$record->guest_phone = $data['customer_mobile'];
		$record->guest_country_code = $data['country_code'];
		$record->guest_salutation = $data['salutation'];
		$record->agent_ref_no = $data['agent_ref_no'];
		$record->remark = $data['remark'];
		$record->file_handling_by = $data['file_handling_by'];
		$record->updated_by = Auth::user()->id;
		$record->payment_date = $paymentDate;
		
		if ($request->has('btn_paynow')) {
		$agent = User::find($record->agent_id);
		
		
		if(!empty($agent))
		{
			$voucherCnt = Voucher::where('agent_id',$agent->id)->where('status_main',7)->count();
			if($voucherCnt > 0)
			{
				return redirect()->back()->with('error', 'Booking is already in the process of being edited in an invoice. Please complete that process first before proceeding with this one.');
			}
			
			$voucherActivity = VoucherActivity::where('voucher_id',$record->id)->get();
			$voucherHotel = VoucherHotel::where('voucher_id',$record->id)->get();
			
			
			if(!empty($voucherHotel)){
				foreach($voucherHotel as $vh){
					$room = SiteHelpers::hotelRoomsDetails($vh->hotel_other_details);
					$hotelPriceTotal += $room['price'];
				}
			}
			$agentAmountBalance = $agent->agent_amount_balance;
			
			$total_activity_amount = $record->voucheractivity->sum('totalprice');
			$discount_tkt = $record->voucheractivity->sum('discount_tkt');
			$discount_sic_pvt_price = $record->voucheractivity->sum('discount_sic_pvt_price');
			$total_discount = $discount_tkt + $discount_sic_pvt_price;
			$grandTotalAfD = $total_activity_amount - $total_discount;
			
			$grandTotal = $grandTotalAfD + $hotelPriceTotal;
			if($agentAmountBalance >= $grandTotal)
			{
			//DB::beginTransaction();

			try {
				
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
					$record->vouchered_by = Auth::user()->id;
					$record->updated_by = Auth::user()->id;
					$record->invoice_number = $code;
					$record->status_main = 5;
					$record->zone = $agent->zone;
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
					'voucherHotel'=>$voucherHotel,
					];
					
					$zoneUserEmails = SiteHelpers::getUserByZoneEmail($record->agent_id);
					

					try {
						$bk = RaynaHelper::tourBooking($record);
						if (isset($bk['status'])) {
							if ($bk['status'] == true && $bk['adata'] == 1) {
									$record->status_main_remark = 1;
								}else{
									if ($bk['status'] == false) {
									$errorDescription = $bk['error']; 
									$record->status_main = 4;
									$saveResult = $record->save();
									$agent->agent_amount_balance += $grandTotal;
									$agent->save();

									return redirect()->route('vouchers.show', $record->id)->with('error', $errorDescription);
									exit;
									}
								}
						}
					} catch (\Exception $e) {
						$record->status_main = 4;
						$saveResult = $record->save();
						
						$agent->agent_amount_balance += $grandTotal;
						$agent->save();
						return redirect()->route('vouchers.show', $record->id)->with('error', $e->getMessage());
					}
					
					
					
					Mail::to($agent->email,'Booking Confirmation.')->cc($zoneUserEmails)->bcc('bookings@abaterab2b.com')->send(new VoucheredBookingEmailMailable($emailData)); 	
					} catch (\Exception $e) {
					//DB::rollback(); 
					return redirect()->back()->with('error', $e->getMessage() ?? 'Something went wrong.');
					}
			
			
			}
			else
			{
				 return redirect()->back()->with('error', 'Agency amount balance not sufficient for this booking.');
			}
			
		}
		else{
				 return redirect()->back()->with('error', 'Agency  Name not found this voucher.');
			}
		
		}
		else if ($request->has('btn_hold')) {
			//$record->booking_date = date("Y-m-d");
			$record->status_main = 4;
			$record->save();
			VoucherActivity::where('voucher_id', $record->id)->update(['status' => '9']);
		}
		else if ($request->has('btn_quotation')) {
			$record->status_main = 2;
			$record->save();
		}
		else if ($request->has('btn_process')) {
			$record->status_main = 3;
			$record->save();
		}
		
		foreach($voucherActivityRecord as $vac){
			if($record->status_main == 5){
				$voucherActivityU = VoucherActivity::with("variant")->find($vac->id);
				$cancellation = VariantCanellation::where('varidCode', $voucherActivityU->variant_code)->get();
				$voucherActivityU->cancellation_chart = json_encode($cancellation);

				
				$voucherActivityU->status = 3;
				$voucherActivityU->save();
				
			}
			SiteHelpers::voucherActivityLog($record->id,$vac->id,$vac->discountPrice,$vac->totalprice,$record->status_main);
			
		}
		
		
		
		//DB::commit();
		
		if($record->status_main > 3){
			return redirect()->route('voucherView',$record->id)->with('success', 'Voucher Created Successfully.');
		}
		else{
			return redirect()->route('vouchers.index')->with('success', 'Voucher Created Successfully.');
		}
        
    }
	
	public function autocompleteAgent(Request $request)
    {
		$search  = $request->get('search');
		$nameOrCompany  = ($request->get('nameorcom'))?$request->get('nameorcom'):'Company';
		if($nameOrCompany == 'Company'){
        $users = User::where('role_id', 3)
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
		   $agentDetails = '<b>Address: </b>'.$user->address. " ".$user->postcode.'<br/><b>Market: </b>'.$user->zone.'<br/><b>Mobile No: </b>'.$user->mobile.'<br/><b>Tin No: </b>'.$user->vat.'<br/><b>Available Limit: </b> AED '.$user->agent_amount_balance;
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
	
	public function autocompleteCustomer(Request $request)
    {
		$search  = $request->get('search');
        $customers = Customer::where('status', 1)
					->where(function ($query) use($search) {
						$query->where('name', 'LIKE', '%'. $search. '%')
						->orWhere('code', 'LIKE', '%'. $search. '%')
						->orWhere('mobile', 'LIKE', '%'. $search. '%');
					})->get();
		$response = array();
      foreach($customers as $customer){
		  $cusDetails = '<b>Email:</b>'.$customer->email.' <b>Mobile No:</b>'.$customer->mobile.' <b>Address:</b>'.$customer->address. " ".$customer->zip_code;
         $response[] = array("value"=>$customer->id,"label"=>$customer->name.'('.$customer->mobile.')','cusDetails'=>$cusDetails);
      }
        return response()->json($response);
    }
	
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addHotelsList(Request $request,$vid)
    {
		$this->checkPermissionMethod('list.voucher');
        $data = $request->all();
		$voucher = Voucher::find($vid);
		if($voucher->is_hotel == '0'){
			return redirect()->back()->with('error', 'If select hotel yes than you can add hotel.');
		}
        $perPage = config("constants.ADMIN_PAGE_LIMIT");
        $query = Hotel::with(['country', 'state', 'city', 'hotelcategory']);
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
		
		if (isset($data['zone_id']) && !empty($data['zone_id'])) {
            $query->where('zone_id', $data['zone_id']);
        }
       
        $query->where('status', 1);
          
        $records = $query->orderBy('created_at', 'DESC')->paginate($perPage);
		
        $countries = Country::where('status', 1)->orderBy('name', 'ASC')->get();
        $states = State::where('status', 1)->orderBy('name', 'ASC')->get();
        $cities = City::where('status', 1)->orderBy('name', 'ASC')->get();
        $hotelcategories = HotelCategory::where('status', 1)->orderBy('name', 'ASC')->get();
		
		$zones = Zone::where('status', 1)->orderBy('name', 'ASC')->get();
        return view('vouchers.hotels', compact('records', 'countries', 'states', 'cities', 'hotelcategories','vid','voucher','zones'));
    }
	
	
	/**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function addHotelsView($hid,$vid)
    {
		$this->checkPermissionMethod('list.voucher');
		$query = Hotel::with(['country', 'state', 'city', 'hotelcategory']);
		$query->where('id', $hid);
		$hotel = $query->where('status', 1)->first();
		$voucher = Voucher::find($vid);
       return view('vouchers.hotel-add-view', compact('hotel','hid','vid','voucher'));
    }
	
	public function newRowAddmore(Request $request)
    {
		$hotel_id = $request->input('hotel_id');
		$v_id = $request->input('v_id');
		$rowCount = $request->input('rowCount');
		$view = view("vouchers.addmore_markup_hotel",['rowCount'=>$rowCount,'hotel_id'=>$hotel_id,'v_id'=>$v_id])->render();
         return response()->json(['success' => 1, 'html' => $view]);
    }
	
	 /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
	 
	 public function hotelSaveInVoucher(Request $request)
	 {
		 
		 //print_r($request->all());
		 //exit;
		 
		 $voucher_id = $request->input('v_id');
		 $hotel_id = $request->input('hotel_id');
		 $check_in_date = $request->input('check_in_date');
		 $check_out_date = $request->input('check_out_date');
	 
		 $room_type = $request->input('room_type');
		 $nom_of_room = $request->input('nom_of_room');
		 $mealplan = $request->input('mealplan');
		 
		 $nop_s = $request->input('nop_s');
		 $nop_d = $request->input('nop_d');
		 $nop_eb = $request->input('nop_eb');
		 $nop_cwb = $request->input('nop_cwb');
		 $nop_cnb = $request->input('nop_cnb');
		 
		 $nr_s = $request->input('nr_s');
		 $nr_d = $request->input('nr_d');
		 $nr_eb = $request->input('nr_eb');
		 $nr_cwb = $request->input('nr_cwb');
		 $nr_cnb = $request->input('nr_cnb');
		 
		 $ppa_s = $request->input('ppa_s');
		 $ppa_d = $request->input('ppa_d');
		 $ppa_eb = $request->input('ppa_eb');
		 $ppa_cwb = $request->input('ppa_cwb');
		 $ppa_cnb = $request->input('ppa_cnb');
		 
		 $markup_p_s = $request->input('markup_p_s');
		 $markup_p_d = $request->input('markup_p_d');
		 $markup_p_eb = $request->input('markup_p_eb');
		 $markup_p_cwb = $request->input('markup_p_cwb');
		 $markup_p_cnb = $request->input('markup_p_cnb');
		 
		 $markup_v_s = $request->input('markup_v_s');
		 $markup_v_d = $request->input('markup_v_d');
		 $markup_v_eb = $request->input('markup_v_eb');
		 $markup_v_cwb = $request->input('markup_v_cwb');
		 $markup_v_cnb = $request->input('markup_v_cnb');
		 $net_cost = 0;
		 $total_markup = 0;
		 $total_price = 0;
		 $data = [];
		 foreach($room_type as $k => $v)
		 {
			 // this is new price without markup
			 $net_cost += ($nr_s[$k] + $nr_d[$k] + $nr_eb[$k] + $nr_cwb[$k] + $nr_cnb[$k]);
			 
			 // this is new price without markup
			 $total_markup += ($markup_v_s[$k] + $markup_v_d[$k] + $markup_v_eb[$k] + $markup_v_cwb[$k] + $markup_v_cnb[$k]);
			 
			 // this is selling price with markup
			 $total_price += ($nr_s[$k] + $nr_d[$k] + $nr_eb[$k] + $nr_cwb[$k] + $nr_cnb[$k]+$markup_v_s[$k] + $markup_v_d[$k] + $markup_v_eb[$k] + $markup_v_cwb[$k] + $markup_v_cnb[$k]);
			 
			 $data[] = [
					 'room_type' => $v,
					 'nom_of_room' => $nom_of_room[$k],
					 'mealplan' => $mealplan[$k],
					 'nop_s' => $nop_s[$k],
					 'nop_d' => $nop_d[$k],
					 'nop_eb' => $nop_eb[$k],
					 'nop_cwb' => $nop_cwb[$k],
					 'nop_cnb' => $nop_cnb[$k],
					 'nr_s' => $nr_s[$k],
					 'nr_d' => $nr_d[$k],
					 'nr_eb' => $nr_eb[$k],
					 'nr_cwb' => $nr_cwb[$k],
					 'nr_cnb' => $nr_cnb[$k],
					 'ppa_s' => $ppa_s[$k],
					 'ppa_d' => $ppa_d[$k],
					 'ppa_eb' => $ppa_eb[$k],
					 'ppa_cwb' => $ppa_cwb[$k],
					 'ppa_cnb' => $ppa_cnb[$k],
					 'markup_p_s' => $markup_p_s[$k],
					 'markup_p_d' => $markup_p_d[$k],
					 'markup_p_eb' => $markup_p_eb[$k],
					 'markup_p_cwb' => $markup_p_cwb[$k],
					 'markup_p_cnb' => $markup_p_cnb[$k],
					 'markup_v_s' => $markup_v_s[$k],
					 'markup_v_d' => $markup_v_d[$k],
					 'markup_v_eb' => $markup_v_eb[$k],
					 'markup_v_cwb' => $markup_v_cwb[$k],
					 'markup_v_cnb' => $markup_v_cnb[$k],
					 'created_by' => Auth::user()->id,
					 'updated_by' => Auth::user()->id,
					 
				 ];
 
				 
		 }
		 
		 $dataInsert = [
			 'voucher_id' => $voucher_id,
			 'hotel_id' => $hotel_id,
			 'check_in_date' => $check_in_date,
			 'check_out_date' => $check_out_date,
			 'hotel_other_details' => json_encode($data),
			 'net_cost'	=> $net_cost,
			 'total_markup'	=> $total_markup,
			 'total_price'	=> $total_price,
			 'total_cost'	=> $total_price,
		 ];
		// dd($dataInsert);
		 if(count($dataInsert) > 0)
		 {
			 VoucherHotel::insert($dataInsert);
		 }
		 
		 if ($request->has('save_and_continue')) {
		  return redirect()->route('voucher.add.hotels',$voucher_id)->with('success', 'Hotel added Successfully.');
		 } else {
		 return redirect('vouchers')->with('success', 'Hotel Added Successfully.');
		 }
		 
	   
	 }
	
	public function destroyHotelFromVoucher($id)
    {
        $record = VoucherHotel::find($id);
        $record->delete();
        return redirect()->back()->with('success', 'Hotel Deleted Successfully.');
    }
	
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	 
	  public function addActivityList(Request $request,$vid)
    {
		$this->checkPermissionMethod('list.voucher');
       $data = $request->all();
		$typeActivities = config("constants.typeActivities"); 
        //$perPage = config("constants.ADMIN_PAGE_LIMIT");
		$perPage = "1000";
		$voucher = Voucher::find($vid);
		$startDate = $voucher->travel_from_date;
		$endDate = $voucher->travel_to_date;
		if($voucher->status_main  == '5')
		{
			return redirect()->route('voucherView',$voucher->id)->with('error', 'You can not add more activity. your voucher already vouchered.');
		}
        $query = Activity::has('activityVariants')->with('activityVariants.prices')->where('status',1);
		
        if (isset($data['name']) && !empty($data['name'])) {
            $query->where('title', 'like', '%' . $data['name'] . '%');
        }
		
       
       $records = $query->whereHas('activityVariants.prices', function ($query) use($startDate,$endDate) {
           $query->where('rate_valid_from', '<=', $startDate)->where('rate_valid_to', '>=', $endDate);
		   $query->where('rate_valid_from', '<=', $startDate)->where('rate_valid_to', '>=', $endDate);
       })->orderBy('created_at', 'DESC')->paginate($perPage); 
	   
	  // dd($records);
		//$records = $query->orderBy('created_at', 'DESC')->paginate($perPage);
	
		
		$voucherHotel = VoucherHotel::where('voucher_id',$vid)->get();
		$voucherActivity = VoucherActivity::where('voucher_id',$vid)->orderBy('tour_date','ASC')->get();
		
		$voucherActivityCount = VoucherActivity::where('voucher_id',$vid)->count();
        return view('vouchers.activities-list', compact('records','typeActivities','vid','voucher','voucherActivityCount','voucherHotel','voucherActivity'));
		
       
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
		$returnHTML = view('vouchers.activities-add-view', compact('variantData','voucher','aid','vid'))->render();
		//$dates = SiteHelpers::getDateListBoth($voucher->travel_from_date,$voucher->travel_to_date,$activity->black_sold_out);
		//$disabledDay = SiteHelpers::getNovableActivityDays($activity->availability);
		
		$dates = [];
		$disabledDay = [];
		return response()->json(array('success' => true, 'html'=>$returnHTML, 'dates'=>json_encode($dates),'disabledDay'=>json_encode($disabledDay)));	
			
    }
	
	public function getActivityVariantPrice(Request $request)
    {
		$data = $request->all();
		$variantData = PriceHelper::getActivityPriceByVariant($data);
		
		return response()->json(array('success' => true,  'variantData'=>$variantData,'postData'=>$data));	
			
    }
	

	

	public function addActivityView($aid,$vid,$d="",$a="",$c="",$i="",$tt="")
    {
		$query = Activity::with('images')->where('id', $aid);
		$activity = $query->where('status', 1)->first();
		
		$voucher = Voucher::find($vid);
		$startDate = $voucher->travel_from_date;
		$endDate = $voucher->travel_to_date;
		$variantData = PriceHelper::getActivityVariantListArrayByTourDate($startDate,$aid);
		
		$typeActivities = config("constants.typeActivities"); 
	
		
       return view('vouchers.activities-add-details', compact('activity','aid','vid','voucher','typeActivities','variantData'));
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
		$activity_select = $request->input('activity_select');

		
	if(isset($activity_select))
	{
		
		$voucher_id = $request->input('v_id');
		$activity_id = $request->input('activity_id');
		$activity_variant_id = $request->input('activity_variant_id');
		$activity_variant_code = $request->input('activity_variant_code');
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
		$isRayna = $request->input('isRayna');
		//dd($request->input('ucode'));
		//dd($request->all());
		$data = [];
		$total_activity_amount = 0;
		$k  = $request->input('ucode');
		$timeslot  = $request->input('timeslot');
		$timeSlotId  = $request->input('timeSlotId');
		//$activitySelectNew[$k] = $k;
		
		$acodes = explode(",",$activity_variant_code[$k]);
		$aids = explode(",",$activity_variant_id[$k]);
		if(!empty($k)){
			$adults= $childs = $infants = 0;
			$transferoption = $transferzone = "";
		foreach($acodes as $ik => $k)
		{

			$avid = $aids[$ik];

			$activityVariant = ActivityVariant::with('variant', 'activity')->find($avid);
			$activity = $activityVariant->activity;
			$variant = $activityVariant->variant;
			if(isset($tour_date[$k]))
				$tour_dt = date("Y-m-d",strtotime($tour_date[$k]));

			$getAvailableDateList = SiteHelpers::getDateList($tour_dt,$variant->black_out,$variant->sold_out,$variant->availability);
			
			if(isset($adult[$k]))
			{
				$adults = $adult[$k];
				$childs = $child[$k];
				$infants = $infant[$k];
				$totalmember = $adult[$k] + $child[$k];
			}
			if(isset($transfer_option[$k]))
				$transferoption = $transfer_option[$k];

			if(isset($transfer_zone[$k]))
			{	
				$transferzone = $transfer_zone[$k];
			}
			$priceCal = PriceHelper::getActivityPriceSaveInVoucher($transferoption,$avid,$voucher->agent_id,$adults,$childs,$infants,"0",$tour_dt,0,0,$transferzone);
				
			if($priceCal['totalprice'] > 0)
			{
				if(!in_array($tour_dt,$getAvailableDateList))
				{
					if ($request->ajax()) {
						return response()->json(['error' => $variant->title.' Tour is not available for Selected Date.']);
					}

					return redirect()->back()->with('error', $variant->title.' Tour is not available for Selected Date.');
				}
			
				if(empty($transfer_zone))
				{
					$transfer_zone = [];
				}
				
				($variant->touroption_id > 0)?$isRayna = "true":$isRayna = "false";
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
				'parent_code' => $variant->parent_code,
				'activity_entry_type' => $activity->entry_type,
				'activity_product_type' => $activity->product_type,
				'variant_pvt_TFRS' => $variant->pvt_TFRS,
				'variant_pick_up_required' => $variant->pick_up_required,
				'variant_type' => $variant->type,
				'activity_title' => $activity->title,
				'variant_zones' => $variant->zones,
				'variant_pvt_TFRS_text' => $variant->pvt_TFRS_text,
				'transfer_option' => $transferoption,
				'tour_date' => $tour_dt,
				'pvt_traf_val_with_markup' => $priceCal['pvt_traf_val_with_markup'],
				'transfer_zone' => $transferzone,
				'zonevalprice_without_markup' => $priceCal['zonevalprice_without_markup'],
				'adult' => $adults,
				'child' => $childs,
				'infant' => $infants,
				'markup_p_ticket_only' => $priceCal['markup_p_ticket_only'],
				'markup_p_sic_transfer' => $priceCal['markup_p_sic_transfer'],
				'markup_p_pvt_transfer' => $priceCal['markup_p_pvt_transfer'],
				'adultPrice' => $priceCal['adultPrice'],
				'childPrice' => $priceCal['childPrice'],
				'infPrice' => $priceCal['infPrice'],
				'original_tkt_rate' => $priceCal['ticketPrice'],
				'original_trans_rate' => $priceCal['transferPrice'],
				'vat_percentage' => $priceCal['vat_per'],
				'discountPrice' => "0",
				'discountPrice' => "0",
				'time_slot' => $timeslot,
				'timeSlotId' => ($isRayna=="true")?$timeSlotId:0,
				'isRayna' => ($isRayna=="true")?1:0,
				'cancellation_chart' => json_encode($cancellation),
				'totalprice' => number_format($priceCal['totalprice'], 2, '.', ''),
				'created_by' => Auth::user()->id,
				'updated_by' => Auth::user()->id,
				'zone' => $voucher->zone,	
					];

				$total_activity_amount += $priceCal['totalprice'];
			}
		}
		
		
	
			if(count($data) > 0)
			{	
				if ($isRayna === "true") {
					if (!empty($data) && isset($data[0])) {
						$payload = $data[0];
				
						$pData = [
							"travelDate" => $payload['tour_date'] ?? null,
							"adult"      => $payload['adult'] ?? 0,
							"child"      => $payload['child'] ?? 0,
							"infant"     => $payload['infant'] ?? 0,
						];
				
						$availability = RaynaHelper::getTourAvailability($variant->touroption_id, $pData);
				
						if (!empty($availability['status']) && $availability['status'] === true) {
							$tourOptionDetails = RaynaHelper::getTourOptionByTourId($variant->touroption_id, $pData);
							if (!empty($tourOptionDetails) && $tourOptionDetails['status'] === true) {
								$data[0]['rayna_adultPrice']  = $tourOptionDetails['rayna_adultPrice'] * $payload['adult'];
								$data[0]['rayna_childPrice']  = $tourOptionDetails['rayna_childPrice'] * $payload['child'];
								$data[0]['rayna_infantPrice'] = $tourOptionDetails['rayna_infantPrice'] * $payload['infant'];
							} else {
								$errorMessage = $tourOptionDetails['message'] ?? 'Unknown error occurred';
								if ($request->ajax()) {
									return response()->json(['error' => $errorMessage]);
								}
								return redirect()->back()->with('error', $errorMessage);
							}

							$actData = $data[0];
							$errors = [];

							if ($actData['rayna_adultPrice'] > $actData['adultPrice']) {
								$errors[] = "Adult price error.";
							}

							if ($actData['rayna_childPrice'] > $actData['childPrice']) {
								$errors[] = "Child price error.";
							}

							if (!empty($errors)) {
								$errorMessage = implode(" ", $errors);
								if ($request->ajax()) {
									return response()->json(['error' => $errorMessage]);
								}
								return redirect()->back()->with('error', $errorMessage);
							}

							VoucherActivity::insert($data);
							$voucher = Voucher::find($voucher_id);
							$voucher->total_activity_amount += $total_activity_amount;
							$voucher->save();
						} else {
							$errorMessage = $availability['message'] ?? 'Unknown error occurred';
							if ($request->ajax()) {
								return response()->json(['error' => $errorMessage]);
							}

							return redirect()->back()->with('error', $errorMessage);
						}
					} else {
						if ($request->ajax()) {
							return response()->json(['error' => 'Invalid tour data.']);
						}
						return redirect()->back()->with('error', 'Invalid tour data.');
					}
				}
				else{
					
					VoucherActivity::insert($data);
							$voucher = Voucher::find($voucher_id);
							$voucher->total_activity_amount += $total_activity_amount;
							$voucher->save();
							if ($request->ajax()) {
								return response()->json(['success' => 'Activity added Successfully.']);
							}
				}
			}

		} else {
			if ($request->ajax()) {
				return response()->json(['error' => 'Please Select Tour Option.']);
			}
			return redirect()->back()->with('error',' Please Select Tour Option.');
		}
		
		
		if ($request->has('save_and_continue')) {
			if ($request->ajax()) {
				return response()->json(['success' => 'Activity added Successfully.']);
			}
         return redirect()->route('voucher.add.activity',$voucher_id)->with('success', 'Activity added Successfully.');
		} else {
			if ($request->ajax()) {
				return response()->json(['success' => 'Activity added Successfully.']);
			}
			return redirect()->back()->with('success', 'Activity added Successfully.');
		}
	}
	if ($request->ajax()) {
		return response()->json(['error' => 'Please select activity variant.']);
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
	
	
	
 public function voucherActivityItineraryPdf(Request $request, $vid)
    {
		
		if(Auth::user()->role_id == '3'){
		$voucher = Voucher::where('id',$vid)->where('agent_id',Auth::user()->id)->first();
		}else{
		$voucher = Voucher::find($vid);
		}
		
		$voucherIds[$vid] = $vid;
		$parentVoucher = $voucher->getParent;
		$childVouchers = $voucher->getChild;
			if(!empty($parentVoucher)){
		$voucherIds[$parentVoucher->id] = $parentVoucher->id;
		}

		if(!empty($childVouchers)){
			foreach ($childVouchers as $childVoucher) {
				$voucherIds[$childVoucher->id] = $childVoucher->id;
			}
		}
		
		
		
		
		if (empty($voucher)) {
            return abort(404); //record not found
        }
		$voucherHotel = VoucherHotel::where('voucher_id',$voucher->id)->whereIn('status',[3])->orderBy("check_in_date","ASC")->get();
		//$voucherActivity = VoucherActivity::where('voucher_id',$voucher->id)->whereIn('status',[0,3,4])->get();
		$voucherActivity = VoucherActivity::whereIn('voucher_id',$voucherIds)->whereIn('status',[0,3,4])->orderBy("tour_date","ASC")->orderBy("serial_no","ASC")->get();
		
		$discountTotal = 0;
		$subTotal = 0;
		$dataArray = [
				'adult' => 0,
				'child' => 0,
				'infant' => 0,
				'adultP' => 0,
				'childP' => 0,
				'infantP' => 0,
				'totalPrice' => 0,
				];
		
	   if(!empty($voucherActivity)){
					 foreach($voucherActivity as $kkh => $ap)
					 {
						
					$vat =  1 + $ap->activity_vat;
					$vatPrice = $ap->totalprice/$vat;
					$total = $ap->totalprice;
				$dataArray['adult'] += $ap->adult;
				$dataArray['child'] += $ap->child;
				$dataArray['infant'] += $ap->infant;
				$dataArray['adultP'] += $ap->adultPrice;
				$dataArray['childP'] += $ap->childPrice;
				$dataArray['infantP'] += $ap->infPrice;
				$dataArray['totalPrice'] += $total;
					 }
					
			}
			
         //return view('vouchers.ActivityItineraryPdf', compact('voucher','voucherHotel','voucherActivity','dataArray'));
        
		

        $pdf = SPDF::loadView('vouchers.ActivityItineraryPdf', compact('voucher','voucherHotel','voucherActivity','dataArray'));
       $pdf->setPaper('A4')->setOrientation('portrait');
        return $pdf->download($voucher->code.'-'.$voucher->guest_name.'.pdf');
		
	
	
	//return \Response::make($content,200, $headers);
    }
	
	public function voucherInvoicePdf(Request $request, $vid)
    {
		if(Auth::user()->role_id == '3'){
		$voucher = Voucher::where('id',$vid)->where('agent_id',Auth::user()->id)->first();
		}else{
		$voucher = Voucher::find($vid);
		}
		if (empty($voucher)) {
            return abort(404); //record not found
        }
		
		$voucherHotel = VoucherHotel::where('voucher_id',$voucher->id)->get();
		$agent = User::where('id',$voucher->agent_id)->first();
		$customer = Customer::where('id',$voucher->customer_id)->first();
		
       //$voucherActivity = VoucherActivity::where('voucher_id',$voucher->id)->whereIn('status',[0,3,4])->get();
	   $voucherActivity = VoucherActivity::where('voucher_id',$voucher->id)->get();
	  
		
        $dataArray = [];
		$discountTotal = 0;
		$grandTotalAmount = 0;
		$at_amount = 0;
		$dis = 0;
		$act_name = $tour_dt  = "";
		if(!empty($voucherActivity)){
					 foreach($voucherActivity as $kkh => $ap)
					 {
						
					$activity = SiteHelpers::getActivity($ap->activity_id);
					$vat =  1 + $activity->vat;
					$vatPrice = $ap->totalprice/$vat;
					//$total = ($ap->totalprice+$ap->discountPrice) - ($vatPrice);
					$total = $ap->totalprice;
					$discounTkt = $ap->discount_tkt;
					$discountTrns = $ap->discount_sic_pvt_price;
					$totalDiscount = $discounTkt + $discountTrns;
					$totalPriceAfDis = $total - $totalDiscount;

					$ar_code = $ap->variant_code.$kkh;
					
					
					if($ap->activity_product_type == 'Bundle_Same')
					{
						$ar_code = $ap->activity_id;
						$at_amount += $totalPriceAfDis;
						$dis = '1';
						$act_name = $activity->title.'-'.$ap->variant_name;
					$tour_dt = $ap->tour_date;

					}
					elseif(($ap->activity_product_type == 'Bundle_Diff') || ($ap->activity_product_type == 'Package'))
					{
						$at_amount  += $totalPriceAfDis;
						$ar_code = $ap->activity_id;
						if($act_name == '')
						$act_name = $activity->title.'-'.$ap->variant_name;
						else 
						$act_name = $act_name."<br/>".$activity->title.'-'.$ap->variant_name;
						if($tour_dt == '')
							$tour_dt = $ap->tour_date;
						else
						$tour_dt = $tour_dt."<br/>".$ap->tour_date;
					}
					else
					{
						$at_amount = $totalPriceAfDis;
						$act_name = $activity->title.'-'.$ap->variant_name;
						$tour_dt = $ap->tour_date;
					}
					
				$dataArray[$ar_code] = [
				'hhotelActName' => $act_name,
				'TouCheckInCheckOutDate' => $tour_dt,
				'adult' => $ap->adult,
				'child' => $ap->child,
				'NoofPax' => 0,
				'hotel' => 0,
				'totalprice' => $at_amount,
				];
			
				// $dataArray[$ap->variant_code.$kkh] = [
				// 'hhotelActName' => $activity->title.'-'.$ap->variant_name,
				// 'TouCheckInCheckOutDate' => $ap->tour_date,
				// 'adult' => $ap->adult,
				// 'child' => $ap->child,
				// 'NoofPax' => 0,
				// 'hotel' => 0,
				// 'totalprice' => $totalPriceAfDis,
				// ];
				$discountTotal += $totalPriceAfDis;
				$grandTotalAmount+= $totalPriceAfDis ;
					 }
					
			}
			
		if(!empty($voucherHotel)){
					 foreach($voucherHotel as $kk => $vh)
					 {
					  $hotelData = json_decode($vh->hotel_other_details);
					  $noofPax = 0;
						$netRate = 0;
					  foreach($hotelData as $k => $hd)
					  {
						  
						  $noofPax+= $hd->nop_s;
						  $noofPax+= $hd->nop_d;
						  $noofPax+= $hd->nop_eb;
						  $noofPax+= $hd->nop_cwb;
						  $noofPax+= $hd->nop_cnb;
						  
						  $netRate+= $hd->nr_s;
						  $netRate+= $hd->nr_d;
						  $netRate+= $hd->nr_eb;
						  $netRate+= $hd->nr_cwb;
						  $netRate+= $hd->nr_cnb;
					  }
				$dataArray[$vh->hotel->name.$kk] = [
				'hhotelActName' => $vh->hotel->name,
				'TouCheckInCheckOutDate' =>$vh->check_in_date.' / '.$vh->check_out_date,
				'NoofPax' => $noofPax,
				'adult' => 0,
				'child' => 0,
				'hotel' => 1,
				//'totalprice' => $netRate,
				'totalprice' => $vh->total_price,
				];
				$grandTotalAmount+= $vh->total_price;
					 }
					
			}
			
			$vat = '1.05';
			$subTotal = 0;
			$grandWithVatTotal = 0;
			$vatTotal =0;
			if($voucher->vat_invoice == 1){
				$vt = $grandTotalAmount/$vat;
				$vatTotal = (($grandTotalAmount - $vt));
				//$subTotal = (($grandTotalAmount - $vatTotal) - $discountTotal);
				$subTotal = ($grandTotalAmount - $vatTotal);
				$totalAmount = $subTotal + $vatTotal;
			}
			else
			{
				//$totalAmount = ($grandTotalAmount) - $discountTotal;
				$totalAmount = $grandTotalAmount;
			}
			
			
			
			
       
//return view('vouchers.invoicePdf', compact('dataArray','agent','customer','voucher','discountTotal','totalAmount','subTotal','vatTotal'));
        $pdf = SPDF::loadView('vouchers.invoicePdf', compact('dataArray','agent','customer','voucher','discountTotal','subTotal','vatTotal','totalAmount'));
       $pdf->setPaper('A4')->setOrientation('portrait');
        return $pdf->download($voucher->invoice_number.'-'.$voucher->guest_name.'.pdf');
		
	
	
	// return \Response::make($content,200, $headers);
    }

	public function voucherInvoiceSummaryPdf(Request $request, $vid)
    {
		if(Auth::user()->role_id == '3'){
		$voucher = Voucher::where('id',$vid)->where('agent_id',Auth::user()->id)->first();
		}else{
		$voucher = Voucher::find($vid);
		}
		if (empty($voucher)) {
            return abort(404); //record not found
        }
		
		$voucherHotel = VoucherHotel::where('voucher_id',$voucher->id)->get();
		$agent = User::where('id',$voucher->agent_id)->first();
		$customer = Customer::where('id',$voucher->customer_id)->first();
		
       //$voucherActivity = VoucherActivity::where('voucher_id',$voucher->id)->whereIn('status',[0,3,4])->get();
	   $voucherActivity = VoucherActivity::where('voucher_id',$voucher->id)->get();
	  
		
        $dataArray = [];
		$discountTotal = 0;
		$grandTotalAmount = 0;
		
		if(!empty($voucherActivity)){
			foreach($voucherActivity as $kkh => $ap)
			{
			   
		   $activity = SiteHelpers::getActivity($ap->activity_id);
		   $vat =  1 + $activity->vat;
		   $vatPrice = $ap->totalprice/$vat;
		   //$total = ($ap->totalprice+$ap->discountPrice) - ($vatPrice);
		   $total = $ap->totalprice;
		   $discounTkt = $ap->discount_tkt;
		   $discountTrns = $ap->discount_sic_pvt_price;
		   $totalDiscount = $discounTkt + $discountTrns;
		   $totalPriceAfDis = $total - $totalDiscount;

		   $ar_code = $ap->variant_code.$kkh;
		   
		   
		   if($ap->activity_product_type == 'Bundle_Same')
		   {
			   $ar_code = $ap->activity_id;
			   $at_amount += $totalPriceAfDis;
			   $dis = '1';
			   $act_name = $activity->title.'-'.$ap->variant_name;
		   $tour_dt = $ap->tour_date;

		   }
		   elseif(($ap->activity_product_type == 'Bundle_Diff') || ($ap->activity_product_type == 'Package'))
		   {
			   $at_amount  += $totalPriceAfDis;
			   $ar_code = $ap->activity_id;
			   $act_name = $act_name."<br/>".$activity->title.'-'.$ap->variant_name;
			   $tour_dt = $tour_dt."<br/>".$ap->tour_date;
		   }
		   else
		   {
			   $at_amount = $totalPriceAfDis;
			   $act_name = $activity->title.'-'.$ap->variant_name;
			   $tour_dt = $ap->tour_date;
		   }
		   
	   $dataArray[$ar_code] = [
	   'hhotelActName' => $act_name,
	   'TouCheckInCheckOutDate' => $tour_dt,
	   'adult' => $ap->adult,
	   'child' => $ap->child,
	   'NoofPax' => 0,
	   'hotel' => 0,
	   'totalprice' => $at_amount,
	   ];
   
	   // $dataArray[$ap->variant_code.$kkh] = [
	   // 'hhotelActName' => $activity->title.'-'.$ap->variant_name,
	   // 'TouCheckInCheckOutDate' => $ap->tour_date,
	   // 'adult' => $ap->adult,
	   // 'child' => $ap->child,
	   // 'NoofPax' => 0,
	   // 'hotel' => 0,
	   // 'totalprice' => $totalPriceAfDis,
	   // ];
	   $discountTotal += $totalPriceAfDis;
	   $grandTotalAmount+= $totalPriceAfDis ;
			}
		   
   }
			
		if(!empty($voucherHotel)){
					 foreach($voucherHotel as $kk => $vh)
					 {
					  $hotelData = json_decode($vh->hotel_other_details);
					  $noofPax = 0;
						$netRate = 0;
					  foreach($hotelData as $k => $hd)
					  {
						  
						  $noofPax+= $hd->nop_s;
						  $noofPax+= $hd->nop_d;
						  $noofPax+= $hd->nop_eb;
						  $noofPax+= $hd->nop_cwb;
						  $noofPax+= $hd->nop_cnb;
						  
						  $netRate+= $hd->nr_s;
						  $netRate+= $hd->nr_d;
						  $netRate+= $hd->nr_eb;
						  $netRate+= $hd->nr_cwb;
						  $netRate+= $hd->nr_cnb;
					  }
				$dataArray[$vh->hotel->name.$kk] = [
				'hhotelActName' => $vh->hotel->name,
				'TouCheckInCheckOutDate' =>$vh->check_in_date.' / '.$vh->check_out_date,
				'NoofPax' => $noofPax,
				'adult' => 0,
				'child' => 0,
				'hotel' => 1,
				//'totalprice' => $netRate,
				'totalprice' => $vh->total_price,
				];
				$grandTotalAmount+= $vh->total_price;
					 }
					
			}
			
			$vat = '1.05';
			$subTotal = 0;
			$grandWithVatTotal = 0;
			$vatTotal =0;
			if($voucher->vat_invoice == 1){
				$vt = $grandTotalAmount/$vat;
				$vatTotal = (($grandTotalAmount - $vt));
				//$subTotal = (($grandTotalAmount - $vatTotal) - $discountTotal);
				$subTotal = ($grandTotalAmount - $vatTotal);
				$totalAmount = $subTotal + $vatTotal;
			}
			else
			{
				//$totalAmount = ($grandTotalAmount) - $discountTotal;
				$totalAmount = $grandTotalAmount;
			}
			
			
			
			
       
//return view('vouchers.invoiceSummaryPdf', compact('dataArray','agent','customer','voucher','discountTotal','totalAmount','subTotal','vatTotal'));
        $pdf = SPDF::loadView('vouchers.invoiceSummaryPdf', compact('dataArray','agent','customer','voucher','discountTotal','subTotal','vatTotal','totalAmount'));
       $pdf->setPaper('A4')->setOrientation('portrait');
        return $pdf->download($voucher->invoice_number.'-'.$voucher->guest_name.'.pdf');
		
	
	
	return \Response::make($content,200, $headers);
    }

	public function voucherHotelInputSae(Request $request)
    {
		$data = $request->all();
		
		$record = VoucherHotel::find($data['id']);
        $record->{$data['inputname']} = $data['val'];
        $record->save();
		$response[] = array("status"=>1);
        return response()->json($response);
	}
	
	public function cancelActivityFromVoucher(Request $request,$id)
	{
		
		$remark = $request->input("cancel_remark_data-{$id}");
		
		$record = VoucherActivity::find($id);
		$recordV = Voucher::find($record->voucher_id);
		$remarkNew = $record->internal_remark.'<br>'.$remark." -- By ".Auth::user()->name." on ".date('M, d: H:s');
		$voucherActivity[0] = $record;
		
		
		$agent = User::find($recordV->agent_id);
		$refundAmt = PriceHelper::checkCancellation($id);
		$cancellation = VariantCanellation::where('varidCode', $record->variant_code)->get();
		//if($record->ticket_downloaded == '0'){
		$record->status = 1;
		$record->cancel_by = Auth::user()->id;
		$record->canceled_date = Carbon::now()->toDateTimeString();
		$record->org_refund_tkt_amt = $refundAmt['refundamt']['tkt'];
		$record->org_refund_trans_amt = $refundAmt['refundamt']['trf'];
		if(!empty($remark)){
			$record->internal_remark = $remarkNew;
		}
		if($record->isRayna == '1'){
			if ($record && !empty($record->rayna_booking_details)) {
			$bookingDetails = json_decode($record->rayna_booking_details, true);
			$referenceNo = $record->referenceNo;
			$bookingId = $bookingDetails[0]['bookingId'];
			$cancel = RaynaHelper::cancelBooking($referenceNo,$bookingId,$record->voucher_id,$record->id);
				if ($cancel['status']) {
					$record->isRaynaCancel = '1';
				}
			}
		}
		//$record->cancellation_time_data = json_encode($cancellation);
		$record->save();
		
		$tickets = Ticket::where("voucher_activity_id",$record->id)->where("ticket_generated",'1')->get();
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
		
		
		$recordCount = VoucherActivity::where("voucher_id",$record->voucher_id)->whereIn("status",['0','3','4'])->count();
		if($recordCount == '0'){
			$voucher = Voucher::find($record->voucher_id);
			$voucher->status_main = 6;
			$voucher->save();		
		}
		
		$zoneUserEmails = SiteHelpers::getUserByZoneEmail($record->agent_id);
		//Mail::to($agent->email,'Booking Cancellation.')->cc($zoneUserEmails)->bcc('bookings@abaterab2b.com')->send(new VoucheredCancelEmail($voucherActivity)); 
		
		return redirect()->back()->with('success', 'Activity Canceled Successfully.');
		//}
		//else{
		//return redirect()->back()->with('error', "Ticket already downloaded you can not cancel this.");		
		//}
	}
	
	
	public function invoiceStatusChange(Request $request,$id)
    {
		
		$this->checkPermissionMethod('list.invoiceEditButton');
		$data = $request->all();
		$hotelPriceTotal = 0;
		$grandTotal = 0;
		$record = Voucher::where('id',$id)->first();
		
		if (empty($record)) {
            return abort(404); //record not found
        }

		$voucherActivity = VoucherActivity::where('voucher_id',$record->id);
		$voucherActivityRecord = $voucherActivity->get();
		$agent = User::find($record->agent_id);
		
		$emailData = [
		'invoiceNumber' =>$record->invoice_number ,
		'requestedBy' => Auth::user()->name.' '.Auth::user()->lname,
		];
		
		
		
		
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
			$total_discountPrice = $record->voucheractivity->sum('discountPrice');
			$discount_tkt = $record->voucheractivity->sum('discount_tkt');
			$discount_sic_pvt_price = $record->voucheractivity->sum('discount_sic_pvt_price');
			$total_discount = $discount_tkt + $discount_sic_pvt_price;
			$grandTotal = $total_activity_amount - $total_discount;
			
			if($agentAmountBalance >= $grandTotal)
			{
			$record->status_main = 7;
			$record->save();
			$agent->agent_amount_balance += $grandTotal;
			$agent->save();
			
			$agentAmount = new AgentAmount();
			$agentAmount->agent_id = $record->agent_id;
			$agentAmount->amount = $grandTotal;
			$agentAmount->date_of_receipt = $record->booking_date;
			$agentAmount->transaction_type = "Receipt";
			$agentAmount->transaction_from = 5;
			$agentAmount->role_user = 3;
			$agentAmount->created_by = Auth::user()->id;
			$agentAmount->updated_by = Auth::user()->id;
			$agentAmount->receipt_no = $record->invoice_number;
			$agentAmount->save();
			/* $receipt_no = 'A-'.date("Y")."-00".$agentAmount->id;
			$recordUser = AgentAmount::find($agentAmount->id);
			$recordUser->receipt_no = $receipt_no;
			$recordUser->save(); */
		
			foreach($voucherActivity as $vac){
			SiteHelpers::voucherActivityLog($record->id,$vac->id,$vac->discountPrice,$vac->totalprice,$record->status_main);
			}
			
			$zoneUserEmails = SiteHelpers::getUserByZoneEmail($record->agent_id);
			Mail::to('payment@abaterab2b.com','Invoice Edit Request.')->cc($agent->email)->send(new InvoiceEditRequestEmail($emailData)); 
			
			 return redirect()->back()->with('success', 'Request processed successfully.');
			}
			else{
				 return redirect()->back()->with('error', 'Agency amount balance not sufficient for this booking.');
			}
			
			
		}
		else{
				 return redirect()->back()->with('error', 'Agency  Name not found this voucher.');
			}
		
		}
		
		
	public function invoicePriceStatusList(Request $request)
    {
		
		$this->checkPermissionMethod('list.invoiceEditList');
		 $perPage = config("constants.ADMIN_PAGE_LIMIT");
		 $data = $request->all();
		$query = Voucher::where('id','!=', null);
		if (isset($data['agent_id_select']) && !empty($data['agent_id_select'])) {
            $query->where('agent_id', $data['agent_id_select']);
        }
		
		if (isset($data['code']) && !empty($data['code'])) {
            $query->where('code', 'like', '%' . $data['code'] . '%');
        }
		if (isset($data['guest_name']) && !empty($data['guest_name'])) {
            $query->where('guest_name', 'like', '%' . $data['guest_name'] . '%');
        }
		
		
                $query->where('status_main', 7);
        
		
		if (isset($data['is_hotel']) && !empty($data['is_hotel'])) {
            if ($data['is_hotel'] == 1)
                $query->where('is_hotel', 1);
            if ($data['is_hotel'] == 2)
                $query->where('is_hotel', 0);
        }
		
		if (isset($data['is_flight']) && !empty($data['is_flight'])) {
            if ($data['is_flight'] == 1)
                $query->where('is_flight', 1);
            if ($data['is_flight'] == 2)
                $query->where('is_flight', 0);
        }
		
		if (isset($data['is_activity']) && !empty($data['is_activity'])) {
            if ($data['is_activity'] == 1)
                $query->where('is_activity', 1);
            if ($data['is_activity'] == 2)
                $query->where('is_activity', 0);
        }
		
        $records = $query->orderBy('created_at', 'DESC')->paginate($perPage);
		$agetid = '';
		$agetName = '';
		
		if(old('agent_id')){
		$agentTBA = User::where('id', old('agent_id_select'))->where('status', 1)->first();
		$agetid = $agentTBA->id;
		$agetName = $agentTBA->company_name;
		}
		
        return view('vouchers.invoice-price-status-list', compact('records','agetid','agetName'));

    }
	
	
	public function invoicePriceChangeView(Voucher $voucher)
    {
		
		$this->checkPermissionMethod('list.invoiceEditList');
		$this->checkPermissionMethod('list.voucher');
		$voucherHotel = VoucherHotel::where('voucher_id',$voucher->id)->get();
		$voucherActivity = VoucherActivity::where('voucher_id',$voucher->id)->whereNotIn('status',[1,2])->orderBy("tour_date","ASC")->orderBy("serial_no","ASC")->get();
		
		if($voucher->status_main != 7)
		{
			 return redirect()->back()->with('error', 'Something went wrong. please try again');
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

        return view('vouchers.invoice-price-change-view-from', compact('voucher','voucherHotel','voucherActivity','voucherStatus','fname','lname'));
    }
	
	
	public function invoicePriceChangeSave(Request $request,$id)
    {
		$this->checkPermissionMethod('list.invoiceEditList');
		$data = $request->all();
		
		$hotelPriceTotal = 0;
		$grandTotal = 0;
		$grandTotalNet = 0;
		$grandDis = 0;
		$record = Voucher::where('id',$id)->first();
		
		if (empty($record)) {
            return abort(404); //record not found
        }

		$voucherActivity = VoucherActivity::where('voucher_id',$record->id);
		$voucherActivityRecord = $voucherActivity->get();
		$agent = User::find($record->agent_id);
		$aData = [];
		if(!empty($agent))
		{
			$discountRecord = $data['discount_tkt'];
			$discount_sic_pvt_price = $data['discount_sic_pvt_price'];
			
			foreach($voucherActivityRecord as $var){
				
				$dis1 = (array_key_exists($var->id,$discountRecord))?$discountRecord[$var->id]:0;
				$dis2 = (array_key_exists($var->id,$discount_sic_pvt_price))?$discount_sic_pvt_price[$var->id]:0;
				
				$dis1 = (floatval($dis1)) ? $dis1 : 0;
				$dis2 = (floatval($dis2)) ? $dis2 : 0;
				$totalDis = $dis1+$dis2;
				$tPrice = $var->totalprice;
				if($totalDis > $tPrice){
					 return redirect()->back()->with('error', 'Discount not greater than total amount.');
				}
				$tP= $tPrice;
				$aData[] =[
				"id" => $var->id,
				"totalprice" => $tP,
				"discount_tkt" => $dis1,
				"discount_sic_pvt_price" => $dis2,
				];
				
				
				$grandTotal +=$tP;
				$grandDis +=$totalDis;
			}
			//dd($aData);
			$agentAmountBalance = $agent->agent_amount_balance;
			$grandTotalNet = $grandTotal-$grandDis;
			if($agentAmountBalance >= $grandTotalNet)
			{
			foreach($aData as $var1){
				$vA = VoucherActivity::find($var1['id']);
				$discount_tkt = $var1['discount_tkt'];
				$discount_sic_pvt_price = $var1['discount_sic_pvt_price'];
				//$vA->totalprice = $var1['totalprice'];
				$vA->discount_tkt = $discount_tkt;
				$vA->discount_sic_pvt_price = $discount_sic_pvt_price;
				$vA->save();
				SiteHelpers::voucherActivityLog($record->id,$var1['id'],$var1['discount_tkt']+$var1['discount_sic_pvt_price'],$var1['totalprice'],5);
			}
			
		
			$record->status_main = 5;
			$record->invoice_edit_date = date("Y-m-d");
			$record->invoice_edit_by = Auth::user()->id;
			$record->save();
			$agent->agent_amount_balance -= $grandTotalNet;
			$agent->save();
			
			$discount_tkt = $record->voucheractivity->sum('discount_tkt');
			$discount_sic_pvt_price = $record->voucheractivity->sum('discount_sic_pvt_price');
			$total_discount = $discount_tkt + $discount_sic_pvt_price;
			
			$agentAmount = new AgentAmount();
			$agentAmount->agent_id = $record->agent_id;
			$agentAmount->amount = $grandTotal - $total_discount;
			$agentAmount->date_of_receipt = $record->booking_date;
			$agentAmount->transaction_type = "Payment";
			$agentAmount->transaction_from = 5;
			$agentAmount->role_user = 3;
			$agentAmount->created_by = Auth::user()->id;
			$agentAmount->updated_by = Auth::user()->id;
			$agentAmount->receipt_no = $record->invoice_number;
			$agentAmount->save();
			/* $receipt_no = 'A-'.date("Y")."-00".$agentAmount->id;
			$recordUser = AgentAmount::find($agentAmount->id);
			$recordUser->receipt_no = $receipt_no;
			$recordUser->save(); */
			
			foreach($voucherActivity as $vac){
			SiteHelpers::voucherActivityLog($record->id,$vac->id,$vac->discountPrice,$vac->totalprice,$record->status_main);
			}
			
			return redirect()->route('vouchers.index')->with('success', 'Voucher '.$record->code.' Invoice Successfully Updated.');
			}
			else{
				 return redirect()->back()->with('error', 'Agency amount balance not sufficient for this booking.');
			}
		}
		else{
				 return redirect()->back()->with('error', 'Agency  Name not found this voucher.');
			}
		
		}

		public function getVoucherActivityCanellation(Request $request)
		{
				$vaid = $request->input('formid');
			
				$voucherActivity = VoucherActivity::where('id',$vaid)->first();
				$variant = Variant::where('ucode', $voucherActivity->variant_code)->first();
				$cancellation = "";
				$current_date_time = time();
				$cancellation = json_decode($voucherActivity->cancellation_chart);
				$timeSlot = $voucherActivity->time_slot;
				if (!empty($timeSlot)) 
				{
					$tourDate = strtotime($voucherActivity->tour_date . ' ' . $timeSlot);
				} 
				elseif($variant->start_time != '')
				{
					$timeSlot = $variant->start_time;
					$tourDate = strtotime($voucherActivity->tour_date . $variant->start_time); // Set time to the start of the day
				}
				else 
				{
					$timeSlot = "00:00:00";
					$tourDate = strtotime($voucherActivity->tour_date . "00:00:00"); // Set time to the start of the day
				}
				$ticketDownloaded = $voucherActivity->ticket_downloaded;
				$tkt_amt = $voucherActivity->original_tkt_rate-$voucherActivity->discount_tkt;
				$trf = $voucherActivity->original_trans_rate-$voucherActivity->discount_sic_pvt_price;
				if($ticketDownloaded == '1')
				$tkt_amt = 0;
				$total_amt = $trf+$tkt_amt;
				
				$cancellation_array = array();
				if(!empty($cancellation))
				{
					foreach ($cancellation as $ar_key => $ca) 
					{	
						$ticket_refund_per = $ca->ticket_refund_value;
						$trns_refund_per = $ca->transfer_refund_value;
						
						$startHours = $endHours = 0;
						if($ca->duration =='72+')
						{
							$startHours ='72';
							$endHours = 0;
						}
						else
						{
							$durationParts = explode('-', $ca->duration);
							$startHours = intval($durationParts[0]);
							$endHours = intval($durationParts[1] ?? PHP_INT_MAX);
						}
						$tkt_refund = ($tkt_amt * $ticket_refund_per) / 100;
						
			
						$total_refund = round((($tkt_refund)+(($trf * $trns_refund_per)/ 100)),2);
						$cancellation_array[$total_refund][] = $startHours;
						if($endHours > 0)
							$cancellation_array[$total_refund][] = $endHours;
						$cancellation_array_val[$total_refund] = "1";
						
						if(($ticket_refund_per == 100) && ($trns_refund_per == 100))
							break;

					}
				}
				$rk = 0;
				$cancellation_data = array();
				krsort($cancellation_array_val);
				$free_cancel_till = "";
				foreach($cancellation_array_val as $v => $ak)
				{
					
					$k = $cancellation_array[$v];
					$startHours = intval($k[0]);
					$endHours = intval(end($k));
					if(($startHours == 0) || ($v == 0))
					{
						
						$cancellation_data[$rk]['refund_amt'] = $v;
						$cancellation_data[$rk]['start_time'] = date('M d,Y H:i',($tourDate-((($endHours)*60*60))));
						$cancellation_data[$rk]['end_time'] = "or Later";
							
						
					}
					elseif(($v == $total_amt))
					{
						$cancellation_data[$rk]['refund_amt'] = $v;
						$cancellation_data[$rk]['start_time'] = "Before of Upto";
						$cancellation_data[$rk]['end_time'] = date('M d,Y H:i',($tourDate-((($startHours)*60*60))));
						$free_cancel_till = $cancellation_data[$rk]['end_time'];
					}
					else
					{
						$cancellation_data[$rk]['start_time'] = date('M d,Y H:i',($tourDate-((($endHours)*60*60))));
						if($free_cancel_till == '')
							$cancellation_data[$rk]['start_time'] = "Before of Upto";
						$cancellation_data[$rk]['refund_amt'] = $v;
						
						$cancellation_data[$rk]['end_time'] = date('M d,Y H:i',($tourDate-((($startHours)*60*60))));
					
					}
					
					$rk++;
				}
				
				
			if(!empty($cancellation_data)){
				$response = array("status"=>1,'free_cancel_till'=>$free_cancel_till,'cancel_table'=>$cancellation_data,'cancellation'=>$cancellation,'cl'=>$cancellation_array);
			} else {
				$response = array("status"=>2,"vid"=>$vaid,'cancel_table'=>[],'cancellation'=>$cancellation,'cl'=>$cancellation_array);
			}
			
			
			return response()->json($response);
		}

		
	public function cancelHotelFromVoucher($id)
	{
		$record = VoucherHotel::find($id);
		
		//if($record->ticket_downloaded == '0'){
		$record->status = 1;
		$record->cancelled_on = Carbon::now()->toDateTimeString();
		$record->cancelled_by = Auth::user()->id;
		//$record->cancellation_time_data = json_encode($cancellation);
		$record->save();
		
		
		return redirect()->back()->with('success', 'Hotel Canceled Successfully.');
		//}
		//else{
		//return redirect()->back()->with('error', "Ticket already downloaded you can not cancel this.");		
		//}
	}
	public function voucherLog($id)
    {
		
		$voucherLogs = ReportLog::where('voucher_id',$id)->get();
		
        return view('vouchers.voucher-log', compact('voucherLogs'));
    }


	public function addQuickActivitySave(Request $request)
    {
		$tourDate = $request->input('tourDate');
		$data = [];
		if(isset($tourDate) && !empty($tourDate))
		{
			
			$voucher_id = $request->input('v_id');
			$avid = $request->input('avid');
			$voucher = Voucher::find($voucher_id);
			$activityVariant = ActivityVariant::with('variant', 'activity')->where("id",$avid)->first();
			$activity = $activityVariant->activity;
			
			$variant = $activityVariant->variant;
			$transfer_option = $request->input('transferOption');
			$tour_date = $request->input('tourDate');
			$adult = $request->input('adult');
			$child = $request->input('child');
			$infant = $request->input('infant');
			$transferCost = $request->input('transferCost');
			$ticketCost = $request->input('ticketCost');
			$total = $request->input('total');
			
			foreach($tour_date as $ik => $k)
			{
				if(!isset($ticketCost[$ik]))
					$ticketCost[$ik] = 0;
				if(!isset($transferCost[$ik]))
					$transferCost[$ik] = 0;
				$data[] = [
					'voucher_id' => $voucher_id,
					'activity_id' => $activity->id,
					'variant_unique_code' => $activityVariant->ucode,
					'variant_name' => $variant->title,
					'variant_code' => $variant->ucode,
					'activity_entry_type' => $activity->entry_type,
					'activity_product_type' => $activity->product_type,
					'variant_pvt_TFRS' => $variant->pvt_TFRS,
					'variant_pick_up_required' => $variant->pick_up_required,
					'activity_title' => $activity->title,
					'variant_zones' => $variant->zones,
					'variant_pvt_TFRS_text' => $variant->pvt_TFRS_text,
					'transfer_option' => $transfer_option[$ik],
					'tour_date' => $k,
					'adult' => $adult[$ik],
					'child' => $child[$ik],
					'infant' => $infant[$ik],
					'markup_p_ticket_only' => 0,
					'markup_p_sic_transfer' => 0,
					'markup_p_pvt_transfer' => 0,
					'adultPrice' => 0,
					'childPrice' => 0,
					'infPrice' => 0,
					'original_tkt_rate' => $transferCost[$ik],
					'original_trans_rate' => $ticketCost[$ik],
					'totalprice' => $total[$ik],
					'discountPrice' => "0",
					'created_by' => Auth::user()->id,
					'updated_by' => Auth::user()->id,
					'zone' => $voucher->zone,	
						];
			}

			
		}

		if(count($data) > 0)
			{
				VoucherActivity::insert($data);
				return redirect('vouchers')->with('success', 'Activity Added Successfully.');
			} else {
				return redirect()->back()->with('error', $variant->title.' Please Select Tour Option.');
			}
	}

	public function autocompleteActivityvariantname(Request $request)
	{
		$search  = $request->get('search');
		if (empty($search)) {
			return response()->json([]);
		}

		$activityVariants = ActivityVariant::with('activity','variant')->where('ActivityVariantName', 'LIKE', '%' . $search . '%')->where('type', 'LIKE', 'single')
						->paginate(20);

		$response = [];
		foreach ($activityVariants as $variant) {
			$response[] = [
				"value" => $variant->id,
				"label" => $variant->ActivityVariantName,
				"tkonly" => (($variant->activity->entry_type=='Limo') || ($variant->activity->entry_type=='Yacht') || ($variant->activity->entry_type=='Ticket Only'))?1:0,
				"sic" => ($variant->variant->sic_TFRS==1)?1:0,
				"pvt" => ($variant->variant->pvt_TFRS==1)?1:0,
			];
		}

		return response()->json($response);
	}
	
	public function addQuickActivityList(Request $request,$vid)
    {
		$this->checkPermissionMethod('list.voucher');
       $data = $request->all();
		$typeActivities = config("constants.typeActivities"); 
        //$perPage = config("constants.ADMIN_PAGE_LIMIT");
		$perPage = "1000";
		$voucher = Voucher::find($vid);
		$startDate = $voucher->travel_from_date;
		$endDate = $voucher->travel_to_date;
		
        return view('vouchers.activities-add-quick', compact('startDate','vid','voucher'));
		
       
    }

	public function sidebarCart($vid)
    {
		$voucher = Voucher::find($vid);
		$voucherActivity = VoucherActivity::where('voucher_id', $vid)->orderBy('tour_date','ASC')->get();
		$voucherActivityCount = $voucherActivity->count();
	
		$html = view('vouchers.cart-list', compact('vid', 'voucher', 'voucherActivity', 'voucherActivityCount'))->render();
	
		return response()->json([
			'html' => $html,
			'voucherActivityCount' => $voucherActivityCount
		]);
    }
}

	
