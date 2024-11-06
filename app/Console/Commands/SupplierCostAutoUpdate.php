<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Voucher;
use App\Models\User;
use App\Models\VoucherActivity;
use App\Models\AgentAmount;
use App\Models\TicketLog;
use App\Models\Ticket;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use SiteHelpers;
use Illuminate\Support\Facades\Auth;

class SupplierCostAutoUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'supplierActualTotalCostAutoUpdate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Supplier Cost Auto Updated Successfully in Ledger';

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
		$today = Carbon::now();
		$previousDay = $today->subDay();
		$voucherActivities = VoucherActivity::with("voucher")->whereDate("tour_date",'<',$today)->where('cron_update',  0)->where('status',4)->where('actual_transfer_cost','>',0)->where('supplier_transfer', '!=', '')->get();
		foreach($voucherActivities as $voucherActivity){
			
			
			$agentAmount = new AgentAmount();
			$agentAmount->agent_id = $voucherActivity->supplier_transfer;
			$agentAmount->amount = $voucherActivity->actual_transfer_cost;
			$agentAmount->date_of_receipt = @$voucherActivity->voucher->booking_date;
			$agentAmount->transaction_type = "Receipt";
			$agentAmount->transaction_from = 3;
			$agentAmount->role_user = 3;
			$agentAmount->receipt_no = @$voucherActivity->voucher->invoice_number;
			$agentAmount->save();
			
			$voucherActivity->cron_update = 1;
			$voucherActivity->save();
	}
		
	$this->line('Ledger Auto Updated Successfully.');
	exit;
    }
}
