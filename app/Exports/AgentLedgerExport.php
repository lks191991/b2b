<?php

namespace App\Exports;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;

class AgentLedgerExport implements FromView
{
    use Exportable;
	
	protected $records;
	protected $openingBalance;

    public function __construct($records,$openingBalance)
    {
		$this->records = $records;
		$this->openingBalance = $openingBalance;
    }
	
	
	public function view(): View
    {
		
        return view('exports.agent-ledger-export', [
            'records' => $this->records,
			'openingBalance' => $this->openingBalance
        ]);

    }
	
    
}
