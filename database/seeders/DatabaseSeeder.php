<?php

namespace Database\Seeders;

use App\Models\Feature;
use App\Models\Package;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Berry',
            'email' => 'berry@example.com',
            'password' => bcrypt('12345A./'),
        ]);

        Feature::create([
            'image' => 'https://img.icons8.com/?size=100&id=TNTpW1UDsN87&format=png&color=000000',
            'route_name' => 'feature1.index',
            'name' => 'Calculate Sum',
            'required_credits' => 1,
            'description' => 'Calculate sum of two numbers',
            'active' => true,
        ]);

        Feature::create([
            'image' => 'https://img.icons8.com/?size=100&id=nUbSfoBVfzah&format=png&color=000000',
            'route_name' => 'feature2.index',
            'name' => 'Calculate Difference',
            'required_credits' => 3,
            'description' => 'Calculate difference of two numbers',
            'active' => true,
        ]);

        Package::create([
            'name' => 'Basic',
            'price' => 5,
            'credits' => 20,
        ]);

        Package::create([
            'name' => 'Silver',
            'price' => 20,
            'credits' => 100,
        ]);

        Package::create([
            'name' => 'Gold',
            'price' => 50,
            'credits' => 500,
        ]);
    }
}
