<?php

namespace App\Http\Middleware;

use App\Models\Quiz;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class QuizNotLocked
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var Quiz $quiz */
        $quiz = $request->route()->parameter('quiz');
        if ($quiz !== null && $quiz->locked)
            abort(403, "Ce quiz est verrouillé, vous ne pouvez plus le modifier");

        return $next($request);
    }
}
