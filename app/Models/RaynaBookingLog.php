<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RaynaBookingLog extends Model
{
    protected $table = "rayna_bookings_log";
	
	use HasFactory;

    protected $fillable = ['payload', 'response','endpoint','voucher_id','voucher_act_id'];

    protected $casts = [
        'payload' => 'array',
        'response' => 'array',
    ];

	public function voucherActivity()
	{
		return $this->belongsTo(VoucherActivity::class, 'voucher_act_id', 'id');
	}

	public function voucher()
	{
		return $this->belongsTo(Voucher::class, 'voucher_id', 'id');
	}


 public static function logBooking($payload, $response = [], $endpoint = null, $vid = 0, $vactid = 0, $status = 0): self
	{
		$log = self::create([
			'payload' => is_string($payload) ? json_decode($payload, true) : $payload,
			'response' => is_string($response) ? json_decode($response, true) : $response,
			'endpoint' => $endpoint,
			'voucher_id' => $vid,
			'voucher_act_id' => $vactid,
			'status' => $status, 
		]);

		return $log;
	}
}
