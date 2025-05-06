<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $table = "tickets";
    public $timestamps = true;
	protected $fillable = [
        'ticket_for', 'type_of_ticket', 'activity_id', 'activity_variant',
        'ticket_no', 'serial_number', 'valid_from', 'valid_till', 'terms_and_conditions',
        'voucher_id', 'voucher_activity_id', 'ticket_generated', 'ticket_downloaded', 
        'ticket_generated_by', 'ticket_downloaded_by', 'generated_time', 'downloaded_time',
        'net_cost', 'supplier_ticket', 'isRayna', 'rayna_ticket_details', 'rayna_ticketURL', 'noOfAdult', 'noOfchild'
    ];
    
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
