<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory, SoftDeletes;

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
