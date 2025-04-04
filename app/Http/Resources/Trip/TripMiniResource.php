<?php

namespace App\Http\Resources\Trip;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TripMiniResource extends JsonResource
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
          'driver_id' => $this->driver_id,
          'status' => $this->current_status,
        ];
    }
}
