<?php

namespace App\Models;

use Exception;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * 
 *
 * @property int $id
 * @property int $driver_id
 * @property int $truck_id
 * @property int $starting_wilaya_id
 * @property int $arrival_wilaya_id
 * @property float $starting_point_longitude
 * @property float $starting_point_latitude
 * @property float $arrival_point_longitude
 * @property float $arrival_point_latitude
 * @property float $distance
 * @property \Illuminate\Support\Carbon $starts_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Wilaya $arrivalWilaya
 * @property-read \App\Models\User $driver
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Favorite> $favorites
 * @property-read int|null $favorites_count
 * @property-read mixed $arrival_wilaya_name
 * @property-read mixed $category_name
 * @property-read mixed $current_status
 * @property-read mixed $is_favored
 * @property-read int|null $orders_count
 * @property-read int|null $shipments_count
 * @property-read mixed $starting_wilaya_name
 * @property-read mixed $subcategory_name
 * @property-read mixed $total_price
 * @property-read mixed $truck_type_name
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Order> $incoming_orders
 * @property-read int|null $incoming_orders_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Order> $orders
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Order> $outgoing_orders
 * @property-read int|null $outgoing_orders_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Order> $pending_orders
 * @property-read int|null $pending_orders_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Shipment> $pending_shipments
 * @property-read int|null $pending_shipments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $renters
 * @property-read int|null $renters_count
 * @property-read \App\Models\Review|null $review
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Review> $reviews
 * @property-read int|null $reviews_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Shipment> $shipments
 * @property-read \App\Models\Wilaya $startingWilaya
 * @property-read \App\Models\TripStatus|null $status
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TripStatus> $statuses
 * @property-read int|null $statuses_count
 * @property-read \App\Models\Transaction|null $transaction
 * @property-read \App\Models\Truck $truck
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Trip newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Trip newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Trip onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Trip query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Trip whereArrivalPointLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Trip whereArrivalPointLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Trip whereArrivalWilayaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Trip whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Trip whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Trip whereDistance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Trip whereDriverId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Trip whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Trip whereStartingPointLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Trip whereStartingPointLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Trip whereStartingWilayaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Trip whereStartsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Trip whereTruckId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Trip whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Trip withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Trip withoutTrashed()
 * @mixin \Eloquent
 */
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

  protected $casts = [
    'starts_at' => 'datetime',
    'distance' => 'double',
    'starting_point_longitude' => 'double',
    'starting_point_latitude' => 'double',
    'arrival_point_longitude' => 'double',
    'arrival_point_latitude' => 'double',
  ];

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
  public function getTotalPriceAttribute()
  {
    return $this->shipments()->sum('price');
  }
  public function getOrdersCountAttribute()
  {
    return $this->incoming_orders()->where('status', 'pending')->count();
  }

  public function getShipmentsCountAttribute()
  {
    return $this->shipments()->count();
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
    return $this->hasMany(Shipment::class)->whereHas('status', function ($query) {
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
  public function review()
  {
    return $this->hasOne(Review::class)->where('user_id', auth()->id())->oldestOfMany();
  }
  public function transaction()
  {
    return $this->hasOne(Transaction::class);
  }

  public function renters()
  {
    return $this->hasManyThrough(User::class, Shipment::class, 'trip_id', 'id', 'id', 'renter_id');
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
      throw new Exception("Cannot change status from {$currentStatus} to {$newStatus}.", 406);
    }

    if ($currentStatus == 'pending' && $newStatus == 'ongoing') {
      if (auth()->user()->ongoing_trip()->exists()) {
        throw new Exception('The driver already have an ongoing trip.', 406);
      }

      /* if ($this->pending_orders()->exists()) {
        throw new Exception('The trip has pending orders.', 406);
      } */

      $this->incoming_orders()->where('status','pending')->update(['status' => 'rejected']);
      $this->outgoing_orders()->where('status','pending')->delete();;
      $this->favorites()->delete();


    } elseif ($currentStatus == 'ongoing' && $newStatus == 'completed') {
      if ($this->pending_shipments()->exists()) {
        throw new Exception('The trip has pending shipments.', 406);
      }

      $this->createTransaction();

    } elseif ($currentStatus == 'paused' && $newStatus == 'canceled') {
      if ($this->shipments()->exists()) {
        throw new Exception('The trip has shipments.', 406);
      }
    }


    $this->statuses()->create(['name' => $newStatus]);

    $notice = Notice::TripNotice($this->id, $newStatus);

    $notice->send($this->renters());

    return;
  }

  public function createTransaction()
  {
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
