<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use App\Models\Voucher;
use App\Models\AgentAmount;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Validator;
use Hash;
use DB;
use Image;
use jeremykenedy\LaravelRoles\Models\Role;

class CommonController extends BaseController
{
    
    /**
     * Companylist api
     *
     * @return \Illuminate\Http\Response
     */
    public function voucherPriceUpdate(Request $request)
    {
		$validator = Validator::make($request->all(), [
            'voucher_code' => 'required',
			'agent_code' => 'required',
			'amount' => 'required',
        ],
        [
        ]);
   
        if($validator->fails()){
           //return $this->sendError('Validation Error.', $validator->errors()); 
           $errors = $validator->errors();
           $errorMsg = '';
			if($errors->first('voucher_id'))
			$errorMsg = $errors->first('voucher_id');
			if($errors->first('agent_code'))
			$errorMsg = $errors->first('agent_code');
			if($errors->first('amount'))
			$errorMsg = $errors->first('amount');

           return $this->sendError($errorMsg); 
           
        }
		
        $request = $request->all();
		
		try{
        $agent = User::where("id",$request['agent_code'])->first();
		$voucher = Voucher::where("code",$request['voucher_code'])->where("status_main",'<',5)->first();
		
		if (empty($voucher)) {
           return $this->sendError([], "Voucher not found.");
        }
		
		$paymentDate = date('Y-m-d', strtotime('-2 days', strtotime($voucher->travel_from_date)));
		$voucher->payment_date = $paymentDate;
		if(!empty($agent))
		{
			if($voucher->vat_invoice == 1)
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
			$voucher->invoice_number = $code;
			$voucher->booking_date = date("Y-m-d H:i:s");
			$voucher->status_main = 5;
			$voucher->api_response_log = json_encode($request);
			$voucher->save();
			
			$this->paymentUpdateInLedger($request['amount'],$agent->id,$code,$voucher->vat_invoice);
			$data['code'] = $voucher->code;
			$data['amount'] = $request['amount'];
			$result = $this->sendResponse($data, 'voucher uopdated successfully.');
			
		} else {
			$result = $this->sendError([], "Agent not found.");
		}
		
		
		
		} catch(Exception $e) {
			$result = $this->sendError([], $e->getMessage());
		}
		
        return $result;

    }
	
	public function paymentUpdateInLedger($grandTotal,$agentId,$code,$vatInvoice)
    {
			$receipt_no = 'A-'.date("Y")."-00";
			$agentAmount = new AgentAmount();
			$agentAmount->agent_id = $agentId;
			$agentAmount->amount = $grandTotal;
			$agentAmount->date_of_receipt = date("Y-m-d");
			$agentAmount->transaction_type = "Payment";
			$agentAmount->transaction_from = 2;
			$agentAmount->status = 2;
			$agentAmount->role_user = 3;
			$agentAmount->created_by = '4009e52c-e44f-4a4f-aca3-dbce6a3cb9c1';
			$agentAmount->updated_by = '4009e52c-e44f-4a4f-aca3-dbce6a3cb9c1';
			$agentAmount->save();
			
			$recordUser = AgentAmount::find($agentAmount->id);
			$recordUser->receipt_no = $code;
			$recordUser->is_vat_invoice = $vatInvoice;
			$recordUser->save(); 
			
			$agentAmountReceipt = new AgentAmount();
			$agentAmountReceipt->agent_id = $agentId;
			$agentAmountReceipt->amount = $grandTotal;
			$agentAmountReceipt->date_of_receipt = date("Y-m-d");
			$agentAmountReceipt->transaction_type = "Receipt";
			$agentAmountReceipt->transaction_from = 2;
			$agentAmountReceipt->role_user = 3;
			$agentAmountReceipt->status = 2;
			$agentAmountReceipt->created_by = '4009e52c-e44f-4a4f-aca3-dbce6a3cb9c1';
			$agentAmountReceipt->updated_by = '4009e52c-e44f-4a4f-aca3-dbce6a3cb9c1';
			$agentAmountReceipt->save();
			
			$recordUserReceipt = AgentAmount::find($agentAmountReceipt->id);
			$recordUserReceipt->receipt_no = $code;
			$recordUserReceipt->is_vat_invoice = $vatInvoice;
			$recordUserReceipt->save(); 
	}
   
    
}