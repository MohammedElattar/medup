<?php

namespace Modules\Payment\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class BankDetailsAuthorization
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        return $next($request);
    }
}
