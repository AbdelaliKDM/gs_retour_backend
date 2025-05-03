<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property int $truck_type_id
 * @property string|null $serial_number
 * @property string|null $gray_card
 * @property string|null $driving_license
 * @property string|null $insurance_certificate
 * @property string|null $insurance_expiry_date
 * @property string|null $inspection_certificate
 * @property string|null $next_inspection_date
 * @property int|null $affiliated_with_agency
 * @property string|null $agency_document
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read mixed $agency_document_url
 * @property-read mixed $category
 * @property-read mixed $driving_license_url
 * @property-read mixed $gray_card_url
 * @property-read mixed $inspection_certificate_url
 * @property-read mixed $insurance_certificate_url
 * @property-read mixed $subcategory
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TruckImage> $truckImages
 * @property-read int|null $truck_images_count
 * @property-read \App\Models\TruckType $truckType
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Truck newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Truck newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Truck onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Truck query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Truck whereAffiliatedWithAgency($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Truck whereAgencyDocument($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Truck whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Truck whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Truck whereDrivingLicense($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Truck whereGrayCard($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Truck whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Truck whereInspectionCertificate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Truck whereInsuranceCertificate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Truck whereInsuranceExpiryDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Truck whereNextInspectionDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Truck whereSerialNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Truck whereTruckTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Truck whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Truck whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Truck withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Truck withoutTrashed()
 * @mixin \Eloquent
 */
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
