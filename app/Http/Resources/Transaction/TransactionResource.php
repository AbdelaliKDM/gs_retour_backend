<?php

namespace App\Http\Resources\Transaction;

use App\Http\Resources\Trip\TripResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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
          'invoice_id' => $this->invoice_id,
          'total_amount' => $this->total_amount,
          'tax_amount' => $this->tax_amount,
          'created_at' => $this->created_at,
          'trip' => new TripResource($this->trip)
        ];
    }
}
