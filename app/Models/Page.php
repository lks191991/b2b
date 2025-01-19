<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;
use Illuminate\Support\Str;

class Page extends Model
{

    
    /**
     * Get the user's full name.
     *
     * @return string
     */
    public $table = 'pages';
	
	protected static function booted()
    {
        static::saving(function ($model) {
            if (!$model->slug) {  
                $model->slug = Str::slug($model->title . '-' . $model->id);
            }
        });
    }

}
