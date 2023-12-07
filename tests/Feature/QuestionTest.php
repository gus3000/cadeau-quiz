<?php

namespace Tests\Feature;

use Database\Seeders\QuizSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuestionTest extends TestCase
{
    use RefreshDatabase;

    public function test_question_exists(): void {
        $this->seed(UserSeeder::class);
        $this->seed(QuizSeeder::class);

        $this->assertDatabaseCount('questions', 20+20+2);
    }
}
