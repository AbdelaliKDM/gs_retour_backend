<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TruckImage extends Model
{
    use HasFactory;

    protected $fillable = [
      'truck_id',
      'path'
    ];

    public function getUrlAttribute()
    {
      return $this->path && Storage::disk('upload')->exists($this->path)
      ? Storage::disk('upload')->url($this->path)
      : null;
    }
}
