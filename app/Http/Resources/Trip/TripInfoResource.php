<?php

namespace App\Http\Resources\Trip;

use Illuminate\Http\Request;
use App\Http\Resources\User\AvatarResource;
use App\Http\Resources\Status\StatusCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Shipment\ShipmentCollection;

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
          'starting_wilaya_id' => $this->starting_wilaya_id,
          'arrival_wilaya_id' => $this->arrival_wilaya_id,
          'starting_wilaya' => $this->startingWilaya->name,
          'arrival_wilaya' => $this->arrivalWilaya->name,
          'starting_point_longitude' => $this->starting_point_longitude,
          'starting_point_latitude' => $this->starting_point_latitude,
          'arrival_point_longitude' => $this->arrival_point_longitude,
          'arrival_point_latitude' => $this->arrival_point_latitude,
          'truck_type' => $this->truck->truckType->name,
          'status' => $this->status->name,
          'distance' => $this->distance,
          'starts_at' => $this->starts_at,
          'created_at' => $this->created_at,
          'driver' => new AvatarResource($this->driver),
          'history' => new StatusCollection($this->statuses),
          'shipments' => new ShipmentCollection($this->shipments)
        ];
    }
}
