<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'admin',
            'email' => 'root@chateau.education',
            'password' => 'azerty',
            'admin' => true
        ]);

        User::factory()->create([
            'name' => 'castless',
            'email' => 'cast@troll.fr',
            'password' => 'qwerty',
            'admin' => false
        ]);
    }
}
