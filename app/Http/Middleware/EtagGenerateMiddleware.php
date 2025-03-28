<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EtagGenerateMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Only apply ETags for successful responses
        if ($response->isSuccessful()) {
            $etag = md5($response->getContent());

            if ($request->header('If-None-Match') === $etag) {
                return response()->noContent(304);
            }

            $response->header('ETag', $etag);
        }

        return $response;
    }
}
