<?php

namespace App\Http\Resources\TruckImage;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PaginatedTruckImageCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */

    public $collects = TruckImageResource::class;
    public function toArray(Request $request): array
    {
      return [

        'data' => $this->collection,
        'meta' => [
          'current_page' => $this->currentPage(),
          'last_page' => $this->lastPage(),
          'per_page' => $this->perPage(),
          'total' => $this->total(),
          'count' => $this->count(),
        ]

      ];
    }
}
