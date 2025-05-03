<?php

namespace App\Models;

use App\Traits\Firebase;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * 
 *
 * @property int $id
 * @property int $notice_id
 * @property int $user_id
 * @property bool $is_read
 * @property \Illuminate\Support\Carbon|null $read_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Notice $notice
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereIsRead($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereNoticeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereReadAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification withoutTrashed()
 * @mixin \Eloquent
 */
class Notification extends Model
{
  use HasFactory, SoftDeletes;

  protected $fillable = [
    'notice_id',
    'user_id',
    'is_read',
    'read_at',
  ];

  protected $casts = [
    'is_read' => 'boolean',
    'read_at' => 'datetime',
  ];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function notice()
  {
    return $this->belongsTo(Notice::class);
  }
}
