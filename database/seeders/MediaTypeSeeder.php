<?php

namespace Database\Seeders;

use App\Models\MediaType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MediaTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach(['image', 'audio', 'video'] as $shortName)
        {
            MediaType::create([
                'short_name'=> $shortName
            ]);
        }

    }
}
