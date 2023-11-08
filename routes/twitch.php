<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;

Route::prefix('twitch')->group(function () {
    Route::get('/auth', function () {
        return Socialite::driver('twitch')
            ->setScopes([])
            ->redirect();
    })->name('twitch-login');

    Route::get('/auth/callback', function (Request $request) {
        if($error = $request->input('error')) {
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

});
