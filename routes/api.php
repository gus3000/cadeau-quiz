<?php

use App\Http\Controllers\GuessController;
use App\Models\Answer;
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
    Route::get('/current', function() {
       return Quiz::currentlyOpen();
    });

    Route::get('/{quiz}', function (Quiz $quiz) {
        return $quiz;
    });

    Route::get('/{quiz}/questions', function (Quiz $quiz) {
        return $quiz->questions;
    });

    Route::get('/{quiz}/open', function (Quiz $quiz) {
        $quiz->open();
        return $quiz;
    });

    Route::get('/{quiz}/close', function (Quiz $quiz) {
        $quiz->close();
        return $quiz;
    });
});

Route::prefix('question')->group(function () {
    Route::get('/{question}/quiz', function (Question $question) {
        return $question->quiz;
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

        Route::get('/guess/{question}', [GuessController::class, 'getGuess']);

        Route::put('/guess/{question}/{answer}', [GuessController::class, 'updateGuess']);
    });
