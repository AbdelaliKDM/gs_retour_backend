<?php

namespace App\Http\Resources\Subcategory;

use Illuminate\Http\Resources\Json\JsonResource;

class SubcategoryResource extends JsonResource
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
          'category_id' => $this->category_id,
          'name' => $this->name,
          'image' => $this->image_url,
          //'created_at' => $this->created_at,
          //'updated_at' => $this->updated_at
        ];
    }
}
