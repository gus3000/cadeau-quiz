<?php

use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

Route::prefix('twitch')->group(function () {
    Route::get('/auth', function () {
        return Socialite::driver('twitch')->redirect();
    })->name('twitch-login');

    Route::get('/auth/callback', function () {
        $twitchUser = Socialite::driver('twitch')->user();

        $user = \App\Models\User::updateOrCreate([
            'email' => $twitchUser->getEmail(),
        ], [
            'name' => $twitchUser->getName(),
        ]);

        Auth::login($user);

        return redirect('/dashboard');
    });

});
