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
            'admin' => true,
        ]);

        User::factory()->create([
            'name' => 'castless',
            'admin' => true,
        ]);

        User::factory()->create([
            'name' => 'cadeauJeff',
            'admin' => false,
        ]);
    }
}
