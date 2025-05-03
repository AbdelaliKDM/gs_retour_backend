<?php

namespace App\Models;

use App\Traits\Firebase;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * 
 *
 * @property int $id
 * @property string $title_ar
 * @property string $title_en
 * @property string $title_fr
 * @property string $content_ar
 * @property string $content_en
 * @property string $content_fr
 * @property int $type
 * @property int $priority
 * @property string|null $metadata
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read mixed $content
 * @property-read mixed $title
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Notification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notice onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notice query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notice whereContentAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notice whereContentEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notice whereContentFr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notice whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notice whereMetadata($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notice wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notice whereTitleAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notice whereTitleEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notice whereTitleFr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notice whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notice whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notice withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notice withoutTrashed()
 * @mixin \Eloquent
 */
class Notice extends Model
{
  use HasFactory, SoftDeletes, SoftCascadeTrait, Firebase;

  protected $fillable = [
    'title_ar',
    'title_en',
    'title_fr',
    'content_ar',
    'content_en',
    'content_fr',
    'type',
    'priority',
    'metadata'
  ];

  protected $softCascade = ['notifications'];

  protected $casts = [
    'type' => 'integer',
    'priority' => 'integer',
  ];

  public function notifications()
  {
    return $this->hasMany(Notification::class);
  }

  public function getTitleAttribute()
  {
    return match(session('locale')){
      'ar' => $this->title_ar,
      'en' => $this->title_en,
      'fr' => $this->title_fr,
      default => $this->title_en
    };
  }

  public function getContentAttribute()
  {
    return match(session('locale')){
      'ar' => $this->content_ar,
      'en' => $this->content_en,
      'fr' => $this->content_fr,
      default => $this->content_en
    };
  }

  public function send($users = null, $with_fcm = true){
    $data = $users ?? User::query();

      $data = $data->where('users.status', 'active')->whereIn('users.role', ['renter', 'driver'])->pluck('users.device_token', 'users.id')->toArray();

      $users = array_keys($data);

      $fcm_tokens = array_filter($data);

      array_walk($users, function (&$value, $key) {
        $value = [
          'user_id' => $value,
          'notice_id' => $this->id,
          'created_at' => now(),
        ];
      });

      Notification::insert($users);

      if($with_fcm){
        $this->send_to_devices(
          $this->title,
          $this->content,
          $fcm_tokens
        );
      }


  }

  public static function ProfileNotice(string $status, ?string $reason = 'default'): self
  {

    $key = "messages.profile.{$status}.{$reason}";

    return self::create([
      'title_en' => trans("{$key}.title", [], 'en'),
      'title_ar' => trans("{$key}.title", [], 'ar'),
      'title_fr' => trans("{$key}.title", [], 'fr'),
      'content_en' => trans("{$key}.content", [], 'en'),
      'content_ar' => trans("{$key}.content", [], 'ar'),
      'content_fr' => trans("{$key}.content", [], 'fr'),
      'type' => 1,
      'priority' => $reason == 'default' ? 0 : 1,
      'metadata' => json_encode([
        'status' => $status,
        'reason' => $reason
      ])
    ]);
  }

  public static function TripNotice(int $trip_id, string $status): self
  {
    $key = "messages.trip.{$status}";

    return self::create([
      'title_en' => trans("{$key}.title", [], 'en'),
      'title_ar' => trans("{$key}.title", [], 'ar'),
      'title_fr' => trans("{$key}.title", [], 'fr'),
      'content_en' => trans("{$key}.content", ['id' => $trip_id], 'en'),
      'content_ar' => trans("{$key}.content", ['id' => $trip_id], 'ar'),
      'content_fr' => trans("{$key}.content", ['id' => $trip_id], 'fr'),
      'type' => 2,
      'priority' => $status === 'completed' ? 1 : 0,
      'metadata' => json_encode([
        'trip_id' => $trip_id,
        'status' => $status
      ])
    ]);
  }

  public static function ShipmentNotice(int $shipment_id, string $status): self
  {
    $key = "messages.shipment.{$status}";

    return self::create([
      'title_en' => trans("{$key}.title", [], 'en'),
      'title_ar' => trans("{$key}.title", [], 'ar'),
      'title_fr' => trans("{$key}.title", [], 'fr'),
      'content_en' => trans("{$key}.content", ['shipment_id' => $shipment_id], 'en'),
      'content_ar' => trans("{$key}.content", ['shipment_id' => $shipment_id], 'ar'),
      'content_fr' => trans("{$key}.content", ['shipment_id' => $shipment_id], 'fr'),
      'type' => 3,
      'priority' => 0,
      'metadata' => json_encode([
        'shipment_id' => $shipment_id,
        'status' => $status
      ])
    ]);
  }

  public static function OrderNotice(Order $order, User $user, string $status): self
  {
    $key = "messages.order.{$status}";

    if($user->role == 'driver'){
      $metadata = ['trip_id' => $order->trip_id];
    }else{
      $metadata = ['shipment_id' => $order->shipment_id];
    }

    $metadata['status'] = $status;

    return self::create([
      'title_en' => trans("{$key}.title", [], 'en'),
      'title_ar' => trans("{$key}.title", [], 'ar'),
      'title_fr' => trans("{$key}.title", [], 'fr'),
      'content_en' => trans("{$key}.content", ['order_id' => $order->id], 'en'),
      'content_ar' => trans("{$key}.content", ['order_id' => $order->id], 'ar'),
      'content_fr' => trans("{$key}.content", ['order_id' => $order->id], 'fr'),
      'type' => 4,
      'priority' => 0,
      'metadata' => json_encode($metadata)
    ]);
  }

  public static function ReviewNotice(int $trip_id, string $rating): self
  {
    $key = "messages.review";

    return self::create([
      'title_en' => trans("{$key}.title", [], 'en'),
      'title_ar' => trans("{$key}.title", [], 'ar'),
      'title_fr' => trans("{$key}.title", [], 'fr'),
      'content_en' => trans("{$key}.content", ['rating' => $rating], 'en'),
      'content_ar' => trans("{$key}.content", ['rating' => $rating], 'ar'),
      'content_fr' => trans("{$key}.content", ['rating' => $rating], 'fr'),
      'type' => 5,
      'priority' => 0,
      'metadata' => json_encode([
        'trip_id' => $trip_id,
        'rating' => $rating
      ])
    ]);
  }

  public static function PaymentNotice(string $type, string $status): self
  {
    $key = "messages.payment.{$type}.{$status}";

    return self::create([
      'title_en' => trans("{$key}.title", [], 'en'),
      'title_ar' => trans("{$key}.title", [], 'ar'),
      'title_fr' => trans("{$key}.title", [], 'fr'),
      'content_en' => trans("{$key}.content", [], 'en'),
      'content_ar' => trans("{$key}.content", [], 'ar'),
      'content_fr' => trans("{$key}.content", [], 'fr'),
      'type' => 6,
      'priority' => 0,
      'metadata' => json_encode([
        'type' => $type,
        'status' => $status
      ])
    ]);
  }


}
