<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShipmentType extends Model
{
    use HasFactory, SoftDeletes;

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
