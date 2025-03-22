<?php

namespace App\Http\Resources\Transaction;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PaginatedTransactionCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public $collects = TransactionResource::class;
    public function toArray($request)
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
