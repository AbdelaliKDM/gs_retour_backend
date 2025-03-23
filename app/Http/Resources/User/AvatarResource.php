<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AvatarResource extends JsonResource
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
        'name' => $this->name,
        'phone' => $this->phone,
        'image' => $this->image_url,
      ];

      if($this->role == 'driver'){
        $data['rating'] = $this->rating;
      }

      if($this->distance){
        $data['distance'] = number_format($this->distance/1000 , 2);
      }

      return $data;
    }
}
