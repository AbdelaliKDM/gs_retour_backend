<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notice extends Model
{
  use HasFactory, SoftDeletes, SoftCascadeTrait;

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

}
