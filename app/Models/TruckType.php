<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Znck\Eloquent\Traits\BelongsToThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class TruckType extends Model
{
    use HasFactory, SoftDeletes, SoftCascadeTrait, BelongsToThrough;

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

    public function subcategory(){
      return $this->belongsTo(Subcategory::class);
    }

    public function category(){
      return $this->belongsToThrough(Category::class, Subcategory::class);
    }

    public function trucks(){
      return $this->hasMany(Truck::class);
    }
}
