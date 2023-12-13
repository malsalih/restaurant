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
            "price"=> $this->price,
            "name"=> $this->name,
            "available"=>$this->available,
            "image"=> asset($this->image),
            "category"=>new CategoryResource($this->category),
        ];
    }
}
