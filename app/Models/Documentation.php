<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string|null $content_ar
 * @property string|null $content_en
 * @property string|null $content_fr
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $content
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Documentation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Documentation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Documentation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Documentation whereContentAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Documentation whereContentEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Documentation whereContentFr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Documentation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Documentation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Documentation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Documentation whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Documentation extends Model
{
    use HasFactory;

    protected $fillable = [
      'name',
      'content_ar',
      'content_en',
      'content_fr',
    ];

    public function getContentAttribute(){
      return match(session('locale')){
        'ar' => $this->content_ar,
        'en' => $this->content_en,
        'fr' => $this->content_fr,
        default => $this->content_en
      };
    }
}
