<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;

class Transfer extends Model
{
    protected $table ="transfers";
	
	 public function transferdata()
    {
        return $this->hasMany(TransferData::class);
    }
}
