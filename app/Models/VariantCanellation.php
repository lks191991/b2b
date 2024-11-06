<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VariantCanellation extends Model
{
    protected $table = "variant_canellation";
	
	protected $fillable = [
        'variant_id',
		'varidCode',
        'duration',
        'ticket_refund_value',
        'transfer_refund_value',
    ];
	
	public function variant()
    {
        return $this->belongsTo(Variant::class, 'variant_id', 'id');
    }
	
	
   
}