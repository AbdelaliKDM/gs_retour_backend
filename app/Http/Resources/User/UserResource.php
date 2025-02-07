<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use App\Http\Resources\Truck\TruckResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
      'name' => $this->name,
      'email' => $this->email,
      'phone' => $this->phone,
      'image' => $this->image_url,
      'id_card' => $this->card_url,
      'id_card_selfie' => $this->selfie_url,
      'role' => $this->role,
      'status' => $this->status,
      'device_token' => $this->device_token,
      //'truck' => new TruckResource($this->truck)
    ];
  }
}
