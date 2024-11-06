<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Customer;
use App\Models\AgentAmount;
use DB;
use SiteHelpers;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AgentAmountExport;
use SPDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\AgentAmountEmailMailable;


class AgentAmountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		$this->checkPermissionMethod('list.agentamount');
		$perPage = config("constants.ADMIN_PAGE_LIMIT");
		$data = $request->all();
		$query = AgentAmount::with('agent')->whereIn('transaction_from',[1,6]);
		if (isset($data['agent_id_select']) && !empty($data['agent_id_select'])) {
            $query->where('agent_id', $data['agent_id_select']);
        }
		if (isset($data['receipt_no']) && !empty($data['receipt_no'])) {
            $query->where('receipt_no', 'like', '%' . $data['receipt_no'] . '%');
        }
		if (isset($data['amount']) && !empty($data['amount'])) {
            $query->where('amount', $data['amount']);
        }
        if (isset($data['status']) && !empty($data['status'])) {
            $query->where('status', $data['status']);
        }
		if (isset($data['date_of_receipt']) && !empty($data['date_of_receipt'])) {
            $query->whereDate('date_of_receipt', $data['date_of_receipt']);
        }
		if (isset($data['transaction_type']) && !empty($data['transaction_type'])) {
            $query->where('transaction_type', $data['transaction_type']);
        }
        if (isset($data['mode_of_payment']) && !empty($data['mode_of_payment'])) {
            $query->where('mode_of_payment', $data['mode_of_payment']);
        }
       
        if(!empty(Auth::user()->zone)){
			$query->whereHas('agent', function($q)  use($data){
				$q->where('zone', '=', Auth::user()->zone);
			});
}
		$agetid = '';
		$agetName = '';
		
		if(old('agent_id')){
		$agentTBA = User::where('id', old('agent_id_select'))->where('status', 1)->first();
		$agetid = $agentTBA->id;
		$agetName = $agentTBA->company_name;
		}
		
		$records = $query->orderBy('created_at', 'DESC')->paginate($perPage);
        return view('agentamounts.index', compact('records','agetid','agetName'));

    }

    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$this->checkPermissionMethod('list.agentamount');
		$agetid = '';
		$agetName = '';
		
		if(request('agent_id')){
		$agentTBA = User::where('id', request('agent_id'))->first();
		$agetid = $agentTBA->id;
		$agetName = $agentTBA->company_name;
		}
        return view('agentamounts.create', compact('agetid','agetName'));
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
            'agent_id'=>'required',
			'amount'=>'required',
            'image' => 'nullable|mimes:jpeg,jpg,png|max:' . ($options['allow_img_size'] * 1024), 
			'date_of_receipt'=>'required',
        ], [
			
		]);
		
		$input = $request->all();
		$date_of_receipt = $request->input('date_of_receipt'); 
		$agent = User::find($request->input('agent_id_select'));
        $record = new AgentAmount();
        $record->agent_id = $request->input('agent_id_select');
		$record->amount = $request->input('amount');
		$record->date_of_receipt = $date_of_receipt;
		$record->transaction_type = $request->input('transaction_type');
		$record->transaction_from = $request->input('transaction_from');
		//$record->role_user = $agent->role_id;
        $record->currency_id = "1";
        $record->currency_amt = $request->input('amount');
		$record->remark = $request->input('remark');
        $record->is_vat_invoice = $request->input('is_vat_invoice');
        $record->status = $request->input('status');
        $record->mode_of_payment = $request->input('mode_of_payment');
        //$record->is_vat_invoice = $request->input('is_vat_invoice');
		$record->created_by = Auth::user()->id;
		$record->updated_by = Auth::user()->id;
        $destinationPath = public_path('/uploads/payment/');
		if ($request->hasFile('image')) 
        {
			$fileName = $input['image']->getClientOriginalName();
			$file = request()->file('image');
			$fileNameArr = explode('.', $fileName);
			$fileNameExt = end($fileNameArr);
			$newName = date('His').rand() . time() . '.' . $fileNameExt;
			$file->move($destinationPath, $newName);
            $record->attachment = $newName;
		}
        
		
		
		//if(Auth::user()->role_id == '3'){
			if(($request->input('transaction_type') == "Receipt"))
			{
                $payment_status = "Pending";
                if($request->input('status') == '2')
                {
                    $agent->agent_amount_balance += $request->input('amount');
                    $agent->save();
                    $payment_status = "Approved";
                }
                elseif($request->input('status') == '3')
                {
                    $payment_status = "Rejected";
                }
				
				$record->save();
				$receipt_no = 'A-'.date("Y")."-00".$record->id;
				$recordUser = AgentAmount::find($record->id);
				$recordUser->receipt_no = $receipt_no;
				$recordUser->save();


                $emailData['remark'] = $request->input('remark');
                $emailData['amount'] = $request->input('amount');
                $emailData['paymentStatus'] = $payment_status;
                $emailData['paymentdate'] = $request->input('date_of_receipt');
                $emailData['paymentmode'] = $request->input('mode_of_payment');
               
                // [
                //     'agentName'=>$agent->company_name,
                //     'amount'=>$request->input('amount'),
                //     'paymentStatus'=>$payment_status
                //     ];
                   
                    
                    $zoneUserEmails = SiteHelpers::getUserByZoneEmail($record->agent_id);
                    
                    Mail::to($agent->email,'Agent Receipt.')->cc($zoneUserEmails)->bcc('payment@abaterab2b.com')->send(new AgentAmountEmailMailable($emailData)); 	
                   

			}
            else if(($request->input('transaction_type') == "Payment"))
			{
                if($agent->role_id == '9')
                {
                    $record->save();
                    $receipt_no = 'A-'.date("Y")."-00".$record->id;
                    $recordUser = AgentAmount::find($record->id);
                    $recordUser->receipt_no = $receipt_no;
                    $recordUser->save();
                }
                elseif(($agent->agent_amount_balance >= $request->input('amount')))
                {
                    if(($request->input('status') == '2'))
                    {
                        $agent->agent_amount_balance -= $request->input('amount');
                        $agent->save();
                    }
                    
                    $record->save();
                    $receipt_no = 'A-'.date("Y")."-00".$record->id;
                    $recordUser = AgentAmount::find($record->id);
                    $recordUser->receipt_no = $receipt_no;
                    $recordUser->save();

                    
				}
				else{
					return redirect()->route('agentamounts.create')->with('error', 'Agency amount cannot be set to 0.'.$agent->role_id);
				}
			}
        
		//}
		
		
        return redirect()->route('agentamounts.index')->with('success', 'Data Created Successfully.');
		
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function show(Voucher $voucher)
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
        
        $agentAmounts = AgentAmount::find($id);
       
			return view('agentamounts.edit', compact('agentAmounts'));
	
        
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
        $options['allow_img_size'] = 10;
        $request->validate([
            'agent_id'=>'required',
			'amount'=>'required',
            'image' => 'nullable|mimes:jpeg,jpg,png|max:' . ($options['allow_img_size'] * 1024), 
			'date_of_receipt'=>'required',
        ], [
			
		]);
		$input = $request->all();
        
		$date_of_receipt = $request->input('date_of_receipt'); 
	
        $record = AgentAmount::find($id);
        $agent = User::find($request->input('agent_id'));
		$record->amount = $request->input('amount');
		$record->date_of_receipt = $date_of_receipt;
		$record->transaction_type = $request->input('transaction_type');
		$record->transaction_from = $request->input('transaction_from');
		//$record->role_user = $agent->role_id;
		$record->remark = $request->input('remark');
        $record->is_vat_invoice = $request->input('is_vat_invoice');
        $record->status = $request->input('status');
        $record->mode_of_payment = $request->input('mode_of_payment');
        //$record->is_vat_invoice = $request->input('is_vat_invoice');
		$record->updated_by = Auth::user()->id;
        $destinationPath = public_path('/uploads/payment/');
		if ($request->hasFile('image')) 
        {
			$fileName = $input['image']->getClientOriginalName();
			$file = request()->file('image');
			$fileNameArr = explode('.', $fileName);
			$fileNameExt = end($fileNameArr);
			$newName = date('His').rand() . time() . '.' . $fileNameExt;
			$file->move($destinationPath, $newName);
            $record->attachment = $newName;
		}
        
       
       
        // [
        //     'agentName'=>$agent->company_name,
        //     'amount'=>$request->input('amount'),
        //     'paymentStatus'=>$payment_status
        //     ];
           
       

		
		$record->save();
		//if(Auth::user()->role_id == '3'){
			if(($request->input('transaction_type') == "Receipt"))
			{
                if($request->input('status') == '2')
                {
                    $agent->agent_amount_balance += $request->input('amount');
                    $agent->save();
                }
				
                $payment_status = "Pending";
                if($request->input('status') == '2')
                {
                    $payment_status = "Approved";
                }
                elseif($request->input('status') == '3')
                {
                    $payment_status = "Rejected";
                }
                $emailData['remark'] = $request->input('remark');
                $emailData['amount'] = $request->input('amount');
                $emailData['paymentStatus'] = $payment_status;
                $emailData['paymentdate'] = $request->input('date_of_receipt');
                $emailData['paymentmode'] = $request->input('mode_of_payment');
                
                $zoneUserEmails = SiteHelpers::getUserByZoneEmail($request->input('agent_id'));
                Mail::to($agent->email,'Agent Receipt.')->cc($zoneUserEmails)->bcc('payment@abaterab2b.com')->send(new AgentAmountEmailMailable($emailData)); 	
                   
				
			}
            else if(($request->input('transaction_type') == "Payment"))
			{
				if($agent->agent_amount_balance >= $request->input('amount'))
                {
                    $agent->agent_amount_balance -= $request->input('amount');
                    $agent->save();
                    
				}
				else{
					return redirect()->route('agentamounts.index')->with('error', 'Agency amount cannot be set to 0.');
				}
			}
        
		//}
		
		
        return redirect()->route('agentamounts.index')->with('success', 'Data Created Successfully.');
		
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Voucher  $Voucher
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       //
    }

    public function agentAmountView($aaid)
    {
        
		$agentAmounts =  AgentAmount::where('id',$aaid)->first();
		if (empty($agentAmounts)) {
            return abort(404); //record not found
        }
		return view('agentamounts.view', compact('agentAmounts'));
    }


    public function receiptForm($id)
    {
        //$this->checkPermissionMethod('list.subadmin');
        $user = auth()->user();
		if(Auth::user()->role_id == '3'){
			
		return view('agentamounts.receipts', compact('user'));
			
		}
		
        
    }
    public function getCurrencyRate(Request $request)
    {
		$data = $request->all();
		$currency_value = SiteHelpers::getCurrencyPriceById($data['id']);
            $amt = round(($data['amt']/($currency_value['value']+$currency_value['markup_value'])),2);
		$response[] = array("status"=>1,"amt"=>$amt);
        return response()->json($response);
	}

   

    public function addReceiptForm(Request $request, $id)
    {
        $options['allow_img_size'] = 10;
        $request->validate([
			'amount'=>'required',
            'image' => 'nullable|mimes:jpeg,jpg,png,pdf|max:' . ($options['allow_img_size'] * 1024), 
			'date_of_receipt'=>'required',
        ], [
			
		]);
		
		$input = $request->all();
		$date_of_receipt =  date('Y-m-d',strtotime($request->input('date_of_receipt'))); 
		$agent = User::find($id);
        $record = new AgentAmount();
        $record->agent_id = $id;
		$record->amount = $request->input('amount');
		$record->date_of_receipt = $date_of_receipt;
		$record->transaction_type = "Receipt";
		$record->transaction_from = "1";
		$record->currency_id = $request->input('currency');
        $record->currency_amt = $request->input('amount_cur');
		$record->remark = $request->input('remark');
        $record->is_vat_invoice = "1";
        $record->status = "1";
        $record->mode_of_payment = $request->input('mode_of_payment');
		$record->created_by = Auth::user()->id;
        $destinationPath = public_path('/uploads/payment/');
		if ($request->hasFile('image')) 
        {
			$fileName = $input['image']->getClientOriginalName();
			$file = request()->file('image');
			$fileNameArr = explode('.', $fileName);
			$fileNameExt = end($fileNameArr);
			$newName = date('His').rand() . time() . '.' . $fileNameExt;
			$file->move($destinationPath, $newName);
            $record->attachment = $newName;
		}
    
        $record->save();
        $receipt_no = 'A-'.date("Y")."-00".$record->id;
        $recordUser = AgentAmount::find($record->id);
        $recordUser->receipt_no = $receipt_no;
        $recordUser->save();
		return redirect('/receipts/'.Auth::user()->id)->with('success', 'Your request has been submitted successfully with Ref No.: '.$receipt_no);
    }

    public function receiptPdf(Request $request, $aaid)
    {


        $agentAmounts =  AgentAmount::where('id',$aaid)->first();
		
			
       
//return view('agentamounts.receiptPdf', compact('agentAmounts'));
        $pdf = SPDF::loadView('agentamounts.receiptPdf', compact('agentAmounts'));
       $pdf->setPaper('A4')->setOrientation('portrait');
        return $pdf->download($agentAmounts->receipt_no.'.pdf');
		
	
	
	return \Response::make($content,200, $headers);
    }

    public function agentAmountExportExcel(Request $request)
    {
		$this->checkPermissionMethod('list.agentamount');
		$perPage = config("constants.ADMIN_PAGE_LIMIT");
		$data = $request->all();
		$query = AgentAmount::with('agent')->whereIn('transaction_from',[1,6]);
		if (isset($data['agent_id_select']) && !empty($data['agent_id_select'])) {
            $query->where('agent_id', $data['agent_id_select']);
        }
		if (isset($data['receipt_no']) && !empty($data['receipt_no'])) {
            $query->where('receipt_no', 'like', '%' . $data['receipt_no'] . '%');
        }
		if (isset($data['amount']) && !empty($data['amount'])) {
            $query->where('amount', $data['amount']);
        }
		if (isset($data['date_of_receipt']) && !empty($data['date_of_receipt'])) {
            $query->whereDate('date_of_receipt', $data['date_of_receipt']);
        }
        if (isset($data['status']) && !empty($data['status'])) {
            $query->where('status', $data['status']);
        }
		if (isset($data['transaction_type']) && !empty($data['transaction_type'])) {
            $query->where('transaction_type', $data['transaction_type']);
        }
        if (isset($data['mode_of_payment']) && !empty($data['mode_of_payment'])) {
            $query->where('mode_of_payment', $data['mode_of_payment']);
        }
		
		$agetid = '';
		$agetName = '';
		
		if(old('agent_id')){
		$agentTBA = User::where('id', old('agent_id_select'))->where('status', 1)->first();
		$agetid = $agentTBA->id;
		$agetName = $agentTBA->company_name;
		}
		
		$records = $query->orderBy('created_at', 'DESC')->paginate($perPage);
      //  return view('agentamounts.index', compact('records','agetid','agetName'));
     
      return Excel::download(new AgentAmountExport($records,$agetid,$agetName), 'agent_amount'.date('d-M-Y s').'.csv');
    }
}
