<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return \Illuminate\Http\JsonResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(auth('admin')->check()) {
            if (is_callable($next)) {
                return $next($request);
            }
        }

        return response()->json([
            'message' => 'You must be logged in.'
        ]);
    }
}
