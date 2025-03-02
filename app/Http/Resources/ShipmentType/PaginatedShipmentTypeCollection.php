<?php

namespace App\Http\Resources\ShipmentType;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PaginatedShipmentTypeCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public $collects = ShipmentTypeResource::class;
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
