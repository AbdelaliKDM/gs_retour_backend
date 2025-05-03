<?php

namespace App\Models;

use Exception;
use App\Traits\Firebase;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * 
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $email
 * @property string|null $phone
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property \Illuminate\Support\Carbon|null $phone_verified_at
 * @property string|null $password
 * @property string|null $image
 * @property string|null $id_card
 * @property string|null $id_card_selfie
 * @property string|null $role
 * @property string|null $device_token
 * @property string|null $suspended_for
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Favorite> $favorites
 * @property-read int|null $favorites_count
 * @property-read mixed $balance
 * @property-read mixed $card_url
 * @property-read mixed $image_url
 * @property-read mixed $rating
 * @property-read mixed $selfie_url
 * @property-read mixed $status
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Invoice> $invoices
 * @property-read int|null $invoices_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Notification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Review> $reviews
 * @property-read int|null $reviews_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Shipment> $shipments
 * @property-read int|null $shipments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserStatus> $statuses
 * @property-read int|null $statuses_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @property-read \App\Models\Trip|null $trip
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Trip> $trips
 * @property-read int|null $trips_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Review> $trips_reviews
 * @property-read int|null $trips_reviews_count
 * @property-read \App\Models\Truck|null $truck
 * @property-read \App\Models\Wallet|null $wallet
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereDeviceToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereIdCard($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereIdCardSelfie($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePhoneVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereSuspendedFor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutTrashed()
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
  use HasApiTokens, HasFactory, /* Notifiable, */ Authorizable, SoftDeletes, SoftCascadeTrait, Firebase;

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
    'suspended_for'
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

  protected $softCascade = [
    'truck',
    'trips',
    'shipments',
    'reviews',
    'favorites',
    'wallet',
    'invoices',
    'statuses'
  ];

  public function role(){
    return $this->role ?? 'user' ;
  }

  public function getImageUrlAttribute()
  {
    return $this->image && Storage::disk('upload')->exists($this->image)
      ? Storage::disk('upload')->url($this->image)
      : $this->image;
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

  public function getBalanceAttribute()
  {
    $wallet = $this->wallet ?? $this->wallet()->create(['balance' => 0]);
    return $wallet->balance;
  }
  public function getRatingAttribute()
  {
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

  public function reviews()
  {
    return $this->hasMany(Review::class);
  }

  public function trips_reviews()
  {
    return $this->hasManyThrough(Review::class, Trip::class, 'driver_id');
  }

  public function ongoing_trip()
  {
    return $this->trips()->whereHas('status', function ($query) {
      $query->where('name', 'ongoing');
    });
  }

  public function trip()
  {
    return $this->hasOne(Trip::class, 'driver_id')->whereHas('status', function ($query) {
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

  public function notifications()
  {
    return $this->hasMany(Notification::class);
  }

  public function wallet_payments()
  {
    return $this->through('wallet')->has('payments');
  }

  public function invoice_payments()
  {
    return $this->through('invoices')->has('payments');
  }

  public function payments()
  {
    return $this->wallet_payments()->union($this->invoice_payments());
  }

  public function notify(Notice $notice)
  {
    Notification::create([
      'user_id' => $this->id,
      'notice_id' => $notice->id
    ]);

    if ($this->device_token) {
      $this->send_to_device(
        $notice->title,
        $notice->content,
        $this->device_token
      );
    }

  }

  public function statuses()
  {
    return $this->hasMany(UserStatus::class);
  }

  public function getStatusAttribute()
  {
    if ($this->statuses()->count() === 0) {
      return 'active';
    }

    if ($this->statuses()->where('name', 'suspended')->exists()) {
      return 'suspended';
    }

    return 'inactive';
  }

  public function getProfileStatusAttribute(){
    return $this->statuses()->where('type','profile')->first()?->name ?? 'active';
  }
  public function getTruckStatusAttribute(){
    return $this->statuses()->where('type','truck')->first()?->name ?? 'active';
  }

  public function getInvoiceStatusAttribute(){
    return $this->statuses()->where('type','invoice')->first()?->name ?? 'active';
  }

  public function updateStatus($newStatus, $type)
  {
    if ($newStatus == 'active') {

      $this->statuses()->where('type', $type)->delete();

      if($this->status == 'active'){
        $notice = Notice::ProfileNotice('active', 'default');
      }
    } else {

      $this->statuses()->updateOrCreate(
        ['type' => $type],
        ['name' => $newStatus]
      );

      $notice = Notice::ProfileNotice($newStatus, $type);
      
    }

    if(isset($notice)){
      $this->notify($notice);
    }  
  }
}
