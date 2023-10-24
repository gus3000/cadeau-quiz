<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Question>
 */
class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'text' => fake()->text(),
            'answer' => fake()->text(20),
            'false_proposition1' => fake()->text(20),
            'false_proposition2' => fake()->text(20),
            'false_proposition3' => fake()->text(20),

        ];
    }
}
