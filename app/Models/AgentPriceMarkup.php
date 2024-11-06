<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgentPriceMarkup extends Model
{
    protected $table = "agent_price_markup";

	public function activity()
    {
        return $this->belongsTo(Activity::class);
    }
	
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