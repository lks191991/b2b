<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;

class City extends Model
{
    protected $table = "cities";
	
	public function state()
    {
        return $this->belongsTo(State::class);
    }
	
	public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
