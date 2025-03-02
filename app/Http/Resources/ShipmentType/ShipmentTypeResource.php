<?php

namespace App\Http\Resources\ShipmentType;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShipmentTypeResource extends JsonResource
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
        'name' => $this->name
      ];
    }
}
