<?php

namespace App\Models;

use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
  use HasFactory, SoftDeletes, SoftCascadeTrait;

  protected $fillable = [
    'trip_id',
    'invoice_id',
    'total_amount',
    'tax_amount',
  ];

  protected $casts = [
    'total_amount' => 'decimal:2',
    'tax_amount' => 'decimal:2',
  ];

  public function trip()
  {
    return $this->belongsTo(Trip::class);
  }
  public function invoice()
  {
    return $this->belongsTo(Invoice::class);
  }
}
