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
 * @property string $name_ar
 * @property string $name_en
 * @property string $name_fr
 * @property string|null $image
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read mixed $image_url
 * @property-read mixed $name
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Subcategory> $subcategories
 * @property-read int|null $subcategories_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereNameFr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category withoutTrashed()
 * @mixin \Eloquent
 */
class Category extends Model
{
    use HasFactory, SoftDeletes, SoftCascadeTrait;

    protected $fillable = [
      'name_ar',
      'name_en',
      'name_fr',
      'image',
  ];

  protected $softCascade = [
    'subcategories',
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

    public function subcategories(){
      return $this->hasMany(Subcategory::class);
    }

    public function truckTypes(){
      return $this->through('subcategories')->has('truckTypes');
    }

    public function trucks(){
      return $this->through('truckTypes')->has('trucks');
    }
}
