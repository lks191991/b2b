<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Company extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        //return parent::toArray($request);

        return [
            'id' => $this->id,
            'name' => $this->name,
            //'status' => $this->status,
            //'created_at' => date(config('app.date_format'),strtotime($this->created_at)),
           // 'updated_at' => date(config('app.date_format'),strtotime($this->updated_at)),
        ];
    }
}
