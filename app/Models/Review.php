<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
  use HasFactory, SoftDeletes;

  protected $fillable = [
    'user_id',
    'trip_id',
    'rating',
    'note'
  ];

  protected $casts = [
    'rating' => 'double',
  ];

  public function user()
  {
    return $this->belongsTo(User::class);
  }
  public function trip()
  {
    return $this->belongsTo(Trip::class);
  }
}
