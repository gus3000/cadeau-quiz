<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
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
    ->group(function() {
    Route::get('/', function() {
        $quiz = \App\Models\Quiz::currentlyOpen();
        $question = $quiz->currentQuestion;
//        foreach($quiz->questions as $question) {
//            foreach($question->answers as $answer) {
//                $answer->label;
//            }
//        }
        return Inertia::render('Quiz', [
            'quiz' => $quiz,
            'question' => $question
        ]);
    });
});

require __DIR__ . '/auth.php';
