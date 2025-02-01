<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'last_name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => 'password',
        ]);

        User::create([
            'name' => 'Vendedor',
            'last_name' => 'Vendedor',
            'email' => 'seller@test.com',
            'password' => 'password',
        ]);
    }
}
