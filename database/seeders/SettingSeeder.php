<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      foreach([
        'serial_number',
        'gray_card',
        'driving_license',
        'insurance_certificate',
        'insurance_expiry_date',
        'inspection_certificate',
        'next_inspection_date',
        'affiliated_with_agency',
      ] as $setting){
        Setting::create([
          'name' => $setting,
          'value' => 'sometimes'
        ]);
      }
    }
}
