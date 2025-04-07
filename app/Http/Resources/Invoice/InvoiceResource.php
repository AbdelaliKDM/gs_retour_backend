<?php

namespace App\Http\Resources\Invoice;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
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
          'month' => $this->month_name,
          'year' => $this->year,
          'total_amount' => $this->total_amount,
          'tax_amount' => $this->tax_amount,
          'status' => $this->status
        ];
    }
}
