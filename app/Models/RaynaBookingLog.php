<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RaynaBookingLog extends Model
{
    protected $table = "rayna_bookings_log";
	
	use HasFactory;

    protected $fillable = ['payload', 'response','endpoint'];

    protected $casts = [
        'payload' => 'array',
        'response' => 'array',
    ];

    public static function logBooking($payload, $response = [], $endpoint = null): self
{
    return self::create([
        'payload' => is_string($payload) ? json_decode($payload, true) : $payload,
        'response' => is_string($response) ? json_decode($response, true) : $response,
        'endpoint' => $endpoint,
    ]);
}

	
}
