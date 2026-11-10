<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class TestUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'User A',
            'email' => 'usera@example.com',
            'password' => 'password123'
        ]);

        User::create([
            'name' => 'User B',
            'email' => 'userb@example.com',
            'password' => 'password123'
        ]);
    }
}
