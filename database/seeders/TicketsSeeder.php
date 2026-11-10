<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class TicketsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userA = User::where('email', 'usera@example.com')->first();
        $userB = User::where('email', 'userb@example.com')->first();

        $userA->tickets()->create([
            'title' => 'Cannot login',
            'description' => 'I cannot access my account.',
            'status' => 'open',
            'priority' => 'high'
        ]);

        $userB->tickets()->create([
            'title' => 'Cannot logout',
            'description' => 'I cannot logout of my account.',
            'status' => 'open',
            'priority' => 'medium'
        ]);
    }
}
