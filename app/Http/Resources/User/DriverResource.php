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
        return[
          'id' => $this->id,
          'name' => $this->name,
          'phone' => $this->phone,
          'image' => $this->image_url,
          'rating' => $this->rating,
          'distance' => number_format($this->distance/1000, 2),
          'trip' => new TripResource($this->trip)
        ];
    }
}
