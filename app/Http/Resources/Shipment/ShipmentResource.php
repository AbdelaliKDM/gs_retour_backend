<?php

namespace App\Http\Resources\Shipment;

use Illuminate\Http\Request;
use App\Http\Resources\User\AvatarResource;
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
      $data = [
        'id' => $this->id,
        'trip_id' => $this->trip_id,
        'starting_wilaya_id' => $this->starting_wilaya_id,
        'arrival_wilaya_id' => $this->arrival_wilaya_id,
        'starting_wilaya' => $this->starting_wilaya_name,
        'arrival_wilaya' => $this->arrival_wilaya_name,
        'truck_type' => $this->truck_type_name,
        'shipment_type' => $this->shipment_type_name,
        'status' => $this->current_status,
        'distance' => $this->distance,
        'price' => $this->price,
        'weight' => $this->weight,
        'waiting_hours' => $this->waiting_hours,
        'waiting_duration' => $this->waiting_duration,
        'shipping_date' => $this->shipping_date,
        'created_at' => $this->created_at,
        'renter' => new AvatarResource($this->renter),
        'is_favored' => $this->is_favored,
        'orders_count' => $this->orders_count,
      ];

      if($request->renter_id && $request->trip_id){
        $data['is_ordered'] = $this->orders()->where('trip_id', $request->trip_id)->exists();
      }

      return $data;
    }
}
