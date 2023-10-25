<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
//        $user = new User();
        User::factory()->create([
            'name' => 'gus3000',
            'email' => 'gus3000spam@gmail.com',
            'password' => 'azerty',
        ]);
    }
}
