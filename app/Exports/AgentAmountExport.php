<?php

namespace App\Exports;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;

class AgentAmountExport implements FromView
{
    use Exportable;
	
	protected $records;
	protected $agetid;
    protected $agetName;

    public function __construct($records,$agetid,$agetName)
    {
		$this->records = $records;
		$this->agetName = $agetName;
        $this->agetid = $agetid;
    }
	
	
	public function view(): View
    {
		
        return view('exports.agent-amount-export', [
            'records' => $this->records,
			'agetid' => $this->agetid,
            'agetName' => $this->agetName
        ]);

    }
	
    
}
