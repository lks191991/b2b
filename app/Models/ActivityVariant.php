<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityVariant extends Model
{
    protected $table = "activity_variants";
	protected $fillable  = ['code','activity_id','variant_id','ucode'];
	
	public function activity()
    {
        return $this->belongsTo(Activity::class, 'activity_id', 'id');
    }
	
	public function variant()
    {
        return $this->belongsTo(Variant::class, 'variant_id', 'id');
    }
	
	/* public function prices()
    {
        return $this->hasMany('App\Models\VariantPrice', 'activity_variant_id', 'id');
    } */
	
	public function prices()
    {
        return $this->belongsTo(VariantPrice::class, 'id', 'activity_variant_id');
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