<?php

namespace App\Http\Resources\Payment;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
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
      'amount' => $this->amount,
      'payment_method' => $this->payment_method,
      'status' => $this->status,
      'type' => $this->type,
      'account' => $this->account,
      'receipt' => $this->receipt_url,
      'created_at' => $this->created_at,
    ];
  }
}
