<?php

namespace Tests\Feature;

use Database\Seeders\QuizSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuestionTest extends TestCase
{
    use RefreshDatabase;

    public function test_question_exists(): void {
        $this->seed(QuizSeeder::class);

        $this->assertDatabaseCount('questions', 20);
    }
}
