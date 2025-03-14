<?php

namespace App\Http\Resources\Order;

use Illuminate\Http\Request;
use App\Http\Resources\Trip\TripResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Shipment\ShipmentResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
      $data = [
        'id' => $this->id,
        'status' => $this->status,
        'type' => $this->type
      ];

      if($request->has('trip_id')){
        $data['shipment'] = new ShipmentResource($this->shipment);
      }
      if($request->has('shipment_id')){
        $data['trip'] = new TripResource($this->trip);
      }

      return $data;
    }
}
