<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Nisa Fauzziah Habibaloh',
            'username' => 'nisafauzziah',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin1'), 
            'role' => 'admin', 
        ]);

        User::create([
            'name' => 'Pepen Efendi',
            'username' => 'pepenefendi',
            'email' => 'pepen@example.com',
            'password' => Hash::make('pepen123'), 
            'role' => 'admin',
        ]);
    }
}
