<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ActivityVariantPriceResource extends JsonResource
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
            "id" => $this->id,
            "activity_variant_id" => $this->activity_variant_id,
            "adult_rate_without_vat" => $this->adult_rate_without_vat,
            "adult_rate_with_vat" => $this->adult_rate_with_vat,
            "adult_mini_selling_price" => $this->adult_mini_selling_price,
            "adult_B2C_with_vat" => $this->adult_B2C_with_vat,
            "adult_max_no_allowed" => $this->adult_max_no_allowed,
            "adult_min_no_allowed" => $this->adult_min_no_allowed,
            "child_rate_without_vat" => $this->child_rate_without_vat,
            "child_rate_with_vat" => $this->child_rate_with_vat,
            "child_mini_selling_price" => $this->child_mini_selling_price,
            "child_B2C_with_vat" => $this->child_B2C_with_vat,
            "child_max_no_allowed" => $this->child_max_no_allowed,
            "child_min_no_allowed" => $this->child_min_no_allowed,
            "infant_rate_without_vat" => $this->infant_rate_without_vat,
            "infant_rate_with_vat" => $this->infant_rate_with_vat,
            "infant_mini_selling_price" => $this->infant_mini_selling_price,
            "infant_B2C_with_vat" => $this->infant_B2C_with_vat,
            "infant_max_no_allowed" => $this->infant_max_no_allowed,
            "infant_min_no_allowed" => $this->infant_min_no_allowed,
            "adult_start_age" => $this->adult_start_age,
            "adult_end_age" => $this->adult_end_age,
            "child_start_age" => $this->child_start_age,
            "child_end_age" => $this->child_end_age,
            "infant_start_age" => $this->infant_start_age,
            "infant_end_age" => $this->infant_end_age,
            "rate_valid_from" => $this->rate_valid_from,
            "rate_valid_to" => $this->rate_valid_to,
        ];
    }
}
