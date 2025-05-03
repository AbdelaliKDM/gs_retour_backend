<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserStatus onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserStatus whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserStatus whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserStatus whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserStatus whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserStatus whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserStatus withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserStatus withoutTrashed()
 * @mixin \Eloquent
 */
class UserStatus extends Model
{

    use SoftDeletes;
    protected $fillable = [
        'user_id',
        'name',
        'type'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
