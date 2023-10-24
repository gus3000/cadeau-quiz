<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuestionTest extends TestCase
{
    use RefreshDatabase;

    public function test_question_exists(): void {
        $this->seed();

        $this->assertDatabaseCount('questions', 6);
    }
}
