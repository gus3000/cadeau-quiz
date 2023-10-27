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
            'admin' => true
        ]);

        User::factory()->create([
            'name' => 'castless',
            'email' => 'gus3000spam@gmail.com',
            'admin' => false
        ]);
    }
}
