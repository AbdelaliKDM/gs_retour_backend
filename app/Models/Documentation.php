<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
