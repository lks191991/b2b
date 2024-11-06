<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    protected $table = "hotels";

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function hotelcategory()
    {
        return $this->belongsTo(HotelCategory::class, 'hotel_category_id', 'id');
    }
	
	 public function zone()
    {
        return $this->belongsTo(Zone::class);
    }
}