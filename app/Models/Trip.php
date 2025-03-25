<?php

namespace App\Models;

use Exception;
use Illuminate\Support\Carbon;
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

  public function getIsFavoredAttribute()
  {
    return $this->favorites()->where('user_id', auth()->id())->exists()
      ? true
      : false;
  }
  public function getTruckTypeNameAttribute()
  {
    return $this->truck->truckType->name;
  }

  public function getSubcategoryNameAttribute()
  {
    return $this->truck?->truckType?->subcategory?->name;
  }

  public function getCategoryNameAttribute()
  {
    return $this->truck?->truckType?->subcategory?->category?->name;
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
  public function getTotalPriceAttribute(){
    return $this->shipments()->sum('price');
  }
  public function getOrdersCountAttribute()
  {
    return $this->incoming_orders()->where('status' , 'pending')->count();
  }
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
    return $this->hasOne(TripStatus::class)->latestOfMany();
  }

  public function statuses()
  {
    return $this->hasMany(TripStatus::class);
  }

  public function orders()
  {
    return $this->hasMany(Order::class);
  }

  public function pending_orders()
  {
    return $this->hasMany(Order::class)->where('status', 'pending');
  }

  public function incoming_orders()
  {
    return $this->hasMany(Order::class)->whereNot('created_by', $this->driver_id);
  }

  public function outgoing_orders()
  {
    return $this->hasMany(Order::class)->where('created_by', $this->driver_id);
  }

  public function shipments()
  {
    return $this->hasMany(Shipment::class);
  }

  public function pending_shipments()
  {
    return $this->hasMany(Shipment::class)->whereHas('status', function($query){
      $query->whereNot('name', 'delivered');
    });
  }

  public function favorites()
  {
    return $this->morphMany(Favorite::class, 'favorable');
  }

  public function reviews()
  {
    return $this->hasMany(Review::class);
  }

  public function transaction()
  {
    return $this->hasOne(Transaction::class);
  }

  public function renters(){
    return $this->hasManyThrough(User::class, Shipment::class, 'trip_id','id','id','renter_id');
  }

  public function updateStatus($newStatus)
  {
    $currentStatus = $this->current_status;

    $allowedTransitions = [
      'pending' => ['ongoing', 'canceled'],
      'ongoing' => ['paused', 'completed'],
      'paused' => ['ongoing', 'canceled'],
      'canceled' => [],
      'completed' => [],
    ];

    if (!in_array($newStatus, $allowedTransitions[$currentStatus])) {
      throw new Exception("Cannot change status from {$currentStatus} to {$newStatus}.");
    }

    if ($currentStatus == 'pending' && $newStatus == 'ongoing') {
      if (auth()->user()->ongoing_trip()->exists()) {
        throw new Exception('The driver already have an ongoing trip.');
      }

      if ($this->pending_orders()->exists()) {
        throw new Exception('The trip has pending orders.');
      }

    } elseif ($currentStatus == 'ongoing' && $newStatus == 'completed') {
      if ($this->pending_shipments()->exists()) {
        throw new Exception('The trip has pending shipments.');
      }

      $this->createTransaction();

    } elseif ($currentStatus == 'paused' && $newStatus == 'canceled') {
      if ($this->shipments()->exists()) {
        throw new Exception('The trip has shipments.');
      }
    }


    $this->statuses()->create(['name' => $newStatus]);

    $notice = Notice::TripNotice($this->id, $newStatus);

    $notice->send($this->renters());

    return ;
  }

  public function createTransaction(){
    $driver = $this->driver;

    $month = Carbon::now()->firstOfMonth();

    $invoice = $driver->invoices()->firstOrCreate(['month' => $month]);

    $tax_ratio = Setting::getTaxRatio();

    $this->transaction()->create([
      'invoice_id' => $invoice->id,
      'total_amount' => $this->total_price,
      'tax_amount' => $this->total_price * ($tax_ratio / 100)
    ]);

  }
}
