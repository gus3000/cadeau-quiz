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

        Route::get('/webgl', function () {
            if (App::isProduction())
                abort(403);
            return Inertia::render('WebGL');
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
    $question?->load(['answers', 'media']);

    $question?->makeHiddenIf(!$question->closed, 'correct_answer');

    if ($question?->finished)
        $question->load('answers.guesses');

    $guess = $question?->guessFromUser($user);

    $guess?->load('answer.question');

    $quizStats = $quiz->stats;
    $questionStats = $question?->stats;

    return Inertia::render('Quiz', [
        'quiz' => $quiz,
        'question' => $question,
        'guess' => $guess,
        'admin' => $user->is_admin,
        'quizStats' => $quizStats,
        'questionStats' => $questionStats,
    ]);
})
    ->name('home');

Route::middleware(['auth', 'quiz_redirect'])
    ->prefix('dashboard')
    ->group(function () {
        Route::get("/", function () {
            return Inertia::render('Dashboard');
        })->name('dashboard');
    });

Route::middleware(['auth', 'admin'])
    ->get('quizzes/submitted', [QuizController::class, 'submitted'])->name('quizzes.submitted');

Route::middleware(['auth', 'quiz_owner', 'quiz_not_locked'])
    ->resource('quizzes', QuizController::class);


Route::middleware(['auth'])
    ->prefix('quiz')
    ->group(function () {
        Route::get('/', function () {

        });
    });

Route::get('temp/image/{path}', function (string $path) {
    if (!\request()->hasValidSignature()) {
        abort(401);
    }

    return Storage::disk('media')->download($path);
})->name('media.temp');

require __DIR__ . '/auth.php';
