<?php

namespace App\Http\Controllers;

use App\Http\Middleware\TwitchJwtAuth;
use App\Models\Quiz;
use Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TwitchController extends Controller
{

    public function __construct(
        protected TwitchJwtAuth $jwtAuth
    )
    {
    }

    private function getQuizInfo()
    {
        $user = Auth::user();
        if ($user === null)
            return [];
        $quiz = Quiz::currentlyOpen();
        if ($quiz === null)
            return [];

        $question = $quiz->current_question;
        $question?->load('answers');

        $question?->makeHiddenIf(!$question->closed, 'correct_answer');

        $guess = $question?->guessFromUser($user);

        $guess?->load('answer.question');

        return [
            'quiz' => $quiz,
            'question' => $question,
            'guess' => $guess
        ];
    }

    public function fullscreen(Request $request)
    {
//        [$user, $quiz, $question, $guess] = $this->getQuizInfo();
        return Inertia::render('TwitchExtension/Fullscreen', [
            'user' => Auth::user(),
            ...$this->getQuizInfo()
        ]);
    }

//    public function landing(Request $request, string $route): \Inertia\Response
//    {
//
//        return Inertia::render('TwitchExtension/Landing', [
//            'user' => Auth::user(),
//            'windowType' => $route,
////            'headerToken' => $this->jwtAuth->getJwtToken($request)
//        ]);
//    }
}
