<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportLog extends Model
{
    protected $table = "report_log";
	protected $fillable = ['input','input_vaue','updated_by','report_type','voucher_id','voucher_activity_id','agent_id'];
	
}
