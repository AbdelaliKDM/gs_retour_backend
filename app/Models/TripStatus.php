<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * 
 *
 * @property int $id
 * @property int $trip_id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Trip $trip
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripStatus onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripStatus whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripStatus whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripStatus whereTripId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripStatus whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripStatus withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripStatus withoutTrashed()
 * @mixin \Eloquent
 */
class TripStatus extends Model
{
    use HasFactory, SoftDeletes, SoftCascadeTrait;

    protected $fillable = [
      'trip_id',
      'name'
    ];

    public function trip(){
      return $this->belongsTo(Trip::class);
    }
}
