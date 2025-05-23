<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string|null $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereValue($value)
 * @mixin \Eloquent
 */
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

    public static function required_truck_fields(){
      return self::where('value','required')->pluck('name')->toArray();
    }
}
