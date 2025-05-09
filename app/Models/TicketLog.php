<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketLog extends Model
{
    protected $table = "ticket_logs";
	public function voucherActivity()
	{
		return $this->belongsTo(VoucherActivity::class, 'voucher_activity_id', 'id');
	}

	public function voucher()
	{
		return $this->belongsTo(Voucher::class, 'voucher_id', 'id');
	}
}
