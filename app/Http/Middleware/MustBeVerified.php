<?php

namespace App\Http\Middleware;

use App\Traits\HttpResponse;
use Closure;
use Illuminate\Http\Request;
use Modules\Auth\Enums\AuthEnum;
use Symfony\Component\HttpFoundation\Response;

class MustBeVerified
{
    use HttpResponse;

    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            if (! auth()->user()->{AuthEnum::VERIFIED_AT}) {
                return $this->forbiddenResponse();
            }
        }

        return $next($request);
    }
}
