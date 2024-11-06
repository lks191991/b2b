<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use App\Models\User;
use App\Models\Activity;
use App\Models\ActivityPrices;
use App\Models\AgentPriceMarkup;
use Illuminate\Http\Request;
use App\Models\VoucherActivity;
use App\Models\Variant;
use Illuminate\Support\Facades\Response;
use App\Models\Ticket;
use Illuminate\Support\Facades\Log;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\GeneratedTicketsExport;
use SiteHelpers;
use Carbon\Carbon;
use SPDF;
use Illuminate\Support\Facades\Auth;
use App\Models\AgentAmount;
use Validator;

class TicketsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		$this->checkPermissionMethod('list.ticket');
		 $perPage = config("constants.ADMIN_PAGE_LIMIT");
		 $data = $request->all();
		$query = Ticket::where('id','!=', null);
		if (isset($data['ticket_no']) && !empty($data['ticket_no'])) {
            $query->where('ticket_no','like','%'.$data['ticket_no'].'%');
        } if (isset($data['serial_number']) && !empty($data['serial_number'])) {
			$query->where('serial_number','like','%'.$data['serial_number'].'%');
        }if (isset($data['valid_from']) && !empty($data['valid_from'])) {
            $query->whereDate('valid_from', '>=',$data['valid_from']);
        }if (isset($data['valid_till']) && !empty($data['valid_till'])) {
            $query->whereDate('valid_till', '<=',$data['valid_till']);
        }
		if (isset($data['activity_id']) && !empty($data['activity_id'])) {
				 $query->where('activity_id',  $data['activity_id']);
		}
		
		if (isset($data['activity_variant']) && !empty($data['activity_variant'])) {
				 $query->where('activity_variant',  $data['activity_variant']);
		}
		if (isset($data['ticket_for']) && !empty($data['ticket_for'])) {
				 $query->where('ticket_for',  $data['ticket_for']);
		}
		
        $records = $query->where('ticket_generated','0')->orderBy('created_at', 'DESC')->paginate($perPage);
		$agetid = '';
		$agetName = '';
		$activities = Activity::where('status', 1)->orderBy('title', 'ASC')->get();
		$variants = Variant::where('status', 1)->orderBy('title', 'ASC')->get();
        return view('tickets.index', compact('records','activities','variants'));

    }
	
	public function generatedTickets(Request $request)
    {
		$this->checkPermissionMethod('list.ticket');
		$perPage = config("constants.ADMIN_PAGE_LIMIT");
		$data = $request->all();
		$query = Ticket::where('id','!=', null);
		if (isset($data['ticket_no']) && !empty($data['ticket_no'])) {
            $query->where('ticket_no', $data['ticket_no']);
        } if (isset($data['serial_number']) && !empty($data['serial_number'])) {
             $query->where('serial_number', $data['serial_number']);
        }if (isset($data['valid_from']) && !empty($data['valid_from'])) {
            $query->whereDate('valid_from', '>=',$data['valid_from']);
        }if (isset($data['valid_till']) && !empty($data['valid_till'])) {
            $query->whereDate('valid_till', '<=',$data['valid_till']);
        }
		
		if (isset($data['activity_variant']) && !empty($data['activity_variant'])) {
				 $query->where('activity_variant',  $data['activity_variant']);
		}
		if (isset($data['ticket_for']) && !empty($data['ticket_for'])) {
				 $query->where('ticket_for',  $data['ticket_for']);
		}
		if (isset($data['code']) && !empty($data['code'])) {
			$query->whereHas('voucher', function($q)  use($data){
		$q->where('code', 'like', '%' . $data['code'] . '%');
		});
	}
	if (isset($data['invcode']) && !empty($data['invcode'])) {
		$query->whereHas('voucher', function($q)  use($data){
	$q->where('invoice_number', 'like', '%' . $data['invcode'] . '%');
	});
}
		
        $records = $query->where('ticket_generated','1')->orderBy('created_at', 'DESC')->paginate($perPage);
		$agetid = '';
		$agetName = '';
		$variants = Variant::where('status', 1)->orderBy('title', 'ASC')->get();
        return view('tickets.generated-tickets-list', compact('records','variants'));

    }

	public function generatedTicketsExport(Request $request)
    {
		$this->checkPermissionMethod('list.ticket');
		$data = $request->all();
		$query = Ticket::where('id','!=', null);
		if (isset($data['ticket_no']) && !empty($data['ticket_no'])) {
            $query->where('ticket_no', $data['ticket_no']);
        } if (isset($data['serial_number']) && !empty($data['serial_number'])) {
             $query->where('serial_number', $data['serial_number']);
        }if (isset($data['valid_from']) && !empty($data['valid_from'])) {
            $query->whereDate('valid_from', '>=',$data['valid_from']);
        }if (isset($data['valid_till']) && !empty($data['valid_till'])) {
            $query->whereDate('valid_till', '<=',$data['valid_till']);
        }
		
		if (isset($data['activity_variant']) && !empty($data['activity_variant'])) {
				 $query->where('activity_variant',  $data['activity_variant']);
		}
		if (isset($data['ticket_for']) && !empty($data['ticket_for'])) {
				 $query->where('ticket_for',  $data['ticket_for']);
		}
		if (isset($data['code']) && !empty($data['code'])) {
			$query->whereHas('voucher', function($q)  use($data){
		$q->where('code', 'like', '%' . $data['code'] . '%');
		});
	}
	if (isset($data['invcode']) && !empty($data['invcode'])) {
		$query->whereHas('voucher', function($q)  use($data){
	$q->where('invoice_number', 'like', '%' . $data['invcode'] . '%');
	});
}
		
        $records = $query->where('ticket_generated','1')->orderBy('created_at', 'DESC')->get();
		$agetid = '';
		$agetName = '';
		return Excel::download(new generatedTicketsExport($records), 'generated_tickets'.date('d-M-Y s').'.csv');     

       //return view('tickets.generated-tickets-list', compact('records','variants'));

    }

	public function ticketGenerate(Request $request, $id)
    {
		$totalprice = 0;
		$voucherActivity = VoucherActivity::find($id);
		if(!empty($voucherActivity->ticket_pdf)){
			return redirect($voucherActivity->ticket_pdf);
		} else {
		$adult = $voucherActivity->adult;
		$child = $voucherActivity->child;
		$totalTicketNeed = $adult+$child;
		$countTotalTicketNeed = $totalTicketNeed;
		$parent_code = $voucherActivity->parent_code;
		if($parent_code == '0')
		{
			$ticketQuery = Ticket::where('ticket_generated','0')->where('activity_variant',$voucherActivity->variant_code)->whereDate('valid_from', '<=',$voucherActivity->tour_date)->whereDate('valid_till', '>=',$voucherActivity->tour_date)->orderBy("valid_till","ASC");
			
		}
		else
		{
			$ticketQuery = Ticket::where('ticket_generated','0')->where('activity_variant',$voucherActivity->parent_code)->whereDate('valid_from', '<=',$voucherActivity->tour_date)->whereDate('valid_till', '>=',$voucherActivity->tour_date)->orderBy("valid_till","ASC");
		}
		$totalTickets =$ticketQuery->get();
		$totalTicketCount =$totalTickets->count();
		
		$tcArray = [];
		if($totalTicketCount >= $totalTicketNeed)
		{
			$totalprice= 0;
			
			foreach($totalTickets as $ticket){
				if(($ticket->ticket_for == 'Adult') && ($adult > 0)){
					$tcArray[$ticket->id] = $ticket->id;
					$totalprice += $ticket->net_cost;
					$adult--;
					$totalTicketNeed--;
				} elseif(($ticket->ticket_for == 'Child') && ($child > 0)){
					$tcArray[$ticket->id] = $ticket->id;
					$totalprice += $ticket->net_cost;
					$child--;
					$totalTicketNeed--;
				} elseif(($ticket->ticket_for == 'Both') && ($totalTicketNeed > 0)){
					// Check if the 'Both' ticket is for an adult or child
					if ($adult > 0) {
						$tcArray[$ticket->id] = $ticket->id;
						$totalprice += $ticket->net_cost;
						$adult--;
					} elseif ($child > 0) {
						$tcArray[$ticket->id] = $ticket->id;
						$totalprice += $ticket->net_cost;
						$child--;
					}
					$totalTicketNeed--;
				}
			}
			
			if(($totalTicketNeed == 0) && (count($tcArray) == $countTotalTicketNeed))
			{
				$tcCountEx = Ticket::where("voucher_id",'=',$voucherActivity->voucher_id)->where("voucher_activity_id",'=',$voucherActivity->id)->count();
				if($tcCountEx > 0){
				return redirect()->route('ticket.dwnload',$voucherActivity->id);	
				} else {
				foreach($tcArray as $ta)
				{
					$tc = Ticket::find($ta);
					$tc->voucher_activity_id = $voucherActivity->id;
					$tc->ticket_generated = 1;
					$tc->ticket_generated_by = Auth::user()->id;
					$tc->generated_time = date("d-m-Y h:i:s");
					$tc->voucher_id = $voucherActivity->voucher_id;
					$tc->save();
				}
				
				$agentsupplierId = '947d43d9-c999-446c-a841-a1aee22c7257';
				$voucher = Voucher::find($voucherActivity->voucher_id);
				if($totalprice <=0 )
				{
					
					$priceCal = SiteHelpers::getActivitySupplierCost($voucherActivity->activity_id,$agentsupplierId,$voucher,$voucherActivity->variant_code,$voucherActivity->adult,$voucherActivity->child,$voucherActivity->infant,$voucherActivity->discount);
					
					
					$totalprice = $priceCal['totalprice'];
				}
				$voucherActivity->ticket_generated = 1;
				$voucherActivity->supplier_ticket = $agentsupplierId;
				$voucherActivity->actual_total_cost = $totalprice;
				$voucherActivity->status = 4;
				
				$voucherActivity->save();

				$agentAmount = new AgentAmount();
				$agentAmount->agent_id = $agentsupplierId;
				$agentAmount->amount = $totalprice;
				$agentAmount->date_of_receipt = date("Y-m-d");
				$agentAmount->transaction_type = "Receipt";
				$agentAmount->transaction_from = 2;
				$agentAmount->service_name = $voucherActivity->variant_name;
				$agentAmount->service_date = $voucherActivity->tour_date;
				$agentAmount->guest_name = $voucher->guest_name;
				$agentAmount->role_user = 9;
				$agentAmount->status = 2;
				$agentAmount->created_by = Auth::user()->id;
				$agentAmount->updated_by = Auth::user()->id;
				$agentAmount->save();
				
				$recordUser = AgentAmount::find($agentAmount->id);
				$recordUser->receipt_no = $voucher->invoice_number;
				$recordUser->is_vat_invoice = "1";
				$recordUser->save(); 

				
				return redirect()->route('ticket.dwnload',$voucherActivity->id);	
				}
			} else {
			return redirect()->back()->with('error', 'API Connection Timeout. Kindly contact Customer Service.');
			}	
					
			} else{
			return redirect()->back()->with('error', 'API Connection Timeout. Kindly contact Customer Service.');
		}
		}
		
		
    }
	
	public function ticketDwnload(Request $request, $id)
    {
		$voucherActivity = VoucherActivity::find($id);
		if(!empty($voucherActivity->ticket_pdf)){
			return redirect($voucherActivity->ticket_pdf);
		} else {
		$voucher = Voucher::where('id',$voucherActivity->voucher_id)->first();;

		$parent_code = $voucherActivity->parent_code;
		if($parent_code == '0')
		{
			$tickets = Ticket::where('activity_variant',$voucherActivity->variant_code)->where('voucher_activity_id',$voucherActivity->id)->where('ticket_generated','1')->get();
		
		}
		else
		{
			$tickets = Ticket::where('activity_variant',$voucherActivity->parent_code)->where('voucher_activity_id',$voucherActivity->id)->where('ticket_generated','1')->get();
			//$ticketQuery = Ticket::where('ticket_generated','0')->where('activity_variant',$voucherActivity->parent_code)->whereDate('valid_from', '<=',$voucherActivity->tour_date)->whereDate('valid_till', '>=',$voucherActivity->tour_date)->orderBy("valid_till","ASC");
		}
        $voucherActivity->ticket_downloaded = 1;
		$voucherActivity->save();
		foreach($tickets as $ticket)
		{
		$ticket->ticket_downloaded_by = Auth::user()->id;
		$ticket->downloaded_time = date("d-m-Y h:i:s");
		$ticket->ticket_downloaded = 1;
		$ticket->save();
		}
		//return view('tickets.ticketPdf', compact('voucherActivity','tickets','voucher'));
        $pdf = SPDF::loadView('tickets.ticketPdf', compact('voucherActivity','tickets','voucher'));
       $pdf->setPaper('A4')->setOrientation('portrait');
        return $pdf->download('Ticket'.$voucher->code.'-'.$voucherActivity->variant_code.'-'.$voucherActivity->id .'.pdf');
		}
	}
    
	
	public function uploadTicketFromReport(Request $request){
		$request->validate([
        'ticketFile' => 'required|mimes:pdf|max:5120', // Adjust the max size as needed
		], [
			'ticketFile.required' => 'The Ticket PDF file is required.',
			'ticketFile.mimes' => 'Please upload a valid Ticket PDF file.',
			'ticketFile.max' => 'The Ticket PDF file must not exceed 5 MB.',
		]);
		
		$data = $request->all();
		/** Below code for save image **/
		$destinationPath = public_path('/uploads/tickets/');
		//$newName = '';
        //pr($request->all()); die;
        $input = $request->all();
		if ($request->hasFile('ticketFile')) {

			$voucherActivity = VoucherActivity::with('voucher')->where('id',$data['vaid'])->where('voucher_id',$data['vid'])->first();
			/* if(empty($voucherActivity->supplier_ticket)){
				return redirect()->back()->with('error','Please select a ticket supplier before uploading the ticket.');
			} */
			
			$fileName = $input['ticketFile']->getClientOriginalName();
			$file = request()->file('ticketFile');
			$fileNameArr = explode('.', $fileName);
			$fileNameExt = end($fileNameArr);
			$newName = $voucherActivity->voucher->code.'-'.$voucherActivity->variant_code .'-' .$voucherActivity->id .'.' . $fileNameExt;
			$file->move($destinationPath, $newName);
            $voucherActivity->ticket_pdf = asset("/uploads/tickets/".$newName);
			$voucherActivity->ticket_generated = 1;
			$voucherActivity->ticket_downloaded = 1;
			$voucherActivity->save();
		}
		
		return redirect(route('voucherTicketOnlyReport'))->with('success','Ticket uploaded.');
		
    }
    
    public function create(){
		//
    }

    
    public function store(Request $request){
		
        //
    }

    public function show(Ticket $ticket){
		//
    }

   
    public function edit($id){
       //
        
    }

   
    public function update(Request $request, $id){
       //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Voucher  $Voucher
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = Ticket::find($id);
        $record->delete();
        return redirect('tickets')->with('success', 'Ticket Deleted.');
    }
	
	public function csvUploadForm()
    {
		$this->checkPermissionMethod('list.ticket.upload');
		$variants = Variant::where('status', 1)->orderBy('title', 'ASC')->get();
		$activities = Activity::where('status', 1)->orderBy('title', 'ASC')->get();
		$supplier_ticket = User::where("service_type",'Ticket')->orWhere('service_type','=','Both')->get();
		return view('tickets.csv-upload',  compact('activities','variants','supplier_ticket'));
    }
	
	public function csvUploadPost(Request $request)
    {
		$validator = Validator::make($request->all(), [
            'ticket_for' => 'required',
			'type_of_ticket' => 'required',
			'supplier_ticket' => 'required',
			'activity_variant' => 'required',
			'serial_number' => 'required',
			'valid_from' => 'required',
			'valid_till' => 'required',
            
        ]);
		
		// if the validator fails, redirect back to the form
		$data = [];
		$j = 0;
        if ($validator->fails()) {    
            
            return redirect()->back()
                ->withErrors($validator) // send back all errors to the form
                ->withInput();
        } else {
            
			$ticket_for = $request->input('ticket_for');
			$type_of_ticket = $request->input('type_of_ticket');
			//$activity_id = $request->input('activity_id');
			$activity_id = 0;
			$activity_variant = $request->input('activity_variant');
			$serial_number = $request->input('serial_number');
			$valid_from = $request->input('valid_from');
			$supplier_ticket = $request->input('supplier_ticket');
			$net_cost = $request->input('net_cost');
			$valid_till = $request->input('valid_till');
			$terms_and_conditions = $request->input('terms_and_conditions');
			$ticket_nos = nl2br(trim($_POST['ticket_no']));
			$importData_tickets = explode("<br />", $ticket_nos);
			$d_from = date("Y-m-d",strtotime($valid_from));
			$d_till = date("Y-m-d",strtotime($valid_till));
				foreach ($importData_tickets as $ticket_no) {
				if(!empty($ticket_no)){
				$data[] = [
					'ticket_for' => $ticket_for,	
					'type_of_ticket' => $type_of_ticket,	
					'activity_id' => $activity_id,	
					'activity_variant' => $activity_variant,	
					'terms_and_conditions' => $terms_and_conditions,	
					'ticket_no' => $ticket_no,
					'serial_number' => $serial_number,
                    'valid_from' => $d_from,
					'valid_till' => $d_till,
					'supplier_ticket' => $supplier_ticket,
					'net_cost' => $net_cost,
				];
				$j++;
				}
				}
				
				/*  return response()->json([
				'message' => "$j records successfully uploaded"
				]);  */
				
				
				if(count($data) > 0){
					DB::beginTransaction();
					try {
						// Data ko database me insert karein
						Ticket::insert($data);
						DB::commit();
						return redirect('tickets')->with('success', $j . ' Records successfully uploaded.');
					} catch (\Exception $e) {
						DB::rollback();
						return redirect()->back()->withInput()->with('error', 'An error occurred while uploading records.');
					}
				}
				
							         
            
            
           return redirect('tickets')->with('success', $j.' Records successfully uploaded.');
        }
		
		
    }
	
	/**
     * Upload the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
	public function csvUploadPostOLD(Request $request)
    {
		$validator = Validator::make($request->all(), [
            'ticket_for' => 'required',
			'type_of_ticket' => 'required',
			'activity_id' => 'required',
			'activity_variant' => 'required',
			'serial_number' => 'required',
			'valid_from' => 'required',
			'valid_till' => 'required',
            
        ]);
		
		// if the validator fails, redirect back to the form
		$data = [];
		$j = 0;
        if ($validator->fails()) {    
            
            return redirect()->back()
                ->withErrors($validator) // send back all errors to the form
                ->withInput();
        } else {
            
			$ticket_for = $request->input('ticket_for');
			$type_of_ticket = $request->input('type_of_ticket');
			$activity_id = $request->input('activity_id');
			$activity_variant = $request->input('activity_variant');
			$serial_number = $request->input('serial_number');
			$valid_from = $request->input('valid_from');
			$valid_till = $request->input('valid_till');
			$terms_and_conditions = $request->input('terms_and_conditions');
		
			$file = $request->file('uploaded_file_csv');
			if ($file) {
				$f = $file->getClientOriginalName();
				$filename = time().$f;
				$extension = $file->getClientOriginalExtension(); //Get extension of uploaded file
				$tempPath = $file->getRealPath();
				$fileSize = $file->getSize(); //Get size of uploaded file in bytes
				//Check for file extension and size
				$returnData = $this->checkUploadedFileProperties($extension, $fileSize);
				if($returnData == 1){
					return redirect()->back()->withInput()->with('error', 'Please upload valid csv file.');
				}elseif($returnData == 2){
					return redirect()->back()->withInput()->with('error', 'Invalid file extension.');
				}
				//Where uploaded file will be stored on the server 
				$location = 'uploads/csv'; //Created an "uploads" folder for that
				// Upload file
				$file->move($location, $filename);
				// In case the uploaded file path is to be stored in the database 
				$filepath = public_path($location . "/" .$filename);
				// Reading file
				$file = fopen($filepath, "r");
				$importData_arr = array(); // Read through the file and store the contents as an array
				$i = 0;
				//Read the contents of the uploaded file 
				while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
					//$dateStr = $filedata[2];
					//$dateStr2 = $filedata[3];

                // Custom function to parse dates with single-digit day values
               // $date = $this->parseDate($dateStr);
                //$date2 = $this->parseDate($dateStr2);

                // Check if parsing was successful before assigning the formatted dates
				
                //if ($date && $date2) {
                    //$filedata[2] = $date->format('Y-m-d');
                    //$filedata[3] = $date2->format('Y-m-d');
                //} else {
                   // Log::error("Error parsing dates '{$dateStr}' or '{$dateStr2}'");
                //}
				
				$num = count($filedata);
				// Skip first row (Remove below comment if you want to skip the first row)
				if ($i == 0) {
				$i++;
				continue;
				}
				for ($c = 0; $c < $num; $c++) {
				if(!empty($filedata[$c][0]))
				{
				$importData_arr[$i][] = $filedata[$c];
				}
				}
				$i++;
				}
				fclose($file); //Close after reading
				$j = 0;
				
				foreach ($importData_arr as $importData) {
				$j++;
				$ticket_no = str_replace("'", "\'", $importData[0]);
				$ticket_no = str_replace('"', "'+String.fromCharCode(34)+'", $importData[0]);
				$serial_number = str_replace("'", "\'", $serial_number);
				$serial_number = str_replace('"', "'+String.fromCharCode(34)+'", $serial_number);
				
				
				$ticket_no = addslashes(trim(ucwords(strtolower($ticket_no))));
				$serial_number = addslashes(trim(ucwords(strtolower($serial_number))));
				
				
				
				
				
				$d_from = date("Y-m-d",strtotime($valid_from));
				$d_till = date("Y-m-d",strtotime($valid_till));

				//echo "<pre>";
				//print_r($importData);
				//exit;
				if(empty($valid_from) OR empty($valid_till)){
					//return redirect()->back()->withInput()->with('error', 'The from date and till date  is required.');
				}
				$data[] = [
					'ticket_for' => $ticket_for,	
					'type_of_ticket' => $type_of_ticket,	
					'activity_id' => $activity_id,	
					'activity_variant' => $activity_variant,	
					'terms_and_conditions' => $terms_and_conditions,	
					'ticket_no' => $ticket_no,
					'serial_number' => $serial_number,
                    'valid_from' => $d_from,
					'valid_till' => $d_till,
				];
				
				}
				
				/*  return response()->json([
				'message' => "$j records successfully uploaded"
				]);  */
				
				
				if(count($data) > 0){
					DB::beginTransaction();
					try {
						// Data ko database me insert karein
						Ticket::insert($data);
						DB::commit();
						return redirect('tickets')->with('success', $j . ' Records successfully uploaded.');
					} catch (\Exception $e) {
						DB::rollback();
						return redirect()->back()->withInput()->with('error', 'An error occurred while uploading records.');
					}
				}
				}
				else
				{
					return redirect()->back()->withInput()->with('error', 'Please upload valid csv file.');
				}
							         
            
            
           return redirect('tickets')->with('success', $j.' Records successfully uploaded.');
        }
		
		
    }
	
	 private function parseDate($dateStr)
    {
        // Array of date formats to support
        $dateFormats = [
            'd/m/Y', // Format: dd/mm/yyyy
            'm/d/Y', // Format: mm/dd/yyyy
			'Y/m/d', // Format: yyyy/mm/dd
            'Y-m-d', // Format: yyyy-mm-dd
			'd-m-Y', // Format: dd-mm-yyyy
			'm-d-Y', // Format: mm-dd-yyyy
        ];

        foreach ($dateFormats as $dateFormat) {
            $parsedDate = \DateTime::createFromFormat($dateFormat, $dateStr);
            if ($parsedDate !== false) {
                return Carbon::instance($parsedDate);
            }
        }

        return null;
    }

	
	public function checkUploadedFileProperties($extension, $fileSize)
	{
		$valid_extension = array("csv", "xlsx"); //Only want csv and excel files
		$maxFileSize = 2097152; // Uploaded file size limit is 2mb
		if (in_array(strtolower($extension), $valid_extension)) {
		if ($fileSize <= $maxFileSize) {
		} else {
		return 1;
		}
		} else {
			return 2;
		//throw new \Exception('Invalid file extension', '415'); //415 error
		}
		}
	
}
