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
        $user = Auth::user();

        $baseGuessAttributes = [
            'user_id' => $user->id,
            'question_id' => $question->id,
        ];

        $guess = Guess::where($baseGuessAttributes)->first();

        if (is_null($guess)) {
            return Guess::create(array_merge($baseGuessAttributes, [
                'answer_id' => $answer->id,
            ]));
        }

        if ($question->finished) {
            throw new \Exception('La question est close, vous ne pouvez plus changer votre réponse');
        }

        $quiz = $question->quiz;
        if ($quiz->finished)
            throw new \Exception('Le quiz est clos, vous ne pouvez plus changer votre réponse');

        $guess->answer_id = $answer->id;
        $guess->save();

        return $guess;
    }
}
