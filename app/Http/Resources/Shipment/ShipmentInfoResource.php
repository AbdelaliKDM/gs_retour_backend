<?php

namespace App\Http\Resources\Shipment;

use Illuminate\Http\Request;
use App\Http\Resources\Trip\TripResource;
use App\Http\Resources\User\AvatarResource;
use App\Http\Resources\Status\StatusCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class ShipmentInfoResource extends JsonResource
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
          'truck_type' => $this->truckType->name,
          'shipment_type' => $this->shipmentType->name,
          'status' => $this->status->name,
          'distance' => $this->distance,
          'price' => $this->price,
          'weight' => $this->weight,
          'waiting_hours' => $this->waiting_hours,
          'waiting_duration' => $this->waiting_duration,
          'shipping_date' => $this->shipping_date,
          'created_at' => $this->created_at,
          'renter' => new AvatarResource($this->renter),
          'history' => new StatusCollection($this->statuses),
          'trip' => new TripResource($this->trip),
        ];
    }
}
