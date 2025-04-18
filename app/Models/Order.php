<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
  use HasFactory, SoftDeletes, SoftCascadeTrait;

  protected $fillable = [
    'trip_id',
    'shipment_id',
    'status',
  ];

  public function getTypeAttribute()
  {
    return $this->created_by == auth()->id()
      ? 'outgoing'
      : 'incoming';
  }

  public function getSenderAttribute()
  {
    return User::find($this->created_by);
  }

  public function getReceiverAttribute()
  {
    return $this->created_by == $this->trip->driver_id
    ? $this->shipment->renter
    : $this->trip->driver ;
  }

  protected static function booted()
  {
    static::creating(function ($order) {
      $order->created_by = auth()->id();
    });
    static::updating(function ($order) {
      $order->updated_by = auth()->id();
    });
    static::deleting(function ($order) {
      if (!$order->isForceDeleting()) {
        $order->deleted_by = auth()->id();
        $order->saveQuietly();
      }
    });
  }

  public function trip()
  {
    return $this->belongsTo(Trip::class);
  }
  public function shipment()
  {
    return $this->belongsTo(Shipment::class);
  }

  public function updateStatus($newStatus)
  {

    $currentStatus = $this->status;

    $allowedTransitions = [
      'pending' => ['accepted', 'rejected'],
      'accepted' => [],
      'rejected' => [],
    ];

    if (!in_array($newStatus, $allowedTransitions[$currentStatus])) {
      throw new Exception("Cannot change status from {$currentStatus} to {$newStatus}.", 406);
    }

if (auth()->id() === $this->created_by) {
    throw new Exception('You cannot update the status of an order you created.', 406);
}

    $shipment = $this->shipment;
    $trip = $this->trip;

    $isRenter = auth()->id() === $shipment->renter_id;
    $isDriver = auth()->id() === $trip->driver_id;

    if (!$isRenter && !$isDriver) {
      throw new Exception('Not allowed',405);
    }

    $this->update(['status' => $newStatus]);


    if ($newStatus == 'accepted') {
      $shipment->update(['trip_id' => $trip->id]);
      $shipment->orders()->whereNot('id', $this->id)->update(['status' => 'rejected']);
      $shipment->favorites()->delete();
    }

    $notice = Notice::OrderNotice($this, $this->sender, $newStatus);

    $notice->send($this->sender);

    return ;
  }
}
