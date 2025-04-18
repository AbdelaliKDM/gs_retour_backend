<?php

namespace App\Http\Resources\Payment;

use Illuminate\Http\Request;
use App\Http\Resources\User\AvatarResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Wallet\WalletInfoResource;
use App\Http\Resources\Invoice\InvoiceInfoResource;

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
        'amount_money'=> $this->amount . __('app.currencies.dzd'),
        'status_name' => __("payment.statuses.{$this->status}"),
        'type_name' => __("payment.types.{$this->type}"),
        'payment_method_name' => __("payment.payment_methods.{$this->payment_method}"),
        'account' => $this->account,
        'receipt' => $this->receipt_url,
        'created_at' => $this->created_at,
        'paid_at' => $this->paid_at,
        'user' => new AvatarResource($this->payable->user),
        'payable' => $this->type == 'wallet' ? new WalletInfoResource($this->payable) : new InvoiceInfoResource($this->payable),
      ];
    }
}
