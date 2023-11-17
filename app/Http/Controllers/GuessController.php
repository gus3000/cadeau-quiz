<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Guess;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;

class GuessController extends Controller
{
    public function getGuess(Question $question)
    {
        $user = Auth::user();

        return Guess::where([
            'user_id' => $user->id,
            'question_id' => $question->id,
        ])
            ->first();
    }

    public function updateGuess(Question $question, Answer $answer)
    {
        if ($question->id !== $answer->question_id)
            abort(401, "Given question {$question->id} and answer {$answer->id} do not match");

        $user = Auth::user();

        $baseGuessAttributes = [
            'user_id' => $user->id,
        ];

        if ($question->finished) {
            abort(401, 'La question est close, vous ne pouvez plus changer votre réponse');
        }

        if (is_null($question->opened_at)) {
            abort(401, 'La question n\'est pas encore ouverte, vous ne pouvez pas encore voter');
        }

        $guess = $question->guessFromUser($user);

        if (is_null($guess)) {
            return Guess::factory()->create(array_merge($baseGuessAttributes, [
                'answer_id' => $answer->id,
            ]));
        }

        $quiz = $question->quiz;
        if ($quiz->finished)
            abort(401, 'Le quiz est clos, vous ne pouvez plus changer votre réponse');

        $guess->answer_id = $answer->id;
        $guess->save();

        return $guess;
    }
}
