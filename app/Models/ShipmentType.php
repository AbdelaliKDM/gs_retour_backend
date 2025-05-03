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
 * @property string $name_ar
 * @property string $name_en
 * @property string $name_fr
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read mixed $name
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Shipment> $shipments
 * @property-read int|null $shipments_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShipmentType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShipmentType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShipmentType onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShipmentType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShipmentType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShipmentType whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShipmentType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShipmentType whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShipmentType whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShipmentType whereNameFr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShipmentType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShipmentType withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShipmentType withoutTrashed()
 * @mixin \Eloquent
 */
class ShipmentType extends Model
{
    use HasFactory, SoftDeletes, SoftCascadeTrait;

    protected $fillable = [
      'name_ar',
      'name_en',
      'name_fr',
  ];

  protected $softCascade = [
    'shipments',
  ];

  public function getNameAttribute(){
    return match(session('locale')){
      'ar' => $this->name_ar,
      'en' => $this->name_en,
      'fr' => $this->name_fr,
      default => $this->name_en
    };
  }

  public function shipments(){
    return $this->hasMany(Shipment::class);
  }
}
