<?php

namespace App\Models;

use Exception;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * 
 *
 * @property int $id
 * @property int $renter_id
 * @property int|null $trip_id
 * @property int $truck_type_id
 * @property int $shipment_type_id
 * @property int $starting_wilaya_id
 * @property int $arrival_wilaya_id
 * @property float $starting_point_longitude
 * @property float $starting_point_latitude
 * @property float $arrival_point_longitude
 * @property float $arrival_point_latitude
 * @property \Illuminate\Support\Carbon $shipping_date
 * @property string $waiting_hours
 * @property float $distance
 * @property float $price
 * @property float $weight
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Wilaya $arrivalWilaya
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Favorite> $favorites
 * @property-read int|null $favorites_count
 * @property-read mixed $arrival_wilaya_name
 * @property-read mixed $current_status
 * @property-read mixed $is_favored
 * @property-read int|null $orders_count
 * @property-read mixed $shipment_type_name
 * @property-read mixed $starting_wilaya_name
 * @property-read mixed $truck_type_name
 * @property-read mixed $waiting_duration
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Order> $incoming_orders
 * @property-read int|null $incoming_orders_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Order> $orders
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Order> $outgoing_orders
 * @property-read int|null $outgoing_orders_count
 * @property-read \App\Models\User $renter
 * @property-read \App\Models\ShipmentType $shipmentType
 * @property-read \App\Models\Wilaya $startingWilaya
 * @property-read \App\Models\ShipmentStatus|null $status
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ShipmentStatus> $statuses
 * @property-read int|null $statuses_count
 * @property-read \App\Models\Trip|null $trip
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Trip> $trips
 * @property-read int|null $trips_count
 * @property-read \App\Models\TruckType $truckType
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shipment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shipment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shipment onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shipment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shipment whereArrivalPointLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shipment whereArrivalPointLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shipment whereArrivalWilayaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shipment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shipment whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shipment whereDistance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shipment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shipment wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shipment whereRenterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shipment whereShipmentTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shipment whereShippingDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shipment whereStartingPointLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shipment whereStartingPointLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shipment whereStartingWilayaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shipment whereTripId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shipment whereTruckTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shipment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shipment whereWaitingHours($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shipment whereWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shipment withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shipment withoutTrashed()
 * @mixin \Eloquent
 */
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

  protected $casts = [
    'shipping_date' => 'datetime',
    'distance' => 'double',
    'price' => 'double',
    'weight' => 'double',
    'starting_point_longitude' => 'double',
    'starting_point_latitude' => 'double',
    'arrival_point_longitude' => 'double',
    'arrival_point_latitude' => 'double',
  ];

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
  public function getOrdersCountAttribute()
  {
    return $this->incoming_orders()->where('status' , 'pending')->count();
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
    return $this->hasOne(ShipmentStatus::class)->latestOfMany();
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

  public function updateStatus($newStatus)
  {
    $currentStatus = $this->current_status;

    $allowedTransitions = [
      'pending' => ['shipped'],
      'shipped' => ['delivered'],
      'delivered' => [],
    ];

    if (!in_array($newStatus, $allowedTransitions[$currentStatus])) {
      throw new Exception("Cannot change status from {$currentStatus} to {$newStatus}.", 406);
    }

    if ($this->trip?->current_status != 'ongoing') {
      throw new Exception('The trip status is not ongoing.', 406);
    }

    $this->statuses()->create(['name' => $newStatus]);

    $notice = Notice::ShipmentNotice($this->id, $newStatus);

    $notice->send($this->renter());

    return ;
  }
}
