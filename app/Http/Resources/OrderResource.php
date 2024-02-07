<?php

namespace App\Http\Resources;

use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            "category_id"=> $this->category_id,
            // "user_id"=> new UserResource($this->user->setAttribute('just_name',true)),
            "customer"=> new CustomerResource($this->customer),
            // "price"=>new MenuItemResource($this->price),

            "name"=> new MenuItemResource($this->menu_item),
            "type"=> new OrderTypeResource($this->order_type),
            "status"=>new OrderStatusResource($this->order_status),
            "desk"=>new DeskResource($this->desk),


        ];
    }
}
