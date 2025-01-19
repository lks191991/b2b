<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoucherActivity extends Model
{
	protected $table ="voucher_activity";
	
	public function voucher()
    {
        return $this->belongsTo(Voucher::class,'voucher_id','id');
    }
	
	public function activity()
    {
        return $this->belongsTo(Activity::class,'activity_id','id');
    }
	
	public function supplierticket()
    {
        return $this->belongsTo(User::class,'supplier_ticket','id');
    }
	
	public function suppliertransfer()
    {
        return $this->belongsTo(User::class,'supplier_transfer','id');
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

    public function transferZone()
    {
        return $this->belongsTo(Zone::class, 'transfer_zone', 'id');
    }
    
	public function variant()
    {
        return $this->belongsTo(Variant::class,'variant_code','ucode');
    }

    public function suppliertransfer2()
    {
        return $this->belongsTo(User::class,'supplier_transfer2','id');
    }
	
	
}
