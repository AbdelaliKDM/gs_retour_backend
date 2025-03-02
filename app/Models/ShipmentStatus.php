<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ShipmentStatus extends Model
{
    use HasFactory, SoftDeletes, SoftCascadeTrait;

    protected $fillable = [
      'shipment_id',
      'name'
    ];

    public function shipment(){
      return $this->belongsTo(Shipment::class);
    }
}
