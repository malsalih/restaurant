<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class BillResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "Bill_id"=> $this->id,
            "customer"=> new CustomerResource($this->customer),
            "cashier"=> new UserResource($this->user->setAttribute('just_name',true)),
            "total_price"=>$this->total_price,
            "discount"=>$this->discount,
            "final_price"=>$this->final_price,
            "preparation_time"=>$this->preparation_time,
            "order_type_id"=>new OrderTypeResource($this->order_type),
            "is_paid_id"=>new IsPaidResource($this->is_paid),
        ];
    }
}
