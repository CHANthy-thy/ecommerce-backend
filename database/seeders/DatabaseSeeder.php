<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Users (idempotent)
        User::query()->updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => \Illuminate\Support\Facades\Hash::make('password123'),
                'role' => 'user',
            ]
        );


        // Existing seeders (kept as-is)
        $this->call([
            CategorySeeder::class,
            BrandSeeder::class,
            ProductSeeder::class,
        ]);

        // Final sanitize pass to enforce Step 9 constraints.
        $this->call([
            SkincareSanitySeeder::class,
        ]);

        // Admin dashboard highly-synchronized dataset for UI metrics/tables.
        // This seeder resets Products + Orders so the dashboard counters and tables are consistent.
        $this->call([
            AdminDashboardSeeder::class,
        ]);

    }
}
