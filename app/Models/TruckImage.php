<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * 
 *
 * @property int $id
 * @property int $truck_id
 * @property string|null $path
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $url
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TruckImage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TruckImage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TruckImage query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TruckImage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TruckImage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TruckImage wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TruckImage whereTruckId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TruckImage whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TruckImage extends Model
{
    use HasFactory;

    protected $fillable = [
      'truck_id',
      'path'
    ];

    public function getUrlAttribute()
    {
      return $this->path && Storage::disk('upload')->exists($this->path)
      ? Storage::disk('upload')->url($this->path)
      : null;
    }
}
