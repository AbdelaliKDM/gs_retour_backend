<?php

namespace App\Models;

use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wallet extends Model
{
  use HasFactory, SoftDeletes, SoftCascadeTrait;

  protected $fillable = [
    'user_id',
    'balance'
  ];

  public function getChargesAttribute(){
    return $this->payments()->where('status', 'paid')->count();
  }

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function payments()
  {
    return $this->morphMany(Payment::class, 'payable');
  }

}
