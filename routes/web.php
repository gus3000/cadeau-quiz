<?php

use App\Http\Controllers\QuizController;
use App\Models\Quiz;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('debug')
    ->group(function () {
        Route::get('/', \App\Http\Controllers\DebugController::class);
        Route::get('/phpinfo', function () {
            if (App::isProduction())
                abort(403);
            return phpinfo();
        });
    });


Route::get('/', function () {
    if (!Auth::check()) {
        return Inertia::render('Welcome', [
            'canLogin' => Route::has('login'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
    }

    $user = Auth::user();
    $quiz = Quiz::currentlyOpen();
    if ($quiz === null)

        return redirect('dashboard');
    $question = $quiz->current_question;
    $question?->load('answers');

    $question?->makeHiddenIf(!$question->closed, 'correct_answer');

    $guess = $question?->guessFromUser($user);

    $guess?->load('answer.question');

    return Inertia::render('Quiz', [
        'quiz' => $quiz,
        'question' => $question,
        'guess' => $guess,
        'admin' => $user->is_admin,
    ]);
})
    ->name('home');

Route::middleware(['auth', 'verified', 'quiz_redirect'])
    ->prefix('dashboard')
    ->group(function () {
        Route::get("/", function () {
            return Inertia::render('Dashboard');
        })->name('dashboard');
    });

Route::resource('quizzes', QuizController::class);


Route::middleware(['auth'])
    ->prefix('quiz')
    ->group(function () {
        Route::get('/', function () {

        });
    });

require __DIR__ . '/auth.php';
