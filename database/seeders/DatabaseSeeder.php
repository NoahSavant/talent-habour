<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Constants\UserConstant\UserRole;
use App\Models\CompanyInformation;
use App\Models\User;
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

        $users = User::where('role', UserRole::RECRUITER)->get();

        foreach($users as $user) {
            CompanyInformation::create([
                'user_id' => $user->id
            ]);
        }
    }
}
