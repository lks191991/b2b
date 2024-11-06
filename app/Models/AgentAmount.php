<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;

class AgentAmount extends Model
{
    protected $table = "agent_amounts";
	
	public function agent()
    {
        return $this->belongsTo(User::class,'agent_id','id');
    }
	
	 public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
    /**
     * Summary of updatedBy
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
	
	public function voucher()
    {
        return $this->belongsTo(Voucher::class, 'receipt_no', 'invoice_number');
    }
}
