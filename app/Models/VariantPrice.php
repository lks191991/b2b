<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VariantPrice extends Model
{
    protected $table = "variant_prices";
	
	public function av()
    {
        return $this->belongsTo(ActivityVariant::class, 'activity_variant_id', 'id');
    }
   
	public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
 
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

   
	
   
}