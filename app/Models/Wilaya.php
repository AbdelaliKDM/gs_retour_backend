<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string $name_ar
 * @property string $name_en
 * @property string $name_fr
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $name
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wilaya newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wilaya newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wilaya query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wilaya whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wilaya whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wilaya whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wilaya whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wilaya whereNameFr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wilaya whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Wilaya extends Model
{
  use HasFactory;

  protected $fillable = [
    'name_ar',
    'name_en',
    'name_fr',
  ];

  public function getNameAttribute()
  {
    return match (session('locale')) {
      'ar' => $this->name_ar,
      'en' => $this->name_en,
      'fr' => $this->name_fr,
      default => $this->name_en
    };
  }
}
