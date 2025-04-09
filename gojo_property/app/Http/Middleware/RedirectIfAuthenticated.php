<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $role = Auth::user()->role;

            if ($role === 'user') {
                return redirect('/dashboard');
            } elseif ($role === 'agent') {
                return redirect('/agent/dashboard');
            } elseif ($role === 'admin') {
                return redirect('/admin/dashboard');
            }
        }

        return $next($request);
    }
}
