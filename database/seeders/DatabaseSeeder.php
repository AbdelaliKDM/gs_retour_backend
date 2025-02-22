<?php

namespace Database\Seeders;

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

    }
}
