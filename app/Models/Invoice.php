<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoice extends Model
{
  use HasFactory, SoftDeletes, SoftCascadeTrait;

  protected $fillable = [
    'user_id',
    'month',
  ];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function transactions()
  {
    return $this->hasMany(Transaction::class);
  }

  public function payments()
  {
    return $this->morphMany(Payment::class, 'payable');
  }

  public function getMonthNameAttribute()
  {
    Carbon::setLocale(session('locale'));
    return Carbon::createFromDate($this->month)->monthName;
  }

  public function getYearAttribute()
  {
    return Carbon::createFromDate($this->month)->year;
  }

  public function getStatusAttribute()
{

    $invoiceMonth = Carbon::parse($this->month)->startOfMonth();
    $currentMonth = Carbon::now()->startOfMonth();

    if ($currentMonth->equalTo($invoiceMonth)) {
        return 'unpayable';
    }

    if ($this->payments()->where('status', 'paid')->exists()) {
        return 'paid';
    }

    if ($this->payments()->where('status', 'pending')->exists()) {
      return 'pending';
    }

    return 'unpaid';
}

  public function getTotalAmountAttribute(){
    return $this->transactions()->sum('total_amount');
  }

  public function getTaxAmountAttribute(){
    return $this->transactions()->sum('tax_amount');
  }
}
