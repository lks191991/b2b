<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketDownloadLog extends Model
{
    protected $table = "ticket_download_logs";
	protected $fillable = [
        'voucher_activity_id',
        'voucher_id',
        'supplier_id',
        'user_ip',
        'user_id',
        'ticket_type',
    ];

    public function voucherActivity()
	{
		return $this->belongsTo(VoucherActivity::class, 'voucher_activity_id', 'id');
	}

	public function voucher()
	{
		return $this->belongsTo(Voucher::class, 'voucher_id', 'id');
	}

    public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}
}
