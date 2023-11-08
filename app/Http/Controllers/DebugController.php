<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

class DebugController extends Controller
{
    public function __invoke()
    {
        if(\App::isProduction())
            abort(401);

        $data = [];

        return $data;
    }
}
