<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/quiz/{quiz}', function (Quiz $quiz) {
    return $quiz;
});

Route::get('/quiz/{quiz}/questions', function (Quiz $quiz) {
    return $quiz->questions;
});

Route::get('/quiz/{quiz}/open', function (Quiz $quiz) {
    $quiz->open();
    return $quiz;
});

Route::get('/quiz/{quiz}/close', function (Quiz $quiz) {
    $quiz->close();
    return $quiz;
});

Route::get('/question/{question}/quiz', function (Question $question) {
    return $question->quiz;
});
