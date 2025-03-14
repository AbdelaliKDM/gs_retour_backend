<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Shipment extends Model
{
  use HasFactory, SoftDeletes, SoftCascadeTrait;

  protected $fillable = [
    'renter_id',
    'trip_id',
    'truck_type_id',
    'shipment_type_id',
    'starting_wilaya_id',
    'arrival_wilaya_id',
    'starting_point_longitude',
    'starting_point_latitude',
    'arrival_point_longitude',
    'arrival_point_latitude',
    'shipping_date',
    'waiting_hours',
    'distance',
    'price',
    'weight',
  ];

  protected $softCascade = ['statuses', 'orders'];

  public function getWaitingDurationAttribute()
  {
    Carbon::setLocale(session('locale'));
    return Carbon::now()->subHours($this->waiting_hours)->longAbsoluteDiffForHumans();
  }

  public function getIsFavoredAttribute(){
    return $this->favorites()->where('user_id', auth()->id())->exists()
    ? true
    : false;
  }
  public function getTruckTypeNameAttribute()
  {
    return $this->truckType->name;
  }
  public function getShipmentTypeNameAttribute()
  {
    return $this->shipmentType->name;
  }
  public function getStartingWilayaNameAttribute()
  {
    return $this->startingWilaya->name;
  }
  public function getArrivalWilayaNameAttribute()
  {
    return $this->arrivalWilaya->name;
  }
  public function getCurrentStatusAttribute()
  {
    return $this->status->name;
  }

  public function renter()
  {
    return $this->belongsTo(User::class, 'renter_id');
  }
  public function truckType()
  {
    return $this->belongsTo(TruckType::class);
  }
  public function shipmentType()
  {
    return $this->belongsTo(ShipmentType::class);
  }
  public function startingWilaya()
  {
    return $this->belongsTo(Wilaya::class, 'starting_wilaya_id');
  }
  public function arrivalWilaya()
  {
    return $this->belongsTo(Wilaya::class, 'arrival_wilaya_id');
  }
  public function status()
  {
    return $this->hasOne(ShipmentStatus::class);
  }

  public function statuses()
  {
    return $this->hasMany(ShipmentStatus::class);
  }

  public function orders()
  {
    return $this->hasMany(Order::class);
  }

  public function incoming_orders()
  {
    return $this->hasMany(Order::class)->whereNot('created_by', $this->renter_id);
  }

  public function outgoing_orders()
  {
    return $this->hasMany(Order::class)->where('created_by', $this->renter_id);
  }

  public function trips()
  {
    return $this->hasManyThrough(Trip::class, Order::class);
  }

  public function trip()
  {
    return $this->belongsTo(Trip::class);
  }

  public function favorites()
  {
    return $this->morphMany(Favorite::class, 'favorable');
  }
}
