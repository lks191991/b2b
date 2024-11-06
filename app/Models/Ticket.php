<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $table = "tickets";
	
	public function activity()
    {
        return $this->belongsTo(Activity::class,'activity_id','id');
    }
	
	public function variant()
    {
        return $this->belongsTo(Variant::class,'activity_variant','ucode');
    }
	
	public function voucher()
    {
        return $this->belongsTo(Voucher::class,'voucher_id','id');
    }
	
	public function supplier()
    {
        return $this->belongsTo(User::class,'supplier_ticket','id');
    }
	
}
