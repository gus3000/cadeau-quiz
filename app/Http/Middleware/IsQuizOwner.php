<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsQuizOwner
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $quiz = $request->route()->parameter('quiz');
        $user = Auth::user();
        if ($quiz !== null && !$user->admin && $user->id !== $quiz->created_by)
            abort(403, "Vous n'êtes pas autorisé à modifier ce quiz");
        return $next($request);
    }
}
