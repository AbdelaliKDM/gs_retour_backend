<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * 
 *
 * @property int $id
 * @property string $payable_type
 * @property int $payable_id
 * @property float $amount
 * @property string|null $payment_method
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $paid_at
 * @property string|null $account
 * @property string|null $receipt
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read mixed $receipt_url
 * @property-read mixed $type
 * @property-read Model|\Eloquent $payable
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment wherePaidAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment wherePayableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment wherePayableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereReceipt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment withoutTrashed()
 * @mixin \Eloquent
 */
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
    'amount' => 'double',
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
      throw new Exception("Cannot change status from {$currentStatus} to {$newStatus}.", 406);
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
