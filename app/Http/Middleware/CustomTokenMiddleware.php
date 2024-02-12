<?php

namespace App\Http\Middleware;

use Closure;

class CustomTokenMiddleware
{
    public function handle($request, Closure $next)
    {
        // Get the token from the request header
        $token = $request->header('Authorization');

        if (!$token || $token !== 'Bearer p547tfslezg2cyrj96nu3dkwq') {
            return response()->json(['status' => false, 'error' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
