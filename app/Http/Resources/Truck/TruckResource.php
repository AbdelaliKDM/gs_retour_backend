<?php

namespace App\Http\Resources\Truck;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TruckResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @return array<string, mixed>
   */
  public function toArray(Request $request): array
  {
    return [
      'id' => $this->id,
      'truck_type_id' => $this->truck_type->id,
      'subcategory_id' => $this->subcategory->id,
      'category_id' => $this->category->id,
      'serial_number' => $this->serial_number,
      'gray_card' => $this->gray_card_url,
      'driving_license' => $this->gray_card_url,
      'insurance_certificate' => $this->driving_license_url,
      'insurance_expiry_date' => $this->insurance_expiry_date,
      'inspection_certificate' => $this->inspection_certificate_url,
      'next_inspection_date' => $this->next_inspection_date,
      'affiliated_with_agency' => $this->affiliated_with_agency,
      'agency_document' => $this->agency_document_url,
      'images' => $this->truck_images()->get()->pluck('url')->toArray()
    ];
  }
}
