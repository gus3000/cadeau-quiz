<?php

namespace Database\Seeders;

use App\Models\Guess;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Database\Seeder;

class GuessSeeder extends Seeder
{
    public function run(): void
    {
//        $users = User::where(['admin' => false])->get();
        $users = User::all();
        $quizzes = Quiz::whereFinished(true)->get();
        foreach ($quizzes as $quiz) {

            foreach ($quiz->questions as $question) {
                $answers = $question->answers;
                foreach ($users as $user) {
                    $correctAnswer = $question->correct_answer;
                    $guessedAnswer = (rand(0,100) < 75) ? $correctAnswer : $answers->random();
                    $guessedTime = fake()->dateTimeBetween($question->opened_at, $question->closed_at);
                    if ($guessedTime->getTimestamp() === $question->closed_at->getTimestamp())
                        continue;
                    $score = ($guessedTime->diff($question->closed_at)->s * 1000) - fake()->numberBetween(0, 1000);

                    Guess::factory()->create([
                        'user_id' => $user->id,
                        'answer_id' => $guessedAnswer->id,
                        'created_at' => $guessedTime,
                        'updated_at' => $guessedTime,
                        'score' => $score,
                    ]);
                }
            }
        }
    }
}
