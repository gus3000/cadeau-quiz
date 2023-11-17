<?php

use App\Http\Controllers\TwitchController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

Route::prefix('twitch')->group(function () {
    Route::get('/auth', function () {
        return Socialite::driver('twitch')
            ->setScopes([])
            ->redirect();
    })->name('twitch-login');

    Route::get('/auth/callback', function (Request $request) {
        if ($error = $request->input('error')) {
            throw new Exception("Twitch login error : {$request->input('error_description')}");
        }

        $twitchUser = Socialite::driver('twitch')
            ->setScopes([])
            ->user();

        $user = User::updateOrCreate([
            'name' => $twitchUser->getName(),
        ]);
        $user->twitch_id = $twitchUser->getId();
        $user->twitch_avatar = $twitchUser->getAvatar();
        $user->save();

        Auth::login($user);

        return redirect('/dashboard');
    });

    Route::middleware('twitch_jwt')
        ->get('/fullscreen', [TwitchController::class, 'fullscreen']);
//        ->get('/{component}', [\App\Http\Controllers\TwitchController::class, 'landing']);

//    Route::get('/config', function () {
//        return Inertia::render('TwitchExtension/Config');
//    });
//    Route::get('/panel', function () {
//        return Inertia::render('TwitchExtension/Panel');
//    });
//    Route::get('/fullscreen', function () {
//        return Inertia::render('TwitchExtension/Fullscreen');
//    });
//    Route::get('/mobile', function () {
//        return Inertia::render('TwitchExtension/Mobile');
//    });
//    Route::get('/video', function () {
//        return Inertia::render('TwitchExtension/Video');
//    });
});
