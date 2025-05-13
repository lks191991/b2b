<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use App\Models\User;
use App\Models\Customer;
use App\Models\Activity;
use App\Models\Vehicle;
use App\Models\ActivityPrices;
use App\Models\AgentPriceMarkup;
use App\Models\TransferData;
use Illuminate\Http\Request;
use App\Models\VoucherActivity;
use App\Models\AgentAmount;
use App\Models\Ticket;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\VariantPrice;
use App\Models\ReportLog;
use App\Models\VoucherHotel;
use DB;
use Illuminate\Support\Facades\Auth;
use SiteHelpers;
use PriceHelper;
use Carbon\Carbon;
use SPDF;
use App\Models\Variant;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LogisticReportExport;
use App\Exports\AccountsReceivablesReportExcelExport;
use App\Exports\VoucherActivityRefundExport;
use App\Exports\VoucherActivityCancelExport;
use App\Exports\TicketStockExport;
use App\Exports\AgentLedgerExport;
use App\Exports\InvoiceReportExport;
use App\Exports\ZoneReportExport;
use App\Exports\TicketOnlyReportExcelExport;
use App\Exports\MasterReportExport;
use App\Mail\ReportTicketEmailMailable;
use App\Mail\VoucheredCancelledEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Exports\VoucherHotelReportExport;
use App\Models\Zone;
//use App\Exports\AllPriceReportExport;
use App\Exports\VoucherHotelRefundedReportExport;

class ReporsController extends Controller
{
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function voucherReport(Request $request)
    {
		$this->checkPermissionMethod('list.logisticreport');
		$data = $request->all();
		$perPage = config("constants.ADMIN_PAGE_LIMIT");
		$voucherStatus = config("constants.voucherStatus");
		$twoDaysAgo = date("Y-m-d", strtotime(date("Y-m-d") . " -2 days"));
		$twoDaysNull = date("Y-m-d", strtotime(date("Y-m-d") . " +2 days"));
		$supplier_ticket = User::where("service_type",'Ticket')->orWhere('service_type','=','Both')->get();
		$supplier_transfer = User::where("service_type",'Transfer')->orWhere('service_type','=','Both')->get();
		
		$query = VoucherActivity::where('id','!=', null)->whereNotIn('status',[1,2])->where(function ($query)  {
			$query->where('transfer_option',  "Pvt Transfer")->orWhere('transfer_option',  "Shared Transfer");
		});
		
		
		
		if(isset($data['booking_type']) && !empty($data['booking_type'])) {
			
			if (isset($data['from_date']) && !empty($data['from_date']) &&  isset($data['to_date']) && !empty($data['to_date'])) {
			$startDate = $data['from_date'];
			$endDate =  $data['to_date'];
				if($data['booking_type'] == 2) {
				 $query->whereDate('tour_date', '>=', $startDate);
				 $query->whereDate('tour_date', '<=', $endDate);
				}
				elseif($data['booking_type'] == 1) {
					$query->whereHas('voucher', function($q)  use($startDate,$endDate){
				 $q->whereDate('booking_date', '>=', $startDate);
				 $q->whereDate('booking_date', '<=', $endDate);
				});
		
				}
				}
				
			}
			else{
			 $query->whereDate('tour_date', '>=', $twoDaysNull);
		}
        if(isset($data['vouchercode']) && !empty($data['vouchercode'])) {
			$query->whereHas('voucher', function($q)  use($data){
				$q->where('code', 'like', '%' . $data['vouchercode']);
			});
		}
		
		$query->whereHas('voucher', function($q)  use($data){
				$q->where('status_main', '=', 5);
			});
		if(!empty(Auth::user()->zone)){
					$query->whereHas('voucher', function($q)  use($data){
						$q->where('zone', '=', Auth::user()->zone);
					});
	   }
			$query->whereHas('voucher', function($q)  use($data){
				$q->orderBy('booking_date', 'DESC');
			});
			
        //$records = $query->orderBy('created_at', 'DESC')->paginate($perPage);
		//$records = $query->orderBy('created_at', 'DESC')->get();
		
		$vehicle_type = Vehicle::where("status",'1')->get();
		$records = $query->get();
        return view('reports.index', compact('records','voucherStatus','supplier_ticket','supplier_transfer','vehicle_type'));

    }
	
	public function voucherReportExport(Request $request)
    {
		$this->checkPermissionMethod('list.logisticreport');
        $data = $request->all();
		$perPage = config("constants.ADMIN_PAGE_LIMIT");
		$twoDaysAgo = date("Y-m-d", strtotime(date("Y-m-d") . " -2 days"));
		$twoDaysNull = date("Y-m-d", strtotime(date("Y-m-d") . " +2 days"));
		$query = VoucherActivity::with(["voucher",'activity','voucher.customer','supplierticket','suppliertransfer'])->whereNotIn('status',[1,2])->where('id','!=', null)->where(function ($query)  {
           $query->where('transfer_option',  "Pvt Transfer")->orWhere('transfer_option',  "Shared Transfer");
       });
	   
	   if(!empty(Auth::user()->zone)){
			$query->where('zone', Auth::user()->zone);
		}
		
		if(isset($data['booking_type']) && !empty($data['booking_type'])) {
			
			if (isset($data['from_date']) && !empty($data['from_date']) &&  isset($data['to_date']) && !empty($data['to_date'])) {
			$startDate = $data['from_date'];
			$endDate =  $data['to_date'];
				if($data['booking_type'] == 2) {
				 $query->whereDate('tour_date', '>=', $startDate);
				 $query->whereDate('tour_date', '<=', $endDate);
				}
				elseif($data['booking_type'] == 1) {
					$query->whereHas('voucher', function($q)  use($startDate,$endDate){
				 $q->whereDate('booking_date', '>=', $startDate);
				 $q->whereDate('booking_date', '<=', $endDate);
				});
		
				}
				}
			}
			else{
			 $query->whereDate('tour_date', '>=', $twoDaysNull);
		}
		
		if(isset($data['vouchercode']) && !empty($data['vouchercode'])) {
			$query->whereHas('voucher', function($q)  use($data){
				$q->where('code', 'like', '%' . $data['vouchercode']);
			});
		}
		
		
		$query->whereHas('voucher', function($q)  use($data){
				$q->where('status_main', '=', 5);
		});
		
        $records = $query->orderBy('created_at', 'DESC')->get();

		return Excel::download(new LogisticReportExport($records), 'logistic_records'.date('d-M-Y s').'.csv');    
    }

	public function uploadLogisticRecordCsvView()
	{
		return view('reports.csv-logistic_record_upload');
	}
	public function uploadLogisticRecordCsvSave(Request $request)
	{
		$request->validate([
			'logistic_record_upload' => 'required|mimes:csv,txt',
		]);

		$file = $request->file('logistic_record_upload');
		$csvData = file_get_contents($file);
		$rows = array_map('str_getcsv', explode("\n", $csvData));
		$header = array_shift($rows);

		foreach ($rows as $row) {
			if (isset($row[0])) { 
				$id = $row[0];
				
				$record = VoucherActivity::find($id);
				
				if ($record) {
					if (isset($row[0]) && !empty(array_filter($row))) {
					if (empty($record->supplier_transfer)) {
						// TFR Supplier code
						$tpsc = $row[22];
						$supplierTransfer = User::select("id")->where("code",$tpsc)->where("role_id",9)->first();
						if(!empty($supplierTransfer)){
							$record->supplier_transfer = $supplierTransfer->id;
						}
						
					}
					if (empty($record->actual_transfer_cost)  || $record->actual_transfer_cost == '0.00' || $record->actual_transfer_cost == '0') {
						$record->actual_transfer_cost = $row[24];
					}
					if (empty($record->supplier_transfer2)) {
						// TFR Supplier 2 code
						$tpsc2 = $row[25];
						$supplierTransfer2 = User::select("id")->where("code",$tpsc2)->where("role_id",9)->first();
						if(!empty($supplierTransfer2)){
							$record->supplier_transfer2 = $supplierTransfer2->id;
						}
						
					}
					if (empty($record->actual_transfer_cost2) || $record->actual_transfer_cost2 == '0.00'  || $record->actual_transfer_cost2 == '0') {
						$record->actual_transfer_cost2 = $row[26];
					}

					$record->save();
				}
				}
			}
		}

	return redirect()->route("voucherReport")->with('success', 'Record Updated.');
	}


	public function voucherTicketOnlyReport(Request $request)
    {
		$this->checkPermissionMethod('list.voucherTicketOnlyReport');
		$data = $request->all();
		$perPage = config("constants.ADMIN_PAGE_LIMIT");
		$voucherStatus = config("constants.voucherActivityStatus");
		$supplier_ticket = User::where("is_active",'1')->whereIn("service_type",['Ticket','Both'])->get();
		$supplier_transfer = User::where("is_active",'1')->whereIn("service_type",['Transfer','Both'])->get();
		
		$query = VoucherActivity::with("activity")
		->where('id','!=', null)
		->whereNotIn('status',[1,2]);
	   
	   
		$twoDaysAgo = date("Y-m-d", strtotime(date("Y-m-d") . " -2 days"));
		$twoDaysNull = date("Y-m-d", strtotime(date("Y-m-d") . " +2 days"));
		if(isset($data['booking_type']) && !empty($data['booking_type'])) {
			
			if (isset($data['from_date']) && !empty($data['from_date']) &&  isset($data['to_date']) && !empty($data['to_date'])) {
			$startDate = $data['from_date'];
			$endDate =  $data['to_date'];
				if($data['booking_type'] == 2) {
				 $query->whereDate('tour_date', '>=', $startDate);
				 $query->whereDate('tour_date', '<=', $endDate);
				}
				elseif($data['booking_type'] == 1) {
					$query->whereHas('voucher', function($q)  use($startDate,$endDate){
				 $q->whereDate('booking_date', '>=', $startDate);
				 $q->whereDate('booking_date', '<=', $endDate);
				});
		
				}
				}
			}
		else{
			$query->whereDate('tour_date', '>=', $twoDaysNull);
		}
		
        if(isset($data['vouchercode']) && !empty($data['vouchercode'])) {
			$query->whereHas('voucher', function($q)  use($data){
				$q->where('code', 'like', '%' . $data['vouchercode']);
			});
		}
		
		if(!empty(Auth::user()->zone)){
			$query->whereHas('voucher', function($q)  use($data){
				$q->where('zone', '=', Auth::user()->zone);
			});
		}
		
		if(isset($data['booking_status']) && !empty($data['booking_status'])) {
			$query->where('status', '=', $data['booking_status']);
		}
		
		$query->whereHas('voucher', function($q)  use($data){
				$q->where('status_main', '=', 5);
			});
			
			// $query->whereHas('voucher', function($q)  use($data){
			// 	$q->orderBy('booking_date', 'DESC');
			// });
       // $records = $query->orderBy('created_at', 'DESC')->paginate($perPage);
		$records = $query->orderBy('created_at', 'DESC')->get();
		//$records = $query->get();
        return view('reports.voucher-ticket-only-report', compact('records','voucherStatus','supplier_ticket','supplier_transfer'));

    }
	
	public function voucherTicketOnlyReportExport(Request $request)
    {
		$this->checkPermissionMethod('list.voucherTicketOnlyReport');
		$data = $request->all();
		$perPage = config("constants.ADMIN_PAGE_LIMIT");
		$voucherStatus = config("constants.voucherStatus");
		$supplier_ticket = User::where("service_type",'Ticket')->orWhere('service_type','=','Both')->get();
		$supplier_transfer = User::where("service_type",'Transfer')->orWhere('service_type','=','Both')->get();
		
		$query = VoucherActivity::with("activity")->where('id','!=', null)->whereNotIn('status',[1,2])->where('variant_type',1)->whereHas('activity', function ($query)  {
			$query->whereIn('variant_type',  ["1"]);
		});
		
		
		 $twoDaysAgo = date("Y-m-d", strtotime(date("Y-m-d") . " -2 days"));
		 $twoDaysNull = date("Y-m-d", strtotime(date("Y-m-d") . " +2 days"));
		 if(isset($data['booking_type']) && !empty($data['booking_type'])) {
			 
			 if (isset($data['from_date']) && !empty($data['from_date']) &&  isset($data['to_date']) && !empty($data['to_date'])) {
			 $startDate = $data['from_date'];
			 $endDate =  $data['to_date'];
				 if($data['booking_type'] == 2) {
				  $query->whereDate('tour_date', '>=', $startDate);
				  $query->whereDate('tour_date', '<=', $endDate);
				 }
				 elseif($data['booking_type'] == 1) {
					 $query->whereHas('voucher', function($q)  use($startDate,$endDate){
				  $q->whereDate('booking_date', '>=', $startDate);
				  $q->whereDate('booking_date', '<=', $endDate);
				 });
		 
				 }
				 }
			 }
		 else{
			 $query->whereDate('tour_date', '>=', $twoDaysNull);
		 }
		 
		 if(isset($data['vouchercode']) && !empty($data['vouchercode'])) {
			 $query->whereHas('voucher', function($q)  use($data){
				 $q->where('code', 'like', '%' . $data['vouchercode']);
			 });
		 }
		 
		 if(!empty(Auth::user()->zone)){
			 $query->whereHas('voucher', function($q)  use($data){
				 $q->where('zone', '=', Auth::user()->zone);
			 });
		 }
		 
		 if(isset($data['booking_status']) && !empty($data['booking_status'])) {
			 $query->where('status', '=', $data['booking_status']);
		 }
		 
		 $query->whereHas('voucher', function($q)  use($data){
				 $q->where('status_main', '=', 5);
			 });
			 
			
		$records = $query->orderBy('created_at', 'DESC')->get();
		return Excel::download(new TicketOnlyReportExcelExport($records), 'ticket_only_records'.date('d-M-Y s').'.csv');

    }
	
	public function voucherReportSave(Request $request)
    {
		$data = $request->all();
		
		$record = VoucherActivity::find($data['id']);
        $vid = $record->voucher_id;
		
		if(($data['inputname'] == 'status') && !empty($data['val']))
		{
			$record->{$data['inputname']} = $data['val'];
			$totalprice = 0;
			$voucher = Voucher::find($record->voucher_id);
			if(($record->supplier_ticket > 0) && ($record->actual_total_cost > 0) && ($data['val'] == '4'))
			{
				
				$totalprice = $record->actual_total_cost;
				$agentAmount = new AgentAmount();
				$agentAmount->agent_id = $record->supplier_ticket;
				$agentAmount->amount = $totalprice;
				$agentAmount->date_of_receipt = date("Y-m-d");
				$agentAmount->transaction_type = "Receipt";
				$agentAmount->transaction_from = 2;
				$agentAmount->service_name = $record->variant_name;
				$agentAmount->guest_name = $voucher->guest_name;
				$agentAmount->service_date = $record->tour_date;
				$agentAmount->status = 2;
				$agentAmount->role_user = 9;
				$agentAmount->created_by = Auth::user()->id;
				$agentAmount->updated_by = Auth::user()->id;
				$agentAmount->save();
				
				$recordUser = AgentAmount::find($agentAmount->id);
				$recordUser->receipt_no = $voucher->invoice_number;
				$recordUser->is_vat_invoice = "1";
				$recordUser->save(); 
			}
			elseif(($record->supplier_ticket > 0) && ($record->actual_total_cost > 0) && ($data['val'] == '12'))
			{
				
				$totalprice = $record->actual_total_cost;
				$agentAmount = new AgentAmount();
				$agentAmount->agent_id = $record->supplier_ticket;
				$agentAmount->amount = $totalprice;
				$agentAmount->date_of_receipt = date("Y-m-d");
				$agentAmount->transaction_type = "Payment";
				$agentAmount->transaction_from = 2;
				$agentAmount->service_name = $record->variant_name;
				$agentAmount->guest_name = $voucher->guest_name;
				$agentAmount->service_date = $record->tour_date;
				$agentAmount->status = 2;
				$agentAmount->role_user = 9;
				$agentAmount->created_by = Auth::user()->id;
				$agentAmount->updated_by = Auth::user()->id;
				$agentAmount->save();
				
				$recordUser = AgentAmount::find($agentAmount->id);
				$recordUser->receipt_no = $voucher->invoice_number;
				$recordUser->is_vat_invoice = "1";
				$recordUser->save(); 
				
			}
       		
			$response[] = array("status"=>2,'cost'=>'0');
		}
		elseif(($data['inputname'] == 'supplier_ticket') && !empty($data['val']))
		{
			$record->{$data['inputname']} = $data['val'];
			$totalprice = 0;
			$voucher = Voucher::find($record->voucher_id);
			$priceCal = SiteHelpers::getActivitySupplierCost($record->activity_id,$data['val'],$voucher,$record->variant_unique_code,$record->adult,$record->child,$record->infant,$record->discount);

			$supplier_email =  SiteHelpers::getSupplierBookingEmail($data['val']);

			$totalprice = $priceCal['totalprice'];
			$record->actual_total_cost = $totalprice;

			
       		
			$response[] = array("status"=>2,'cost'=>$totalprice,'email'=>$supplier_email,'adult'=>$priceCal['markup_p_ticket_only'],'child'=>$priceCal['markup_p_sic_transfer']);
		}
		elseif(($data['inputname'] == 'internal_remark') && !empty($data['val']))
		{
			$record->{$data['inputname']} = $data['val']." -- By ".Auth::user()->name." on ".date('M, d: H:s');
			$response[] = array("status"=>1,'cost'=>"0");
			
		} elseif (($data['inputname'] == 'discountPrice') ) {
				$discount = $data['val'];
				$totalPrice = $record->totalprice;
				if(($totalPrice > $discount)){
				$discountPrice = $record->discountPrice;
				$tpD = $discountPrice + $totalPrice;
				$record->{$data['inputname']} = $discount;
				
				$totalPrice = $tpD - $discount;

				$record->totalprice = $totalPrice;
				}
				$response[] = array("status" => 2, 'cost' => $record->totalprice);
		} elseif(($data['inputname'] == 'discount_tkt') && !empty($data['val'])) {
			$record->discount_tkt = $data['val'];
			$response[] = array("status" => 2, 'cost' => $record->totalprice);
		} elseif(($data['inputname'] == 'discount_sic_pvt_price') && !empty($data['val'])) {
			$record->discount_sic_pvt_price = $data['val'];
			$response[] = array("status" => 2, 'cost' => $record->totalprice);
		}
		else
		{
			$record->{$data['inputname']} = $data['val'];
			$response[] = array("status"=>1,'cost'=>"0");
		}
		
		
		if(isset($data['type']) && $data['type'] == 'Report')
		{
			ReportLog::create([
			"input"=>$data['inputname'],
			"input_vaue"=>$data['val'],
			"updated_by"=>Auth::user()->id,
			"report_type"=>isset($data['report_type'])?$data['report_type']:'',
			"voucher_id"=>$record->voucher_id,
			"voucher_activity_id"=>$data['id']
			]);
		}
		$record->save();
		if(($data['inputname'] == 'status') && !empty($data['val']) && ($data['val'] == '12')){
			$voucherActivity[0] = $record;
			$voucher = Voucher::select('id', 'agent_id')->find($record->voucher_id);
			$zoneUserEmails = SiteHelpers::getUserByZoneEmail($voucher->agent_id);
			$agent = User::select('id', 'email')->find($voucher->agent_id);
			Mail::to($agent->email,'Booking Cancelled.')->cc($zoneUserEmails)->bcc('payment@abaterab2b.com')->send(new VoucheredCancelledEmail($voucherActivity)); 
		}
				
		return response()->json($response);
	}

	public function voucherHotelInputSave(Request $request)
    {
		$data = $request->all();
		$record = VoucherHotel::find($data['id']);
        $record->{$data['inputname']} = $data['val'];
        $record->save();
		
		
	}
	
	public function voucherReportSaveInVoucher(Request $request)
    {
		$data = $request->all();
		$record = Voucher::find($data['id']);
        $record->{$data['inputname']} = $data['val'];
		if(($data['inputname'] == 'guest_name') OR ($data['inputname'] == 'guest_phone') OR ($data['inputname'] == 'whatsapp_group')){
        	$record->save();
		}
		$response[] = array("status"=>1);
        return response()->json($response);
	}


/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function accountsReceivablesReport(Request $request)
    {
		$this->checkPermissionMethod('list.accountsreceivables');
		 $data = $request->all();
        $perPage = config("constants.ADMIN_PAGE_LIMIT");
        $query = User::with(['country', 'state', 'city']);
		$query->where('role_id', 3);
		$query->whereColumn('agent_credit_limit','!=','agent_amount_balance');
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

        $records = $query->orderBy('created_at', 'DESC')->paginate($perPage);

        $countries = Country::where('status', 1)->orderBy('name', 'ASC')->get();
        $states = State::where('status', 1)->orderBy('name', 'ASC')->get();
        $cities = City::where('status', 1)->orderBy('name', 'ASC')->get();

		
        return view('reports.accounts-receivables-report', compact('records', 'countries', 'states', 'cities'));

    }
	
	 public function accountsReceivablesReportExcel(Request $request)
    {
		$this->checkPermissionMethod('list.accountsreceivables');
		 $data = $request->all();
        $perPage = config("constants.ADMIN_PAGE_LIMIT");
        $query = User::with(['country', 'state', 'city']);
		$query->where('role_id', 3);
		$query->whereColumn('agent_credit_limit','!=','agent_amount_balance');
       
        $records = $query->orderBy('created_at', 'DESC')->get();
		return Excel::download(new AccountsReceivablesReportExcelExport($records), 'accounts_receivables_records'.date('d-M-Y s').'.csv');

    }
	
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function agentLedgerReport(Request $request)
    {
		//$this->checkPermissionMethod('list.agent.ledger');
		$data = $request->all();
		$perPage = config("constants.ADMIN_PAGE_LIMIT");
		$voucherStatus = config("constants.voucherStatus");
		$s = 0;
		$query = AgentAmount::where('is_vat_invoice','=', '0')->where("role_user",3);
		if(Auth::user()->role_id == '3')
		{
			$query->where('agent_id', '=', Auth::user()->id);
		}
		else
		{
			if(isset($data['agent_id_select']) && !empty($data['agent_id_select'])) {
					$query->where('agent_id', '=', $data['agent_id_select']);
					$s = 1;
			}
		}
		
		if (isset($data['from_date']) && !empty($data['from_date']) &&  isset($data['to_date']) && !empty($data['to_date'])) {
			$startDate = date('Y-m-d', strtotime($data['from_date']));
			$endDate = date('Y-m-d', strtotime($data['to_date']));
			 $query->whereDate('date_of_receipt', '>=', $startDate);
			 $query->whereDate('date_of_receipt', '<=', $endDate);
		$s = 1;
			}
		if($s == 1){	
        $records = $query->orderBy('created_at', 'DESC')->paginate($perPage);
		}
		else
		{
		$records = AgentAmount::where('id','=', null)->orderBy('created_at', 'DESC')->paginate($perPage);	
		}
		$agetid = '';
		$agetName = '';
		
		if(old('agent_id')){
		$agentTBA = User::where('id', old('agent_id_select'))->where('status', 1)->first();
		$agetid = $agentTBA->id;
		$agetName = $agentTBA->company_name;
		}
        return view('reports.agent-ledger-report', compact('records','voucherStatus','agetid','agetName'));

    }
	
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function agentLedgerReportWithVat(Request $request)
    {
		$this->checkPermissionMethod('list.agent.ledger');
		$data = $request->all();
		$perPage = config("constants.ADMIN_PAGE_LIMIT");
		$voucherStatus = config("constants.voucherStatus");
		
		$s = 0;
		$openingBalance = 0;
		$agent_id = '';
		$query = AgentAmount::where("id","!=",NULL);
		$query->where("status","=","2");
		if(Auth::user()->role_id == '3')
		{
			$agent_id  = Auth::user()->id;
			$query->where('agent_id', '=', Auth::user()->id);
		}
		else
		{
			if(isset($data['agent_id_select']) && !empty($data['agent_id_select'])) {
				$agent_id  = $data['agent_id_select'];
					$query->where('agent_id', '=', $data['agent_id_select']);
					$s = 1;
			}
		}
		
		if (isset($data['from_date']) && !empty($data['from_date']) &&  isset($data['to_date']) && !empty($data['to_date'])) 
		{
			$startDate = date('Y-m-d', strtotime($data['from_date']));
			$endDate = date('Y-m-d', strtotime($data['to_date']));
			if(Auth::user()->role_id == '3'){
			$query->whereDate('date_of_receipt', '>=', $startDate);
			$query->whereDate('date_of_receipt', '<=', $endDate);
			}
			else{
				if($data['booking_type'] == 2) {
				$query->whereDate('service_date', '>=', $startDate);
				$query->whereDate('service_date', '<=', $endDate);
			   }
			   elseif($data['booking_type'] == 1) {
				$query->whereDate('date_of_receipt', '>=', $startDate);
				$query->whereDate('date_of_receipt', '<=', $endDate);
			   }
			}

			$s = 1;
			if($agent_id!='')
			{
				$payment = AgentAmount::where('agent_id',  $agent_id)->where('status',"2")->whereDate('date_of_receipt', '<', $startDate)->where("transaction_type","Payment")->sum('amount');
				$receipt = AgentAmount::where('agent_id',  $agent_id)->where('status',"2")->whereDate('date_of_receipt', '<', $startDate)->where("transaction_type","Receipt")->sum('amount');
				$openingBalance = $receipt - $payment;
			} 
			else 
			{
				
				$payment = AgentAmount::where('agent_id',  $agent_id)->where('status',"2")->whereDate('date_of_receipt', '<', $startDate)->where("transaction_type","Payment")->sum('amount');
				$receipt = AgentAmount::where('agent_id',  $agent_id)->where('status',"2")->whereDate('date_of_receipt', '<', $startDate)->where("transaction_type","Receipt")->sum('amount');
				$openingBalance = $receipt - $payment;
			}
		
		}
		$openingBalance = number_format($openingBalance,2, '.', '');
		if($s == 1)
		{	
        $records = $query->orderBy('created_at', 'DESC')->get();
		}
		else
		{
		$records = AgentAmount::where('id','=', null)->orderBy('created_at', 'DESC')->get();	
		}
		$agetid = '';
		$agetName = '';
		$agent_role_id = "";
		if($agent_id > 0)
		{
			$agentTBA = User::where('id',$agent_id)->first();
			$agetid = $agentTBA->id;
			$agetName = $agentTBA->company_name;
			$agent_role_id = $agentTBA->role_id;
		}
		
		if(Auth::user()->role_id == '3')
		{
        return view('reports.agent-with-vat-ledger-report', compact('records','voucherStatus','agetid','agetName','openingBalance','data'));
		} else {
		 return view('reports.agent-with-vat-ledger-report-forAdmin', compact('records','voucherStatus','agetid','agetName','openingBalance','data','agent_role_id'));	
		}

    }
	
	 public function agentLedgerReportWithVatExportExcel(Request $request)
    {
		$this->checkPermissionMethod('list.agent.ledger');
		$data = $request->all();
		$perPage = config("constants.ADMIN_PAGE_LIMIT");
		$voucherStatus = config("constants.voucherStatus");
		
		
		
		$s = 0;
		$openingBalance = 0;
		$agent_id = '';
		$query = AgentAmount::where("id","!=",NULL);
		$query->where("status","=","2");
		if(Auth::user()->role_id == '3')
		{
			$agent_id  = Auth::user()->id;
			$query->where('agent_id', '=', Auth::user()->id);
		}
		else
		{
			if(isset($data['agent_id_select']) && !empty($data['agent_id_select'])) {
				$agent_id  = $data['agent_id_select'];
					$query->where('agent_id', '=', $data['agent_id_select']);
					$s = 1;
			}
		}
		
		if (isset($data['from_date']) && !empty($data['from_date']) &&  isset($data['to_date']) && !empty($data['to_date'])) {
			$startDate = date('Y-m-d', strtotime($data['from_date']));
			$endDate = date('Y-m-d', strtotime($data['to_date']));
			 $query->whereDate('date_of_receipt', '>=', $startDate);
			 $query->whereDate('date_of_receipt', '<=', $endDate);
		$s = 1;
		if($agent_id!=''){
		$payment = AgentAmount::where('agent_id',  $agent_id)->where('status',"2")->whereDate('date_of_receipt', '<', $startDate)->where("transaction_type","Payment")->sum('amount');
		$receipt = AgentAmount::where('agent_id',  $agent_id)->where('status',"2")->whereDate('date_of_receipt', '<', $startDate)->where("transaction_type","Receipt")->sum('amount');
		$openingBalance = $receipt - $payment;
		} else {
			$payment = AgentAmount::where('agent_id',  $agent_id)->where('status',"2")->whereDate('date_of_receipt', '<', $startDate)->where("transaction_type","Payment")->sum('amount');
		$receipt = AgentAmount::where('agent_id',  $agent_id)->where('status',"2")->whereDate('date_of_receipt', '<', $startDate)->where("transaction_type","Receipt")->sum('amount');
		$openingBalance = $receipt - $payment;
		}
	
		}
		
		$openingBalance = number_format($openingBalance,2, '.', '');
		
		if($s == 1){	
        $records = $query->orderBy('created_at', 'DESC')->get();
		}
		else
		{
		$records = AgentAmount::where('id','=', null)->orderBy('created_at', 'DESC')->get();	
		}
		
		return Excel::download(new AgentLedgerExport($records,$openingBalance), 'agent_ledger_export_records'.date('d-M-Y s').'.csv');

    }
	
	public function voucherActivtyCancelRequestReport(Request $request)
    {
		$this->checkPermissionMethod('list.ActivityCancelRequestReport');
		$data = $request->all();
		$perPage = config("constants.ADMIN_PAGE_LIMIT");
		$voucherStatus = config("constants.voucherStatus");
		$supplier_ticket = User::where("service_type",'Ticket')->orWhere('service_type','=','Both')->get();
		$supplier_transfer = User::where("service_type",'Transfer')->orWhere('service_type','=','Both')->get();
		
		$query = VoucherActivity::where('id','!=', null);
		
		if(isset($data['booking_type']) && !empty($data['booking_type'])) {
			
			if (isset($data['from_date']) && !empty($data['from_date']) &&  isset($data['to_date']) && !empty($data['to_date'])) {
			$startDate = $data['from_date'];
			$endDate =  $data['to_date'];
				if($data['booking_type'] == 2) {
				 $query->whereDate('tour_date', '>=', $startDate);
				 $query->whereDate('tour_date', '<=', $endDate);
				}
				elseif($data['booking_type'] == 1) {
				 $query->where('canceled_date', '>=', $startDate);
				 $query->where('canceled_date', '<=', $endDate);
				}
				}
			}
        if(isset($data['reference']) && !empty($data['reference'])) {
			$query->whereHas('voucher', function($q)  use($data){
				$q->where('code', 'like', '%' . $data['reference'] . '%');
			});

		}
		if(!empty(Auth::user()->zone)){
			$query->whereHas('voucher', function($q)  use($data){
				$q->where('zone', '=', Auth::user()->zone);
			});
}
		$query->whereIN('status',[1,11]);
			
        $records = $query->orderBy('created_at', 'DESC')->paginate($perPage);
		
        return view('reports.activity-canceled-requested-report', compact('records','voucherStatus','supplier_ticket','supplier_transfer'));

    }

	public function voucherActivtyCanceledReport(Request $request)
    {
		$this->checkPermissionMethod('list.ActivityCanceledReport');
		$data = $request->all();
		$perPage = config("constants.ADMIN_PAGE_LIMIT");
		$voucherStatus = config("constants.voucherStatus");
		$supplier_ticket = User::where("service_type",'Ticket')->orWhere('service_type','=','Both')->get();
		$supplier_transfer = User::where("service_type",'Transfer')->orWhere('service_type','=','Both')->get();
		
		$query = VoucherActivity::where('id','!=', null);
		
		if(isset($data['booking_type']) && !empty($data['booking_type'])) {
			
			if (isset($data['from_date']) && !empty($data['from_date']) &&  isset($data['to_date']) && !empty($data['to_date'])) {
			$startDate = $data['from_date'];
			$endDate =  $data['to_date'];
				if($data['booking_type'] == 2) {
				 $query->whereDate('tour_date', '>=', $startDate);
				 $query->whereDate('tour_date', '<=', $endDate);
				}
				elseif($data['booking_type'] == 1) {
				 $query->where('canceled_date', '>=', $startDate);
				 $query->where('canceled_date', '<=', $endDate);
				}
				}
			}
        if(isset($data['reference']) && !empty($data['reference'])) {
			$query->whereHas('voucher', function($q)  use($data){
				$q->where('code', 'like', '%' . $data['reference'] . '%');
			});
		}
		if(!empty(Auth::user()->zone)){
			$query->whereHas('voucher', function($q)  use($data){
				$q->where('zone', '=', Auth::user()->zone);
			});
}
		$query->where('status', '=', 12);
			
        $records = $query->orderBy('created_at', 'DESC')->paginate($perPage);
		
        return view('reports.activity-canceled-report', compact('records','voucherStatus','supplier_ticket','supplier_transfer'));

    }
	
	public function voucherActivtyCanceledReportExportExcel(Request $request)
    {
		$this->checkPermissionMethod('list.ActivityCanceledReport');
		$data = $request->all();
		$perPage = config("constants.ADMIN_PAGE_LIMIT");
		$voucherStatus = config("constants.voucherStatus");
		
		$query = VoucherActivity::where('id','!=', null);
		
		if(isset($data['booking_type']) && !empty($data['booking_type'])) {
			
			if (isset($data['from_date']) && !empty($data['from_date']) &&  isset($data['to_date']) && !empty($data['to_date'])) {
			$startDate = $data['from_date'];
			$endDate =  $data['to_date'];
				if($data['booking_type'] == 2) {
				 $query->whereDate('tour_date', '>=', $startDate);
				 $query->whereDate('tour_date', '<=', $endDate);
				}
				elseif($data['booking_type'] == 1) {
				 $query->where('canceled_date', '>=', $startDate);
				 $query->where('canceled_date', '<=', $endDate);
				}
				}
			}
        if(isset($data['reference']) && !empty($data['reference'])) {
			$query->whereHas('voucher', function($q)  use($data){
				$q->where('code', 'like', '%' . $data['reference'] . '%');
			});
		}
		if(!empty(Auth::user()->zone)){
			$query->whereHas('voucher', function($q)  use($data){
				$q->where('zone', '=', Auth::user()->zone);
			});
}
		$query->where('status', '=', 12);
			
        $records = $query->orderBy('created_at', 'DESC')->get();
       return Excel::download(new VoucherActivityCancelExport($records), 'voucher_activity_cancel_records'.date('d-M-Y s').'.csv');

    }
	
	public function activityRefundSave(Request $request)
    {
		$data = $request->all();
		
		$totalPrice = 0;
		$tkt = 0;
		$record = VoucherActivity::where("id",$data['id'])->where('status', '=', 12)->first();
		$price = PriceHelper::getRefundAmountAfterCancellation($record->id);
		$tktPrice = $price['refund_tkt_priceAfDis'];
		$trnsPrice = $price['refund_trns_priceAfDis'];
		if($data['inputname'] == 'refund_amount_tkt'){
			$totalPrice = $tktPrice;
			$tkt = 1;
		} elseif($data['inputname'] == 'refund_amount_trans'){
			$totalPrice = $trnsPrice;
			$tkt = 2;
		}
		
		/* if($data['val'] <= $totalPrice){ */
				if(!empty($record)){
				if($tkt==1){
					$record->refund_amount_tkt = $data['val'];
				} elseif($tkt==2){
					$record->refund_amount_trans = $data['val'];
				}
				
				
				$record->refund_by = Auth::user()->id;
				$record->save();
				$response[] = array("status"=>1);
			
			/* }
			else{
			$response[] = array("status"=>3);
			} */
			
		}
		else{
			$response[] = array("status"=>4);
		}
		
        return response()->json($response);
	}
	
	public function activityFinalRefundSave(Request $request)
    {
		$data = $request->all();
		$id = $data['id'];
		$tktPrice = $data['trans'];
		$trnsPrice = $data['tkt'];
		$totalPrice = 0;
		$tkt = 0;
		$record = VoucherActivity::where("id",$id)->where('status', '=', 12)->first();
		
		
		
			if(!empty($record)){
			$record->status = 2;
			$record->refund_amount_tkt = $tktPrice;
			$record->refund_amount_trans = $trnsPrice;
			$record->refund_by = Auth::user()->id;
			$record->save();
			
			$totalPrice = $tktPrice + $trnsPrice;
			$voucher = Voucher::where('id',$record->voucher_id)->select(['agent_id','vat_invoice','invoice_number'])->first();
			$agent = User::find($voucher->agent_id);
			if(!empty($agent))
			{
				if($totalPrice > 0)
				{
					$agent->agent_amount_balance += $totalPrice;
					$agent->save();
					
					$agentAmount = new AgentAmount();
					$agentAmount->agent_id = $agent->id;
					$agentAmount->amount = $totalPrice;
					$agentAmount->date_of_receipt = date("Y-m-d");
					$agentAmount->transaction_type = "Receipt";
					$agentAmount->role_user = 3;
					$agentAmount->status = 2;
					$agentAmount->transaction_from = 4;
					$agentAmount->created_by = Auth::user()->id;
					$agentAmount->updated_by = Auth::user()->id;
					$agentAmount->receipt_no = $voucher->invoice_number;
					$agentAmount->is_vat_invoice = $voucher->vat_invoice;
					$agentAmount->save();
				}
				
				return redirect()->back()->with('success', 'Activity Canceled Successfully Refund Amount '.$totalPrice);
			}else{
			return redirect()->back()->with('error', 'Agent Not Found.');
			}
			
			}
			else{
			return redirect()->back()->with('error', 'Voucher Not Found.');
			}
			
		
        return response()->json($response);
	}
	

public function voucherActivtyRefundedReport(Request $request)
    {
		$this->checkPermissionMethod('list.ActivityRefundReport');
		$data = $request->all();
		$perPage = config("constants.ADMIN_PAGE_LIMIT");
		$voucherStatus = config("constants.voucherStatus");
		$supplier_ticket = User::where("service_type",'Ticket')->orWhere('service_type','=','Both')->get();
		$supplier_transfer = User::where("service_type",'Transfer')->orWhere('service_type','=','Both')->get();
		
		$query = VoucherActivity::where('id','!=', null);
		
		if(isset($data['booking_type']) && !empty($data['booking_type'])) {
			
			if (isset($data['from_date']) && !empty($data['from_date']) &&  isset($data['to_date']) && !empty($data['to_date'])) {
			$startDate = $data['from_date'];
			$endDate =  $data['to_date'];
				if($data['booking_type'] == 2) {
				 $query->whereDate('tour_date', '>=', $startDate);
				 $query->whereDate('tour_date', '<=', $endDate);
				}
				elseif($data['booking_type'] == 1) {
				 $query->where('canceled_date', '>=', $startDate);
				 $query->where('canceled_date', '<=', $endDate);
				}
				}
			}
        if(isset($data['reference']) && !empty($data['reference'])) {
			$query->whereHas('voucher', function($q)  use($data){
				$q->where('code', 'like', '%' . $data['reference'] . '%');
			});
		}
		
		$query->where('status', '=', 2);
			
        $records = $query->orderBy('created_at', 'DESC')->paginate($perPage);
		
        return view('reports.activity-refunded-report', compact('records','voucherStatus','supplier_ticket','supplier_transfer'));

    }
	
	public function voucherActivtyRefundedReportExportExcel(Request $request)
    {
		$this->checkPermissionMethod('list.ActivityRefundReport');
		$data = $request->all();
		$perPage = config("constants.ADMIN_PAGE_LIMIT");
		$voucherStatus = config("constants.voucherStatus");
		
		$query = VoucherActivity::where('id','!=', null);
		
		if(isset($data['booking_type']) && !empty($data['booking_type'])) {
			
			if (isset($data['from_date']) && !empty($data['from_date']) &&  isset($data['to_date']) && !empty($data['to_date'])) {
			$startDate = $data['from_date'];
			$endDate =  $data['to_date'];
				if($data['booking_type'] == 2) {
				 $query->whereDate('tour_date', '>=', $startDate);
				 $query->whereDate('tour_date', '<=', $endDate);
				}
				elseif($data['booking_type'] == 1) {
				 $query->where('canceled_date', '>=', $startDate);
				 $query->where('canceled_date', '<=', $endDate);
				}
				}
			}
        if(isset($data['reference']) && !empty($data['reference'])) {
			$query->whereHas('voucher', function($q)  use($data){
				$q->where('code', 'like', '%' . $data['reference'] . '%');
			});
		}
		
		$query->where('status', '=', 2);
			
        $records = $query->orderBy('created_at', 'DESC')->get();
       return Excel::download(new VoucherActivityRefundExport($records), 'voucher_activity_refund_records'.date('d-M-Y s').'.csv');

    }
	
	public function ticketStockReport(Request $request)
    {
		$this->checkPermissionMethod('list.TicketStockReport');
		$data = $request->all();
		$perPage = config("constants.ADMIN_PAGE_LIMIT");
		$activities = Activity::where('status', 1)->orderBy('title', 'ASC')->get();
		$variants = Variant::where('status', 1)->orderBy('title', 'ASC')->get();
		$query = Ticket::with(['variant'])
            ->select(
                'activity_variant',
                'valid_till',
                DB::raw('SUM(CASE WHEN id != "0" AND ticket_for = "Adult" THEN 1 ELSE 0 END) as stock_uploaded_adult'),
                DB::raw('SUM(CASE WHEN id != "0" AND ticket_for = "Child" THEN 1 ELSE 0 END) as stock_uploaded_child'),
				DB::raw('SUM(CASE WHEN id != "0" AND ticket_for = "Both" THEN 1 ELSE 0 END) as stock_uploaded_both'),
                DB::raw('SUM(CASE WHEN ticket_generated = "1" AND ticket_for = "Adult" THEN 1 ELSE 0 END) as stock_allotted_adult'),
                DB::raw('SUM(CASE WHEN ticket_generated = "1" AND ticket_for = "Child" THEN 1 ELSE 0 END) as stock_allotted_child'),
				DB::raw('SUM(CASE WHEN ticket_generated = "1" AND ticket_for = "Both" THEN 1 ELSE 0 END) as stock_allotted_both'),
                DB::raw('SUM(CASE WHEN ticket_generated = "0" AND ticket_for = "Adult" THEN 1 ELSE 0 END) as stock_left_adult'),
                DB::raw('SUM(CASE WHEN ticket_generated = "0" AND ticket_for = "Child" THEN 1 ELSE 0 END) as stock_left_child'),
				DB::raw('SUM(CASE WHEN ticket_generated = "0" AND ticket_for = "Both" THEN 1 ELSE 0 END) as stock_left_both')
            );
		if (isset($data['from_date']) && !empty($data['from_date']) &&  isset($data['to_date']) && !empty($data['to_date'])) {
			$startDate = date("Y-m-d",strtotime($data['from_date']));
			$endDate =  date("Y-m-d",strtotime($data['to_date']));
				 $query->whereDate('valid_till', '>=', $startDate);
				 $query->whereDate('valid_till', '<=', $endDate);
		}
		
		if(isset($data['ticket_no']) && !empty($data['ticket_no'])) {
				$query->where('ticket_no', 'like', '%' . $data['ticket_no']);
		}

		if(isset($data['serial_number']) && !empty($data['serial_number'])) {
			$query->where('serial_number', 'like', '%' . $data['serial_number']);
	}

		
		if (isset($data['activity_variant']) && !empty($data['activity_variant'])) {
				 $query->where('activity_variant',  $data['activity_variant']);
		}
				
            $query->groupBy('activity_variant', 'valid_till');
           $records = $query->paginate($perPage);
			
		 
	
		return view('reports.ticket-report', compact('records','variants'));
	}
	
	public function ticketStockReportExportExcel(Request $request)
    {
		$data = $request->all();
		$perPage = config("constants.ADMIN_PAGE_LIMIT");
		$variants = Variant::where('status', 1)->orderBy('title', 'ASC')->get();
		$query = Ticket::with(['variant'])
            ->select(
                'activity_variant',
                'valid_till',
                DB::raw('SUM(CASE WHEN id != "0" AND ticket_for = "Adult" THEN 1 ELSE 0 END) as stock_uploaded_adult'),
                DB::raw('SUM(CASE WHEN id != "0" AND ticket_for = "Child" THEN 1 ELSE 0 END) as stock_uploaded_child'),
				DB::raw('SUM(CASE WHEN id != "0" AND ticket_for = "Both" THEN 1 ELSE 0 END) as stock_uploaded_both'),
                DB::raw('SUM(CASE WHEN ticket_generated = "1" AND ticket_for = "Adult" THEN 1 ELSE 0 END) as stock_allotted_adult'),
                DB::raw('SUM(CASE WHEN ticket_generated = "1" AND ticket_for = "Child" THEN 1 ELSE 0 END) as stock_allotted_child'),
				DB::raw('SUM(CASE WHEN ticket_generated = "1" AND ticket_for = "Both" THEN 1 ELSE 0 END) as stock_allotted_both'),
                DB::raw('SUM(CASE WHEN ticket_generated = "0" AND ticket_for = "Adult" THEN 1 ELSE 0 END) as stock_left_adult'),
                DB::raw('SUM(CASE WHEN ticket_generated = "0" AND ticket_for = "Child" THEN 1 ELSE 0 END) as stock_left_child'),
				DB::raw('SUM(CASE WHEN ticket_generated = "0" AND ticket_for = "Both" THEN 1 ELSE 0 END) as stock_left_both')
            );
		if (isset($data['from_date']) && !empty($data['from_date']) &&  isset($data['to_date']) && !empty($data['to_date'])) {
			$startDate = date("Y-m-d",strtotime($data['from_date']));
			$endDate =  date("Y-m-d",strtotime($data['to_date']));
				 $query->whereDate('valid_till', '>=', $startDate);
				 $query->whereDate('valid_till', '<=', $endDate);
		}
		
		if (isset($data['activity_id']) && !empty($data['activity_id'])) {
				 $query->where('activity_id',  $data['activity_id']);
		}
		
		if (isset($data['activity_variant']) && !empty($data['activity_variant'])) {
				 $query->where('activity_variant',  $data['activity_variant']);
		}
				
            $query->groupBy('activity_variant', 'valid_till');
           $records = $query->get();
			
		
	 return Excel::download(new TicketStockExport($records), 'ticket_stock_records'.date('d-M-Y s').'.csv');
	}
   
   
   public function voucherActivityReport(Request $request)
    {
		$this->checkPermissionMethod('list.voucherActivityReport');
		$data = $request->all();
		//$perPage = config("constants.ADMIN_PAGE_LIMIT");
		$perPage = "1000";
		$voucherStatus = config("constants.voucherStatus");
		$voucherAStatus = config("constants.voucherActivityStatus");
		$supplier_ticket = User::where("service_type",'Ticket')->orWhere('service_type','=','Both')->get();
		$supplier_transfer = User::where("service_type",'Transfer')->orWhere('service_type','=','Both')->get();
		
		$query = VoucherActivity::where('id','!=', null);
		
		if(isset($data['booking_type']) && !empty($data['booking_type'])) {
			
			if (isset($data['from_date']) && !empty($data['from_date']) &&  isset($data['to_date']) && !empty($data['to_date'])) {
			$startDate = $data['from_date'];
			$endDate =  $data['to_date'];
				if($data['booking_type'] == 2) {
				 $query->whereDate('tour_date', '>=', $startDate);
				 $query->whereDate('tour_date', '<=', $endDate);
				}
				elseif($data['booking_type'] == 1) {
					$query->whereHas('voucher', function($q)  use($startDate,$endDate){
				 $q->whereDate('booking_date', '>=', $startDate);
				 $q->whereDate('booking_date', '<=', $endDate);
				});
		
				}
				elseif($data['booking_type'] == 3) 
				{
					$query->whereHas('voucher', function($q)  use($startDate,$endDate){
					$q->whereDate('created_at', '>=', $startDate);
					$q->whereDate('created_at', '<=', $endDate);
					});
		
				}
				}
			}
			if(!empty(Auth::user()->zone)){
				$query->whereHas('voucher', function($q)  use($data){
					$q->where('zone', '=', Auth::user()->zone);
				});
   }
        if(isset($data['vouchercode']) && !empty($data['vouchercode'])) {
			$query->whereHas('voucher', function($q)  use($data){
				$q->where('code', 'like', '%' . $data['vouchercode']);
			});
		}
		if(isset($data['invoicecode']) && !empty($data['invoicecode'])) {
			$query->whereHas('voucher', function($q)  use($data){
				$q->where('invoice_number', 'like', '%' . $data['invoicecode']);
			});
		}
		if(isset($data['booking_status']) && !empty($data['booking_status'])) {
		$query->whereHas('voucher', function($q) use ($data) {
			$statuses = is_array($data['booking_status']) ? $data['booking_status'] : [$data['booking_status']];
				$q->whereIn('status_main', $statuses);
		});
		}else {
			$query->whereHas('voucher', function($q)  use($data){
				$q->where('status_main','5');
			});
		}
		$agent_id = '';
		if(isset($data['agent_id_select']) && !empty($data['agent_id_select'])) {
			$query->whereHas('voucher', function($q)  use($data){
				$agent_id  = $data['agent_id_select'];
				$q->where('agent_id', '=', $data['agent_id_select']);
			});
		}
		
        $records = $query->orderBy('created_at', 'DESC')->paginate($perPage);
		//$records = $query->orderBy('created_at', 'DESC')->get();
		$agetid = '';
		$agetName = '';
		
		if(old('agent_id')){
		$agentTBA = User::where('id', old('agent_id_select'))->where('status', 1)->first();
		$agetid = $agentTBA->id;
		$agetName = $agentTBA->company_name;
		}
		
        return view('reports.invoice-report', compact('records','voucherStatus','voucherAStatus','supplier_ticket','supplier_transfer','agetid','agetName'));

    }
	
	 public function voucherActivityReportExcelReport(Request $request)
    {
		$this->checkPermissionMethod('list.voucherActivityReport');
		$data = $request->all();
		$perPage = config("constants.ADMIN_PAGE_LIMIT");
		$voucherStatus = config("constants.voucherStatus");
		$supplier_ticket = User::where("service_type",'Ticket')->orWhere('service_type','=','Both')->get();
		$supplier_transfer = User::where("service_type",'Transfer')->orWhere('service_type','=','Both')->get();
		
		$query = VoucherActivity::where('id','!=', null);
		
		if(isset($data['booking_type']) && !empty($data['booking_type'])) {
			
			if (isset($data['from_date']) && !empty($data['from_date']) &&  isset($data['to_date']) && !empty($data['to_date'])) {
			$startDate = $data['from_date'];
			$endDate =  $data['to_date'];
				if($data['booking_type'] == 2) {
				 $query->whereDate('tour_date', '>=', $startDate);
				 $query->whereDate('tour_date', '<=', $endDate);
				}
				elseif($data['booking_type'] == 1) {
					$query->whereHas('voucher', function($q)  use($startDate,$endDate){
				 $q->whereDate('booking_date', '>=', $startDate);
				 $q->whereDate('booking_date', '<=', $endDate);
				});
		
				}
				elseif($data['booking_type'] == 3) 
				{
					$query->whereHas('voucher', function($q)  use($startDate,$endDate){
					$q->whereDate('created_at', '>=', $startDate);
					$q->whereDate('created_at', '<=', $endDate);
					});
		
				}
				}
			}
			if(!empty(Auth::user()->zone)){
				$query->whereHas('voucher', function($q)  use($data){
					$q->where('zone', '=', Auth::user()->zone);
				});
   }
			if(isset($data['vouchercode']) && !empty($data['vouchercode'])) {
				$query->whereHas('voucher', function($q)  use($data){
					$q->where('code', 'like', '%' . $data['vouchercode']);
				});
			}
			if(isset($data['invoicecode']) && !empty($data['invoicecode'])) {
				$query->whereHas('voucher', function($q)  use($data){
					$q->where('invoice_number', 'like', '%' . $data['invoicecode']);
				});
			}
		if(isset($data['booking_status']) && !empty($data['booking_status'])) {
		$query->whereHas('voucher', function($q) use ($data) {
			$statuses = is_array($data['booking_status']) ? $data['booking_status'] : [$data['booking_status']];
				$q->whereIn('status_main', $statuses);
		});
		}else {
			$query->whereHas('voucher', function($q)  use($data){
				$q->where('status_main','5');
			});
		}
		if(isset($data['agent_id_select']) && !empty($data['agent_id_select'])) {
			$query->whereHas('voucher', function($q)  use($data){
				$agent_id  = $data['agent_id_select'];
				$q->where('agent_id', '=', $data['agent_id_select']);
			});
		}
		$records = $query->orderBy('created_at', 'DESC')->get();
		return Excel::download(new InvoiceReportExport($records), 'invoice_report'.date('d-M-Y s').'.csv');

    }
	
	
	public function voucherHotelReport(Request $request)
    {
		$this->checkPermissionMethod('list.voucherHotelReport');
		$data = $request->all();
		$perPage = config("constants.ADMIN_PAGE_LIMIT");
		$twoDaysAgo = date("Y-m-d", strtotime(date("Y-m-d") . " -2 days"));
		$zones = config("constants.agentZone");
		$voucherStatus = config("constants.voucherStatus");
		$query = VoucherHotel::where('id','!=', null);
		$supplier_hotel = User::where("service_type",'Hotel')->get();

		if(isset($data['vouchercode']) && !empty($data['vouchercode'])) {
			$query->whereHas('voucher', function($q)  use($data){
				$q->where('code', 'like', '%' . $data['vouchercode']);
			});
		}
		if(isset($data['invoicecode']) && !empty($data['invoicecode'])) {
			$query->whereHas('voucher', function($q)  use($data){
				$q->where('invoice_number', 'like', '%' . $data['invoicecode']);
			});
		}

		if(isset($data['zone']) && !empty($data['zone'])) {
			$query->whereHas('voucher', function($q)  use($data){
				$q->where('zone', $data['zone']);
			});
		}

		if(isset($data['booking_type']) && !empty($data['booking_type'])) {
			
			if (isset($data['from_date']) && !empty($data['from_date']) &&  isset($data['to_date']) && !empty($data['to_date'])) {
			$startDate = $data['from_date'];
			$endDate =  $data['to_date'];
				if($data['booking_type'] == 2) {
				 $query->whereDate('check_in_date', '>=', $startDate);
				 $query->whereDate('check_in_date', '<=', $endDate);
				}
				elseif($data['booking_type'] == 1) {
					$query->whereHas('voucher', function($q)  use($startDate,$endDate){
				 $q->whereDate('booking_date', '>=', $startDate);
				 $q->whereDate('booking_date', '<=', $endDate);
				});
		
				}
				}
			}
			else
			{
				$query->whereDate('check_in_date', '>=', $twoDaysAgo);
			}

			$query->whereHas('voucher', function($q)  use($data,$twoDaysAgo){
				$q->whereIn('status_main',[4,5,6]);
				$q->orderBy('booking_date', 'DESC');
			});
			if(isset($data['voucher_status']) && !empty($data['voucher_status'])) {
				$query->whereHas('voucher', function($q)  use($data){
					$q->where('status_main', $data['voucher_status']);
				});
			}

			if(!empty(Auth::user()->zone)){
				$query->whereHas('voucher', function($q)  use($data){
					$q->where('zone', '=', Auth::user()->zone);
				});
	}
		
		$records = $query->get();
        return view('reports.voucher_hotel_report', compact('records','supplier_hotel','zones','voucherStatus'));

    }


	public function voucherHotelReportExport(Request $request)
    {
		$this->checkPermissionMethod('list.voucherHotelReport');
		$data = $request->all();
		$perPage = config("constants.ADMIN_PAGE_LIMIT");
		$twoDaysAgo = date("Y-m-d", strtotime(date("Y-m-d") . " -2 days"));
		
		$query = VoucherHotel::where('id','!=', null);
		$supplier_hotel = User::where("service_type",'Hotel')->get();

		
		if(isset($data['vouchercode']) && !empty($data['vouchercode'])) {
			$query->whereHas('voucher', function($q)  use($data){
				$q->where('code', 'like', '%' . $data['vouchercode']);
			});
		}
		if(isset($data['invoicecode']) && !empty($data['invoicecode'])) {
			$query->whereHas('voucher', function($q)  use($data){
				$q->where('invoice_number', 'like', '%' . $data['invoicecode']);
			});
		}

		if(isset($data['zone']) && !empty($data['zone'])) {
			$query->whereHas('voucher', function($q)  use($data){
				$q->where('zone', $data['zone']);
			});
		}

		if(isset($data['booking_type']) && !empty($data['booking_type'])) {
			
			if (isset($data['from_date']) && !empty($data['from_date']) &&  isset($data['to_date']) && !empty($data['to_date'])) {
			$startDate = $data['from_date'];
			$endDate =  $data['to_date'];
				if($data['booking_type'] == 2) {
				 $query->whereDate('check_in_date', '>=', $startDate);
				 $query->whereDate('check_in_date', '<=', $endDate);
				}
				elseif($data['booking_type'] == 1) {
					$query->whereHas('voucher', function($q)  use($startDate,$endDate){
				 $q->whereDate('booking_date', '>=', $startDate);
				 $q->whereDate('booking_date', '<=', $endDate);
				});
		
				}
				}
			}
			else
			{
				$query->whereDate('check_in_date', '>=', $twoDaysAgo);
			}

			$query->whereHas('voucher', function($q)  use($data,$twoDaysAgo){
				$q->whereIn('status_main',[4,5]);
				$q->orderBy('booking_date', 'DESC');
			});

			
			if(isset($data['voucher_status']) && !empty($data['voucher_status'])) {
				$query->whereHas('voucher', function($q)  use($data){
					$q->where('status_main', $data['voucher_status']);
				});
			}
		$records = $query->get();
		
		return Excel::download(new VoucherHotelReportExport($records), 'hotel_report'.date('d-M-Y s').'.csv');

    }
	
	public function reportEmailSend(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'email_to' => 'required|email',
			'email_subject' => 'required|max:255',
			'email_body' => 'required',
		]);

		if ($validator->fails()) {
			return response()->json([
				'status' => 0,
				'errors' => $validator->errors()
			], 422);
		}

		$data = $request->all();
		$emailTo = $data['email_to'];
		$emailSubject = $data['email_subject'];
		$emailCc = ['Bookings@abaterab2b.com', 'Accounts@abatera.com', 'Accounts1@abatera.com'];

		Mail::to($emailTo)->cc($emailCc)->send(new ReportTicketEmailMailable($data));

		return response()->json([
			'status' => 1,
			'message' => 'Email Sent Successfully'
		]);
	}
	public function masterReport(Request $request)
    {
		$this->checkPermissionMethod('list.masterreport');
		$data = $request->all();
		$filter = 0;
		$perPage = config("constants.ADMIN_PAGE_LIMIT");
		$voucherActivityStatus = config("constants.voucherActivityStatus");
		$voucherStatus = config("constants.voucherStatus");
		$zones = config("constants.agentZone");
		$twoDaysAgo = date("Y-m-d", strtotime(date("Y-m-d") . " -2 days"));
		$twoDaysNull = date("Y-m-d", strtotime(date("Y-m-d") . " +2 days"));

				$supplier_ticket = User::where("service_type",'Ticket')->orWhere('service_type','=','Both')->get();
		$supplier_transfer = User::where("service_type",'Transfer')->orWhere('service_type','=','Both')->get();
		
		//$query = VoucherActivity::where('id','!=', null)->whereIn('status',[0,3,4,9]);
		$query = VoucherActivity::where('id','!=', null)->whereNotIn('status',[1,2,11,12]);
		if(Auth::user()->role_id == '3')
		{
			$query->whereHas('voucher', function($q)  use($data){
				$q->where('agent_id', '=', Auth::user()->id);
			});
		}
		else
		{
			if(isset($data['agent_id_select']) && !empty($data['agent_id_select'])) {
				$filter = 1;
				$query->whereHas('voucher', function($q)  use($data){
				$q->where('agent_id', '=',$data['agent_id_select']);
			});
			
			}
		}
		if(isset($data['booking_type']) && !empty($data['booking_type'])) {
			
			if (isset($data['from_date']) && !empty($data['from_date']) &&  isset($data['to_date']) && !empty($data['to_date'])) {
				$filter = 1;
			$startDate = $data['from_date'];
			$endDate =  $data['to_date'];
				if($data['booking_type'] == 2) {
				 $query->whereDate('tour_date', '>=', $startDate);
				 $query->whereDate('tour_date', '<=', $endDate);
				}
				elseif($data['booking_type'] == 1) {
					$query->whereHas('voucher', function($q)  use($startDate,$endDate){
				 $q->whereDate('booking_date', '>=', $startDate);
				 $q->whereDate('booking_date', '<=', $endDate);
				});
		
				}
				}
				
			}
			
        if(isset($data['vouchercode']) && !empty($data['vouchercode'])) {
			$filter = 1;
			$query->whereHas('voucher', function($q)  use($data){
				$q->where('code', 'like', '%' . $data['vouchercode']);
			});
		}
		
		$query->whereHas('voucher', function($q)  use($data){
			$q->where('status_main', '=', 5);
		});
		if(isset($data['zone']) && !empty($data['zone'])) {
			$filter = 1;
		$query->where('zone', '=', $data['zone']);
		}	
			$query->whereHas('voucher', function($q)  use($data){
				$q->orderBy('booking_date', 'DESC');
			});
			
			
        //$records = $query->orderBy('created_at', 'DESC')->paginate($perPage);
		//$records = $query->orderBy('created_at', 'DESC')->get();
		
		$agetid = '';
		$agetName = '';
		
		if(old('agent_id')){
		$agentTBA = User::where('id', old('agent_id_select'))->where('status', 1)->first();
		$agetid = $agentTBA->id;
		$agetName = $agentTBA->company_name;
		}
		
		$records = [];
		$vouchers = Voucher::withCount('voucherActivities')
		->where("status_main", 5)
		->get();

		$totalVoucher = $vouchers->count();
		$totalVoucherActivity = $vouchers->sum('voucher_activities_count');

		$records = [];
		if($filter == 1){
			$records = $query->paginate(50);
		}
		
        return view('reports.master', compact('records','voucherStatus','supplier_ticket','supplier_transfer','agetid','agetName','voucherActivityStatus','zones','totalVoucher','totalVoucherActivity'));

    }
	public function masterReportExport(Request $request)
    {
		$this->checkPermissionMethod('list.masterreport');
		$data = $request->all();
		$filter = 0;
		$perPage = config("constants.ADMIN_PAGE_LIMIT");
		$voucherActivityStatus = config("constants.voucherActivityStatus");
		$voucherStatus = config("constants.voucherStatus");
		$zones = config("constants.agentZone");
		$twoDaysAgo = date("Y-m-d", strtotime(date("Y-m-d") . " -2 days"));
		$twoDaysNull = date("Y-m-d", strtotime(date("Y-m-d") . " +2 days"));

				$supplier_ticket = User::where("service_type",'Ticket')->orWhere('service_type','=','Both')->get();
		$supplier_transfer = User::where("service_type",'Transfer')->orWhere('service_type','=','Both')->get();
		
		//$query = VoucherActivity::where('id','!=', null)->whereIn('status',[0,3,4,9]);
		$query = VoucherActivity::where('id','!=', null)->whereNotIn('status',[1,2,11,12]);
		if(Auth::user()->role_id == '3')
		{
			$query->whereHas('voucher', function($q)  use($data){
				$q->where('agent_id', '=', Auth::user()->id);
			});
		}
		else
		{
			if(isset($data['agent_id_select']) && !empty($data['agent_id_select'])) {
				$filter = 1;
				$query->whereHas('voucher', function($q)  use($data){
				$q->where('agent_id', '=',$data['agent_id_select']);
			});
			
			}
		}
		if(isset($data['booking_type']) && !empty($data['booking_type'])) {
			
			if (isset($data['from_date']) && !empty($data['from_date']) &&  isset($data['to_date']) && !empty($data['to_date'])) {
				$filter = 1;
			$startDate = $data['from_date'];
			$endDate =  $data['to_date'];
				if($data['booking_type'] == 2) {
				 $query->whereDate('tour_date', '>=', $startDate);
				 $query->whereDate('tour_date', '<=', $endDate);
				}
				elseif($data['booking_type'] == 1) {
					$query->whereHas('voucher', function($q)  use($startDate,$endDate){
				 $q->whereDate('booking_date', '>=', $startDate);
				 $q->whereDate('booking_date', '<=', $endDate);
				});
		
				}
				}
				
			}
			
        if(isset($data['vouchercode']) && !empty($data['vouchercode'])) {
			$filter = 1;
			$query->whereHas('voucher', function($q)  use($data){
				$q->where('code', 'like', '%' . $data['vouchercode']);
			});
		}
		
		$query->whereHas('voucher', function($q)  use($data){
			$q->where('status_main', '=', 5);
		});
		if(isset($data['zone']) && !empty($data['zone'])) {
			$filter = 1;
		$query->where('zone', '=', $data['zone']);
		}	
			$query->whereHas('voucher', function($q)  use($data){
				$q->orderBy('booking_date', 'DESC');
			});
			
			
        //$records = $query->orderBy('created_at', 'DESC')->paginate($perPage);
		//$records = $query->orderBy('created_at', 'DESC')->get();
		
		$agetid = '';
		$agetName = '';
		
		if(old('agent_id')){
		$agentTBA = User::where('id', old('agent_id_select'))->where('status', 1)->first();
		$agetid = $agentTBA->id;
		$agetName = $agentTBA->company_name;
		}
		
		$records = [];
		$vouchers = Voucher::withCount('voucherActivities')
		->where("status_main", 5)
		->get();

		$totalVoucher = $vouchers->count();
		$totalVoucherActivity = $vouchers->sum('voucher_activities_count');

		$records = [];
		

		$records = $query->get();
		return Excel::download(new MasterReportExport($records), 'master_report'.date('d-M-Y s').'.csv');

    }
	
	
	
	
	public function zoneReport(Request $request)
{
    $this->checkPermissionMethod('list.zonereport');
    $input = $request->all();

    // Determine zones to process
    if (isset($input['zone']) && !empty($input['zone'])) {
        $zones = [$input['zone'] => $input['zone']];
		
    } else {
        $zones = config("constants.agentZone");
    }
	
    // Start the query for voucher activity
    $result = DB::table('voucher_activity as va')
	->select(
		'va.zone',
		DB::raw('COUNT(DISTINCT va.voucher_id) AS no_ofBkgs'),
		DB::raw('COUNT(*) AS no_ofServices'),
		
		DB::raw('SUM(CASE WHEN CAST(va.actual_total_cost AS DECIMAL(10,2)) > 0 AND va.status NOT IN (1,2,11,12) THEN CAST(va.original_tkt_rate AS DECIMAL(10,2)) ELSE 0 END) AS totalAccountedSell'),
		DB::raw('SUM(CASE WHEN CAST(va.actual_total_cost AS DECIMAL(10,2)) > 0 AND va.status NOT IN (1,2,11,12) THEN CAST(va.discount_tkt AS DECIMAL(10,2)) ELSE 0 END) AS totalAccountedSellDis'),
		
		DB::raw('SUM(CASE WHEN CAST(va.actual_total_cost AS DECIMAL(10,2)) = 0 AND va.status NOT IN (1,2,11,12) THEN CAST(va.original_tkt_rate AS DECIMAL(10,2)) ELSE 0 END) AS totalUnAccountedSell'),
		DB::raw('SUM(CASE WHEN CAST(va.actual_total_cost AS DECIMAL(10,2)) = 0 AND va.status NOT IN (1,2,11,12) THEN CAST(va.discount_tkt AS DECIMAL(10,2)) ELSE 0 END) AS totalUnAccountedSellDis'),
		
		DB::raw('SUM(CASE WHEN va.status NOT IN (1,2,11,12) THEN CAST(va.original_tkt_rate AS DECIMAL(10,2)) ELSE 0 END) AS totalSells'),
		DB::raw('SUM(CASE WHEN va.status NOT IN (1,2,11,12) THEN CAST(va.discount_tkt AS DECIMAL(10,2)) ELSE 0 END) AS totalSellsDis'),
		
		DB::raw('SUM(CASE WHEN va.status NOT IN (1,2,11,12) THEN CAST(va.actual_total_cost AS DECIMAL(10,2)) ELSE 0 END) AS totalCost'),
	
		DB::raw('SUM(CASE WHEN (CAST(va.actual_transfer_cost AS DECIMAL(10,2)) + CAST(va.actual_transfer_cost2 AS DECIMAL(10,2))) > 0  
				  AND va.status NOT IN (1,2,11,12) THEN CAST(va.original_trans_rate AS DECIMAL(10,2)) ELSE 0 END) AS totalAccountedTransSell'),
				  
		DB::raw('SUM(CASE WHEN (CAST(va.actual_transfer_cost AS DECIMAL(10,2)) + CAST(va.actual_transfer_cost2 AS DECIMAL(10,2))) = 0  
				  AND va.status NOT IN (1,2,11,12) THEN CAST(va.original_trans_rate AS DECIMAL(10,2)) ELSE 0 END) AS totalUnAccountedTransSell'),
				  
		DB::raw('SUM(CASE WHEN (CAST(va.actual_transfer_cost AS DECIMAL(10,2)) + CAST(va.actual_transfer_cost2 AS DECIMAL(10,2))) IS NOT NULL 
				  AND va.status NOT IN (1,2,11,12) THEN CAST(va.original_trans_rate AS DECIMAL(10,2)) ELSE 0 END) AS totalTransSells'),
	
		DB::raw('SUM(CASE WHEN (CAST(va.actual_transfer_cost AS DECIMAL(10,2)) + CAST(va.actual_transfer_cost2 AS DECIMAL(10,2))) > 0  
				  AND va.status NOT IN (1,2,11,12) THEN CAST(va.discount_sic_pvt_price AS DECIMAL(10,2)) ELSE 0 END) AS totalAccountedTransSellDis'),
	
		DB::raw('SUM(CASE WHEN (CAST(va.actual_transfer_cost AS DECIMAL(10,2)) + CAST(va.actual_transfer_cost2 AS DECIMAL(10,2))) = 0  
				  AND va.status NOT IN (1,2,11,12) THEN CAST(va.discount_sic_pvt_price AS DECIMAL(10,2)) ELSE 0 END) AS totalUnAccountedTransSellDis'),
	
		DB::raw('SUM(CASE WHEN (CAST(va.actual_transfer_cost AS DECIMAL(10,2)) + CAST(va.actual_transfer_cost2 AS DECIMAL(10,2))) IS NOT NULL 
				  AND va.status NOT IN (1,2,11,12) THEN CAST(va.discount_sic_pvt_price AS DECIMAL(10,2)) ELSE 0 END) AS totalTransSellsDis'),
	
		DB::raw('SUM(CASE WHEN va.status NOT IN (1,2,11,12) THEN CAST(va.actual_transfer_cost AS DECIMAL(10,2)) ELSE 0 END) AS totalTransCost')
	)->leftJoin('vouchers as v', 'va.voucher_id', '=', 'v.id')
        ->leftJoin('voucher_hotels as vh', 'v.id', '=', 'vh.voucher_id')
        ->where('v.status_main', 5)
        ->where('va.zone', '!=', '')
        ->groupBy('va.zone');

    // Apply zone filter if zones are set
    if (isset($zones) && !empty($zones)) {
        $result->whereIn('va.zone', array_keys($zones)); // This filters based on zones
    }
	

    // Apply date filter if booking_type and date range are set
    if (isset($input['booking_type']) && !empty($input['booking_type'])) {
        if (isset($input['from_date'], $input['to_date']) && !empty($input['from_date']) && !empty($input['to_date'])) {
            $startDate = $input['from_date'];
            $endDate = $input['to_date'];

            if ($input['booking_type'] == 2) {
                // Apply date filter for tour_date
                $result->whereDate('va.tour_date', '>=', $startDate)
                    ->whereDate('va.tour_date', '<=', $endDate);
            } elseif ($input['booking_type'] == 1) {
                // Apply date filter for booking_date
                $result->whereDate('v.booking_date', '>=', $startDate)
                    ->whereDate('v.booking_date', '<=', $endDate);
            }
        }
    }

    // Execute the voucher activity query
    $result = $result->get();

    // Prepare data for report
    $data = [];
    foreach ($zones as $zone) {
        $zoneResult = $result->firstWhere('zone', $zone);
        // Fetch hotel data with check_in_date filter
        $hotelData = DB::table('voucher_hotels as vh')
            ->join('vouchers as v', 'vh.voucher_id', '=', 'v.id')
            ->where('v.zone', $zone)
            ->select(
                DB::raw('COALESCE(sum(vh.total_price), 0) as totalHotelSP'),
                DB::raw('COALESCE(sum(vh.net_cost), 0) as totalHotelCost')
            );

        // Apply date range filter for hotel check-in date
        if (isset($input['from_date'], $input['to_date']) && !empty($input['from_date']) && !empty($input['to_date'])) {
            $startDate = $input['from_date'];
            $endDate = $input['to_date'];
            $hotelData->whereBetween('vh.check_in_date', [$startDate, $endDate]);
        }

        // Execute the hotel query
        $hotelData = $hotelData->first();

        // Prepare the data for the report
		$data[$zone] = [
			'activeAgents' => User::where('role_id', 3)->where('zone', $zone)->count(),
			'no_ofBkgs' => $zoneResult ? number_format($zoneResult->no_ofBkgs, 2) : '0.00',
			'no_ofServices' => $zoneResult ? number_format($zoneResult->no_ofServices, 2) : '0.00',
			'totalAccountedSell' => $zoneResult ? number_format($zoneResult->totalAccountedSell-$zoneResult->totalAccountedSellDis, 2) : '0.00',
			'totalUnAccountedSell' => $zoneResult ? number_format($zoneResult->totalUnAccountedSell-$zoneResult->totalUnAccountedSellDis, 2) : '0.00',
			'totalSells' => $zoneResult ? number_format($zoneResult->totalSells-$zoneResult->totalSellsDis, 2) : '0.00',
			'totalAccountedSellDis' => $zoneResult ? number_format($zoneResult->totalAccountedSellDis, 2) : '0.00',
			'totalUnAccountedSellDis' => $zoneResult ? number_format($zoneResult->totalUnAccountedSellDis, 2) : '0.00',
			'totalSellsDis' => $zoneResult ? number_format($zoneResult->totalSellsDis, 2) : '0.00',
			'totalCost' => isset($zoneResult->totalCost) ? number_format($zoneResult->totalCost, 2) : '0.00',
			'totalAccountedProfit' => $zoneResult ? number_format($zoneResult->totalAccountedSell - $zoneResult->totalCost-$zoneResult->totalAccountedSellDis, 2) : '0.00',
			'totalAccountedTransSell' => $zoneResult ? number_format($zoneResult->totalAccountedTransSell-$zoneResult->totalAccountedTransSellDis, 2) : '0.00',
			'totalUnAccountedTransSell' => $zoneResult ? number_format($zoneResult->totalUnAccountedTransSell-$zoneResult->totalUnAccountedTransSellDis, 2) : '0.00',
			'totalTransSells' => $zoneResult ? number_format($zoneResult->totalTransSells-$zoneResult->totalTransSellsDis, 2) : '0.00',

			'totalAccountedTransSellDis' => $zoneResult ? number_format($zoneResult->totalAccountedTransSellDis, 2) : '0.00',
			'totalUnAccountedTransSellDis' => $zoneResult ? number_format($zoneResult->totalUnAccountedTransSellDis, 2) : '0.00',
			'totalTransSellsDis' => $zoneResult ? number_format($zoneResult->totalTransSellsDis, 2) : '0.00',

			'totalTransCost' => isset($zoneResult->totalCost) ? number_format($zoneResult->totalTransCost, 2) : '0.00',
			'totalAccountedTransProfit' => $zoneResult ? number_format($zoneResult->totalAccountedTransSell - $zoneResult->totalTransCost, 2) : '0.00',
			'totalHotelSP' => $hotelData ? number_format($hotelData->totalHotelSP, 2) : '0.00',
			'totalHotelCost' => $hotelData ? number_format($hotelData->totalHotelCost, 2) : '0.00',
			'PLHotel' => $hotelData ? number_format($hotelData->totalHotelSP - $hotelData->totalHotelCost, 2) : '0.00',
		];
		
    }

    // Return the view with the data
    $zones = config("constants.agentZone");
    return view('reports.zone-report', compact('data', 'zones'));
}




	public function zoneReportExport(Request $request)
	{
		$this->checkPermissionMethod('list.zonereport');
		$input = $request->all();

    // Determine zones to process
    if (isset($input['zone']) && !empty($input['zone'])) {
        $zones = [$input['zone'] => $input['zone']];
    } else {
        $zones = config("constants.agentZone");
    }

	$result = DB::table('voucher_activity as va')
	->select(
		'va.zone',
		DB::raw('COUNT(DISTINCT va.voucher_id) AS no_ofBkgs'),
		DB::raw('COUNT(*) AS no_ofServices'),
		
		DB::raw('SUM(CASE WHEN CAST(va.actual_total_cost AS DECIMAL(10,2)) > 0 AND va.status NOT IN (1,2,11,12) THEN CAST(va.original_tkt_rate AS DECIMAL(10,2)) ELSE 0 END) AS totalAccountedSell'),
		DB::raw('SUM(CASE WHEN CAST(va.actual_total_cost AS DECIMAL(10,2)) > 0 AND va.status NOT IN (1,2,11,12) THEN CAST(va.discount_tkt AS DECIMAL(10,2)) ELSE 0 END) AS totalAccountedSellDis'),
		
		DB::raw('SUM(CASE WHEN CAST(va.actual_total_cost AS DECIMAL(10,2)) = 0 AND va.status NOT IN (1,2,11,12) THEN CAST(va.original_tkt_rate AS DECIMAL(10,2)) ELSE 0 END) AS totalUnAccountedSell'),
		DB::raw('SUM(CASE WHEN CAST(va.actual_total_cost AS DECIMAL(10,2)) = 0 AND va.status NOT IN (1,2,11,12) THEN CAST(va.discount_tkt AS DECIMAL(10,2)) ELSE 0 END) AS totalUnAccountedSellDis'),
		
		DB::raw('SUM(CASE WHEN va.status NOT IN (1,2,11,12) THEN CAST(va.original_tkt_rate AS DECIMAL(10,2)) ELSE 0 END) AS totalSells'),
		DB::raw('SUM(CASE WHEN va.status NOT IN (1,2,11,12) THEN CAST(va.discount_tkt AS DECIMAL(10,2)) ELSE 0 END) AS totalSellsDis'),
		
		DB::raw('SUM(CAST(va.actual_total_cost AS DECIMAL(10,2))) AS totalCost'),
	
		DB::raw('SUM(CASE WHEN (CAST(va.actual_transfer_cost AS DECIMAL(10,2)) + CAST(va.actual_transfer_cost2 AS DECIMAL(10,2))) > 0  
				  AND va.status NOT IN (1,2,11,12) THEN CAST(va.original_trans_rate AS DECIMAL(10,2)) ELSE 0 END) AS totalAccountedTransSell'),
				  
		DB::raw('SUM(CASE WHEN (CAST(va.actual_transfer_cost AS DECIMAL(10,2)) + CAST(va.actual_transfer_cost2 AS DECIMAL(10,2))) = 0  
				  AND va.status NOT IN (1,2,11,12) THEN CAST(va.original_trans_rate AS DECIMAL(10,2)) ELSE 0 END) AS totalUnAccountedTransSell'),
				  
		DB::raw('SUM(CASE WHEN (CAST(va.actual_transfer_cost AS DECIMAL(10,2)) + CAST(va.actual_transfer_cost2 AS DECIMAL(10,2))) IS NOT NULL 
				  AND va.status NOT IN (1,2,11,12) THEN CAST(va.original_trans_rate AS DECIMAL(10,2)) ELSE 0 END) AS totalTransSells'),
	
		DB::raw('SUM(CASE WHEN (CAST(va.actual_transfer_cost AS DECIMAL(10,2)) + CAST(va.actual_transfer_cost2 AS DECIMAL(10,2))) > 0  
				  AND va.status NOT IN (1,2,11,12) THEN CAST(va.discount_sic_pvt_price AS DECIMAL(10,2)) ELSE 0 END) AS totalAccountedTransSellDis'),
	
		DB::raw('SUM(CASE WHEN (CAST(va.actual_transfer_cost AS DECIMAL(10,2)) + CAST(va.actual_transfer_cost2 AS DECIMAL(10,2))) = 0  
				  AND va.status NOT IN (1,2,11,12) THEN CAST(va.discount_sic_pvt_price AS DECIMAL(10,2)) ELSE 0 END) AS totalUnAccountedTransSellDis'),
	
		DB::raw('SUM(CASE WHEN (CAST(va.actual_transfer_cost AS DECIMAL(10,2)) + CAST(va.actual_transfer_cost2 AS DECIMAL(10,2))) IS NOT NULL 
				  AND va.status NOT IN (1,2,11,12) THEN CAST(va.discount_sic_pvt_price AS DECIMAL(10,2)) ELSE 0 END) AS totalTransSellsDis'),
	
		DB::raw('SUM(CASE WHEN va.status NOT IN (1,2,11,12) THEN CAST(va.actual_transfer_cost AS DECIMAL(10,2)) ELSE 0 END) AS totalTransCost')
	)->leftJoin('vouchers as v', 'va.voucher_id', '=', 'v.id')
        ->leftJoin('voucher_hotels as vh', 'v.id', '=', 'vh.voucher_id')
        ->where('v.status_main', 5)
        ->where('va.zone', '!=', '')
        ->groupBy('va.zone');

    // Apply zone filter if zones are set
    if (isset($zones) && !empty($zones)) {
        $result->whereIn('va.zone', array_keys($zones)); // This filters based on zones
    }
	

    // Apply date filter if booking_type and date range are set
    if (isset($input['booking_type']) && !empty($input['booking_type'])) {
        if (isset($input['from_date'], $input['to_date']) && !empty($input['from_date']) && !empty($input['to_date'])) {
            $startDate = $input['from_date'];
            $endDate = $input['to_date'];

            if ($input['booking_type'] == 2) {
                // Apply date filter for tour_date
                $result->whereDate('va.tour_date', '>=', $startDate)
                    ->whereDate('va.tour_date', '<=', $endDate);
            } elseif ($input['booking_type'] == 1) {
                // Apply date filter for booking_date
                $result->whereDate('v.booking_date', '>=', $startDate)
                    ->whereDate('v.booking_date', '<=', $endDate);
            }
        }
    }

    // Execute the voucher activity query
    $result = $result->get();

    // Prepare data for report
    $data = [];
    foreach ($zones as $zone) {
        $zoneResult = $result->firstWhere('zone', $zone);

        // Fetch hotel data with check_in_date filter
        $hotelData = DB::table('voucher_hotels as vh')
    ->join('vouchers as v', 'vh.voucher_id', '=', 'v.id')
    ->where('v.zone', $zone)
    ->select(
        DB::raw('COALESCE(SUM(CAST(vh.total_price AS DECIMAL(10,2))), 0) AS totalHotelSP'),
        DB::raw('COALESCE(SUM(CAST(vh.net_cost AS DECIMAL(10,2))), 0) AS totalHotelCost')
    );


        // Apply date range filter for hotel check-in date
        if (isset($input['from_date'], $input['to_date']) && !empty($input['from_date']) && !empty($input['to_date'])) {
            $startDate = $input['from_date'];
            $endDate = $input['to_date'];
            $hotelData->whereBetween('vh.check_in_date', [$startDate, $endDate]);
        }

        // Execute the hotel query
        $hotelData = $hotelData->first();

        // Prepare the data for the report
		$data[$zone] = [
			'activeAgents' => User::where('role_id', 3)->where('zone', $zone)->count(),
			'no_ofBkgs' => $zoneResult ? number_format($zoneResult->no_ofBkgs, 2) : '0.00',
			'no_ofServices' => $zoneResult ? number_format($zoneResult->no_ofServices, 2) : '0.00',
			'totalAccountedSell' => $zoneResult ? number_format($zoneResult->totalAccountedSell-$zoneResult->totalAccountedSellDis, 2) : '0.00',
			'totalUnAccountedSell' => $zoneResult ? number_format($zoneResult->totalUnAccountedSell-$zoneResult->totalUnAccountedSellDis, 2) : '0.00',
			'totalSells' => $zoneResult ? number_format($zoneResult->totalSells-$zoneResult->totalSellsDis, 2) : '0.00',
			'totalAccountedSellDis' => $zoneResult ? number_format($zoneResult->totalAccountedSellDis, 2) : '0.00',
			'totalUnAccountedSellDis' => $zoneResult ? number_format($zoneResult->totalUnAccountedSellDis, 2) : '0.00',
			'totalSellsDis' => $zoneResult ? number_format($zoneResult->totalSellsDis, 2) : '0.00',
			'totalCost' => isset($zoneResult->totalCost) ? number_format($zoneResult->totalCost, 2) : '0.00',
			'totalAccountedProfit' => $zoneResult ? number_format($zoneResult->totalAccountedSell - $zoneResult->totalCost-$zoneResult->totalAccountedSellDis, 2) : '0.00',
			'totalAccountedTransSell' => $zoneResult ? number_format($zoneResult->totalAccountedTransSell-$zoneResult->totalAccountedTransSellDis, 2) : '0.00',
			'totalUnAccountedTransSell' => $zoneResult ? number_format($zoneResult->totalUnAccountedTransSell-$zoneResult->totalUnAccountedTransSellDis, 2) : '0.00',
			'totalTransSells' => $zoneResult ? number_format($zoneResult->totalTransSells-$zoneResult->totalTransSellsDis, 2) : '0.00',

			'totalAccountedTransSellDis' => $zoneResult ? number_format($zoneResult->totalAccountedTransSellDis, 2) : '0.00',
			'totalUnAccountedTransSellDis' => $zoneResult ? number_format($zoneResult->totalUnAccountedTransSellDis, 2) : '0.00',
			'totalTransSellsDis' => $zoneResult ? number_format($zoneResult->totalTransSellsDis, 2) : '0.00',

			'totalTransCost' => isset($zoneResult->totalCost) ? number_format($zoneResult->totalTransCost, 2) : '0.00',
			'totalAccountedTransProfit' => $zoneResult ? number_format($zoneResult->totalAccountedTransSell - $zoneResult->totalTransCost, 2) : '0.00',
			'totalHotelSP' => $hotelData ? number_format($hotelData->totalHotelSP, 2) : '0.00',
			'totalHotelCost' => $hotelData ? number_format($hotelData->totalHotelCost, 2) : '0.00',
			'PLHotel' => $hotelData ? number_format($hotelData->totalHotelSP - $hotelData->totalHotelCost, 2) : '0.00',
		];
		
    }
	$zones = config("constants.agentZone");
		return Excel::download(new ZoneReportExport($data), 'zone_report'.date('d-M-Y s').'.csv');
	}



	public function voucherHotelCanceledReport(Request $request)
    {
		$this->checkPermissionMethod('list.HotelCanceledReport');
		$data = $request->all();
		$perPage = config("constants.ADMIN_PAGE_LIMIT");
		
		
		$query = VoucherHotel::where('id','!=', null);
		
		if(isset($data['booking_type']) && !empty($data['booking_type'])) {
			
			if (isset($data['from_date']) && !empty($data['from_date']) &&  isset($data['to_date']) && !empty($data['to_date'])) {
			$startDate = $data['from_date'];
			$endDate =  $data['to_date'];
				if($data['booking_type'] == 2) {
				 $query->whereDate('check_in_date', '>=', $startDate);
				 $query->whereDate('check_in_date', '<=', $endDate);
				}
				elseif($data['booking_type'] == 1) {
				 $query->where('cancelled_on', '>=', $startDate);
				 $query->where('cancelled_on', '<=', $endDate);
				}
				}
			}
        if(isset($data['reference']) && !empty($data['reference'])) {
			$query->whereHas('voucher', function($q)  use($data){
				$q->where('code', 'like', '%' . $data['reference'] . '%');
			});
		}
		if(!empty(Auth::user()->zone)){
			$query->whereHas('voucher', function($q)  use($data){
				$q->where('zone', '=', Auth::user()->zone);
			});
}
		$query->where('status', '=', 1);
			
        $records = $query->orderBy('created_at', 'DESC')->paginate($perPage);
		
        return view('reports.hotel-canceled-report', compact('records'));

    }
	public function hotelFinalRefundSave(Request $request)
    {
		$data = $request->all();
		$id = $data['id'];
		$refund_amt = $data['refund_amt'];
		$totalPrice = 0;
		$record = VoucherHotel::where("id",$id)->where('status', '=', 1)->first();
		
		
		
			if(!empty($record)){
			$record->status = 2;
			$record->refund_amount = $refund_amt;
			$record->refund_on = date("Y-m-d H:i:s");
			$record->refund_by = Auth::user()->id;
			$record->save();
			
			$totalPrice = $refund_amt;
			$voucher = Voucher::where('id',$record->voucher_id)->select(['agent_id','vat_invoice','invoice_number'])->first();
			$agent = User::find($voucher->agent_id);
			if(!empty($agent))
			{
				if($totalPrice > 0){
				$agent->agent_amount_balance += $totalPrice;
				$agent->save();
				
				$agentAmount = new AgentAmount();
				$agentAmount->agent_id = $agent->id;
				$agentAmount->amount = $totalPrice;
				$agentAmount->date_of_receipt = date("Y-m-d");
				$agentAmount->transaction_type = "Receipt";
				$agentAmount->role_user = 3;
				$agentAmount->status = 2;
				$agentAmount->transaction_from = 4;
				$agentAmount->created_by = Auth::user()->id;
				$agentAmount->updated_by = Auth::user()->id;
				$agentAmount->receipt_no = $voucher->invoice_number;
				$agentAmount->is_vat_invoice = $voucher->vat_invoice;
				$agentAmount->save();
				}
				
				return redirect()->back()->with('success', 'Hotel Canceled Successfully.');
			}else{
			return redirect()->back()->with('error', 'Agent Not Found.');
			}
			
			}
			else{
			return redirect()->back()->with('error', 'Voucher Not Found.');
			}
			
		
        return response()->json($response);
	}

	
public function voucherHotelRefundedReport(Request $request)
{
	$this->checkPermissionMethod('list.HotelRefundReport');
	$data = $request->all();
	$perPage = config("constants.ADMIN_PAGE_LIMIT");

	$query = VoucherHotel::where('id','!=', null);
	
	if(isset($data['booking_type']) && !empty($data['booking_type'])) {
		
		if (isset($data['from_date']) && !empty($data['from_date']) &&  isset($data['to_date']) && !empty($data['to_date'])) {
		$startDate = $data['from_date'];
		$endDate =  $data['to_date'];
			if($data['booking_type'] == 2) {
			 $query->whereDate('check_in_date', '>=', $startDate);
			 $query->whereDate('check_in_date', '<=', $endDate);
			}
			elseif($data['booking_type'] == 1) {
			 $query->where('cancelled_on', '>=', $startDate);
			 $query->where('cancelled_on', '<=', $endDate);
			}
			}
		}
	if(isset($data['reference']) && !empty($data['reference'])) {
		$query->whereHas('voucher', function($q)  use($data){
			$q->where('code', 'like', '%' . $data['reference'] . '%');
		});
	}
	
	$query->where('status', '=', 2);
		
	$records = $query->orderBy('created_at', 'DESC')->paginate($perPage);
	
	return view('reports.hotel-refunded-report', compact('records'));

}

public function voucherHotelRefundedReportExport(Request $request)
{
	$this->checkPermissionMethod('list.HotelRefundReport');
	$data = $request->all();
	$perPage = config("constants.ADMIN_PAGE_LIMIT");

	$query = VoucherHotel::where('id','!=', null);
	
	if(isset($data['booking_type']) && !empty($data['booking_type'])) {
		
		if (isset($data['from_date']) && !empty($data['from_date']) &&  isset($data['to_date']) && !empty($data['to_date'])) {
		$startDate = $data['from_date'];
		$endDate =  $data['to_date'];
			if($data['booking_type'] == 2) {
			 $query->whereDate('check_in_date', '>=', $startDate);
			 $query->whereDate('check_in_date', '<=', $endDate);
			}
			elseif($data['booking_type'] == 1) {
			 $query->where('cancelled_on', '>=', $startDate);
			 $query->where('cancelled_on', '<=', $endDate);
			}
			}
		}
	if(isset($data['reference']) && !empty($data['reference'])) {
		$query->whereHas('voucher', function($q)  use($data){
			$q->where('code', 'like', '%' . $data['reference'] . '%');
		});
	}
	
	$query->where('status', '=', 2);
		
	$records = $query->orderBy('created_at', 'DESC')->get();
	return Excel::download(new VoucherHotelRefundedReportExport($records), 'hotel-refunded-report'.date('d-M-Y s').'.csv');

}

public function productMaster(Request $request)
    {
        $data = $request->all();
        $perPage = config("constants.ADMIN_PAGE_LIMIT");
		$filter = 0;
		$records = [];
        $query = VariantPrice::with("createdBy","updatedBy","av","av.activity","av.variant");
		if (isset($data['from_date']) && !empty($data['from_date']) && isset($data['to_date']) && !empty($data['to_date'])) {
			$filter = 1;
			$startDate = date("Y-m-d", strtotime($data['from_date']));
			$endDate = date("Y-m-d", strtotime($data['to_date']));
		} else {
			$filter = 1; 
			$startDate = date("Y-m-d"); 
			$endDate = date("Y-m-d", strtotime("+1 month"));
		}
		
		$query->whereDate('rate_valid_from', '>=', $startDate);
		$query->whereDate('rate_valid_to', '<=', $endDate);
		
		
		
		if(isset($data['vcode']) && !empty($data['vcode'])) {
		$query->whereHas('av.variant', function($q)  use($data){
			$q->where('code', 'like', '%' . $data['vcode'] . '%');
		});

		$filter = 1;
		}
		
		if ($filter == 1) {
			$records = $query->orderBy('rate_valid_to', 'ASC')->paginate($perPage);
		} 
		//dd($records);
        return view('reports.product-master', compact('records','filter'));
    }
	
	public function productMasterExport(Request $request)
    {
        $data = $request->all();
        $perPage = config("constants.ADMIN_PAGE_LIMIT");
		$filter = 0;
		$records = [];
       /**  $query = VariantPrice::with("createdBy","updatedBy","av","av.activity","av.variant");
		if (isset($data['from_date']) && !empty($data['from_date']) &&  isset($data['to_date']) && !empty($data['to_date'])) {
		$filter = 1;
			$startDate = date("Y-m-d", strtotime($data['from_date']));
			$endDate = date("Y-m-d", strtotime($data['to_date']));
			$query->whereDate('rate_valid_from', '>=', $startDate);
			$query->whereDate('rate_valid_to', '<=', $endDate);
		}
		
		if(isset($data['vcode']) && !empty($data['vcode'])) {
		$query->whereHas('av.variant', function($q)  use($data){
			$q->where('code', 'like', '%' . $data['vcode'] . '%');
		});
		}
		
		$records = $query->orderBy('created_at', 'DESC')->get();
		
		return Excel::download(new AllPriceReportExport($records), 'price_report'.date('d-M-Y s').'.csv');
		**/
    }
	
}