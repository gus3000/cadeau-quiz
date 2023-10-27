<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Guess;
use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Seeder;

class GuessSeeder extends Seeder
{
    public function run(): void
    {
        $questions = Question::all();
        $users = User::all();
        foreach ($users as $user) {
            foreach ($questions as $question) {
                $answers = Answer::whereQuestionId($question->id);
                $guessedAnswer = $answers->inRandomOrder()->first();
                Guess::factory()->create([
                    'question_id' => $question->id,
                    'user_id' => $user->id,
                    'answer_id' => $guessedAnswer->id,
                ]);
            }
        }
    }
}
