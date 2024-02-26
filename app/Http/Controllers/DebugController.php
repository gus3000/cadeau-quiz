<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class DebugController extends Controller
{
    public function __invoke()
    {
        if (\App::isProduction())
            abort(401);

        Storage::disk('media')->put('file.txt', 'Content blabla');
        $data = [
            'asset' => asset('storage/file.txt'),
            'url' => Storage::disk('local')->url('file.txt'),
            'temp_url' => Storage::disk('media')-> temporaryUrl('file.txt', now()->addSeconds(5)),
        ];

        return $data;
    }
}
