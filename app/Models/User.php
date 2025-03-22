<?php

namespace App\Models;

use Askedio\SoftCascade\Traits\SoftCascadeTrait;
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
  use HasApiTokens, HasFactory, Notifiable, Authorizable, SoftDeletes, SoftCascadeTrait;

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

  protected $softCascade = ['truck', 'trips', 'shipments'];

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

  public function getBalanceAttribute(){
    $wallet = $this->wallet ?? $this->wallet()->create(['balance' => 0]);
    return $wallet->balance;
  }
  public function getRatingAttribute(){
    return $this->trips_reviews()->avg('rating');
  }
  public function truck()
  {
    return $this->hasOne(Truck::class);
  }
  public function trips()
  {
    return $this->hasMany(Trip::class, 'driver_id');
  }

  public function shipments()
  {
    return $this->hasMany(Shipment::class, 'renter_id');
  }

  public function favorites()
  {
    return $this->hasMany(Favorite::class);
  }

  public function reviews(){
    return $this->hasMany(Review::class);
  }

  public function trips_reviews(){
    return $this->hasManyThrough(Review::class, Trip::class, 'driver_id');
  }

  public function ongoing_trip()
  {
    return $this->trips()->whereHas('status', function($query) {
      $query->where('name', 'ongoing');
    });
  }

  public function trip()
  {
    return $this->hasOne(Trip::class, 'driver_id')->whereHas('status', function($query) {
      $query->where('name', 'ongoing');
    })->latestOfMany();
  }

  public function wallet()
  {
    return $this->hasOne(Wallet::class);
  }

  public function invoices()
  {
    return $this->hasMany(Invoice::class);
  }
}
