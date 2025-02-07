<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
  use HasApiTokens, HasFactory, Notifiable, Authorizable, SoftDeletes;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'name',
    'email',
    'phone',
    'password',
    'image',
    'id_card',
    'id_card_selfie',
    'role',
    'status',
    'device_token',
    'email_verified_at',
    'phone_verified_at',
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  /**
   * The attributes that should be cast.
   *
   * @var array<string, string>
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
    'phone_verified_at' => 'datetime',
    'role' => 'string',
    'status' => 'string',
  ];

  public function getImageUrlAttribute()
  {
    return $this->image && Storage::disk('upload')->exists($this->image)
      ? Storage::disk('upload')->url($this->image)
      : null;
  }

  public function getCardUrlAttribute()
  {
    return $this->id_card && Storage::disk('upload')->exists($this->id_card)
      ? Storage::disk('upload')->url($this->id_card)
      : null;
  }
  public function getSelfieUrlAttribute()
  {
    return $this->id_card_selfie && Storage::disk('upload')->exists($this->id_card_selfie)
      ? Storage::disk('upload')->url($this->id_card_selfie)
      : null;
  }
  public function truck()
  {
    return $this->hasOne(Truck::class);
  }
}
