<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoucherActivityLog extends Model
{
	protected $table ="voucher_activity_logs";
	protected $fillable = ['voucher_id', 'voucher_activity_id', 'discount', 'priceTotal', 'created_by','voucher_status'];   
	
}
