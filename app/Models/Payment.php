<?php

namespace App\Models;

use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Payment extends Model
{
  use HasFactory, SoftDeletes, SoftCascadeTrait;

  protected $fillable = [
    'amount',
    'payment_method',
    'status',
    'account',
    'receipt',
    'paid_at',
    'created_at'
  ];

  protected $casts = [
    'amount' => 'decimal:2',
    'paid_at' => 'datetime',
  ];

  public function payable()
  {
    return $this->morphTo();
  }

  public function getReceiptUrlAttribute()
  {
    return $this->receipt && Storage::disk('upload')->exists($this->receipt)
      ? Storage::disk('upload')->url($this->receipt)
      : null;
  }

  public function getTypeAttribute(){
    return match($this->payable_type){
      Wallet::class => 'wallet',
      Invoice::class => 'invoice',
      default => null
    };
  }

  public function updateStatus($newStatus)
  {
    $currentStatus = $this->status;

    $allowedTransitions = [
      'pending' => ['failed', 'paid'],
      'failed' => [],
      'paid' => [],
    ];

    if (!in_array($newStatus, $allowedTransitions[$currentStatus])) {
      throw new Exception("Cannot change status from {$currentStatus} to {$newStatus}.");
    }

    $data = ['status' => $newStatus];

    if ($newStatus == 'paid') {
        if($this->type == 'wallet'){
          $wallet = $this->payable;
          $wallet->update(['balance' => $wallet->balance + $this->amount]);
        }

        $data['paid_at'] = now();
    }

    $this->update($data);

    $notice = Notice::PaymentNotice($this->type, $newStatus);

    $notice->send($this->payable->user());

    return ;
  }
}
