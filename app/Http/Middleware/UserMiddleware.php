<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserMiddleware
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(auth('user')->check()) {
            if (is_callable($next)) {
                return $next($request);
            }
        }

        return response()->json([
            'message' => 'You must be logged in.'
        ]);
    }
}
