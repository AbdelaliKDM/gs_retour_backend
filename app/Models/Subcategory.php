<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * 
 *
 * @property int $id
 * @property int $category_id
 * @property string $name_ar
 * @property string $name_en
 * @property string $name_fr
 * @property string|null $image
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Category $category
 * @property-read mixed $image_url
 * @property-read mixed $name
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TruckType> $truckTypes
 * @property-read int|null $truck_types_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subcategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subcategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subcategory onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subcategory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subcategory whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subcategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subcategory whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subcategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subcategory whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subcategory whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subcategory whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subcategory whereNameFr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subcategory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subcategory withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subcategory withoutTrashed()
 * @mixin \Eloquent
 */
class Subcategory extends Model
{
  use HasFactory, SoftDeletes, SoftCascadeTrait;

  protected $fillable = [
    'category_id',
    'name_ar',
    'name_en',
    'name_fr',
    'image',
];

protected $softCascade = [
  'truckTypes',
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

  public function category(){
    return $this->belongsTo(Category::class);
  }

  public function truckTypes(){
    return $this->hasMany(TruckType::class);
  }

  public function trucks(){
    return $this->through('truckTypes')->has('trucks');
  }
}
