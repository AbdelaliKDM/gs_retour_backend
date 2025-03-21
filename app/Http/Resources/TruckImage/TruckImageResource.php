<?php

namespace App\Http\Resources\TruckImage;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TruckImageResource extends JsonResource
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
          'url' => $this->url
        ];
    }
}
