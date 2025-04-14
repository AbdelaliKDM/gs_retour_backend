<?php

namespace App\Http\Resources\TruckType;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TruckTypeInfoResource extends JsonResource
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
      'name_en' => $this->name_en,
      'name_ar' => $this->name_ar,
      'name_fr' => $this->name_fr,
      'image' => $this->image_url,
      'weight' => $this->weight,
      'capacity' => $this->capacity
    ];
  }
}
