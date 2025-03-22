<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
      'name',
      'value'
    ];

    public static function truck_parameters_validation(){
      $settings = self::pluck('value','name')->toArray();

      return [
        'truck_type_id' => "required|exists:truck_types,id",
        'serial_number' => "{$settings['serial_number']}|string",
        'gray_card' => "{$settings['gray_card']}|file",
        'driving_license' => "{$settings['driving_license']}|file",
        'insurance_certificate' => "{$settings['insurance_certificate']}|file",
        'insurance_expiry_date' => "{$settings['insurance_expiry_date']}|date",
        'inspection_certificate' => "{$settings['inspection_certificate']}|file",
        'next_inspection_date' => "{$settings['next_inspection_date']}|date",
        'affiliated_with_agency' => "{$settings['affiliated_with_agency']}|boolean",
        'agency_document' => "required_if:affiliated_with_agency,true|file",
        'images' => 'sometimes|array',
        'images.*' => 'mimetypes:image/*'
      ];
    }

    public static function getTaxRatio(){
      return self::where('name','tax_ratio')->value('value') ?? 0;
    }
}
