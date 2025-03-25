<?php

namespace App\Models;

use App\Traits\Firebase;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
  use HasFactory, SoftDeletes;

  protected $fillable = [
    'notice_id',
    'user_id',
    'is_read',
    'read_at',
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
