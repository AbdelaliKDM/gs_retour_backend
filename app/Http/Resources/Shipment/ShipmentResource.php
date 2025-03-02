<?php

namespace App\Http\Resources\Shipment;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShipmentResource extends JsonResource
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
        'truck_type' => $this->truckType->name,
        'shipment_type' => $this->shipmentType->name,
        'status' => $this->status->name,
        'distance' => $this->distance,
        'price' => $this->price,
        'weight' => $this->weight,
        'waiting_hours' => $this->waiting_hours,
        'waiting_duration' => $this->waiting_duration,
        'shipping_date' => $this->shipping_date,
        'created_at' => $this->created_at
      ];
    }
}
