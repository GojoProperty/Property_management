<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpFoundation\Response;

class Role
{
    public function handle(Request $request, Closure $next, $role): Response
    {
        if (!$request->user() || $request->user()->role !== $role) { 
            return redirect($this->getRedirectPath($request->user()->role)); 
        }

        return $next($request);
    }

    /**
     * Get the correct redirect path based on user role.
     */
    private function getRedirectPath($role): string
    {
        return match ($role) {
            'agent' => Config::get('constants.AGENT'),
            'admin' => Config::get('constants.ADMIN'),
            'customer' => Config::get('constants.HOME'),
            
        };
    }
}
