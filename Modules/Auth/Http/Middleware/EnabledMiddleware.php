<?php

namespace Modules\Auth\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\Auth\Exceptions\LoginException;

class EnabledMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @throws LoginException
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && ! auth()->user()->status) {
            LoginException::blockedAccount();
        }

        return $next($request);
    }
}
