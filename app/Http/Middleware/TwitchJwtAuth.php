<?php

namespace App\Http\Middleware;

use App\Services\Auth\TwitchAuth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TwitchJwtAuth
{


    public function __construct(
        protected TwitchAuth $twitchAuth,
    )
    {
    }

    public function getJwtToken(Request $request): string
    {
        $authString = $request->header('Authorization');
        return substr($authString, strlen("Bearer "));
    }

    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $jwtToken = $this->getJwtToken($request);
        $this->twitchAuth->authFromJwt($jwtToken);

        return $next($request);
    }
}
