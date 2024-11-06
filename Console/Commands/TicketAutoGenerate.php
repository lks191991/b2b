<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Voucher;
use App\Models\User;
use App\Models\VoucherActivity;
use App\Models\TicketLog;
use App\Models\Ticket;
use App\Models\AgentAmount;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use SiteHelpers;


class TicketAutoGenerate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ticketAutoGenerate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ticket Auto Generated Successfully';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
		$voucherActivities = VoucherActivity::with("activity")->whereDate('tour_date', '>=',date('Y-m-d'))->where("ticket_generated","0")->where("status","3")->whereHas('activity', function ($query)  {
           $query->where('entry_type',  "Ticket Only");
       })->get();
	   
	   $totalprice =0;
		foreach($voucherActivities as $voucherActivity){
			
		$adult = $voucherActivity->adult;
		$child = $voucherActivity->child;
		$totalTicketNeed = $adult+$child;
		$countTotalTicketNeed = $totalTicketNeed;
		$countTotalTicketNeed = $totalTicketNeed;
		
		$ticketQuery = Ticket::where('ticket_generated','0')->where('activity_variant',$voucherActivity->variant_code)->whereDate('valid_from', '<=',$voucherActivity->tour_date)->whereDate('valid_till', '>=',$voucherActivity->tour_date)->orderBy("valid_till","ASC");
		
		
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
				if($tcCountEx == 0)
				{
					foreach($tcArray as $ta){
						$voucherCheck = Voucher::find($voucherActivity->voucher_id);
						if($voucherCheck->booking_date >= date("Y-m-d")){
							$tc = Ticket::find($ta);
							$tc->voucher_activity_id = $voucherActivity->id;
							$tc->ticket_generated = 1;
							$tc->ticket_generated_by = "0";
							$tc->generated_time = date("d-m-Y h:i:s");
							$tc->voucher_id = $voucherActivity->voucher_id;
							$tc->save();
						}
					}
				
					$voucher = Voucher::find($voucherActivity->voucher_id);
					$agentsupplierId = '947d43d9-c999-446c-a841-a1aee22c7257';
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
					$agentAmount->status = 2;
					$agentAmount->role_user = 9;
					$agentAmount->created_by = 0;
					$agentAmount->updated_by = 0;
					$agentAmount->save();
					
					$recordUser = AgentAmount::find($agentAmount->id);
					$recordUser->receipt_no = $voucher->invoice_number;
					$recordUser->is_vat_invoice = "1";
					$recordUser->save(); 
				}
			}
			
				$log = new TicketLog();
				$log->total_record = $countTotalTicketNeed;
				// $log->supplier_id = $agentsupplierId;
				// $log->supplier_cost = $totalprice;
				// $log->voucher_activity_id = $voucherActivity->id;
				$log->save();
					
		}
	}
		
	$this->line('Ticket Auto Generated Successfully.');
	exit;
    }
}
