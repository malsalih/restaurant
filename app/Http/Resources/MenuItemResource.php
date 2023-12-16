<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MenuItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=> $this->id,
            "name"=> $this->name,
            "price"=> $this->price,
            "discounted_price"=>$this->discounted_price,
            "offer"=>$this->offer,
            "available"=>$this->available,
            "image"=> $this->image,
            "details"=>$this->details,
            "prep_time"=>$this->prep_time,
            "category"=>new CategoryResource($this->category),
            "created_at"=>$this->created_at,
            "updated_at"=>$this->updated_at,
        ];
    }
}
