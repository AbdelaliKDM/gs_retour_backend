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
 * @property int $shipment_id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Shipment $shipment
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShipmentStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShipmentStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShipmentStatus onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShipmentStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShipmentStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShipmentStatus whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShipmentStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShipmentStatus whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShipmentStatus whereShipmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShipmentStatus whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShipmentStatus withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShipmentStatus withoutTrashed()
 * @mixin \Eloquent
 */
class ShipmentStatus extends Model
{
    use HasFactory, SoftDeletes, SoftCascadeTrait;

    protected $fillable = [
      'shipment_id',
      'name'
    ];

    public function shipment(){
      return $this->belongsTo(Shipment::class);
    }
}
