<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleAdmin
{
    public function handle(Request $request, Closure $next): \Illuminate\Http\JsonResponse
    {
        if (Auth::user() && Auth::user()->role === 'admin') {
            return $next($request);
        }
        return response()->json(['message' => 'You are not an admin'], 401);

    }
}
