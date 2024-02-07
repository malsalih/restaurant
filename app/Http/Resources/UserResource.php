<?php

namespace App\Http\Resources;

use App\Models\Bill;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        
            return ($this->nameReturn($request) ?? $this->fullReturn($request));


        

    }
    public function nameReturn($request)
    {
        if ($this->just_name) {
            return [
                'id' => $this->id,
                'name'=> $this->name,
            ];
        }
        return null;
    }

    public function fullReturn($request)
    {
        return [
            "id"=> $this->id,
            "name"=> $this->name,
            "email"=> $this->email,
            'phone'=> $this->phone,
            'address'=> $this->address,
            'user_type'=> new UserTypeResource($this->userType),
            'category'=> new CategoryResource($this->category),
            'isActive'=>$this->isActive,
            'workStart'=>$this->workStart,
            'workEnd'=> $this->workEnd,
            'salary'=>$this->salary,
        ];
    }

        
}
