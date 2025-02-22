<?php

namespace App\Http\Resources\Trip;

use App\Http\Resources\User\AvatarResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TripInfoResource extends JsonResource
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
          'driver' => new AvatarResource($this->driver),
          'starting_wilaya_id' => $this->starting_wilaya_id,
          'arrival_wilaya_id' => $this->arrival_wilaya_id,
          'starting_wilaya' => $this->startingWilaya->name,
          'arrival_wilaya' => $this->arrivalWilaya->name,
          'truck_type' => $this->truck->truck_type->name,
          'status' => $this->status->name,
          'history' => $this->statuses,
          'distance' => $this->distance,
          'starts_at' => $this->starts_at,
          'created_at' => $this->created_at
        ];
    }
}
