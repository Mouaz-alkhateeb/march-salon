<?php

namespace App\Http\Middleware;

use App\Statuses\UserType;
use Closure;
use Illuminate\Http\Request;

class CheckAdminReceiption
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->type == UserType::ADMIN || auth()->user()->type == UserType::RECEPTION) {
            return $next($request);
        } else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }
}
