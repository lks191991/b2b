<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slot extends Model
{
    protected $table = "variant_slots";
	protected $fillable = [
        'variant_id',
        'slot_timing',
        'ticket_only',
        'sic',
        'pvt',
    ];

}