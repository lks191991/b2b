<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VoucherHotel extends Model
{
    protected $table = "voucher_hotels";
	public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
   
   public function voucher()
    {
        return $this->belongsTo(Voucher::class,'voucher_id','id');
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
