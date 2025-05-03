<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

/**
 * 
 *
 * @property int $id
 * @property int $subcategory_id
 * @property string $name_ar
 * @property string $name_en
 * @property string $name_fr
 * @property float|null $weight
 * @property string|null $image
 * @property int|null $capacity
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read mixed $category
 * @property-read mixed $image_url
 * @property-read mixed $name
 * @property-read \App\Models\Subcategory $subcategory
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Truck> $trucks
 * @property-read int|null $trucks_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TruckType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TruckType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TruckType onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TruckType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TruckType whereCapacity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TruckType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TruckType whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TruckType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TruckType whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TruckType whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TruckType whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TruckType whereNameFr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TruckType whereSubcategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TruckType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TruckType whereWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TruckType withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TruckType withoutTrashed()
 * @mixin \Eloquent
 */
class TruckType extends Model
{
    use HasFactory, SoftDeletes, SoftCascadeTrait;

    protected $fillable = [
        'subcategory_id',
        'name_ar',
        'name_en',
        'name_fr',
        'weight',
        'capacity',
        'image'
    ];

    protected $casts = [
      'weight' => 'double',
      'capacity' => 'integer',
    ];

    protected $softCascade = [
      'trucks',
    ];

    public function getImageUrlAttribute()
    {
        return $this->image && Storage::disk('upload')->exists($this->image)
            ? Storage::disk('upload')->url($this->image)
            : null;
    }

    public function getNameAttribute(){
      return match(session('locale')){
        'ar' => $this->name_ar,
        'en' => $this->name_en,
        'fr' => $this->name_fr,
        default => $this->name_en
      };
    }

    public function getCategoryAttribute(){
      return $this->subcategory->category;
    }

    public function subcategory(){
      return $this->belongsTo(Subcategory::class);
    }

    public function trucks(){
      return $this->hasMany(Truck::class);
    }
}
