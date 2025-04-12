<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
