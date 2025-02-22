<?php

namespace Database\Seeders;

use App\Models\Documentation;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DocumentationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      foreach (['privacy_policy', 'about_app', 'terms_of_use', 'delete_account']  as $name){
        Documentation::create(['name' => $name]);
      }
    }
}
