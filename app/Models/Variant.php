<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Variant extends Model
{
    protected $table = "variants";
	protected static function booted()
    {
        static::saving(function ($model) {
            if (!$model->slug) {  
                $model->slug = Str::slug($model->title . '-' . $model->id);
            }
        });
    }
   
	public function images()
    {
        return $this->hasMany('App\Models\Files', 'model_id', 'id')->where("model", "Activity");
    }
   
	public function prices()
    {
        return $this->hasMany('App\Models\ActivityPrices', 'activity_id', 'id');
    }
	
	
	public function transfer()
    {
        return $this->belongsTo('App\Models\Transfer', 'transfer_plan', 'id');
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
