<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
//        $nickname = fake()->firstName() . fake()->numberBetween(0,9999);
        $nickname = fake()->userName;
        return [
            'name' => $nickname,
            'twitch_id' => fake()->unique()->numberBetween(-1000000, -1),
            'twitch_avatar' => fake()->imageUrl(randomize: false, word: $nickname),
            'remember_token' => Str::random(10),

        ];
    }

}
