<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $table = "vouchers";

    
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function agent()
    {
        return $this->belongsTo(User::class,'agent_id','id');
    }
	
	public function customer()
    {
        return $this->belongsTo(Customer::class,'customer_id','id');
    }
	
	public function arrivalairline()
    {
        return $this->belongsTo(Airline::class,'arrival_airlines_id','id');
    }
	
	public function depatureairline()
    {
        return $this->belongsTo(Airline::class,'depature_airlines_id','id');
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
	
	 public function voucheredBy()
    {
        return $this->belongsTo(User::class, 'vouchered_by', 'id');
    }
	
	 public function fileHandlingBy()
    {
        return $this->belongsTo(User::class, 'file_handling_by', 'id');
    }
	
	function voucheractivity() {

    return $this->hasMany(VoucherActivity::class);
}

public function voucherActivities()
    {
        return $this->hasMany(VoucherActivity::class, 'voucher_id'); // assuming 'voucher_id' is the foreign key in VoucherActivity
    }

	public function getParent()
    {
        return $this->belongsTo(Voucher::class, 'parent_id');
    }

    public function getChild()
    {
        return $this->hasMany(Voucher::class, 'parent_id')->where('id', '!=', $this->id);
    }
   
}