<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trip extends Model
{
  use HasFactory, SoftDeletes;
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

    protected $casts = [
        'starts_at' => 'datetime',
        'starting_point_longitude' => 'decimal:7',
        'starting_point_latitude' => 'decimal:7',
        'arrival_point_longitude' => 'decimal:7',
        'arrival_point_latitude' => 'decimal:7',
        'distance' => 'decimal:2'
    ];

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
}
