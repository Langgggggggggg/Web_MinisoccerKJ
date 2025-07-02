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
            'email' => 'nissafauzziah1@gmail.com',
            'password' => Hash::make('pengelola1'), 
            'role' => 'admin', 
        ]);

        User::create([
            'name' => 'Pepen Efendi',
            'username' => 'pepenefendi',
            'email' => 'pepen8465@gmail.com',
            'password' => Hash::make('pengelola2'), 
            'role' => 'admin',
        ]);
    }
}
