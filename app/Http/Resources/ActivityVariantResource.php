<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ActivityVariantPriceResource ;

class ActivityVariantResource extends JsonResource
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
            'activity_id' => $this->activity_id,
            'variant_id' => $this->variant_id,
            'type' => $this->type,
            'ucode' => $this->ucode,
            'code' => $this->code,
            'prices' => new ActivityVariantPriceResource($this->prices),
        ];
    }

}
