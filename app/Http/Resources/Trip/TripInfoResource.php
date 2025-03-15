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
          'starting_wilaya' => $this->starting_wilaya_name,
          'arrival_wilaya' => $this->arrival_wilaya_name,
          'starting_point_longitude' => $this->starting_point_longitude,
          'starting_point_latitude' => $this->starting_point_latitude,
          'arrival_point_longitude' => $this->arrival_point_longitude,
          'arrival_point_latitude' => $this->arrival_point_latitude,
          'truck_type' => $this->truck_type_name,
          'status' => $this->current_status,
          'distance' => $this->distance,
          'starts_at' => $this->starts_at,
          'created_at' => $this->created_at,
          'is_favored' => $this->is_favored,
          'orders_count' => $this->orders_count,
          'driver' => new AvatarResource($this->driver),
          'history' => new StatusCollection($this->statuses),
          'shipments' => new ShipmentCollection($this->shipments)
        ];
    }
}
