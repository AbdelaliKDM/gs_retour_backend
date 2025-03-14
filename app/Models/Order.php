<?php

namespace App\Models;

use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes, SoftCascadeTrait;

    protected $fillable = [
      'trip_id',
      'shipment_id',
      'status',
  ];

  public function getTypeAttribute(){
    return $this->created_by == auth()->id()
    ? 'outgoing'
    : 'incoming';
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
}
