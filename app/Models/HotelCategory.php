<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class HotelCategory extends Model
{
    protected $table = "hotelcategories";
	protected static function booted()
    {
        static::saving(function ($model) {
            if (!$model->slug) {  
                $model->slug = Str::slug($model->name . '-' . $model->id);
            }
        });
    }
	
}
