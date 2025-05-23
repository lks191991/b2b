<?php

namespace App\Exports;

use App\Models\VoucherActivity;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;

class VoucherHotelRefundedReportExport implements FromView
{
    use Exportable;
	
	protected $records;


    public function __construct($records)
    {
		$this->records = $records;
    }
	
	public function view(): View
    {
        return view('exports.voucher-hotel-refunded-report', [
            'records' => $this->records
        ]);
    }
	
    
}
