<?php

namespace App\Exports;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;

class VoucherActivityRefundExport implements FromView
{
    use Exportable;
	
	protected $records;


    public function __construct($records)
    {
		$this->records = $records;
       // dd($this->records);
    }
	
	public function view(): View
    {
		
        return view('exports.voucher-activity-refund-export', [
            'records' => $this->records
        ]);

    }
	
    
}
