<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */

    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');
        collect(array(
            [
                'uuid' => $faker->uuid(),
                'name' => 'Administrator',
                'email' => 'admin@admin.com',
                'password' => Hash::make('password'),
                'role' => 'Admin',
                'email_verified_at' => now(),
                'remember_token' => $faker->sha256()
            ],
            [
                'uuid' => $faker->uuid(),
                'name' => 'Asesor',
                'email' => 'asesor@asesor.com',
                'password' => Hash::make('password'),
                'role' => 'Asesor',
                'email_verified_at' => now(),
                'remember_token' => $faker->sha256()
            ],
            [
                'uuid' => $faker->uuid(),
                'name' => 'Asesi',
                'email' => 'asesi@asesi.com',
                'password' => Hash::make('password'),
                'role' => 'Asesi',
                'email_verified_at' => now(),
                'remember_token' => $faker->sha256()
            ]
        ))->each(function($users){
            User::create($users);
        });
    }
}
