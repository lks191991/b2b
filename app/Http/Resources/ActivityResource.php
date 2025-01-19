<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ActivityResource extends JsonResource
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
				'id' => $this->id,
				'title' => $this->title,
				'city_id' => $this->city_id,
				'state_id' => $this->state_id,
				'country_id' => $this->country_id,
				'currency_id' => $this->currency_id,
				'image' => asset("uploads/activities/".$this->image),
				'product_type' => $this->product_type,
				'entry_type' => $this->entry_type,
				'vat' => $this->vat,
				'tags' => $this->tags,
				'tagsforshow' => $this->tagsforshow,
				'popularity' => $this->popularity,
				'min_price' => $this->min_price,
				'list_price' => $this->list_price,
				'short_description' => $this->short_description,
				'bundle_product_cancellation' => $this->bundle_product_cancellation,
				'notes' => $this->notes,
				'longitute' => $this->longitute,
				'latitude' => $this->latitude,
				'description' => $this->description,
        ];
    }
	
	
}
