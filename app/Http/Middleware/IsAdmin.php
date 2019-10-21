<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->isAdmin()) { //check the proper role
            return $next($request);
        }
        else {
            return response()
                ->view('admin.dashboard')
                ->header('Content-Type', 'text/html');
        }
    }
}
