<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // Pastikan ini ada jika Anda menggunakan User Seeder
use Database\Seeders\AdminSeeder; // Import AdminSeeder

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Menjalankan AdminSeeder
        $this->call(AdminSeeder::class);

    }
}
