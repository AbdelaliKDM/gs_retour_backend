<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Truck extends Model
{
  use HasFactory, SoftDeletes;

  protected $fillable = [
    'user_id',
    'truck_type_id',
    'serial_number',
    'gray_card',
    'driving_license',
    'insurance_certificate',
    'insurance_expiry_date',
    'inspection_certificate',
    'next_inspection_date',
    'affiliated_with_agency',
    'agency_document'
  ];

  public function getGrayCardUrlAttribute()
  {
    return $this->gray_card && Storage::disk('upload')->exists($this->gray_card)
      ? Storage::disk('upload')->url($this->gray_card)
      : null;
  }

  public function getDrivingLicenseUrlAttribute()
  {
    return $this->driving_license && Storage::disk('upload')->exists($this->driving_license)
      ? Storage::disk('upload')->url($this->driving_license)
      : null;
  }

  public function getInsuranceCertificateUrlAttribute()
  {
    return $this->insurance_certificate && Storage::disk('upload')->exists($this->insurance_certificate)
      ? Storage::disk('upload')->url($this->insurance_certificate)
      : null;
  }

  public function getInspectionCertificateUrlAttribute()
  {
    return $this->inspection_certificate && Storage::disk('upload')->exists($this->inspection_certificate)
      ? Storage::disk('upload')->url($this->inspection_certificate)
      : null;
  }

  public function getAgencyDocumentUrlAttribute()
  {
    return $this->agency_document && Storage::disk('upload')->exists($this->agency_document)
      ? Storage::disk('upload')->url($this->agency_document)
      : null;
  }

  public function getSubcategoryAttribute()
  {
    return $this->truckType->subcategory;
  }

  public function getCategoryAttribute()
  {
    return $this->subcategory->category;
  }
  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function truckType()
  {
    return $this->belongsTo(TruckType::class);
  }

  public function truckImages()
  {
    return $this->hasMany(TruckImage::class);
  }

}
