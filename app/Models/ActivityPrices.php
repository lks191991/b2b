<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityPrices extends Model
{
    protected $table = "activity_prices";
	
	 public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
    /**
     * Summary of updatedBy
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

   
	
   
}