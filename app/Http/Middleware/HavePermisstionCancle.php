<?php

namespace App\Http\Middleware;

use App\Statuses\HavePermission;
use Closure;
use Illuminate\Http\Request;

class HavePermisstionCancle
{

    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->permission_to_delete == HavePermission::TRUE) {
            return $next($request);
        } else {
            return response()->json(['message' => "You Don't Have Permission To Cancle This Reservation"]);
        }
    }
}
