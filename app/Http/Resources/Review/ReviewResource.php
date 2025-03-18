<?php

namespace App\Http\Resources\Review;

use App\Http\Resources\User\AvatarResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
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
          'trip_id' => $this->trip_id,
          'rating' => $this->rating,
          'note' => $this->note,
          'user' => new AvatarResource($this->user)
        ];
    }
}
