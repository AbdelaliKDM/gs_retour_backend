<?php

namespace App\Http\Resources\Wallet;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WalletInfoResource extends JsonResource
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
        'user_id' => $this->user_id,
        'balance' => $this->balance,
        'balance_money'=> number_format($this->balance) . __('app.currencies.dzd'),
        'charges' => $this->charges,
        'created_at' => $this->created_at,
    ];
    }
}
