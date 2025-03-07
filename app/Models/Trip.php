<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Trip extends Model
{
  use HasFactory, SoftDeletes, SoftCascadeTrait;
  protected $fillable = [
    'driver_id',
    'truck_id',
    'starting_wilaya_id',
    'arrival_wilaya_id',
    'starting_point_longitude',
    'starting_point_latitude',
    'arrival_point_longitude',
    'arrival_point_latitude',
    'distance',
    'starts_at'
  ];
  protected $softCascade = ['statuses', 'orders'];

  public function driver(): BelongsTo
  {
    return $this->belongsTo(User::class, 'driver_id');
  }

  public function truck(): BelongsTo
  {
    return $this->belongsTo(Truck::class);
  }

  public function startingWilaya(): BelongsTo
  {
    return $this->belongsTo(Wilaya::class, 'starting_wilaya_id');
  }

  public function arrivalWilaya(): BelongsTo
  {
    return $this->belongsTo(Wilaya::class, 'arrival_wilaya_id');
  }

  public function status()
  {
    return $this->hasOne(TripStatus::class);
  }

  public function statuses()
  {
    return $this->hasMany(TripStatus::class);
  }

  public function orders()
  {
    return $this->hasMany(Order::class)->whereNot('created_by', $this->driver_id);
  }

  public function shipments()
  {
    return $this->hasMany(Shipment::class);
  }

  public function favorites()
  {
    return $this->morphMany(Favorite::class, 'favorable');
  }
}
