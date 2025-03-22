<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Trip\TripResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DriverResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
      $trip = new TripResource($this->trip);
      $trip = $trip->toArray($request);
      $trip['driver'] = new AvatarResource($this);
      return $trip;
    }
}
