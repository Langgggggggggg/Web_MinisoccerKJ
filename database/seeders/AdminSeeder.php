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
            'username' => 'nissafauzziah',
            'email' => 'nissa@example.com',
            'password' => Hash::make('pengelola1'), 
            'role' => 'admin', 
        ]);

        User::create([
            'name' => 'Pepen Efendi',
            'username' => 'pepenefendi',
            'email' => 'pepen@example.com',
            'password' => Hash::make('pengelola2'), 
            'role' => 'admin',
        ]);
    }
}
