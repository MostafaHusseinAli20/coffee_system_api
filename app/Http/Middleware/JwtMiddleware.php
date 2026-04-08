<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;

class JwtMiddleware
{
    public function handle($request, Closure $next)
    {
        try {

            $user = JWTAuth::parseToken()->authenticate();

            if (!$user) {
                return response()->json([
                    'error' => 'User not found'
                ], 404);
            }

        } catch (Exception $e) {

            return response()->json([
                'error' => 'Token not valid'
            ], 401);
        }

        return $next($request);
    }
}
