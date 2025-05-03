<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property string $month
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read mixed $month_name
 * @property-read mixed $status
 * @property-read mixed $tax_amount
 * @property-read mixed $total_amount
 * @property-read mixed $year
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Payment> $payments
 * @property-read int|null $payments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Transaction> $transactions
 * @property-read int|null $transactions_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereMonth($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice withoutTrashed()
 * @mixin \Eloquent
 */
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
