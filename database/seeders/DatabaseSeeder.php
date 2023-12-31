<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'mobile' => '8108889047',
            'address' => 'borivali',
            'property_id' => '0',
            'emi_amount' => '10',
            'emi_count' => '10',
            'address' => 'borivali',
            'password' => Hash::make('12345'),
            'dcrypt_password' => '12345',
            'status' => 1,
        ]);
    }
}
