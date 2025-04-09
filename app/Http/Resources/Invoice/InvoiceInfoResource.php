<?php

namespace App\Http\Resources\Invoice;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceInfoResource extends JsonResource
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
        'total_amount_money'=> number_format($this->total_amount) . __('app.currencies.dzd'),
        'tax_amount_money'=> number_format($this->tax_amount) . __('app.currencies.dzd'),
        'status' => $this->status
      ];
    }
}
