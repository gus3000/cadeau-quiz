<?php

namespace App\Http\Requests;

use App\Models\Question;
use Illuminate\Foundation\Http\FormRequest;

abstract class QuizRequest extends FormRequest
{
    public function getQuestion(int $id): ?array
    {
        $questions = $this->request->all('questions');

        $filtered = array_filter($questions, fn($question) => $question['id'] === $id);

        return $filtered[0] ?? null;
    }
}
