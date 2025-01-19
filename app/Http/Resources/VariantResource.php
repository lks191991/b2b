<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VariantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
			"id" =>$this->id,
            "ucode" =>$this->ucode,
            "title" =>$this->title,
            "description" =>$this->description,
            "code" => $this->code,
            "advance_booking" =>$this->advance_booking,
            "days_for_advance_booking" =>$this->days_for_advance_booking,
            "booking_window" =>$this->booking_window,
            "cancellation_value" =>$this->cancellation_value,
            "is_opendated" =>$this->is_opendated,
            "valid_till" =>$this->valid_till,
            "availability" =>$this->availability,
            "sic_TFRS" =>$this->sic_TFRS,
            "zones" =>$this->zones,
            "black_out" =>$this->black_out,
            "sold_out" =>$this->sold_out,
            "pvt_TFRS" =>$this->pvt_TFRS,
            "transfer_plan" =>$this->transfer_plan,
            "inclusion" =>$this->inclusion,
            "important_information" =>$this->important_information,
            "cancellation_policy" =>$this->cancellation_policy,
            "slot_type" =>$this->slot_type,
            "available_slots" =>$this->available_slots,
            "slot_duration" =>$this->slot_duration,
            "activity_duration" =>$this->activity_duration,
            "start_time" =>$this->start_time,
            "end_time" =>$this->end_time,
            "status" =>$this->status,
            "is_price" =>$this->is_price,
            "is_slot" =>$this->is_slot,
            "is_canellation" =>$this->is_canellation,
            "pvt_TFRS_text" =>$this->pvt_TFRS_text,
            "pick_up_required" =>$this->pick_up_required,
            "booking_policy" =>$this->booking_policy,
            "terms_conditions" =>$this->terms_conditions,
            "for_backend_only" =>$this->for_backend_only,
			'cart_block_description' => $this->cart_block_description,
            "list_price" =>$this->list_price,
            "sell_price" =>$this->sell_price,
        ];
    }
}
