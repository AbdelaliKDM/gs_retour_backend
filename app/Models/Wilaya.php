<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
