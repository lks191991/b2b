<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;

class Module extends Model
{
    use HasFactory;
    use Uuids;

    public $incrementing = false;
}
