<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Constants\UserConstant\UserRole;
use App\Constants\UserConstant\UserStatus;
use App\Models\CompanyInformation;
use App\Models\User;
use Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::create([
            'first_name' => 'Admin',
            'last_name' => 'TH',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456'),
            'role' => UserRole::ADMIN,
            'image_url' => 'https://res.cloudinary.com/dsrtzowwc/image/upload/v1700325403/samples/people/boy-snow-hoodie.jpg',
            'status' => UserStatus::ACTIVE
        ]);
    }
}
