<?php

namespace App\Http\Resources\Trip;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TripResource extends JsonResource
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
          'starting_wilaya_id' => $this->starting_wilaya_id,
          'arrival_wilaya_id' => $this->arrival_wilaya_id,
          'starting_wilaya' => $this->starting_wilaya_name,
          'arrival_wilaya' => $this->arrival_wilaya_name,
          'truck_type' => $this->truck_type_name,
          'status' => $this->current_status,
          'distance' => $this->distance,
          'starts_at' => $this->starts_at,
          'created_at' => $this->created_at,
          'is_favored' => $this->is_favored,
          'orders_count' => $this->orders_count,
        ];
    }
}
