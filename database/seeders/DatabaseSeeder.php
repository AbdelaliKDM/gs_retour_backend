<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Models\Documentation;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        \App\Models\User::create([
          'name' => 'admin',
          'email' => 'admin@gmail.com',
          'password'=> bcrypt('123456789'),
          'role' => 'admin',
          'status' => 'active'
        ]);

        //\App\Models\User::factory(30)->create();

        foreach (['privacy_policy', 'about_app', 'terms_of_use', 'delete_account']  as $name){
          Documentation::create(['name' => $name]);
        }

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
