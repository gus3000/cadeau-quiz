<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Guess;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Database\Seeder;

class GuessSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $quizzes = Quiz::whereFinished(true)->get();
        foreach ($quizzes as $quiz) {
            $questions = Question::whereQuizId($quiz->id)->get();
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
}
