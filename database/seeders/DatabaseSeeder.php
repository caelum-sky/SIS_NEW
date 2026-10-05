<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin User',
            'email' => env('ADMIN_EMAIL', 'admin@example.com'),
            'password' => env('ADMIN_PASSWORD', 'password'),
            'is_admin' => true,
        ]);

        Student::factory()->create([
            'name' => 'Demo Student',
            'email' => 'student@example.com',
            'address' => 'Malaybalay City, Bukidnon',
            'course' => 'BSIT',
            'year_level' => 1,
            'enrollment_status' => 'enrolled',
        ]);
    }
}
