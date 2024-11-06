<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Voucher;
use App\Models\User;
use App\Models\VoucherActivity;
use App\Models\TicketLog;
use App\Models\Ticket;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use SiteHelpers;

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
    protected $description = 'Supplier Cost Auto Updated Successfully';

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
		
		$voucherActivities = VoucherActivity::with("activity")->whereDate("tour_date",'>=',$today)->whereHas('activity', function ($query)  {
           $query->where('entry_type',  "Ticket Only");
       })->get();
	   
	   $totalprice =0;
		foreach($voucherActivities as $voucherActivity){
			
		$adult = $voucherActivity->adult;
		$child = $voucherActivity->child;
				
		$voucher = Voucher::find($voucherActivity->voucher_id);
		$agentsupplierId = '947d43d9-c999-446c-a841-a1aee22c7257';
		$voucher = Voucher::find($voucherActivity->voucher_id);
		$priceCal = SiteHelpers::getActivityPriceSaveInVoucherActivity("Ticket Only",$voucherActivity->activity_id,$agentsupplierId,$voucher,$voucherActivity->variant_unique_code,$voucherActivity->adult,$voucherActivity->child,$voucherActivity->infant,$voucherActivity->discount);
		$totalprice = $priceCal['totalprice'];
		
		$voucherActivity->supplier_ticket = $agentsupplierId;
		$voucherActivity->actual_total_cost = $totalprice;
		$voucherActivity->save();
			
				
					
	}
		
	$this->line('Ticket Auto Generated Successfully.');
	exit;
    }
}
