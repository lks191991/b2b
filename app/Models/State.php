<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;

class State extends Model
{
    protected $table = "states";
	
	public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
