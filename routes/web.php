<?php

use App\Http\Controllers\ProfileController;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Socialite\Facades\Socialite;

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

Route::get('/phpinfo', function () {
    return phpinfo();
});

Route::get('/', function () {
    if (Auth::check()) {
        return redirect('dashboard');
    }
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})
    ->name('home');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified', 'quiz_redirect'])->name('dashboard');

Route::middleware(['auth'])
    ->prefix('quiz')
    ->group(function () {
        Route::get('/', function () {
            $user = Auth::user();
            $quiz = Quiz::currentlyOpen();
            $question = $quiz->current_question;
            $question?->load('answers');

            $question->makeHiddenIf(!$question->finished, 'correct_answer');

            $question?->makeHiddenIf(!$question->finished, 'correct_answer');

            return Inertia::render('Quiz', [
                'quiz' => $quiz,
                'question' => $question,
                'admin' => $user->is_admin,
            ]);
        });
    });

require __DIR__ . '/auth.php';
