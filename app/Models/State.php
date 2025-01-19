<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;
use Illuminate\Support\Str;

class State extends Model
{
    protected $table = "states";
	
	protected static function booted()
    {
        static::saving(function ($model) {
            if (!$model->slug) {  
                $model->slug = Str::slug($model->name . '-' . $model->id);
            }
        });
    }


	public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
