<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Constants\UserConstant\UserRole;
use App\Constants\UserConstant\UserStatus;
use App\Models\AccountVerify;
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
        User::create([
            'first_name' => 'Admin',
            'last_name' => 'TH',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456'),
            'role' => UserRole::ADMIN,
            'image_url' => 'https://res.cloudinary.com/dsrtzowwc/image/upload/v1700325403/samples/people/boy-snow-hoodie.jpg',
            'status' => UserStatus::ACTIVE,
        ]);

        $users = [
            [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'john@example.com',
            ],
            [
                'first_name' => 'Jane',
                'last_name' => 'Smith',
                'email' => 'jane@example.com',
            ],
            [
                'first_name' => 'Bob',
                'last_name' => 'Johnson',
                'email' => 'bob@example.com',
            ],
            [
                'first_name' => 'Alice',
                'last_name' => 'Williams',
                'email' => 'alice@example.com',
            ],
        ];

        $employees = [
            [
                'first_name' => 'Michael',
                'last_name' => 'Brown',
                'email' => 'michael@example.com',
            ],
        ];

        foreach ($employees as $user) {
            $newUser = User::create(array_merge($user, [
                'password' => Hash::make('123456'),
                'role' => UserRole::EMPLOYEE,
                'status' => UserStatus::ACTIVE,
            ]));

            AccountVerify::create([
                'user_id' => $newUser->id,
                'deleted_at' => now(),
            ]);
        }

        foreach ($users as $user) {
            $newUser = User::create(array_merge($user, [
                'password' => Hash::make('123456'),
                'role' => UserRole::RECRUITER,
                'status' => UserStatus::ACTIVE,
            ]));

            AccountVerify::create([
                'user_id' => $newUser->id,
                'deleted_at' => now(),
            ]);

            CompanyInformation::create([
                'user_id' => $newUser->id,
            ]);
        }
    }
}
