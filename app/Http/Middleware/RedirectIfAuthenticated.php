<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        // Check for authenticated user
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // If authenticated, redirect to the dashboard
                return redirect('/dashboard');
            }
        }

        return $next($request);
    }
}
