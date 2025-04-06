<?php

namespace App\Http\Resources\Payment;

use App\Http\Resources\User\AvatarResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentInfoResource extends JsonResource
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
        'paid_at' => $this->paid_at,
        'user' => new AvatarResource($this->payable->user)
      ];
    }
}
