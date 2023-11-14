<?php

use App\Http\Controllers\Api\QuestionApiController;
use App\Http\Controllers\Api\QuizApiController;
use App\Http\Controllers\GuessController;
use App\Http\Controllers\QuizController;
use App\Models\Guess;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('quiz')->group(function () {
    Route::get('/current', function () {
        return Quiz::currentlyOpen();
    });

    Route::get('/{quiz}', function (Quiz $quiz) {
        return $quiz;
    });

    Route::get('/{quiz}/questions', function (Quiz $quiz) {
        return $quiz->questions;
    });

    Route::middleware(['web', 'auth:sanctum', 'quiz_owner'])->group(function () {

        Route::post('/{quiz}/lock', [QuizApiController::class, 'lock'])->name("api.quizzes.lock");

        Route::middleware('admin')->group(function () {
            Route::get('/{quiz}/open', function (Quiz $quiz) {
                $quiz->open();
                return $quiz;
            });

            Route::get('/{quiz}/close', function (Quiz $quiz) {
                $quiz->close();
                return $quiz;
            });

            Route::post('/next-question', function () {
                Quiz::currentlyOpen()->nextQuestion();
            });

            Route::post('/close-question', function () {
                Quiz::currentlyOpen()->current_question->close();
            });
        });
    });
});

Route::resource('questions', QuestionApiController::class);

Route::prefix('question')->group(function () {
    Route::get('/{question}/quiz', function (Question $question) {
        return $question->quiz;
    });

    Route::get('/{question}/guesses', function (Question $question) {
        if ($question->is_open)
            abort(401, 'La question est encore ouverte, vous ne pouvez pas récuperer les réponses');
        return Guess::whereQuestionId($question->id);
    });
});

Route::prefix('user')
    ->middleware(['web', 'auth:sanctum'])
    ->group(function () {
        Route::get('/', function (Request $request) {
            return $request->user();
        });

        Route::get('/history', function () {
            $user = Auth::user();
            $guesses = Guess::where(['user_id' => $user->id]);
            return $guesses->get();
        });

        Route::get('/twitch/profile', function () {
            $user = Auth::user();

        });

        Route::get('/guess/{question}', [GuessController::class, 'getGuess']);

        Route::put('/guess/{question}/{answer}', [GuessController::class, 'updateGuess']);
    });
