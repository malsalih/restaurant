<?php

namespace App\Http\Resources;

use App\Models\Chef;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChefResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // dd(MenuItem::find($request->category_id));

        //$chef=Chef::find($request->category_id);
        return [
            "id"=> $this->id,
            // "chef"=>()
            "chef"=> $this->chef,
            // "price"=> $this->price,
            // "chef"=> $this->chef_id,
            // "category"=> new CategoryResource($this->category),

        ];
    }
}
