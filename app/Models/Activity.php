<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Activity extends Model
{
    protected $table = "activities";
	
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
	
	public function activityVariants()
    {
        return $this->hasMany('App\Models\ActivityVariant', 'activity_id', 'id');
    }
   
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
	
	
	public function currency()
    {
        return $this->belongsTo(Currency::class);
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
