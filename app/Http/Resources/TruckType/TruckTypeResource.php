<?php

namespace App\Http\Resources\TruckType;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TruckTypeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
      return [
        'id' => $this->id,
        'category_id' => $this->category->id,
        'subcategory_id' => $this->subcategory_id,
        'name' => $this->name,
        'image' => $this->image_url,
        'weight' => $this->weight,
        'capacity' => $this->capacity,
      ];
    }
}
