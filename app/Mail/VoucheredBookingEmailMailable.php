<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VoucheredBookingEmailMailable extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
       $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        
        $voucher = $this->data['voucher'];
        $voucherActivity = $this->data['voucherActivity'];
        $voucherHotel = $this->data['voucherHotel'];
		$this->subject("Booking Confirmation");
        
        return $this->markdown('emails.VoucheredBookingEmail', compact('voucher','voucherActivity','voucherHotel'));
    }
}
